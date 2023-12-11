<?php

/**
 * Plugin Name: Skybase orders with WooCommerce
 * Description: Разработанный плагин для CMS Wordpress + Woocommerce. рекомендуемый для добавления дополнительных опций оплаты. (Оплата только доставки) для возможности при оформлении заказа выбрать вариант оплаты и оплатить только доставку товара при получении, а также функционал для подключения платежной системы ЮМани для проведения оплаты и обработки платежа.
 * Version: 1.1
 * Author: Daniar Jabagin
 * Author URI: https://daniar-state.vercel.app/
 * Text Domain: Skybase orders with WooCommerce
 * Domain Path: /languages
 * License: MIT
 * License URI: https://opensource.org/license/mit/
 * Requires at least: 6.3.0
 * Tested up to: 6.3.1
 * Stable tag: 6.3.1
 * Tags: WooCommerce, Skybase API, Integration, Orders
 * Requires PHP: 7.0
*/

    require_once(plugin_dir_path(__FILE__) . 'functions/logging.php');
    require_once(plugin_dir_path(__FILE__) . 'functions/log-details.php');
    require_once(plugin_dir_path(__FILE__) . 'functions/skybase-process-order.php');
    require_once(plugin_dir_path(__FILE__) . 'functions/skybase-create-client.php');
    require_once(plugin_dir_path(__FILE__) . 'functions/skybase-id.php');
    require_once(plugin_dir_path(__FILE__) . 'functions/skybase-send-data.php');

    add_action('woocommerce_checkout_order_processed', 'skybase_process_order');

?>