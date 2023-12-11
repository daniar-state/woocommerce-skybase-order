<?php

function skybase_send_data($data_order)
{
    global $log;

    $authentication_url = 'https://app.skybase.ru/app16740/login';
    $order_create_url = 'https://app.skybase.ru/app16740/saveData';

    $authentication_data = ['login' => 'event.climate@mail.ru', 'password' => 'xueqWg2q91esNgyL',];
    $authentication_response = wp_remote_post($authentication_url, ['body' => $authentication_data]);

    if (is_wp_error($authentication_response) || wp_remote_retrieve_response_code($authentication_response) !== 200) {
        error_log("Ошибка авторизации: " . print_r($authentication_response, true), 3, $log);
        return false;
    } else {
        error_log("\r\n[Заказ] Authorization successful  \n", 3, $log);
    }

    $request_args_data = [
        'body' => $data_order,
        'headers' => [
            'Content-Type' => 'application/json',
            'Cookie' => wp_remote_retrieve_header($authentication_response, 'set-cookie'),
        ],
    ];

    $response_data = wp_remote_post($order_create_url, $request_args_data);

    if (is_wp_error($response_data) || wp_remote_retrieve_response_code($response_data) !== 200) {
        error_log("\r\nОшибка при отправке json_data(Заказ): " . print_r($response_data, true) . "\r\n", 3, $log);
    } else {
        error_log("\r\n[Заказ] успешно создан!  \r\n", 3, $log);
    }
}

?>