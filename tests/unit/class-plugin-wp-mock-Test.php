<?php
/**
 * Tests for the root plugin file.
 *
 * @package BH_WC_Set_Gateway_By_URL
 * @author  Brian Henry <BrianHenryIE@gmail.com>
 */

namespace BrianHenryIE\WC_Set_Gateway_By_URL;

use BrianHenryIE\WC_Set_Gateway_By_URL\Includes\BH_WC_Set_Gateway_By_URL;

/**
 * Class Plugin_WP_Mock_Test
 */
class Plugin_WP_Mock_Test extends \Codeception\Test\Unit {

	protected function setup() : void {
		// parent::setUp();
		\WP_Mock::setUp();
	}

	public function tearDown(): void {
		\WP_Mock::tearDown();
		parent::tearDown();
	}

	/**
	 * Verifies the plugin does not output anything to screen.
	 *
	 */
	public function test_plugin_include_no_output() {

		global $plugin_root_dir;

		// Prevents code-coverage counting.
		\Patchwork\redefine(
			array( BH_WC_Set_Gateway_By_URL::class, '__construct' ),
			function( $settings, $logger ) {}
		);

		\WP_Mock::userFunction(
			'plugin_dir_path',
			array(
				'args'   => array( \WP_Mock\Functions::type( 'string' ) ),
				'return' => $plugin_root_dir . '/',
			)
		);

		\WP_Mock::userFunction(
			'is_admin',
			array(
				'return_arg' => false,
			)
		);

		\WP_Mock::userFunction(
			'get_current_user_id'
		);

		\WP_Mock::userFunction(
			'wp_normalize_path',
			array(
				'return_arg' => true,
			)
		);

		ob_start();

		include $plugin_root_dir . '/bh-wc-set-gateway-by-url.php';

		$printed_output = ob_get_contents();

		ob_end_clean();

		$this->assertEmpty( $printed_output );

	}

}
