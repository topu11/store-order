<?php

/**
 * Fired during plugin activation
 *
 * @link       https://touhidulit.com
 * @since      1.0.0
 *
 * @package    Store_Order_Plugin
 * @subpackage Store_Order_Plugin/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Store_Order_Plugin
 * @subpackage Store_Order_Plugin/includes
 * @author     Touhidul <touhidulislam256@gmil.com>
 */
class Store_Order_Plugin_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		// Check if Woo is active
		if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

			// Woo is active.

		} else {

			//deactivate_plugins( plugin_basename( __FILE__ ) );
			//Store_Order_Plugin_Deactivator::deactivate();
			//
			require_once plugin_dir_path( __FILE__ ) . '/class-store-order-plugin-deactivator.php';
	        Store_Order_Plugin_Deactivator::deactivate();
			wp_die( __( 'Please activate WooCommerce.', 'store-order-plugin' ), 'Plugin dependency check', array( 'back_link' => true ) );
		}
	}
	

}
