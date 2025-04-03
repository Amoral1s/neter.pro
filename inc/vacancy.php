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
            document.getElementById('update-vacancies-btn').addEventListener('click', function() {
                this.innerText = 'Обновляется...';
                this.disabled = true;

                fetch('<?php echo admin_url('admin-ajax.php?action=update_vacancies'); ?>')
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('update-status').innerText = data.message;
                        this.innerText = 'Обновить вакансии';
                        this.disabled = false;
                    })
                    .catch(error => {
                        document.getElementById('update-status').innerText = 'Ошибка при обновлении';
                        this.innerText = 'Обновить вакансии';
                        this.disabled = false;
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
    $page_id = 481;
    $acf_repeater_field = 'vac';
    $api_url = 'https://api.hh.ru/vacancies?employer_id=3494661';

    // Удаляем старые данные
    update_field($acf_repeater_field, [], $page_id);

    // Запрашиваем новые данные
    $response = wp_remote_get($api_url, [
        'headers' => ['User-Agent' => 'WordPress/your-site']
    ]);

    if (is_wp_error($response)) {
        wp_send_json(['message' => 'Ошибка API hh.ru'], 500);
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if (!isset($data['items']) || empty($data['items'])) {
        wp_send_json(['message' => 'Вакансий не найдено'], 500);
    }

    $vacancies = [];

    foreach ($data['items'] as $vacancy) {
        $requirements = !empty($vacancy['snippet']['requirement']) ? explode('.', strip_tags($vacancy['snippet']['requirement'])) : [];
        $duties = !empty($vacancy['snippet']['responsibility']) ? explode('.', strip_tags($vacancy['snippet']['responsibility'])) : [];

        $vacancies[] = [
            'city' => 'Казань',
            'title' => $vacancy['name'],
            'text' => strip_tags($vacancy['snippet']['responsibility'] ?? ''),
            'trebovaniya' => array_map(fn($r) => ['trebovanie' => trim($r)], array_filter($requirements)),
            'obyazannosti' => array_map(fn($d) => ['obyazannost' => trim($d)], array_filter($duties))
        ];
    }

    // Загружаем новые вакансии
    update_field($acf_repeater_field, $vacancies, $page_id);

    wp_send_json(['message' => 'Вакансии успешно обновлены!'], 200);
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