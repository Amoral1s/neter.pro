<?php

add_action('admin_menu', 'main_theme_stock_menu');

function main_theme_stock_menu() {
    add_menu_page(
        'Остатки',
        'Остатки',
        'manage_woocommerce',
        'main-theme-stock',
        'main_theme_stock_page',
        'dashicons-archive',
        56
    );
}

function main_theme_stock_page() {
    if (!current_user_can('manage_woocommerce')) {
        return;
    }
    ?>
    <div class="wrap">
        <h1>Остатки</h1>
        <p>Включить управление запасами у товаров без артикула. Количество товара сохраняется.</p>
        <p>Положительный остаток — «В наличии», нулевой или пустой — «Нет в наличии». Предзаказы будут отключены.</p>
        <p>Товары из корзины и автоматические черновики не обрабатываются. Обработка идёт порциями до 100 товаров.</p>
        <?php if (!function_exists('wc_get_product') || 'yes' !== get_option('woocommerce_manage_stock')) : ?>
            <div class="notice notice-error inline"><p>Для запуска нужны активный WooCommerce и включённое управление запасами в его настройках.</p></div>
        <?php else : ?>
            <p><label><input type="checkbox" id="main-stock-fill-price"> Заполнить пустую обычную цену значением 1</label><br>
            <span class="description">Без галочки цены не меняются. С галочкой заполняются только пустые цены; уже заданные сохраняются.</span></p>
            <p><button type="button" class="button button-primary" id="main-stock-start">Обновить остатки</button>
            <button type="button" class="button" id="main-stock-stop" disabled>Приостановить</button></p>
            <p>Не закрывайте страницу до завершения. Повторный запуск заново проверяет текущие остатки.</p>
            <?php if ((float) get_option('woocommerce_notify_no_stock_amount', 0) != 0) : ?>
                <p>В настройках WooCommerce задан порог отсутствия: <?php echo esc_html(get_option('woocommerce_notify_no_stock_amount')); ?>. Наличие будет рассчитано с учётом этого порога.</p>
            <?php endif; ?>
        <?php endif; ?>
        <p id="main-stock-status" role="status" aria-live="polite"></p>
        <ul id="main-stock-errors"></ul>
    </div>
    <script>
        (function() {
            const start = document.getElementById('main-stock-start');
            if (!start) return;

            const stop = document.getElementById('main-stock-stop');
            const fillPrice = document.getElementById('main-stock-fill-price');
            const status = document.getElementById('main-stock-status');
            const errors = document.getElementById('main-stock-errors');
            let cursor = 0;
            let maxId = 0;
            let running = false;
            let pause = false;
            let totals = {processed: 0, updated: 0, instock: 0, outofstock: 0, skipped: 0, failed: 0};

            function summary(prefix) {
                status.textContent = prefix + ' Проверено: ' + totals.processed +
                    '. Обновлено: ' + totals.updated + '. В наличии: ' + totals.instock +
                    '. Нет в наличии: ' + totals.outofstock + '. Пропущено: ' + totals.skipped +
                    '. Ошибок: ' + totals.failed + '.';
            }

            stop.addEventListener('click', function() {
                pause = true;
                stop.disabled = true;
                summary('Пауза после текущей порции.');
            });

            window.addEventListener('beforeunload', function(event) {
                if (running) {
                    event.preventDefault();
                    event.returnValue = '';
                }
            });

            start.addEventListener('click', async function() {
                if (running) return;
                running = true;
                pause = false;
                start.disabled = true;
                stop.disabled = false;
                // Выбор сохраняется на все порции, включая паузу и повтор после ошибки.
                const fillEmptyPrice = fillPrice.checked;
                fillPrice.disabled = true;
                if (!cursor) {
                    totals = {processed: 0, updated: 0, instock: 0, outofstock: 0, skipped: 0, failed: 0};
                    errors.textContent = '';
                }
                summary('Обработка…');

                try {
                    while (!pause) {
                        const response = await fetch(<?php echo wp_json_encode(admin_url('admin-ajax.php')); ?>, {
                            method: 'POST',
                            credentials: 'same-origin',
                            body: new URLSearchParams({
                                action: 'main_theme_update_stock',
                                nonce: <?php echo wp_json_encode(wp_create_nonce('main_theme_update_stock')); ?>,
                                after_id: cursor,
                                max_id: maxId,
                                fill_empty_price: fillEmptyPrice ? '1' : '0'
                            })
                        });
                        const result = await response.json();
                        if (!response.ok || !result.success) {
                            throw new Error(result.data && result.data.message ? result.data.message : 'Ошибка сервера.');
                        }
                        const data = result.data;
                        cursor = data.last_id;
                        maxId = data.max_id;
                        Object.keys(totals).forEach(function(key) { totals[key] += data[key]; });
                        data.errors.forEach(function(message) {
                            const item = document.createElement('li');
                            item.textContent = message;
                            errors.appendChild(item);
                        });
                        summary('Обработка…');
                        if (data.done) {
                            summary(totals.failed ? 'Завершено с ошибками. Проблемные товары перечислены ниже.' : 'Готово.');
                            cursor = 0;
                            maxId = 0;
                            fillPrice.disabled = false;
                            start.textContent = 'Запустить заново';
                            return;
                        }
                        await new Promise(function(resolve) { setTimeout(resolve, 250); });
                    }
                    summary('Приостановлено.');
                    start.textContent = 'Продолжить';
                } catch (error) {
                    summary('Обработка остановлена: ' + error.message + ' Можно повторить текущую порцию.');
                    start.textContent = 'Повторить порцию';
                } finally {
                    running = false;
                    start.disabled = false;
                    stop.disabled = true;
                }
            });
        }());
    </script>
    <?php
}

