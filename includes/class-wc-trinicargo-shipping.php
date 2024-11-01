<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://kendallarneaud.me
 * @since      1.0.0
 *
 * @package    Wc_Trincargo_Shipping
 * @subpackage Wc_Trincargo_Shipping/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Wc_Trincargo_Shipping
 * @subpackage Wc_Trincargo_Shipping/includes
 * @author     Kendall ARneaud <info@kendallarneaud.me>
 */
class Wc_Trincargo_Shipping {
	protected $wc_trinicargo_shipping_method;
	protected $wc_trinicargo_shipping_create_waybill_method;
	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Wc_Trincargo_Shipping_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'WC_TRINICARGO_SHIPPING_VERSION' ) ) {
			$this->version = WC_TRINICARGO_SHIPPING_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'wc-trinicargo-shipping';
		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Wc_Trincargo_Shipping_Loader. Orchestrates the hooks of the plugin.
	 * - Wc_Trincargo_Shipping_i18n. Defines internationalization functionality.
	 * - Wc_Trincargo_Shipping_Admin. Defines all hooks for the admin area.
	 * - Wc_Trincargo_Shipping_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		 require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wc-trinicargo-shipping-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wc-trinicargo-shipping-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wc-trinicargo-shipping-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wc-trinicargo-shipping-public.php';

		require plugin_dir_path( dirname(__FILE__) ) . 'includes/class-waybill.php';

	  require plugin_dir_path( dirname(__FILE__) ) . 'includes/class-wc-trinicargo-shipping-create-waybill.php';



		$this->loader = new Wc_Trincargo_Shipping_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Wc_Trincargo_Shipping_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Wc_Trincargo_Shipping_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Wc_Trincargo_Shipping_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'woocommerce_shipping_init', $this, 'wc_trinicargo_shipping_init_method');
		$this->loader->add_action( 'woocommerce_shipping_methods', $this, 'wc_trinicargo_shipping_register_method_class');
		$this->loader->add_filter('plugin_action_links', $plugin_admin, 'link_settings', 10, 3);
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Wc_Trincargo_Shipping_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Wc_Trincargo_Shipping_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	public function wc_trinicargo_shipping_init_method() {
      require_once WC_TRINICARGO_SHIPPING_DIR . '/admin/partials/wc-trinicargo-shipping-init-methods.php';
			require_once WC_TRINICARGO_SHIPPING_DIR . '/includes/class-wc-trinicargo-shipping-create-waybill.php';

      $this->wc_trinicargo_shipping_method = new Wc_Trincargo_Shipping_Method();
			add_action('woocommerce_update_options_shipping_' . $this->wc_trinicargo_shipping_method->id, [$this->wc_trinicargo_shipping_method, 'process_admin_options']);
      add_action('woocommerce_order_status_processing', [$this->wc_trinicargo_shipping_method, 'create_waybill'], 10, 1 );

			$this->wc_trinicargo_shipping_create_waybill_method = new Wc_Trinicargo_Shipping_Create_Waybill();
			add_action('wc-trinicargo-shipping_create_waybill', [$this->wc_trinicargo_shipping_create_waybill_method, 'init'], 1, 2 );
			add_action('woocommerce_email_order_meta', [$this->wc_trinicargo_shipping_create_waybill_method, 'add_order_notes_to_email'], 10, 2 );

  }

		/**
     * Add shipping method.
     *
     * Add configured methods to available shipping methods.
     *
     * @since 1.0.0
     */
    public function wc_trinicargo_shipping_register_method_class($methods) {

        if (class_exists('Wc_Trincargo_Shipping_Method')) {
            $methods[] = 'Wc_Trincargo_Shipping_Method';
        }

        return $methods;
    }
}
