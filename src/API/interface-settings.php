<?php
/**
 * Setting required by the plugin.
 *
 * @package BrianHenryIE\WC_Set_Gateway_By_URL\API
 */

namespace BrianHenryIE\WC_Set_Gateway_By_URL\API;

/**
 * Interface Settings_Interface
 */
interface Settings_Interface {

	/**
	 * The plugin slug for the CSS handle.
	 *
	 * @used-by Admin::enqueue_scripts()
	 *
	 * @return string
	 */
	public function get_plugin_slug(): string;

	/**
	 * The plugin version for versioning the CSS.
	 *
	 * @used-by Admin::enqueue_scripts()
	 *
	 * @return string
	 */
	public function get_plugin_version(): string;

}
