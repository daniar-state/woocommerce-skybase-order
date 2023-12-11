<?php

function skybase_id($client)
{
    global $log;

    $authentication_url = 'https://app.skybase.ru/app16740/login';
    $client_id_url = 'https://app.skybase.ru/app16740/tables/10001?format=json';

    $authentication_data = ['login' => '###', 'password' => '###',];
    $authentication_response = wp_remote_post($authentication_url, ['body' => $authentication_data]);

    if (is_wp_error($authentication_response) || wp_remote_retrieve_response_code($authentication_response) !== 200) {
        error_log("Ошибка авторизации: " . print_r($authentication_response, true), 3, $log);
        return false;
    } else {
        error_log("\r\n[ID Client] Authorization successful \n", 3, $log);
    }

    $request_args = [
        'headers' => [
            'Content-Type' => 'application/json',
            'Cookie' => wp_remote_retrieve_header($authentication_response, 'set-cookie'),
        ],
    ];

    $response = wp_remote_get($client_id_url, $request_args);

    if (is_wp_error($response) || wp_remote_retrieve_response_code($response) !== 200) {
        error_log("\r\nОшибка при получение ID клиента \r\n", 3, $log);
        return false;
    }

    $data = json_decode(wp_remote_retrieve_body($response), true);

    if (is_array($data) && !empty($data)) {
        foreach ($data as $clientData) {
            if ($clientData['f1'] === $client) {
                return $clientData['id'];
            }
        }
    }
}

?>
