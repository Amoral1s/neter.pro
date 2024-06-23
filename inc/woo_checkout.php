<?php
// Кастомизация полей типа text
add_filter('woocommerce_form_field_text', 'custom_woocommerce_form_field_text', 10, 4);
function custom_woocommerce_form_field_text($field, $key, $args, $value) {
    return custom_woocommerce_form_field_common($field, $key, $args, $value);
}

// Кастомизация полей типа textarea
add_filter('woocommerce_form_field_textarea', 'custom_woocommerce_form_field_textarea', 10, 4);
function custom_woocommerce_form_field_textarea($field, $key, $args, $value) {
    return custom_woocommerce_form_field_common($field, $key, $args, $value);
}

// Кастомизация полей типа tel
add_filter('woocommerce_form_field_tel', 'custom_woocommerce_form_field_tel', 10, 4);
function custom_woocommerce_form_field_tel($field, $key, $args, $value) {
    return custom_woocommerce_form_field_common($field, $key, $args, $value);
}

// Кастомизация полей типа email
add_filter('woocommerce_form_field_email', 'custom_woocommerce_form_field_email', 10, 4);
function custom_woocommerce_form_field_email($field, $key, $args, $value) {
    return custom_woocommerce_form_field_common($field, $key, $args, $value);
}

// Общая функция для кастомизации полей
function custom_woocommerce_form_field_common($field, $key, $args, $value) {
    $custom_field = '<div class="input ' . esc_attr(implode(' ', $args['class'])) . '" id="' . esc_attr($key) . '_field">';
    $custom_field .= '<p>' . $args['label'] . '</p>';
    $input_type = isset($args['type']) ? $args['type'] : 'text';
    if ($input_type === 'textarea') {
        $custom_field .= '<textarea class="' . esc_attr(implode(' ', $args['input_class'])) . '" name="' . esc_attr($key) . '" id="' . esc_attr($key) . '" placeholder="' . esc_attr($args['placeholder']) . '" ' . implode(' ', $args['custom_attributes']) . '>' . esc_textarea($value) . '</textarea>';
    } else {
        $custom_field .= '<input type="' . esc_attr($input_type) . '" class="input-text ' . esc_attr(implode(' ', $args['input_class'])) . '" name="' . esc_attr($key) . '" id="' . esc_attr($key) . '" value="' . esc_attr($value) . '" placeholder="' . esc_attr($args['placeholder']) . '" ' . implode(' ', $args['custom_attributes']) . ' />';
    }
    $custom_field .= '<span class="error-message" style="display:none;color:red;"></span>';
    $custom_field .= '</div>';
    return $custom_field;
}

// Удаление страны
add_filter('woocommerce_checkout_fields', 'custom_override_checkout_fields');
function custom_override_checkout_fields($fields) {
    // Удаляем поле выбора страны
    if (isset($fields['billing']['billing_country'])) {
        unset($fields['billing']['billing_country']);
    }

    // Устанавливаем значение страны по умолчанию для России (RU)
    $fields['billing']['billing_country'] = array(
        'type'     => 'hidden',
        'default'  => 'RU'
    );

    return $fields;
}

add_filter('woocommerce_enable_order_notes_field', '__return_false');

// Добавление поля выбора типа покупателя в чекаут
add_action('woocommerce_before_checkout_billing_form', 'add_custom_checkout_field');
function add_custom_checkout_field($checkout) {
    // Поле выбора типа покупателя с радиокнопками
    woocommerce_form_field('customer_type', array(
        'type' => 'radio',
        'class' => array('type'),
        'label' => false,
        'default' => 'individual',
        'options' => array(
            'individual' => __('Физическое лицо'),
            'company' => __('Юридическое лицо')
        ),
    ), $checkout->get_value('customer_type'));

}

