<?php
/**
 * Setting required by the plugin.
 *
 * @package brianhenryie/bh-wc-set-gateway-by-url
 */

namespace BrianHenryIE\WC_Set_Gateway_By_URL;

use BrianHenryIE\WC_Set_Gateway_By_URL\Admin\Admin_Assets;

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

	/**
	 * The plugin basename, as determined in the base plugin file.
	 *
	 * @used-by BH_WC_Set_Gateway_By_URL::define_plugins_page_hooks()
	 * @used-by Admin_Assets::enqueue_styles()
	 *
	 * @return string
	 */
	public function get_plugin_basename(): string;
}
