<?php 

function is_local_comment() {
    return in_array($_SERVER['HTTP_HOST'], ['localhost', '127.0.0.1', 'neter.local', 'neter.local:8888', 'localhost:3000']);
}

$comment_RECAPTCHA_SITE_KEY = '6LfCa20rAAAAABxS8bkfbwOE2jL8BhaIqf2GCiwi'; // public key (SITE KEY)
$comment_RECAPTCHA_SECRET_KEY = '6LfCa20rAAAAAPszLFtQdCmEEjG_BTIJO5_tFlQB'; // secret key (SECRET KEY)

function verify_recaptcha_comment($recaptcha_response) {
    global $comment_RECAPTCHA_SECRET_KEY;

    if (empty($comment_RECAPTCHA_SECRET_KEY) || empty($recaptcha_response)) {
        return true;
    }

    $response = wp_remote_post('https://www.google.com/recaptcha/api/siteverify', [
        'body' => [
            'secret'   => $comment_RECAPTCHA_SECRET_KEY,
            'response' => $recaptcha_response,
            'remoteip' => $_SERVER['REMOTE_ADDR'],
        ],
    ]);

    $result = json_decode(wp_remote_retrieve_body($response));

    return !empty($result->success);
}

function enqueue_comment_scripts() {
    global $comment_RECAPTCHA_SITE_KEY;
    wp_enqueue_script('comment-comment', get_template_directory_uri() . '/js/comments.js', ['jquery'], null, true);

    wp_localize_script('comment-comment', 'comment_params', [
        'ajax_url'  => admin_url('admin-ajax.php'),
        'is_local'  => is_local_comment(),
        'recaptcha_site_key' => $comment_RECAPTCHA_SITE_KEY,
    ]);
}
add_action('wp_enqueue_scripts', 'enqueue_comment_scripts');

// AJAX handlers
add_action('wp_ajax_submit_comment', 'handle_ajax_comment_submission');
add_action('wp_ajax_nopriv_submit_comment', 'handle_ajax_comment_submission');

function get_initials($name) {
  $name = trim($name);
  $parts = preg_split('/\s+/', $name); // разбиваем по пробелам

  if (count($parts) >= 2) {
    return mb_strtoupper(mb_substr($parts[0], 0, 1) . mb_substr($parts[1], 0, 1)); // Фамилия + Имя
  } elseif (count($parts) === 1) {
    return mb_strtoupper(mb_substr($parts[0], 0, 1)); // Только имя
  }

  return '';
}

// Custom comments display
function custom_wp_comments($comment, $args, $depth) {
    custom_comment_template($comment, $args, $depth);
}


function handle_ajax_comment_submission() {
    $cookie_name = 'last_comment_time';

    // Anti-spam by time
    if (isset($_COOKIE[$cookie_name])) {
        $last_comment_time = intval($_COOKIE[$cookie_name]);
        /* if (time() - $last_comment_time < 3600) { 
            wp_send_json_error([
                'error' => __('Вы уже отправляли комментарий, попробуйте еще раз через час.', 'text-domain')
            ]);
        } */
    }

    $recaptcha_response = $_POST['recaptcha_response'] ?? '';

    if (!is_local_comment() && !verify_recaptcha_comment($recaptcha_response)) {
        wp_send_json_error(['error' => __('Ошибка reCAPTCHA, попробуйте позже', 'text-domain')]);
    }

    if (!isset($_POST['comment']) || empty($_POST['comment'])) {
        wp_send_json_error(['error' => __('Ваш комментарий пустой!', 'text-domain')]);
    }

    $user = wp_get_current_user();
    $is_logged_in = $user && $user->exists();

    if ($is_logged_in) {
        $author_name  = $user->display_name ?: $user->user_login;
        $author_email = $user->user_email;
        $user_id      = $user->ID;
    } else {
        if (!isset($_POST['author']) || empty($_POST['author'])) {
            wp_send_json_error(['error' => __('Введите ваше имя.', 'text-domain')]);
        }

        if (!isset($_POST['email']) || empty($_POST['email']) || !is_email($_POST['email'])) {
            wp_send_json_error(['error' => __('Введите правильный email адрес.', 'text-domain')]);
        }

        $author_name  = sanitize_text_field($_POST['author']);
        $author_email = sanitize_email($_POST['email']);
        $user_id      = 0;
    }

    $comment_post_ID = intval($_POST['comment_post_ID']);
    $comment_parent = isset($_POST['comment_parent']) ? intval($_POST['comment_parent']) : 0;

    $comment_data = [
        'comment_post_ID'      => $comment_post_ID,
        'comment_author'       => $author_name,
        'comment_author_email' => $author_email,
        'comment_content'      => sanitize_textarea_field($_POST['comment']),
        'comment_type'         => '',
        'comment_approved'     => 0,
        'user_id'              => $user_id,
        'comment_parent'       => $comment_parent,
    ];


    $comment_id = wp_insert_comment($comment_data);

    if ($comment_id) {
        setcookie($cookie_name, time(), time() + 3600, "/");
        wp_send_json_success([
            'message' => __('Отправлено! Комментарий появится после модерации.', 'text-domain')
        ]);
    } else {
        wp_send_json_error(['error' => __('Неизвестная ошибка, попробуйте позже.', 'text-domain')]);
    }
}

