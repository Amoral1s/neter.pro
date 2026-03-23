<?php
// Добавляем страницу в админку
function add_vacancy_update_page() {
    add_menu_page(
        'Обновление вакансий', 
        'Обновление вакансий', 
        'manage_options', 
        'update-vacancies', 
        'render_vacancy_update_page', 
        'dashicons-update', 
        20
    );
}
add_action('admin_menu', 'add_vacancy_update_page');

// Функция рендера страницы в админке
function render_vacancy_update_page() {
    $is_scheduled = get_option('vacancy_auto_update', false);
    $update_interval = get_option('vacancy_update_interval', 'daily');
    ?>
    <div class="wrap">
        <h1>Обновление вакансий</h1>
        <p>Нажмите кнопку, чтобы загрузить актуальные вакансии с hh.ru</p>
        
        <button id="update-vacancies-btn" class="button button-primary">Обновить вакансии</button>
        <p id="update-status"></p>

        <hr>

        <h3>Автоматизация</h3>
        <label>
            <input type="checkbox" id="auto-update" <?php checked($is_scheduled, true); ?>>
            Автоматизировать обновление вакансий
        </label>

        <br>

        <label for="update-interval">Частота обновления:</label>
        <select id="update-interval">
            <option value="daily" <?php selected($update_interval, 'daily'); ?>>Раз в день</option>
            <option value="weekly" <?php selected($update_interval, 'weekly'); ?>>Раз в неделю</option>
            <option value="monthly" <?php selected($update_interval, 'monthly'); ?>>Раз в месяц</option>
        </select>

        <button id="save-auto-settings" class="button">Сохранить настройки</button>
        <p id="auto-status"></p>

        <script>
            const updateButton = document.getElementById('update-vacancies-btn');
            const updateStatus = document.getElementById('update-status');

            const shortenMessage = (message) => {
                if (!message) {
                    return '';
                }
                const trimmed = message.trim();
                if (trimmed.length <= 500) {
                    return trimmed;
                }
                return trimmed.slice(0, 500) + '...';
            };

            const parseAjaxResponse = async (response) => {
                const text = await response.text();
                let data = null;

                if (text) {
                    try {
                        data = JSON.parse(text);
                    } catch (parseError) {
                        data = null;
                    }
                }

                if (!response.ok) {
                    const message = data && data.message ? data.message : shortenMessage(text) || ('HTTP ' + response.status);
                    throw new Error(message);
                }

                if (!data) {
                    throw new Error(shortenMessage(text) || 'Некорректный ответ сервера');
                }

                return data;
            };

            updateButton.addEventListener('click', function() {
                updateButton.innerText = 'Обновляется...';
                updateButton.disabled = true;

                fetch('<?php echo admin_url('admin-ajax.php?action=update_vacancies'); ?>', {
                    credentials: 'same-origin'
                })
                    .then(parseAjaxResponse)
                    .then(data => {
                        updateStatus.innerText = data.message || 'Вакансии обновлены';
                        updateButton.innerText = 'Обновить вакансии';
                        updateButton.disabled = false;
                    })
                    .catch(error => {
                        updateStatus.innerText = error.message || 'Ошибка при обновлении';
                        updateButton.innerText = 'Обновить вакансии';
                        updateButton.disabled = false;
                    });
            });

            document.getElementById('save-auto-settings').addEventListener('click', function() {
                let autoUpdate = document.getElementById('auto-update').checked ? 1 : 0;
                let interval = document.getElementById('update-interval').value;

                fetch('<?php echo admin_url('admin-ajax.php?action=save_vacancy_settings'); ?>', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                    body: 'auto_update=' + autoUpdate + '&interval=' + interval
                })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('auto-status').innerText = data.message;
                });
            });
        </script>
    </div>
    <?php
}

// AJAX для обновления вакансий
add_action('wp_ajax_update_vacancies', 'update_acf_vacancies_from_hh');