// Настройка полей чекаута
add_filter('woocommerce_checkout_fields', 'customize_checkout_fields');
function customize_checkout_fields($fields) {
    // Удаление всех ненужных полей
    unset($fields['billing']['billing_address_2']);
    unset($fields['billing']['billing_postcode']);
    unset($fields['billing']['billing_country']);
    unset($fields['billing']['billing_state']);
    unset($fields['billing']['billing_last_name']);
    unset($fields['shipping']);
    unset($fields['order']['order_comments']);

    // Поля для всех типов покупателей
    $fields['billing']['billing_first_name']['label'] = __('Ваше имя', 'woocommerce');
    $fields['billing']['billing_first_name']['placeholder'] = _x('Ваше имя', 'woocommerce');
    $fields['billing']['billing_first_name']['required'] = false;
    $fields['billing']['billing_first_name']['class'] = array('form-row-wide', 'customer-common');

    // Поле для email, будет использоваться только для юридических лиц
    $fields['billing']['billing_email'] = array(
        'label'       => __('Email', 'woocommerce'),
        'placeholder' => _x('Email', 'woocommerce'),
        'required'    => false,
        'autocomplete'    => 'email',
        'class'       => array('form-row-wide'),
        'clear'       => true
    );
    
    // Поле для телефонного номера
    $fields['billing']['billing_phone'] = array(
        'label'       => __('Ваш телефон*', 'woocommerce'),
        'placeholder' => _x('Ваш телефон*', 'placeholder', 'woocommerce'),
        'required'    => true,
        'class'       => array('form-row-wide', 'customer-common', 'wpcf7'),
        'input_class' => array('wpcf7-tel'),
        'clear'       => true,
        'autocomplete'    => false,
        'type'        => 'tel',
        'custom_attributes' => array('required' => 'required')
    );
    
    // Поле для наименования организации
    $fields['billing']['billing_company']['label'] = __('Наименование организации', 'woocommerce');
    $fields['billing']['billing_company']['placeholder'] = __('Наименование организации', 'woocommerce');
    $fields['billing']['billing_company']['required'] = false;
    $fields['billing']['billing_company']['class'] = array('form-row-wide', 'customer-company');
    
    // Поле для города, будет использоваться только для физических лиц
    $fields['billing']['billing_city'] = array(
        'label'       => __('Город', 'woocommerce'),
        'placeholder' => _x('Город', 'placeholder', 'woocommerce'),
        'required'    => false,
        'class'       => array('form-row-wide', 'customer-individual'),
        'clear'       => true,
        'autocomplete'    => false,
        
    );

    // Поле для адреса, будет использоваться только для физических лиц
    $fields['billing']['billing_address_1'] = array(
        'label'       => __('Адрес', 'woocommerce'),
        'placeholder' => _x('Адрес', 'placeholder', 'woocommerce'),
        'required'    => false,
        'class'       => array('form-row-wide', 'customer-individual'),
        'clear'       => true,
        'autocomplete'    => false,

    );

    // Добавление комментария к заказу
    $fields['billing']['order_comments'] = array(
    'type'        => 'textarea',
    'label'       => __('Комментарий к заказу', 'woocommerce'),
    'placeholder' => _x('Комментарий к заказу', 'placeholder', 'woocommerce'),
    'class'       => array('form-row-wide', 'customer-common'),
    'clear'       => true,
    'autocomplete'    => false,
        
    );

    // Добавление поля для выбора способа связи, будет использоваться только для физических лиц
    $fields['billing']['billing_contact_method'] = array(
        'type' => 'radio',
        'label' => __('Способ связи', 'woocommerce'),
        'options' => array(
            'phone' => __('Телефон', 'woocommerce'),
            'whatsapp' => __('WhatsApp', 'woocommerce'),
            'telegram' => __('Telegram', 'woocommerce')
        ),
        'default' => 'phone',
        'class' => array('type-phone','type', 'customer-individual'),
        'required' => false
    );

    // Сортировка полей для физического лица
    $fields['billing']['billing_first_name']['priority'] = 10;
    $fields['billing']['billing_phone']['priority'] = 20;
    $fields['billing']['billing_contact_method']['priority'] = 30;
    $fields['billing']['billing_city']['priority'] = 40;
    $fields['billing']['billing_address_1']['priority'] = 50;
    $fields['billing']['order_comments']['priority'] = 60;

    // Сортировка полей для юридического лица
    $fields['billing']['billing_first_name']['priority'] = 10;
    $fields['billing']['billing_phone']['priority'] = 20;
    $fields['billing']['billing_email']['priority'] = 30;
    $fields['billing']['billing_company']['priority'] = 40;
    $fields['billing']['order_comments']['priority'] = 50;

	$fields['billing']['billing_phone']['custom_attributes']['data-parsley-error-message'] = 'Телефон обязателен для заполнения!';

    return $fields;
}

