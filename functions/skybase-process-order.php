<?php

function skybase_process_order($order_id)
{
    global $log;

    $order = wc_get_order($order_id);
    $first_name = $order->get_billing_first_name();
    $last_name = $order->get_billing_last_name();
    $client = $first_name . ' ' . $last_name;
    $company = $order->get_billing_company();
    $client_address = $order->get_billing_address_1();
    $client_email = $order->get_billing_email();
    $client_phone = $order->get_billing_phone();
    $product_items = $order->get_items();

    $equipment_items = [];
    foreach ($product_items as $item) {
        $equipment_items[] = $item->get_name();
    }
    $equipment_items = implode(', ', $equipment_items);

    $rental_start = $order->get_meta('billing_rentstart');
    $rental_end = $order->get_meta('billing_rentend');
    $rental_start_date = date('Y-m-d H:i:s', strtotime($rental_start));
    $rental_end_date = date('Y-m-d H:i:s', strtotime($rental_end));
    $status = $order->get_status();
    $total_price = $order->get_total();
    $residue_price = $total_price;
    $create_date = $order->get_date_created()->format('Y-m-d H:i:s');
    $client_note = $order->get_customer_note();

    log_order_details($client, $company, $client_address, $client_email, $client_phone, $equipment_items, $rental_start_date, $rental_end_date, $status, $total_price, $residue_price, $create_date, $client_note);

    $data_client = [
        "data" => [
            "sb_sys" => [
                "status" => "new",
                "typeId" => "table.10001"
            ],
            "f1" => $client,
            "f40" => $company,
            "f4" => $client_phone,
            "f5" => $client_address,
            "f15" => 0,
            "f10" => $client_email,
            "f17" => $client_address,
            "f12" => $create_date,
            "f26" => $client_note,
        ]
    ];

    $json_client = json_encode($data_client);
    skybase_create_client($json_client);

    $client_id = skybase_id($client);
    if ($client_id !== false) {
        error_log("[ФИО Клиента]: $client = [ID Клиента]: $client_id\r\n", 3, $log);
    } else {
        error_log("\r\nКлиент с именем [$client] не найден\r\n", 3, $log);
    }

    $data_order = [
        "data" => [
            "sb_sys" => [
                "status" => "new",
                "typeId" => "table.10006"
            ],
            "f1" => $create_date,
            "f2" => $client_id,
            "f6" => $rental_start_date,
            "f21" => $rental_end_date,
            "f29" => $client_note,
            "f10" => 1,
            "f5" => 1
        ]
    ];

    $json_order = json_encode($data_order);
    skybase_send_data($json_order);
}

?>