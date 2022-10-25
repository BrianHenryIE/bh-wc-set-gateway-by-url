<?php
/**
 * The plugin's settings.
 *
 * @package brianhenryie/bh-wc-set-gateway-by-url
 */

namespace BrianHenryIE\WC_Set_Gateway_By_URL\API;

use BrianHenryIE\WC_Set_Gateway_By_URL\Admin\Admin_Assets;
use BrianHenryIE\WC_Set_Gateway_By_URL\Settings_Interface;
use BrianHenryIE\WC_Set_Gateway_By_URL\WP_Logger\Logger_Settings_Interface;
use Psr\Log\LogLevel;

/**
 * Class Settings
 */
class Settings implements Settings_Interface, Logger_Settings_Interface {

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
		return '1.1.1';
	}

	/**
	 * The log detail level.
	 *
	 * @used-by BH_WP_Logger
	 *
	 * @return string
	 */
	public function get_log_level(): string {
		return LogLevel::INFO;
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
