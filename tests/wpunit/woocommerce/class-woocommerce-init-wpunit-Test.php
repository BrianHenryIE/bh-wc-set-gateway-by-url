<?php
/**
 * Tests for main plugin action on woocommerce_init.
 *
 * @package brianhenryie/bh-wc-set-gateway-by-url
 * @author  Brian Henry <BrianHenryIE@gmail.com>
 */

namespace BrianHenryIE\WC_Set_Gateway_By_URL\WooCommerce;

use BrianHenryIE\ColorLogger\ColorLogger;
use BrianHenryIE\WC_Set_Gateway_By_URL\WooCommerce\WooCommerce_Init;
use WC_Session_Handler;
use function WC;

/**
 * Class WooCommerce_Init_Unit_Test
 *
 * @coversDefaultClass \BrianHenryIE\WC_Set_Gateway_By_URL\WooCommerce\WooCommerce_Init
 */
class WooCommerce_Init_WPUnit_Test extends \Codeception\TestCase\WPTestCase {

	/**
	 * @covers ::set_payment_gateway_from_url
	 */
	public function test_action_woocommerce_init_set_payment_gateway_from_url() {

		WC()->session = new WC_Session_Handler();

		$_GET['payment_gateway'] = 'cheque';

		$default = WC()->session->get( 'chosen_payment_method' );

		$this->assertNotEquals( $default, 'cheque' );

		$sut = new WooCommerce_Init();
		$sut->setLogger( new ColorLogger() );

		$sut->set_payment_gateway_from_url();

		$after = WC()->session->get( 'chosen_payment_method' );

		$this->assertEquals( $after, 'cheque' );
	}

	/**
	 * @covers ::set_payment_gateway_from_url
	 */
	public function test_change_nothing_with_unknown_gateway() {

		WC()->session = new WC_Session_Handler();

		$_GET['payment_gateway'] = 'unknown_gateway';

		$before = WC()->session->get( 'chosen_payment_method' );

		$woocommerce_init = new WooCommerce_Init();
		$woocommerce_init->setLogger( new ColorLogger() );

		$woocommerce_init->set_payment_gateway_from_url();

		$after = WC()->session->get( 'chosen_payment_method' );

		$this->assertEquals( $before, $after );
	}

	/**
	 * @covers ::set_payment_gateway_from_url
	 */
	public function test_change_nothing_without_querystring() {

		WC()->session = new WC_Session_Handler();

		$_GET['payment_gateway'] = null;

		WC()->session->set( 'chosen_payment_method', 'bacs' );

		$woocommerce_init = new WooCommerce_Init();
		$woocommerce_init->setLogger( new ColorLogger() );

		$woocommerce_init->set_payment_gateway_from_url();

		$after = WC()->session->get( 'chosen_payment_method' );

		$this->assertEquals( 'bacs', $after );
	}

	/**
	 * @covers ::set_payment_gateway_from_url
	 */
	public function test_filter() {

		WC()->session = new WC_Session_Handler();

		$_GET['payment_gateway'] = 'gateway_alias';

		WC()->session->set( 'chosen_payment_method', 'bacs' );

		add_filter(
			'set_payment_gateway_from_url',
			function( $payment_gateway ) {

				if ( 'gateway_alias' === $payment_gateway ) {
					$payment_gateway = 'cheque';
				}
				return $payment_gateway;
			}
		);

		$woocommerce_init = new WooCommerce_Init();
		$woocommerce_init->setLogger( new ColorLogger() );

		$woocommerce_init->set_payment_gateway_from_url();

		$after = WC()->session->get( 'chosen_payment_method' );

		$this->assertEquals( 'cheque', $after );
	}
}
