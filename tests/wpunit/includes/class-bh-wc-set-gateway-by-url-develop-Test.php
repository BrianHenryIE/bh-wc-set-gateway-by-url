<?php
/**
 * Tests for BH_WC_Set_Gateway_By_URL main setup class. Tests the actions are correctly added.
 *
 * @package BH_WC_Set_Gateway_By_URL
 * @author  Brian Henry <BrianHenryIE@gmail.com>
 */

namespace BH_WC_Set_Gateway_By_URL\includes;

/**
 * Class InitTest
 */
class BH_WC_Set_Gateway_By_URL_Develop_Test extends \Codeception\TestCase\WPTestCase {

	/**
	 * Verify action to call load textdomain is added.
	 */
	public function test_action_plugins_loaded_load_plugin_textdomain() {

		$action_name       = 'plugins_loaded';
		$expected_priority = 10;

		$bh_wc_set_gateway_by_url = $GLOBALS['bh_wc_set_gateway_by_url'];

		$class = $bh_wc_set_gateway_by_url->i18n;

		$function = array( $class, 'load_plugin_textdomain' );

		$actual_action_priority = has_action( $action_name, $function );

		$this->assertNotFalse( $actual_action_priority );

		$this->assertEquals( $expected_priority, $actual_action_priority );

	}


	/**
	 * Verify action to change payment gateway on woocommerce_init.
	 */
	public function test_action_woocommerce_init_set_payment_gateway_from_url() {

		$action_name       = 'woocommerce_init';
		$expected_priority = 10;

		$bh_wc_set_gateway_by_url = $GLOBALS['bh_wc_set_gateway_by_url'];

		$class = $bh_wc_set_gateway_by_url->woocommerce_init;

		$function = array( $class, 'set_payment_gateway_from_url' );

		$actual_action_priority = has_action( $action_name, $function );

		$this->assertNotFalse( $actual_action_priority );

		$this->assertEquals( $expected_priority, $actual_action_priority );

	}
}
