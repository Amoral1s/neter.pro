<?php 

function enqueue_review_script() {
  if (is_product()) {
      wp_enqueue_script('recaptcha', 'https://www.google.com/recaptcha/api.js?render=6LeZlf8pAAAAALIprB1_PfRBJBKPfwXhT2IV3SWw', [], null, true);
      wp_enqueue_script('woo-review', get_template_directory_uri() . '/js/woo-review.js', ['recaptcha'], null, true);
      wp_localize_script('woo-review', 'woocommerce_params', array(
          'ajax_url' => admin_url('admin-ajax.php')
      ));
  }
}
add_action('wp_enqueue_scripts', 'enqueue_review_script');



add_action('wp_ajax_submit_review', 'handle_ajax_review_submission');
add_action('wp_ajax_nopriv_submit_review', 'handle_ajax_review_submission');

function handle_ajax_review_submission() {
    // Проверка наличия cookie и его значения
    if (isset($_COOKIE['last_review_time'])) {
        $last_review_time = intval($_COOKIE['last_review_time']);
        $current_time = time();
        $time_diff = $current_time - $last_review_time;

        if ($time_diff < 3600) { // 3600 секунд = 1 час
            wp_send_json_error(array('error' => __('Вы уже отправили отзыв. Пожалуйста, подождите час перед отправкой следующего отзыва.', 'woocommerce')));
        }
    }

    $is_local = in_array($_SERVER['SERVER_NAME'], ['localhost', '127.0.0.1', 'neter.local', 'localhost:3000']) || strpos($_SERVER['SERVER_NAME'], '.local') !== false;

    if (!$is_local) {
        $recaptcha_secret = '6LeZlf8pAAAAANxbQmC1NYaJlIOXAqYYIienCcxU';
        $recaptcha_response = sanitize_text_field($_POST['recaptcha_response']);

        $response = wp_remote_get("https://www.google.com/recaptcha/api/siteverify?secret={$recaptcha_secret}&response={$recaptcha_response}");
        $response_body = wp_remote_retrieve_body($response);
        $result = json_decode($response_body);

        if (!$result->success) {
            error_log('Ошибка проверки reCAPTCHA: ' . print_r($result, true)); // Отладочный вывод
            wp_send_json_error(array('error' => __('Проверка reCAPTCHA не удалась, пожалуйста, попробуйте еще раз.', 'woocommerce')));
        } else {
            error_log('reCAPTCHA успешно проверена'); // Отладочный вывод
        }
    }

    $errors = [];

    if (!isset($_POST['comment']) || empty($_POST['comment'])) {
        $errors[] = __('Введите комментарий.', 'woocommerce');
    }

    if (!isset($_POST['author']) || empty($_POST['author'])) {
        $errors[] = __('Введите ваше имя.', 'woocommerce');
    }

    if (!isset($_POST['email']) || empty($_POST['email'])) {
        $errors[] = __('Введите ваш email.', 'woocommerce');
    }

    if (!is_email($_POST['email'])) {
        $errors[] = __('Введите корректный email адрес.', 'woocommerce');
    }

    if (isset($_POST['rating']) && empty($_POST['rating'])) {
        $errors[] = __('Выберите рейтинг.', 'woocommerce');
    }

    if (!empty($errors)) {
        wp_send_json_error(array('error' => implode('<br>', $errors)));
    }

    $comment_data = array(
        'comment_post_ID' => $_POST['comment_post_ID'],
        'comment_author' => $_POST['author'],
        'comment_author_email' => $_POST['email'],
        'comment_content' => $_POST['comment'],
        'comment_type' => 'review',
        'comment_approved' => 0,
    );

    // Вставка комментария и получение ID
    $comment_id = wp_insert_comment($comment_data);

    if ($comment_id) {
        // Если рейтинг включен и отправлен, добавляем его к комментарию
        if (isset($_POST['rating']) && $_POST['rating']) {
            add_comment_meta($comment_id, 'rating', intval($_POST['rating']), true);
        }

        // Устанавливаем cookie для предотвращения спама
        setcookie('last_review_time', time(), time() + 3600, "/"); // Cookie на 1 час

        // Отправка сообщения об успешном добавлении комментария
        wp_send_json_success(array('message' => __('Спасибо за ваш отзыв. Он отправлен на модерацию.', 'woocommerce')));
    } else {
        wp_send_json_error(array('error' => __('Не удалось отправить ваш отзыв. Пожалуйста, попробуйте еще раз.', 'woocommerce')));
    }

    wp_die();
}
//Список отзывов
function custom_woocommerce_comments($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    $rating = intval(get_comment_meta($comment->comment_ID, 'rating', true));
    ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
        <div class="top">
            <div class="avatar">
                <img src="<?php echo get_template_directory_uri(); ?>/img/icons/user.svg" alt="Аватар">
            </div>
            <div class="meta">
                <div class="author">
                    <div class="name">
                        <?php printf(__('%s'), get_comment_author()); ?>
                    </div>
                    <?php if ($rating && wc_review_ratings_enabled()) : ?>
                        <div class="star-rating" title="<?php echo sprintf(__('Rated %d out of 5'), $rating) ?>">
                            <span style="width:<?php echo esc_attr(($rating / 5) * 100); ?>%"></span>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="date">
                    <?php printf(__('%1$s в %2$s'), get_comment_date(),  get_comment_time()); ?></a>
                </div>
            </div>
        </div>
        <div class="content">
            <?php if ($comment->comment_approved == '0') : ?>
                <em><?php _e('Ваш комментарий ожидает модерации.'); ?></em>
                <br />
            <?php endif; ?>
            <?php comment_text(); ?>
        </div>
    </li>
    <?php
}
