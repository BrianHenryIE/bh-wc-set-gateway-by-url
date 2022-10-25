<?php
/**
 * Setting required by the plugin.
 *
 * @package brianhenryie/bh-wc-set-gateway-by-url
 */

namespace BrianHenryIE\WC_Set_Gateway_By_URL;

/**
 * Interface Settings_Interface
 */
interface Settings_Interface {

	/**
	 * The plugin slug for the CSS handle.
	 *
	 * @used-by Admin_Assets::enqueue_scripts()
	 *
	 * @return string
	 */
	public function get_plugin_slug(): string;

	/**
	 * The plugin version for versioning the CSS.
	 *
	 * @used-by Admin_Assets::enqueue_scripts()
	 *
	 * @return string
	 */
	public function get_plugin_version(): string;

	public function get_plugin_basename(): string;
}
