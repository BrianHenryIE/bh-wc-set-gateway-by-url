<?php
/**
 * Tests for the root plugin file.
 *
 * @package BH_WC_Set_Gateway_By_URL
 * @author  Brian Henry <BrianHenryIE@gmail.com>
 */

namespace BH_WC_Set_Gateway_By_URL;

use BH_WC_Set_Gateway_By_URL\includes\BH_WC_Set_Gateway_By_URL;

/**
 * Class Plugin_WP_Mock_Test
 */
class Plugin_WP_Mock_Test extends \Codeception\Test\Unit {

	protected function _before() {
		\WP_Mock::bootstrap();
		\WP_Mock::setUp();
	}

	/**
	 * Verifies the plugin initialization.
	 *
	 * @ asd runInSeparateProcess
	 */
	public function test_plugin_include() {

////		global $plugin_root_dir;
		$plugin_root_dir = dirname( __DIR__, 2 ) . '/src';

		\WP_Mock::userFunction(
			'plugin_dir_path',
			array(
				'args'   => array( \WP_Mock\Functions::type( 'string' ) ),
				'return' => $plugin_root_dir . '/',
			)
		);

		\WP_Mock::userFunction(
			'register_activation_hook'
		);

		\WP_Mock::userFunction(
			'register_deactivation_hook'
		);

		require_once $plugin_root_dir . '/bh-wc-set-gateway-by-url.php';

		$this->assertArrayHasKey( 'bh_wc_set_gateway_by_url', $GLOBALS );

		$this->assertInstanceOf( BH_WC_Set_Gateway_By_URL::class, $GLOBALS['bh_wc_set_gateway_by_url'] );

	}


	/**
	 * Verifies the plugin does not output anything to screen.
	 *
	 * @ asd runInSeparateProcess
	 */
	public function test_plugin_include_no_output() {

//		global $plugin_root_dir;
		$plugin_root_dir = dirname( __DIR__, 2 ) . '/src';


		\WP_Mock::userFunction(
			'plugin_dir_path',
			array(
				'args'   => array( \WP_Mock\Functions::type( 'string' ) ),
				'return' => $plugin_root_dir . '/',
			)
		);

		\WP_Mock::userFunction(
			'register_activation_hook'
		);

		\WP_Mock::userFunction(
			'register_deactivation_hook'
		);

		ob_start();

		require_once $plugin_root_dir . '/bh-wc-set-gateway-by-url.php';

		$printed_output = ob_get_contents();

		ob_end_clean();

		$this->assertEmpty( $printed_output );

	}

}
