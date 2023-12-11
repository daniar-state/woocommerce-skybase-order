<?php

function skybase_create_client($data_client)
{
    global $log;

    $authentication_url = 'https://app.skybase.ru/app16740/login';
    $client_create_url = 'https://app.skybase.ru/app16740/saveData';

    $authentication_data = ['login' => '###', 'password' => '###',];
    $authentication_response = wp_remote_post($authentication_url, ['body' => $authentication_data]);

    if (is_wp_error($authentication_response) || wp_remote_retrieve_response_code($authentication_response) !== 200) {
        error_log("Ошибка авторизации: " . print_r($authentication_response, true), 3, $log);
        return false;
    } else {
        error_log("\r\n[Client] Authorization successful  \n", 3, $log);
    }

    $request_args_client = [
        'body' => $data_client,
        'headers' => [
            'Content-Type' => 'application/json',
            'Cookie' => wp_remote_retrieve_header($authentication_response, 'set-cookie'),
        ],
    ];

    $response_client = wp_remote_post($client_create_url, $request_args_client);

    if (is_wp_error($response_client) || wp_remote_retrieve_response_code($response_client) !== 200) {
        error_log("\r\nОшибка при создание клиента: " . print_r($response_client, true) . "\r\n", 3, $log);
        return false;
    } else {
        error_log("\r\n[Client] успешно создан! \r\n", 3, $log);
    }
}

?>