// Скрытие/показ полей в зависимости от типа покупателя
add_action('wp_footer', 'toggle_fields_based_on_customer_type');
function toggle_fields_based_on_customer_type() {
    if (is_checkout()) {
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                if (window.screen.width < 992 || jQuery('.map order-map')) {
                    jQuery('body').css('overflow-x', 'hidden');
                    jQuery('html').css('overflow-x', 'hidden');
                }
                function toggleFields(customerType) {
                    if (customerType === 'company') {
                        $('.customer-company').show();
                        $('.customer-individual').hide();
                    } else {
                        $('.customer-company').hide();
                        $('.customer-individual').show();
                    }
                }

                var customerTypeField = $('input[name="customer_type"]');
                toggleFields(customerTypeField.filter(':checked').val());

                customerTypeField.change(function() {
                    toggleFields($(this).val());
                });

                
            });
        </script>
        <?php
    } else { ?>
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                if (window.screen.width) {
                    jQuery('body').css('overflow-x', 'hidden');
                    jQuery('html').css('overflow-x', 'hidden');
                }
            });
        </script>
    <?php }
}

// Сохранение данных полей в заказе
add_action('woocommerce_checkout_update_order_meta', 'save_custom_checkout_fields');
function save_custom_checkout_fields($order_id) {
    if (!empty($_POST['customer_type'])) {
        update_post_meta($order_id, 'Customer Type', sanitize_text_field($_POST['customer_type']));
    }
    if (!empty($_POST['billing_company'])) {
        update_post_meta($order_id, 'Company Name', sanitize_text_field($_POST['billing_company']));
    }
    if (!empty($_POST['billing_email'])) {
        update_post_meta($order_id, 'Billing Email', sanitize_text_field($_POST['billing_email']));
    }
    if (!empty($_POST['billing_contact_method'])) {
        update_post_meta($order_id, 'Contact Method', sanitize_text_field($_POST['billing_contact_method']));
    }
}

// Отображение данных в админке заказа
add_action('woocommerce_admin_order_data_after_billing_address', 'display_custom_checkout_fields_in_admin', 10, 1);
function display_custom_checkout_fields_in_admin($order) {
    echo '<p><strong>' . __('Тип покупателя') . ':</strong> ' . get_post_meta($order->get_id(), 'Customer Type', true) . '</p>';
    echo '<p><strong>' . __('Наименование организации') . ':</strong> ' . get_post_meta($order->get_id(), 'Company Name', true) . '</p>';
    echo '<p><strong>' . __('Email') . ':</strong> ' . get_post_meta($order->get_id(), 'Billing Email', true) . '</p>';
    echo '<p><strong>' . __('Выбор способа связи') . ':</strong> ' . get_post_meta($order->get_id(), 'Contact Method', true) . '</p>';
}

// Отключение стандартной проверки WooCommerce для поля "телефон"
add_filter('woocommerce_default_address_fields', 'remove_default_validation', 20, 1);
function remove_default_validation($fields) {
    if (isset($fields['phone'])) {
        unset($fields['phone']['required']);
    }
    return $fields;
}

// Добавление пользовательского сообщения об ошибке для поля "телефон"
add_action('woocommerce_checkout_process', 'custom_checkout_field_process');
function custom_checkout_field_process() {
    if (empty($_POST['billing_phone'])) {
        wc_add_notice(__('Телефон обязателен для заполнения!', 'woocommerce'), 'error');
    }
}