<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://kendallarneaud.me
 * @since             1.0.0
 * @package           Wc_Trincargo_Shipping
 *
 * @wordpress-plugin
 * Plugin Name:       Wicommerce Shipping Extension
 * Plugin URI:        http://www2.trinebox.com/index.php/en/information/our-services
 * Description:       Shipping Extension Plugin for WooCommerce. Delivery services for Trinidad and Tobago provided by Trin-e-box.
 * Version:           1.0.0
 * Author:            Kendall Arneaud for Trin-e-box
 * Author URI:        http://kendallarneaud.me
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wc-trinicargo-shipping
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wc-trinicargo-shipping-activator.php
 */
function activate_wc_trinicargo_shipping() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wc-trinicargo-shipping-activator.php';
	Wc_Trincargo_Shipping_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wc-trinicargo-shipping-deactivator.php
 */
function deactivate_wc_trinicargo_shipping() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wc-trinicargo-shipping-deactivator.php';
	Wc_Trincargo_Shipping_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wc_trinicargo_shipping' );
register_deactivation_hook( __FILE__, 'deactivate_wc_trinicargo_shipping' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'wc-trinicargo-shipping-constants.php';
require plugin_dir_path( __FILE__ ) . 'includes/class-wc-trinicargo-shipping.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wc_trinicargo_shipping() {
	$plugin = new Wc_Trincargo_Shipping();
	$plugin->run();
}

run_wc_trinicargo_shipping();
