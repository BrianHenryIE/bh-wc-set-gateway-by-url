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

namespace BH_WC_Set_Gateway_By_URL\includes;

use BH_WC_Set_Gateway_By_URL\admin\Admin;
use BH_WC_Set_Gateway_By_URL\woocommerce\Settings_API;
use BH_WC_Set_Gateway_By_URL\woocommerce\WooCommerce_Init;
use BH_WC_Set_Gateway_By_URL\WPPB\WPPB_Loader_Interface;
use BH_WC_Set_Gateway_By_URL\WPPB\WPPB_Object;

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
class BH_WC_Set_Gateway_By_URL extends WPPB_Object {

	/**
	 * Allow access for testing and unhooking.
	 *
	 * @var Admin The plugin Admin object instance.
	 */
	public $admin;

	/**
	 * Allow access for testing and unhooking.
	 *
	 * @var WooCommerce_Init The plugin class handling WooCommerce init events.
	 */
	public $woocommerce_init;

	/**
	 * Allow access for testing and unhooking.
	 *
	 * @var Settings_API
	 */
	public $woocommerce_settings_api;

	/**
	 * Allow access for testing and unhooking.
	 *
	 * @var I18n The plugin I18n object instance.
	 */
	public $i18n;

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      WPPB_Loader_Interface    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the frontend-facing side of the site.
	 *
	 * @since    1.0.0
	 *
	 * @param WPPB_Loader_Interface $loader The WPPB class which adds the hooks and filters to WordPress.
	 */
	public function __construct( $loader ) {
		if ( defined( 'BH_WC_SET_GATEWAY_BY_URL_VERSION' ) ) {
			$this->version = BH_WC_SET_GATEWAY_BY_URL_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'bh-wc-set-gateway-by-url';

		parent::__construct( $this->plugin_name, $this->version );

		$this->loader = $loader;

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

		$this->admin = new Admin( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'admin_enqueue_scripts', $this->admin, 'enqueue_styles' );

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

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    WPPB_Loader_Interface    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

}
