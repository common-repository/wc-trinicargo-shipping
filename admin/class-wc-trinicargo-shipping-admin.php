<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://kendallarneaud.me
 * @since      1.0.0
 *
 * @package    Wc_Trincargo_Shipping
 * @subpackage Wc_Trincargo_Shipping/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wc_Trincargo_Shipping
 * @subpackage Wc_Trincargo_Shipping/admin
 * @author     Kendall ARneaud <info@kendallarneaud.me>
 */
class Wc_Trincargo_Shipping_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wc_Trincargo_Shipping_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wc_Trincargo_Shipping_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wc-trinicargo-shipping-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wc_Trincargo_Shipping_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wc_Trincargo_Shipping_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wc-trinicargo-shipping-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function link_settings( $links, $plugin_file, $plugin_data ) {
			$settings_link = '<a href="'.admin_url( 'admin.php?page=wc-settings&tab=shipping&section=' . WC_TRINICARGO_SHIPPING_TEXT_DOMAIN ).'">Settings</a>';
			array_push( $links, $settings_link);
			if ( isset( $plugin_data['slug'] ) && current_user_can( 'install_plugins' ) && isset( $plugin_data['PluginURI'] ) && false !== strpos( $plugin_data['PluginURI'], 'http://wordpress.org/extend/plugins/' )) {
				$details_link= sprintf( '<a href="%s" class="thickbox" title="%s">%s</a>',
					self_admin_url( 'plugin-install.php?tab=plugin-information&amp;plugin=' . WC_TRINICARGO_SHIPPING_TEXT_DOMAIN . '&amp;TB_iframe=true&amp;width=600&amp;height=550' ),
					esc_attr( sprintf( __( 'More information about %s' ), $plugin_data['Name'] ) ),
					__( 'Details' )
				);

				array_push( $links, $settings_link);
			}

			return $links;
	}

}
