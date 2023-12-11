<?php

function log_order_details($client, $company, $client_address, $client_email, $client_phone, $equipment_items, $rental_start_date, $rental_end_date, $status, $total_price, $residue_price, $create_date, $client_note)
{
    global $log;

    $log_info_client_message = "\r\nПолучение данных клиента:\r\n\r\n" .
        "[1] ФИО Клиента: $client\r\n" .
        "[2] Компания: $company\r\n" .
        "[3] Адрес клиента: $client_address\r\n" .
        "[4] Почта клиента: $client_email\r\n" .
        "[5] Номер клиента: $client_phone\r\n" .
        "[6] Заказ товары: $equipment_items\r\n" .
        "[7] Дата начало аренды: $rental_start_date\r\n" .
        "[8] Дата конца аренды: $rental_end_date\r\n" .
        "[9] Статус заказа: $status\r\n" .
        "[10] Сумма заказа: $total_price\r\n" .
        "[11] Остаток сумма: $residue_price\r\n" .
        "[12] Дата создания заказа: $create_date\r\n" .
        "[13] Примечание к заказу: $client_note\r\n" .
        "===========================================\r\n\r\n";

    error_log($log_info_client_message, 3, $log);
}

?>