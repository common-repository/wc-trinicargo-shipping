<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
* Class Wc_Trincargo_Shipping_Method.
*
* WooCommerce Advanced flat rate shipping method class.
*/
if (!class_exists('Wc_Trincargo_Shipping_Method')) {

    class Wc_Trincargo_Shipping_Method extends WC_Shipping_Method {
        protected $fee_cost = 30.00;
        public $fee = 30.00;
        /**
         * Constructor
         *
         * @since 1.0.0
         */
        public function __construct($instance_id = 0) {
            parent::__construct($instance_id);

            $this->id = WC_TRINICARGO_SHIPPING_TEXT_DOMAIN;
            $this->method_title = __('Trin-e-box Shipping', WC_TRINICARGO_SHIPPING_TEXT_DOMAIN);
            $this->title = $this->method_title;
            $this->availability = 'specific';
            $this->countries = array('TT');
            $this->method_description = __('Local delivery via Trin-e-box Shipping with a Flat Rate Fee of $30.00TTD per order', WC_TRINICARGO_SHIPPING_TEXT_DOMAIN);

            $this->init();
            $this->fee = isset($this->settings['fee'])? $this->settings['fee'] : $this->fee_cost;
            $this->enabled = isset($this->settings['enabled'])? $this->settings['enabled'] : 'no';
        }

        /**
         * Init
         *
         * @since 1.0.0
         */
        function init() {
            $this->init_form_fields();
            $this->init_settings();
        }

        /**
         * Init form fields.
         *
         * @since 1.0.0
         */
        public function init_form_fields() {
            $this->form_fields = array(
                 'enabled' => array(
                 'title' => __('Enable', WC_TRINICARGO_SHIPPING_TEXT_DOMAIN),
                 'type' => 'checkbox',
                 'default' => 'yes'
                    ),
                'fee' => array(
                'title' => __('Shipping Fee', WC_TRINICARGO_SHIPPING_TEXT_DOMAIN),
                'type' => 'number',
                'default' => 30
                   ),
                   'waybill_customer_id' => array(
                   'title' => __('Customer ID', WC_TRINICARGO_SHIPPING_TEXT_DOMAIN),
                   'type' => 'text',
                   'label' => __('Enter your Trin-e-box customer if', WC_TRINICARGO_SHIPPING_TEXT_DOMAIN),
                   'description' => 'Enter the customer id provided by Trin-e-box',
                   'default' => 'TEST_CUSTOMER'
                      ),
                'waybill_username' => [
                    'title' => __('Username', WC_TRINICARGO_SHIPPING_TEXT_DOMAIN),
                    'type' => 'text',
                    'default' => 'testuser',
                    'label' => __('Enter your Trin-e-box username', WC_TRINICARGO_SHIPPING_TEXT_DOMAIN),
                    'description' => 'Enter the account username provided by Trin-e-box'
                    ],
                'waybill_password' => [
                    'title' => __('Password', WC_TRINICARGO_SHIPPING_TEXT_DOMAIN),
                    'type' => 'password',
                    'default' => 'password',
                    'label' => __('Enter your Trin-e-box password', WC_TRINICARGO_SHIPPING_TEXT_DOMAIN),
                    'description' => 'Enter the account password provided by Trin-e-box'
                    ],
                'waybill_pickupdays' => [
                    'default' => 2,
                    'title' => __('Pickup Request Date', WC_TRINICARGO_SHIPPING_TEXT_DOMAIN),
                    'type' => 'number',
                    'label' => __('Enter the number of day(s)', WC_TRINICARGO_SHIPPING_TEXT_DOMAIN),
                    'description' => 'Enter the number of days after order payment is complete to have the package(s) picked up from your warehouse. The Date is calculated as nth days after date order has made or been paid for.'
                    ],
                'waybill_pickupaddress' => [
                    'default' => get_option('woocommerce_store_address'),
                    'title' => __('Pickup Address', WC_TRINICARGO_SHIPPING_TEXT_DOMAIN),
                    'type' => 'text',
                    'label' => __('Enter address if different from store address', WC_TRINICARGO_SHIPPING_TEXT_DOMAIN),
                    'description' => 'Enter the address where deliveries should be picked up from.'
                    ],
                'waybill_pickupaddress1' => [
                    'default' => get_option('woocommerce_store_address1'),
                    'title' => __('Pickup Address 1', WC_TRINICARGO_SHIPPING_TEXT_DOMAIN),
                    'type' => 'text',
                    'label' => __('Enter address if different from store address', WC_TRINICARGO_SHIPPING_TEXT_DOMAIN),
                    'description' => 'Enter the address where deliveries should be picked up from.'
                    ],
                'waybill_pickupcity' => [
                    'default' => get_option('woocommerce_store_city'),
                    'title' => __('Pickup Address City', WC_TRINICARGO_SHIPPING_TEXT_DOMAIN),
                    'type' => 'text',
                    'label' => __('Enter address city if different from store address', WC_TRINICARGO_SHIPPING_TEXT_DOMAIN),
                    'description' => 'Enter the address city where deliveries should be picked up from.'
                    ],
                'waybill_pickupcosignee' => [
                    'default' => 'Anyone',
                    'title' => __('Pickup Contact Name', WC_TRINICARGO_SHIPPING_TEXT_DOMAIN),
                    'type' => 'text',
                    'label' => __('Enter the name of a contact for pickup deliveries', WC_TRINICARGO_SHIPPING_TEXT_DOMAIN),
                    'description' => 'This would be the name/ cosignee for the pickup/ delivery'
                    ],
         );
        }
        /**
         * Calculate shipping.
         *
         * @since 1.0.0
         *
         * @param array $package List containing all products for this method.
         */
        public function calculate_shipping($package = array()) {
            if( $this->is_available($package)) {

                $rate = array(
                	'id'       => $this->id,
                	'label'    => "Trin-e-box Shipping Rate",
                	'cost'     => $this->fee,
                	'calc_tax' => 'per_item'
                );

                // Register the rate
                $this->add_rate( $rate );
            }

        }

        private function environment_check() {
      		  global $woocommerce;

        		if ( get_woocommerce_currency() != "TTD" ) {
        			echo '<div class="notice">
        				<p>' . __( 'Trin-e-box Shipping requires the currency in Trinidad and Tobago Dollars.', WC_TRINICARGO_SHIPPING_TEXT_DOMAIN ) . '</p>
        			</div>';
        		}

        		if ( $woocommerce->countries->get_base_country() != "TT" ) {
        			echo '<div class="error">
        				<p>' . __( 'Trin-e-box requires that the base country/region is set to Trinidad and Tobago.', WC_TRINICARGO_SHIPPING_TEXT_DOMAIN ) . '</p>
        			</div>';
        		}
    	   }

        public function admin_options() {
    		    // Check users environment supports this method
    		  $this->environment_check();

            parent::admin_options();
    	   }

        public function create_waybill($order_id)
        {
            $order = wc_get_order( $order_id );
            $waybill_opts = [
                    'unit_dimensions' => get_option( 'woocommerce_dimension_unit' ),
                    'weight_unit' => get_option( 'woocommerce_weight_unit' ),
                    'waybill_customer_id' => $this->get_option('waybill_customer_id'),
                    'waybill_username' => $this->get_option('waybill_username'),
                    'waybill_password' => $this->get_option('waybill_password'),
                    'waybill_pickupdays' => $this->get_option('waybill_pickupdays'),
                    'waybill_pickupcosignee' => $this->get_option('waybill_pickupcosignee'),
                    'waybill_pickupaddress' => $this->get_option('waybill_pickupaddress'),
                    'waybill_pickupaddress1' => $this->get_option('waybill_pickupaddress1'),
                    'waybill_pickupcity' => $this->get_option('waybill_pickupcity')
                ];

            do_action('wc-trinicargo-shipping_create_waybill', $order, $waybill_opts);
        }


    }
}
?>
