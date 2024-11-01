<?php

if ( ! defined( 'WPINC' ) ) {
	die;
}


define( 'WC_TRINICARGO_SHIPPING_VERSION', '1.0.0' );


if (!defined('WC_TRINICARGO_SHIPPING_URL')) {
    define('WC_TRINICARGO_SHIPPING_URL', plugin_dir_url(__FILE__));
}
if (!defined('WC_TRINICARGO_SHIPPING_DIR')) {
    define('WC_TRINICARGO_SHIPPING_DIR', dirname(__FILE__));
}
if (!defined('WC_TRINICARGO_SHIPPING_DIR_PATH')) {
    define('WC_TRINICARGO_SHIPPING_DIR_PATH', plugin_dir_path(__FILE__));
}
if (!defined('WC_TRINICARGO_SHIPPING_BASENAME')) {
    define('WC_TRINICARGO_SHIPPING_BASENAME', plugin_basename(__FILE__));
}
if (!defined('WC_TRINICARGO_SHIPPING_NAME')) {
    define('WC_TRINICARGO_SHIPPING_NAME', 'Trincargo Shipping Extension For WooCommerce');
}
if (!defined('WC_TRINICARGO_SHIPPING_TEXT_DOMAIN')) {
    define('WC_TRINICARGO_SHIPPING_TEXT_DOMAIN', 'wc-trinicargo-shipping');
}
 ?>
