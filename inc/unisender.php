<?php
// Функция для отправки данных в Unisender
function send_to_unisender($data, $list_id) {
  $api_key = '6g5st7c8gys4q4orryw5x1mgfw4o4zkdqhmrytja';
  
  // Получаем данные из формы
  $email = isset($data['Email']) ? $data['Email'] : '';
  $name = isset($data['Name']) ? $data['Name'] : '';
      
  // Если email не указан, прерываем выполнение функции
  if (empty($email)) {
    error_log('Unisender: Email is missing in the form submission.');
    return;
  }

  $fields = array(
    'api_key' => $api_key,
    'list_ids' => $list_id,
    'fields[email]' => $email,
    'fields[Name]' => $name,
    'double_optin' => 3
  );

  $url = 'https://api.unisender.com/ru/api/subscribe?format=json';

  $response = wp_remote_post($url, array(
    'method' => 'POST',
    'body' => $fields,
  ));

  if (is_wp_error($response)) {
    error_log('Unisender API error: ' . $response->get_error_message());
  } else {
    $body = wp_remote_retrieve_body($response);
    $result = json_decode($body, true);

    // Добавляем логирование всего ответа для отладки
    error_log('Unisender API response: ' . print_r($result, true));

    if (isset($result['error'])) {
        error_log('Unisender API error: ' . $result['error']);
    } else {
        error_log('Unisender: Successfully subscribed user - ' . $email);
    }
  }
}

    
// Хук на отправку формы Contact Form 7
add_action('wpcf7_mail_sent', 'send_contact_form_to_unisender');

function send_contact_form_to_unisender($contact_form) {
    $form_id = $contact_form->id();
    $submission = WPCF7_Submission::get_instance();

    // Ассоциативный массив для сопоставления ID форм и ID списков Unisender
    $forms_to_lists = array(
        '203' => '35',
        '326' => '35',
        '327' => '795',
        // Добавьте здесь другие формы и соответствующие списки
    );

    if ($submission && isset($forms_to_lists[$form_id])) {
        $data = $submission->get_posted_data();
        $list_id = $forms_to_lists[$form_id];

        // Логирование данных перед отправкой
        error_log('Unisender: Sending data to list ID ' . $list_id . ' for form ID ' . $form_id . ' with data: ' . print_r($data, true));

        send_to_unisender($data, $list_id);
    } else {
        error_log('Unisender: Form ID not found or no list associated with this form ID - ' . $form_id);
    }
}