<?php
/**
 * Tests for main plugin action on woocommerce_init.
 *
 * @package BH_WC_Set_Gateway_By_URL
 * @author  Brian Henry <BrianHenryIE@gmail.com>
 */

namespace BH_WC_Set_Gateway_By_URL\woocommerce;

use WC_Session_Handler;
use WooCommerce;
use function WC;

/**
 * Class Develop_Test
 */
class InitTest extends \Codeception\TestCase\WPTestCase {


	/**
	 *
	 */
	public function test_action_woocommerce_init_set_payment_gateway_from_url() {

		WC()->session = new WC_Session_Handler();

		$_GET['payment_gateway'] = 'cheque';

		$default = WC()->session->get('chosen_payment_method' );

		$this->assertNotEquals( $default, 'cheque' );

		do_action( 'woocommerce_init' );

		$after = WC()->session->get('chosen_payment_method' );

		$this->assertEquals( $after, 'cheque' );

	}


	/**
	 *
	 */
	public function test_change_nothing_with_unknown_gateway() {

		WC()->session = new WC_Session_Handler();

		$_GET['payment_gateway'] = 'unknown_gateway';

		$before = WC()->session->get('chosen_payment_method' );

		do_action( 'woocommerce_init' );

		$after = WC()->session->get('chosen_payment_method' );

		$this->assertEquals( $before, $after );

	}


	/**
	 *
	 */
	public function test_change_nothing_without_querystring() {

		WC()->session = new WC_Session_Handler();

		$_GET['payment_gateway'] = null;

		WC()->session->set( 'chosen_payment_method', 'bacs' );

		do_action( 'woocommerce_init' );

		$after = WC()->session->get('chosen_payment_method' );

		$this->assertEquals( 'bacs', $after );

	}


	/**
	 *
	 */
	public function test_filter() {

		WC()->session = new WC_Session_Handler();

		$_GET['payment_gateway'] = 'unknown_gateway';

		WC()->session->set( 'chosen_payment_method', 'bacs' );

		add_filter( 'set_payment_gateway_from_url', function( $payment_gateway ) {

			if('unknown_gateway' === $payment_gateway) {
				$payment_gateway = 'cheque';
			}
			return $payment_gateway;
		});

		do_action( 'woocommerce_init' );

		$after = WC()->session->get('chosen_payment_method' );

		$this->assertEquals( 'cheque', $after );

	}
}
