<?php
/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://github.com/BrianHenryIE/bh-wc-set-gateway-by-url/
 * @since      1.0.0
 *
 * @package brianhenryie/bh-wc-set-gateway-by-url
 */

namespace BrianHenryIE\WC_Set_Gateway_By_URL\WP_Includes;

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package brianhenryie/bh-wc-set-gateway-by-url
 *
 * @author     Brian Henry <BrianHenryIE@gmail.com>
 */
class I18n {

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @hooked plugins_loaded
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain(): void {

		load_plugin_textdomain(
			'bh-wc-set-gateway-by-url',
			false,
			dirname( plugin_basename( __FILE__ ), 3 ) . '/languages/'
		);

	}

}
