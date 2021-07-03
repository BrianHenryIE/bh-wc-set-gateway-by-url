<?php
/**
 * Class Plugin_Test. Tests the root plugin setup.
 *
 * @package BH_WC_Set_Gateway_By_URL
 * @author     Brian Henry <BrianHenryIE@gmail.com>
 */

namespace BrianHenryIE\WC_Set_Gateway_By_URL;

use BrianHenryIE\WC_Set_Gateway_By_URL\includes\BH_WC_Set_Gateway_By_URL;

/**
 * Verifies the plugin has been instantiated and added to PHP's $GLOBALS variable.
 */
class PluginTest extends \Codeception\TestCase\WPTestCase {

	/**
	 * Test the main plugin object is added to PHP's GLOBALS and that it is the correct class.
	 */
	public function test_plugin_instantiated() {

		$this->assertArrayHasKey( 'bh_wc_set_gateway_by_url', $GLOBALS );

		$this->assertInstanceOf( BH_WC_Set_Gateway_By_URL::class, $GLOBALS['bh_wc_set_gateway_by_url'] );
	}

}
