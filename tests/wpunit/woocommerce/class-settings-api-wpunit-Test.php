<?php
/**
 *
 *
 * @package brianhenryie/bh-wc-set-gateway-by-url
 * @author  Brian Henry <BrianHenryIE@gmail.com>
 */

namespace BrianHenryIE\WC_Set_Gateway_By_URL\WooCommerce;

use BrianHenryIE\ColorLogger\ColorLogger;
use BrianHenryIE\WC_Set_Gateway_By_URL\WooCommerce\Settings_API;
use BrianHenryIE\WC_Set_Gateway_By_URL\WooCommerce\WooCommerce_Init;
use WC_Session_Handler;
use function WC;

/**
 * @coversDefaultClass \BrianHenryIE\WC_Set_Gateway_By_URL\WooCommerce\Settings_API
 */
class Settings_API_WPUnit_Test extends \Codeception\TestCase\WPTestCase {

	/**
	 * @covers ::register_filter_on_each_gateway
	 */
	public function test_register_filters() {

		$sut = new Settings_API();
		$sut->setLogger( new ColorLogger() );

		$sut->register_filter_on_each_gateway();

		$gateways = WC()->payment_gateways()->get_payment_gateway_ids();

		$priority = 20;
		foreach ( $gateways as $gateway_id ) {
			$this->assertEquals( $priority, has_filter( "woocommerce_settings_api_form_fields_{$gateway_id}", array( $sut, 'add_link_to_gateway_settings_page' ) ) );
		}

	}
}