add_action('wp_ajax_main_theme_update_stock', 'main_theme_update_stock_ajax');

function main_theme_update_stock_ajax() {
    if (!current_user_can('manage_woocommerce') || !current_user_can('edit_products')) {
        wp_send_json_error(array('message' => 'Недостаточно прав для изменения товаров.'), 403);
    }
    if (!check_ajax_referer('main_theme_update_stock', 'nonce', false)) {
        wp_send_json_error(array('message' => 'Сессия истекла. Обновите страницу.'), 403);
    }
    if (!function_exists('wc_get_product') || 'yes' !== get_option('woocommerce_manage_stock')) {
        wp_send_json_error(array('message' => 'Включите WooCommerce и управление запасами в его настройках.'), 400);
    }

    global $wpdb;
    $after_id = isset($_POST['after_id']) ? absint($_POST['after_id']) : 0;
    $max_id = isset($_POST['max_id']) ? absint($_POST['max_id']) : 0;
    $fill_empty_price = isset($_POST['fill_empty_price']) && '1' === $_POST['fill_empty_price'];
    if (!$max_id) {
        $max_id = (int) $wpdb->get_var("SELECT MAX(ID) FROM {$wpdb->posts} WHERE post_type = 'product'");
        if ($wpdb->last_error) {
            wp_send_json_error(array('message' => 'Не удалось получить список товаров.'), 500);
        }
    }

    $ids = main_theme_stock_product_ids($after_id, $max_id);
    if ($wpdb->last_error) {
        wp_send_json_error(array('message' => 'Не удалось получить порцию товаров.'), 500);
    }
    $result = array(
        'max_id' => $max_id,
        'last_id' => $after_id,
        'processed' => 0,
        'updated' => 0,
        'instock' => 0,
        'outofstock' => 0,
        'skipped' => 0,
        'failed' => 0,
        'errors' => array(),
        'done' => false,
    );
    $started = microtime(true);

    foreach ($ids as $id) {
        $result['last_id'] = (int) $id;
        $result['processed']++;
        try {
            $product = wc_get_product($id);
            if (!$product) {
                throw new Exception('Не удалось загрузить товар.');
            }
            if (trim((string) $product->get_sku('edit')) !== '' || !current_user_can('edit_post', $id)) {
                $result['skipped']++;
            } elseif (!$product->is_type(array('simple', 'variable'))) {
                throw new Exception('Этот тип товара не поддерживает данную обработку.');
            } else {
                if ($fill_empty_price && '' === $product->get_regular_price('edit')) {
                    $product->set_regular_price('1');
                }
                $product->set_manage_stock(true);
                $product->set_backorders('no');
                // WooCommerce сам рассчитывает статус по сохранённому количеству и порогу отсутствия.
                $product->save();
                $result['updated']++;
                $result[$product->is_in_stock() ? 'instock' : 'outofstock']++;
            }
        } catch (Exception $error) {
            $result['failed']++;
            $result['errors'][] = 'Товар #' . $id . ': ' . $error->getMessage();
        }

        // Даже на медленном сервере следующую часть продолжит отдельный запрос.
        if (microtime(true) - $started >= 8) {
            break;
        }
    }

    $result['done'] = count($ids) < 100 && $result['processed'] === count($ids);
    wp_send_json_success($result);
}

// Выбираем только ID; курсор не зависит от изменения остатков у обработанных товаров.
function main_theme_stock_product_ids($after_id, $max_id) {
    global $wpdb;

    return $wpdb->get_col($wpdb->prepare(
        "SELECT p.ID FROM {$wpdb->posts} p
        WHERE p.post_type = 'product'
          AND p.post_status NOT IN ('trash', 'auto-draft')
          AND p.ID > %d AND p.ID <= %d
          AND NOT EXISTS (
              SELECT 1 FROM {$wpdb->postmeta} sku
              WHERE sku.post_id = p.ID AND sku.meta_key = '_sku'
                AND TRIM(sku.meta_value) <> ''
          )
        ORDER BY p.ID ASC LIMIT 100",
        $after_id,
        $max_id
    ));
}
