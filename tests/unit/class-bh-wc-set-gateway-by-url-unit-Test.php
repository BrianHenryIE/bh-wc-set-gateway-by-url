<?php
/**
 *
 * @package brianhenryie/bh-wc-set-gateway-by-url
 * @author  Brian Henry <BrianHenryIE@gmail.com>
 */

namespace BrianHenryIE\WC_Set_Gateway_By_URL;

use BrianHenryIE\WC_Set_Gateway_By_URL\Admin\Admin_Assets;
use BrianHenryIE\WC_Set_Gateway_By_URL\Admin\Plugins_Page;
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

	protected function setup(): void {
		parent::setup();
		\WP_Mock::setUp();
	}

	protected function tearDown(): void {
		parent::tearDown();
		\WP_Mock::tearDown();
	}

	/**
	 * @covers ::__construct
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

	/**
	 * @covers ::define_plugins_page_hooks
	 */
	public function test_plugins_page_hooks() {

		$plugin_basename = 'bh-wc-set-gateway-by-url/bh-wc-set-gateway-by-url.php';

		\WP_Mock::expectFilterAdded(
			"plugin_action_links_{$plugin_basename}",
			array( new AnyInstance( Plugins_Page::class ), 'action_links' ),
			10,
			4
		);

		\WP_Mock::expectFilterAdded(
			'plugin_row_meta',
			array( new AnyInstance( Plugins_Page::class ), 'row_meta' ),
			20,
			4
		);

		$settings = $this->makeEmpty(
			Settings_Interface::class,
			array(
				'get_plugin_basename' => $plugin_basename,
			)
		);
		$logger   = new NullLogger();

		new BH_WC_Set_Gateway_By_URL( $settings, $logger );
	}

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
