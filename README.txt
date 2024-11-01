=== Plugin Name ===
Plugin Name: Wicommerce Shipping Extension
Plugin URI: http://www2.trinebox.com/index.php/en/information/our-services
Author: Kendall Arneaud for Trin-e-box
Author URI: http://www.kendallarneaud.me
Contributors: Kendall Arneaud, Natalie O'brien, Nigel Bellamy
Tags: wipay, wicommerce, shipping, woocommerce, trinidad, tobago, trinebox
Requires at least: 4.4
Tested up to: 4.9
Stable tag: 1.0.0
Version: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Shipping Extension Plugin for WooCommerce. Delivery services for Trinidad and Tobago provided by Trin-e-box.

== Description ==

The Wicommerce Shipping Extension Plugin offers local delivery services for Trinidad and Tobago provided by Trin-e-box for WooCommerce storefronts. You would be required to register for membership to be able to use the service.

A few notes about:

*   This plugin was developed for a service provided within Trinidad and Tobago ONLY.
*   You would require a customer ID, username and password which can be obtained by registering for membership with Trin-e-box services.
*   The standard shipping rate for the service is a flat fee of $30.00TTD

== System Requirements ==

*   PHP >= 5.6
*   PHP Soap Client Extension
*   PHP cURL Extension
*   Woocommerce >= 3.2.5

== Installation ==

Before installation the following requirements for WooCommerce should be met:-

*   WooCommerce general option store location country should be set to Trinidad and Tobago
*   WooCommerce general options selling location(s), sell to specific countries, ship to specific location(s) or ship to specific countries should have Trinidad and Tobago as a value.
*   WooCommerce general option currency option parameter MUST be set to Trinidad and Tobago dollars.
*   ALL PRODUCTS applicable for shipping should have a Weight AND Dimensions. Products submitted for shipping that do not have these parameters set would result in error.

1. Upload `wc-trinicargo-shipping.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Navigate to Woocommerce->Settings->Shipping. Click on Wicommerce shipping option.
4. Ensure the enabled parameter is checked.
5. Enter the shipping you wish to apply to orders. The default shipping rate is $30.00TTD.
6. Enter the customer ID provided by Trin-e-box upon registration.
7. Enter the login username provided by Trin-e-box upon registration.
8. Enter the login password provided by Trin-e-box upon registration.
9. Enter the number of days from which the order was placed/ paid to have the ordered items picked up for shipping.
10. Enter the address the order would be picked up from if different from Woocommerce store address.
11. Enter a contact consignee for the order pickup information.

== Usage ==

When an order is created the plugin will append a cost of the flat fee rate onto the current cost of the order provided that the shipping information’s country option has a value of Trinidad and Tobago and the currency is in Trinidad and Tobago Dollars. When an order is marked as “processing” the plugin sends the order’s shipping information to Trin-e-box’s system which will return a shipping ID number. A successful return will result in a shipping number being appended to your customer’s order receipt and also an “order note” added to the order which can be viewed via the administration’s mange order details section of Woocommerce.

== Troubleshooting ==

= Unable to install plugin =

Be sure to meet the system’s requirements before installing the plugin. The plugin would not be activated if the store’s country/ selling country/ shipping country does not have Trinidad and Tobago as a value or the currency is not set to Trinidad and Tobago dollars.

= Trin-e-box Shipping Rate not being set =

Shipping rate for Trin-e-box will be applied if the currency is in Trinidad and Tobago Dollars and the country of the shipping address value is Trinidad and Tobago.

= Order created but no shipping number assigned =

If the order status has not be marked as “processing” no shipping number would generated. If/ When an order has been set with an order status of “processing” a shipping number would be generated and an order note would be created with the necessary shipping number and details. If an email is sent a shipping number would be appended to the email before being sent. If an order has been set when an order status of “processing” and no order note has been generated try inspecting one of the following:-

1. Ensure all products applicable for shipping have a weight unit and unit dimensions set.
2. Check your login credentials.

If there is still a problem, please contact support highlighting any errors and details pertinent to the order and transaction.

== Screenshots ==

1. Woocommerce store front information settings.
2. Woocommerce currency settings.
3. Product shipping attributes
4. Plugin settings
5. Order note created showing shipping number and delivery information in order notes