function custom_comment_template($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
        <div class="top">
            <?php
                $author_email = get_comment_author_email();
                $author_name = get_comment_author();
                $author_id   = $comment->user_id;

                $user     = get_user_by('email', $author_email);
                $is_admin = $user && user_can($user, 'manage_options');

                $display_name = get_comment_author();
                $author_place = '';
                $avatar_html  = '';

                if ($author_id) {
                    $acf_author_name   = get_field('author_name', 'user_' . $author_id);
                    $acf_author_avatar = get_field('author_avatar', 'user_' . $author_id);
                    $acf_author_place  = get_field('author_place', 'user_' . $author_id);

                    if (!empty($acf_author_name)) {
                        $display_name = $acf_author_name;
                    }

                    if (!empty($acf_author_place)) {
                        $author_place = $acf_author_place;
                    }

                    if (!empty($acf_author_avatar)) {
                        $avatar_url = is_array($acf_author_avatar) ? $acf_author_avatar['url'] : $acf_author_avatar;
                        if ($avatar_url) {
                            $avatar_html = '<div class="avatar"><img src="' . esc_url($avatar_url) . '" alt="' . esc_attr($display_name) . '"></div>';
                        }
                    }
                }

                if (empty($avatar_html)) {
                    $initials = get_initials($display_name);
                    $avatar_html = '<div class="avatar">' . esc_html($initials) . '</div>';
                }

                echo $avatar_html;
            ?>

            <div class="meta">
                <div class="author">
                    <div class="name">
                        <?php 
                            echo esc_html($display_name); 
                            if (!empty($acf_author_name) && !empty($acf_author_place)) {
                                ?>
                                    <div class="icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="22" viewBox="0 0 18 22" fill="none">
                                            <path d="M9.22079 0.905396C10.0225 0.905396 10.8164 1.06219 11.5571 1.36661C12.2979 1.67104 12.9711 2.11732 13.5381 2.67984C14.105 3.24233 14.5547 3.91009 14.8616 4.645C15.1683 5.37989 15.3262 6.16756 15.3262 6.96299H12.6861C12.686 6.51163 12.5964 6.06464 12.4224 5.64763C12.2482 5.2305 11.9928 4.85119 11.6711 4.53193C11.3493 4.2127 10.9672 3.95934 10.5468 3.78657C10.1264 3.61382 9.67581 3.52504 9.22079 3.52504C8.76577 3.52504 8.31514 3.61381 7.89476 3.78657C7.47436 3.95935 7.09229 4.21269 6.77053 4.53193C6.44876 4.85119 6.19377 5.2305 6.01963 5.64763C5.84553 6.06468 5.75555 6.51158 5.75553 6.96299H5.75425V9.83521H16.2524C17.2176 9.83521 18 10.6176 18 11.5828V19.347C17.9999 20.3121 17.2176 21.0945 16.2524 21.0945H1.74756C0.782447 21.0945 5.76081e-05 20.3121 0 19.347V11.5828C0 10.6176 0.782411 9.83521 1.74756 9.83521H3.10858V9.83052H3.11456L3.10858 9.83521H3.11541V6.96299C3.11543 6.16756 3.27325 5.37988 3.58003 4.645C3.88683 3.91009 4.33663 3.24233 4.90351 2.67984C5.47045 2.11732 6.14371 1.67104 6.88445 1.36661C7.62517 1.06218 8.41904 0.905398 9.22079 0.905396Z" fill="#ED0A34"/>
                                            <path d="M5.21872 11.8278V18.7163H3.64801V13.1176H3.63722L1.74805 14.1532V12.9188L3.73977 11.8278H5.21872Z" fill="white"/>
                                            <path d="M9.18361 11.8278V18.7163H7.6129V13.1176H7.6021L5.71293 14.1532V12.9188L7.70466 11.8278H9.18361Z" fill="white"/>
                                            <path d="M12.7599 18.818C12.1877 18.818 11.6821 18.7256 11.2431 18.5406C10.8041 18.3557 10.4551 18.0983 10.196 17.7686C9.9369 17.4357 9.79477 17.0473 9.76958 16.6035H11.3133C11.3349 16.9271 11.4806 17.1953 11.7505 17.4079C12.024 17.6206 12.3622 17.7269 12.7653 17.7269C13.1863 17.7269 13.5263 17.6067 13.7854 17.3663C14.0481 17.1228 14.1794 16.8116 14.1794 16.4325C14.1794 16.0503 14.0517 15.7374 13.7962 15.4939C13.5407 15.2474 13.2079 15.1241 12.7976 15.1241C12.4414 15.1241 12.1373 15.1888 11.8854 15.3183C11.6336 15.4446 11.4626 15.6234 11.3727 15.8546H9.87753L10.1258 11.8278H15.2536V12.9604H11.5724L11.4213 14.6109H11.432C11.8459 14.2441 12.3964 14.0608 13.0837 14.0608C13.5659 14.0608 14.0067 14.164 14.4061 14.3705C14.8092 14.5739 15.1294 14.8513 15.3669 15.2027C15.608 15.554 15.7286 15.9532 15.7286 16.4001C15.7286 16.8717 15.6044 17.2893 15.3561 17.653C15.1114 18.0167 14.766 18.3018 14.3198 18.5083C13.8736 18.7148 13.3536 18.818 12.7599 18.818Z" fill="white"/>
                                        </svg>
                                    </div>
                                    <span><?php echo $acf_author_place; ?></span>
                                <?php
                            }
                        ?>
                        
                    </div>
                    <!-- <?php if (!empty($author_place)) : ?>
                        <div class="place">
                            <?php echo esc_html($author_place); ?>
                        </div>
                    <?php endif; ?> -->
                    <div class="date">
                        <?php echo get_comment_date('d M, Y'); ?>
                    </div>
                </div>
                
            </div>
        </div>
        <div class="content">
            <?php if ($comment->comment_approved == '0') : ?>
                <em><?php _e('Ваш комментарий ожидает модерации.', 'text-domain'); ?></em>
                <br />
            <?php endif; ?>
            <?php comment_text(); ?>
            <div class="reply">
                <?php
                    $acf_author_name = '';
                    $author_name = get_comment_author($comment); // по умолчанию

                    if ($author_id) {
                        $acf_author_name = get_field('author_name', 'user_' . $author_id);
                        if (!empty($acf_author_name)) {
                            $author_name = $acf_author_name;
                        } else {
                            $wp_user = get_user_by('id', $author_id);
                            if ($wp_user && !empty($wp_user->display_name)) {
                                $author_name = $wp_user->display_name;
                            }
                        }
                    }

                    $reply_link = get_comment_reply_link([
                    'reply_text' => 'Ответить',
                    'depth'      => 1,
                    'max_depth'  => 2,
                    ], $comment->comment_ID);

                    if ($reply_link) {
                        $reply_link = str_replace(
                            'data-replyto="' . esc_attr(sprintf(__('Комментарий к записи %s'), get_comment_author($comment))) . '"',
                            'data-replyto="' . esc_attr($author_name) . '"',
                            $reply_link
                        );
                        $reply_link = str_replace(
                            'aria-label="' . esc_attr(sprintf(__('Комментарий к записи %s'), get_comment_author($comment))) . '"',
                            'aria-label="Ответить ' . esc_attr($author_name) . '"',
                            $reply_link
                        );

                        echo '<div class="reply">' . $reply_link . '</div>';
                    }
                ?>
            </div>
        </div>
    </li>
    <?php
}