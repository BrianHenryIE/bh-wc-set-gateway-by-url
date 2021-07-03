<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * frontend-facing side of the site and the admin area.
 *
 * @link       http://github.com/BrianHenryIE/bh-wc-set-gateway-by-url/
 * @since      1.0.0
 *
 * @package    BH_WC_Set_Gateway_By_URL
 * @subpackage BH_WC_Set_Gateway_By_URL/includes
 */

namespace BrianHenryIE\WC_Set_Gateway_By_URL\Includes;

use BrianHenryIE\WC_Set_Gateway_By_URL\Admin\Admin;
use BrianHenryIE\WC_Set_Gateway_By_URL\API\Settings_Interface;
use BrianHenryIE\WC_Set_Gateway_By_URL\WooCommerce\Settings_API;
use BrianHenryIE\WC_Set_Gateway_By_URL\WooCommerce\WooCommerce_Init;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * frontend-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    BH_WC_Set_Gateway_By_URL
 * @subpackage BH_WC_Set_Gateway_By_URL/includes
 * @author     Brian Henry <BrianHenryIE@gmail.com>
 */
class BH_WC_Set_Gateway_By_URL {

	use LoggerAwareTrait;

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 */

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the frontend-facing side of the site.
	 *
	 * @since    1.0.0
	 *
	 * @param LoggerInterface    $logger A PSR logger.
	 */
	public function __construct( Settings_Interface $settings, LoggerInterface $logger ) {

		$this->setLogger( $logger );

		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_woocommerce_hooks();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$this->i18n = $plugin_i18n = new I18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$admin = new Admin( $this->settings, $this->logger );
		add_action( 'admin_enqueue_scripts', array( $admin, 'enqueue_styles' ) );

	}

	/**
	 * Register all of the hooks related to woocommerce.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_woocommerce_hooks() {

		$this->woocommerce_init = new WooCommerce_Init( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'woocommerce_init', $this->woocommerce_init, 'set_payment_gateway_from_url' );

		$this->woocommerce_settings_api = new Settings_API( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'woocommerce_after_register_post_type', $this->woocommerce_settings_api, 'add_links_to_gateway_settings_pages' );
		$woocommerce_init->setLogger( $this->logger );

		$woocommerce_settings_api->setLogger( $this->logger );

	}

}