function update_acf_vacancies_from_hh() {
    if (!function_exists('update_field')) {
        wp_send_json(['message' => 'ACF не активен или update_field недоступна'], 500);
    }

    $page_id = 481;
    $acf_repeater_field = 'vac';
    $api_base_url = 'https://api.hh.ru/vacancies';
    $query_args = [
        'employer_id' => 3494661,
        'per_page' => 100, // hh.ru возвращает максимум 100 записей за раз
    ];
    $max_pages = 50; // страховка от бесконечного цикла при ошибке API

    // Удаляем старые данные
    update_field($acf_repeater_field, [], $page_id);

    $vacancies = [];
    $page = 0;

    // Запрашиваем все страницы с вакансиями
    while ($page < $max_pages) {
        $request_url = add_query_arg(array_merge($query_args, ['page' => $page]), $api_base_url);
        $response = wp_remote_get($request_url, [
            'headers' => ['User-Agent' => 'WordPress/your-site']
        ]);

        if (is_wp_error($response)) {
            wp_send_json(['message' => 'Ошибка API hh.ru: ' . $response->get_error_message()], 500);
        }

        $response_code = wp_remote_retrieve_response_code($response);
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);

        if ($response_code < 200 || $response_code >= 300) {
            $error_message = sprintf('Ошибка API hh.ru: HTTP %d', $response_code);
            $error_detail = '';

            if (is_array($data)) {
                if (!empty($data['errors'][0]['value'])) {
                    $error_detail = $data['errors'][0]['value'];
                } elseif (!empty($data['message'])) {
                    $error_detail = $data['message'];
                } elseif (!empty($data['error'])) {
                    $error_detail = $data['error'];
                }
            }

            if ($error_detail === '') {
                $response_message = wp_remote_retrieve_response_message($response);
                if ($response_message) {
                    $error_detail = $response_message;
                }
            }

            if ($error_detail !== '') {
                $error_message .= ' - ' . sanitize_text_field($error_detail);
            }

            wp_send_json(['message' => $error_message], 500);
        }

        if (!is_array($data)) {
            wp_send_json(['message' => 'Некорректный ответ API hh.ru'], 500);
        }

        if (empty($data['items'])) {
            break;
        }

        foreach ($data['items'] as $vacancy) {
            $city = '';

            if (!empty($vacancy['address']['city'])) {
                $city = $vacancy['address']['city'];
            } elseif (!empty($vacancy['area']['name'])) {
                $city = $vacancy['area']['name'];
            } elseif (!empty($vacancy['schedule']['id']) && $vacancy['schedule']['id'] === 'remote') {
                $city = 'Удалённо';
            }

            $description_html = '';
            $salary_block = '';
            $salary_data = $vacancy['salary'] ?? null;

            if (!empty($salary_data)) {
                $currency_map = [
                    'RUR' => '₽',
                    'RUB' => '₽',
                    'USD' => '$',
                    'EUR' => '€',
                ];
                $currency_code = $salary_data['currency'] ?? '';
                $currency_symbol = $currency_map[$currency_code] ?? $currency_code;
                $salary_from = isset($salary_data['from']) ? number_format((float) $salary_data['from'], 0, '.', ' ') : '';
                $salary_to = isset($salary_data['to']) ? number_format((float) $salary_data['to'], 0, '.', ' ') : '';
                $salary_text = '';

                if ($salary_from && $salary_to) {
                    $salary_text = sprintf('от %s до %s %s', $salary_from, $salary_to, $currency_symbol);
                } elseif ($salary_from) {
                    $salary_text = sprintf('от %s %s', $salary_from, $currency_symbol);
                } elseif ($salary_to) {
                    $salary_text = sprintf('до %s %s', $salary_to, $currency_symbol);
                }

                if ($salary_text !== '') {
                    if (!empty($salary_data['gross'])) {
                        $salary_text .= ' (до вычета налогов)';
                    }

                    $salary_block = '<p style="font-size: 24px; margin-bottom: 24px;"><strong style="font-size: 24px">Зарплата:</strong> ' . esc_html($salary_text) . '</p>';
                }
            }
            $details_url = trailingslashit($api_base_url) . $vacancy['id'];
            $details_response = wp_remote_get($details_url, [
                'headers' => ['User-Agent' => 'WordPress/your-site']
            ]);

            if (!is_wp_error($details_response)) {
                $details_code = wp_remote_retrieve_response_code($details_response);
                if ($details_code >= 200 && $details_code < 300) {
                    $details_body = wp_remote_retrieve_body($details_response);
                    $details_data = json_decode($details_body, true);

                    if (!empty($details_data['description'])) {
                        $description_html = wp_kses_post($details_data['description']);
                    }
                }
            }

            if ($salary_block !== '') {
                $description_html = $salary_block . $description_html;
            }

            if ($description_html === '') {
                $requirements = trim(strip_tags($vacancy['snippet']['requirement'] ?? ''));
                $duties = trim(strip_tags($vacancy['snippet']['responsibility'] ?? ''));
                $fallback_parts = [];

                if ($duties !== '') {
                    $fallback_parts[] = '<h3><strong>Обязанности:</strong></h3><p>' . esc_html($duties) . '</p>';
                }

                if ($requirements !== '') {
                    $fallback_parts[] = '<h3><strong>Требования:</strong></h3><p>' . esc_html($requirements) . '</p>';
                }

                $description_html = implode('', $fallback_parts);
            }

            

            $vacancies[] = [
                'city' => $city,
                'title' => $vacancy['name'],
                'text' => $description_html,
            ];
        }

        $total_pages = isset($data['pages']) ? (int) $data['pages'] : 0;
        $page++;

        if ($total_pages && $page >= $total_pages) {
            break;
        }
    }

    if (empty($vacancies)) {
        wp_send_json(['message' => 'Вакансий не найдено'], 500);
    }

    // Загружаем новые вакансии
    update_field($acf_repeater_field, $vacancies, $page_id);

    wp_send_json(['message' => 'Вакансии успешно обновлены: ' . count($vacancies)], 200);
}

// AJAX для сохранения настроек
add_action('wp_ajax_save_vacancy_settings', 'save_vacancy_settings');

function save_vacancy_settings() {
    $auto_update = isset($_POST['auto_update']) ? (bool) $_POST['auto_update'] : false;
    $interval = isset($_POST['interval']) ? sanitize_text_field($_POST['interval']) : 'daily';

    update_option('vacancy_auto_update', $auto_update);
    update_option('vacancy_update_interval', $interval);

    if ($auto_update) {
        setup_vacancy_cron($interval);
    } else {
        wp_clear_scheduled_hook('vacancy_auto_update_event');
    }

    wp_send_json(['message' => 'Настройки сохранены!']);
}

// Функция настройки CRON
function setup_vacancy_cron($interval) {
    wp_clear_scheduled_hook('vacancy_auto_update_event');

    $schedule_time = time() + 3600; // Запускаем через час

    if ($interval === 'daily') {
        wp_schedule_event($schedule_time, 'daily', 'vacancy_auto_update_event');
    } elseif ($interval === 'weekly') {
        wp_schedule_event($schedule_time, 'weekly', 'vacancy_auto_update_event');
    } elseif ($interval === 'monthly') {
        wp_schedule_event($schedule_time, 'monthly', 'vacancy_auto_update_event');
    }
}

// CRON задание
add_action('vacancy_auto_update_event', 'update_acf_vacancies_from_hh');
?>
