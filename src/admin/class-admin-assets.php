<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://github.com/BrianHenryIE/bh-wc-set-gateway-by-url/
 * @since      1.0.0
 *
 * @package brianhenryie/bh-wc-set-gateway-by-url
 */

namespace BrianHenryIE\WC_Set_Gateway_By_URL\Admin;

use BrianHenryIE\WC_Set_Gateway_By_URL\Settings_Interface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package brianhenryie/bh-wc-set-gateway-by-url
 *
 * @author     Brian Henry <BrianHenryIE@gmail.com>
 */
class Admin_Assets {

	use LoggerAwareTrait;

	/**
	 * Required for the css handle and version.
	 *
	 * @var Settings_Interface
	 */
	protected Settings_Interface $settings;

	/**
	 * Admin constructor.
	 *
	 * @param Settings_Interface $settings The plugin's settings.
	 * @param LoggerInterface    $logger A PSR logger.
	 */
	public function __construct( Settings_Interface $settings, LoggerInterface $logger ) {
		$this->setLogger( $logger );
		$this->settings = $settings;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @hooked admin_enqueue_scripts
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles(): void {

		wp_enqueue_style( $this->settings->get_plugin_slug(), plugin_dir_url( $this->settings->get_plugin_basename() ) . 'assets/bh-wc-set-gateway-by-url-admin.css', array(), $this->settings->get_plugin_version(), 'all' );
	}

}
