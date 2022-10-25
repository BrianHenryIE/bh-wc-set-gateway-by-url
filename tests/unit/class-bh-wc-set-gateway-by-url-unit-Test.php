<?php
/**
 *
 * @package brianhenryie/bh-wc-set-gateway-by-url
 * @author  Brian Henry <BrianHenryIE@gmail.com>
 */

namespace BrianHenryIE\WC_Set_Gateway_By_URL;

use BrianHenryIE\WC_Set_Gateway_By_URL\Admin\Admin_Assets;
use BrianHenryIE\WC_Set_Gateway_By_URL\Settings_Interface;
use BrianHenryIE\WC_Set_Gateway_By_URL\WooCommerce\Settings_API;
use BrianHenryIE\WC_Set_Gateway_By_URL\WooCommerce\WooCommerce_Init;
use BrianHenryIE\WC_Set_Gateway_By_URL\WP_Includes\I18n;
use Psr\Log\NullLogger;
use WP_Mock\Matcher\AnyInstance;

/**
 * @coversDefaultClass \BrianHenryIE\WC_Set_Gateway_By_URL\BH_WC_Set_Gateway_By_URL
 */
class BH_WC_Set_Gateway_By_URL_Unit_Test extends \Codeception\Test\Unit {

	protected function _before() {
		\WP_Mock::setUp();
	}

	public function _after() {
		parent::_after();
		\WP_Mock::tearDown();
	}

	/**
	 *
	 * @covers ::set_locale
	 */
	public function test_set_locale_hooked() {

		\WP_Mock::expectActionAdded(
			'plugins_loaded',
			array( new AnyInstance( I18n::class ), 'load_plugin_textdomain' )
		);

		$settings = $this->makeEmpty( Settings_Interface::class );
		$logger   = new NullLogger();

		new BH_WC_Set_Gateway_By_URL( $settings, $logger );
	}

	/**
	 * @covers ::define_admin_hooks
	 */
	public function test_define_admin_hooks() {

		\WP_Mock::expectActionAdded(
			'admin_enqueue_scripts',
			array( new AnyInstance( Admin_Assets::class ), 'enqueue_styles' )
		);

		$settings = $this->makeEmpty( Settings_Interface::class );
		$logger   = new NullLogger();

		new BH_WC_Set_Gateway_By_URL( $settings, $logger );
	}
	//
	// **
	// * @covers ::define_plugins_page_hooks
	// */
	// public function test_plugins_page_hooks() {
	//
	// $this->markTestIncomplete();
	//
	// \WP_Mock::expectFilterAdded(
	// 'plugin_action_links_bh-wc-set-gateway-by-url/bh-wc-set-gateway-by-url.php',
	// array( new AnyInstance( Plugins_Page::class ), 'add_settings_action_link' )
	// );
	//
	// \WP_Mock::expectFilterAdded(
	// 'plugin_action_links_bh-wc-set-gateway-by-url/bh-wc-set-gateway-by-url.php',
	// array( new AnyInstance( Plugins_Page::class ), 'add_orders_action_link' )
	// );
	//
	// $settings = $this->makeEmpty( Settings_Interface::class, array(
	// 'get_plugin_basename' => 'bh-wc-set-gateway-by-url/bh-wc-set-gateway-by-url.php'
	// ));
	// $logger = new NullLogger();
	//
	// new BH_WC_Set_Gateway_By_URL( $settings, $logger );
	// }

	/**
	 * @covers ::define_woocommerce_hooks
	 */
	public function test_woocommerce_hooks() {

		\WP_Mock::expectActionAdded(
			'init',
			array( new AnyInstance( WooCommerce_Init::class ), 'set_payment_gateway_from_url' )
		);

		\WP_Mock::expectActionAdded(
			'woocommerce_after_register_post_type',
			array( new AnyInstance( Settings_API::class ), 'register_filter_on_each_gateway' )
		);

		$settings = $this->makeEmpty( Settings_Interface::class );
		$logger   = new NullLogger();

		new BH_WC_Set_Gateway_By_URL( $settings, $logger );
	}

}
