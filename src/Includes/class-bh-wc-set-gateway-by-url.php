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
use BrianHenryIE\WC_Set_Gateway_By_URL\WooCommerce\Admin_Order_UI;
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
	 * The settings object to pass to other classes.
	 *
	 * @var Settings_Interface
	 */
	protected Settings_Interface $settings;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the frontend-facing side of the site.
	 *
	 * @since    1.0.0
	 *
	 * @param Settings_Interface $settings The plugin's settings.
	 * @param LoggerInterface    $logger A PSR logger.
	 */
	public function __construct( Settings_Interface $settings, LoggerInterface $logger ) {

		$this->setLogger( $logger );
		$this->settings = $settings;

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
	 */
	protected function set_locale(): void {

		$plugin_i18n = new I18n();

		add_action( 'plugins_loaded', array( $plugin_i18n, 'load_plugin_textdomain' ) );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 */
	protected function define_admin_hooks(): void {

		$admin = new Admin( $this->settings, $this->logger );
		add_action( 'admin_enqueue_scripts', array( $admin, 'enqueue_styles' ) );

	}

	/**
	 * Register all of the hooks related to woocommerce.
	 *
	 * @since    1.0.0
	 */
	protected function define_woocommerce_hooks(): void {

		$woocommerce_init = new WooCommerce_Init();
		$woocommerce_init->setLogger( $this->logger );
		add_action( 'init', array( $woocommerce_init, 'set_payment_gateway_from_url' ) );

		$woocommerce_settings_api = new Settings_API();
		$woocommerce_settings_api->setLogger( $this->logger );
		add_action( 'woocommerce_after_register_post_type', array( $woocommerce_settings_api, 'register_filter_on_each_gateway' ) );

		$admin_order_ui = new Admin_Order_UI();
		add_filter( 'woocommerce_get_checkout_payment_url', array( $admin_order_ui, 'add_payment_gateway_to_customer_payment_page_url' ), 10, 2 );
	}

}
