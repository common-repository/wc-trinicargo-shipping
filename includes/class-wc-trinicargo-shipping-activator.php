<?php

/**
 * Fired during plugin activation
 *
 * @link       http://kendallarneaud.me
 * @since      1.0.0
 *
 * @package    Wc_Trincargo_Shipping
 * @subpackage Wc_Trincargo_Shipping/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wc_Trincargo_Shipping
 * @subpackage Wc_Trincargo_Shipping/includes
 * @author     Kendall ARneaud <info@kendallarneaud.me>
 */
class Wc_Trincargo_Shipping_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		Wc_Trincargo_Shipping_Activator::wc_trinicargo_shipping_activation_check();
	}

	public static function wc_trinicargo_shipping_activation_check(){
		if ( ! class_exists( 'SoapClient' ) ) {
	        deactivate_plugins( basename( __FILE__ ) );
	        wp_die( 'Sorry, but you cannot run this plugin, it requires the <a href="http://php.net/manual/en/class.soapclient.php">SOAP</a> support on your server/hosting to function.' );
		}
	}

}
