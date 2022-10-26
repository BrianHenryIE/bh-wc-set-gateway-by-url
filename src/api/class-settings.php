<?php
/**
 * The plugin's settings.
 *
 * @package brianhenryie/bh-wc-set-gateway-by-url
 */

namespace BrianHenryIE\WC_Set_Gateway_By_URL\API;

use BrianHenryIE\WC_Set_Gateway_By_URL\Admin\Admin_Assets;
use BrianHenryIE\WC_Set_Gateway_By_URL\Settings_Interface;
use BrianHenryIE\WC_Set_Gateway_By_URL\WooCommerce\WooCommerce_Init;
use BrianHenryIE\WC_Set_Gateway_By_URL\WP_Logger\Logger_Settings_Interface;
use Psr\Log\LogLevel;

/**
 * Class Settings
 */
class Settings implements Settings_Interface, Logger_Settings_Interface {

	const LOG_LEVEL_OPTION_NAME = 'bh_wc_set_gateway_by_url_log_level';

	/**
	 * The plugin slug for CSS handle.
	 *
	 * @used-by Admin_Assets::enqueue_scripts()
	 * @used-by BH_WP_Logger
	 *
	 * @return string
	 */
	public function get_plugin_slug(): string {
		return 'bh-wc-set-gateway-by-url';
	}

	/**
	 * The plugin version for CSS version.
	 *
	 * @used-by Admin_Assets::enqueue_scripts()
	 * @used-by BH_WP_Logger
	 *
	 * @return string
	 */
	public function get_plugin_version(): string {
		return '1.2.1';
	}

	/**
	 * The log detail level.
	 * There's no UI to configure this, but get_option's filters can be used to control it.
	 *
	 * @used-by BH_WP_Logger
	 * @see WooCommerce_Init::set_payment_gateway_from_url()
	 *
	 * @return string
	 */
	public function get_log_level(): string {
		return get_option( self::LOG_LEVEL_OPTION_NAME, LogLevel::INFO );
	}

	/**
	 * The friendly plugin name.
	 *
	 * @used-by BH_WP_Logger
	 *
	 * @return string
	 */
	public function get_plugin_name(): string {
		return 'Set Gateway by URL';
	}

	/**
	 * The main plugin file.
	 *
	 * @used-by Admin_Assets
	 * @used-by BH_WP_Logger
	 *
	 * @return string
	 */
	public function get_plugin_basename(): string {
		return 'bh-wc-set-gateway-by-url/bh-wc-set-gateway-by-url.php';
	}
}
