<?php

namespace BrianHenryIE\WC_Set_Gateway_By_URL\WP_Logger\WooCommerce;

use BrianHenryIE\WC_Set_Gateway_By_URL\API\Settings_Interface;
use BrianHenryIE\WC_Set_Gateway_By_URL\WooCommerce\Settings_API;
use \Psr\Log\NullLogger;

/**
 * @coversDefaultClass \BrianHenryIE\WC_Set_Gateway_By_URL\WooCommerce\Settings_API
 */
class Settings_API_Unit_Test  extends \Codeception\Test\Unit {

	protected function setup() : void {
		// parent::setUp();
		\WP_Mock::setUp();
	}

	public function tearDown(): void {
		\WP_Mock::tearDown();
		parent::tearDown();
	}

	public function test_form_fields() {

		\WP_Mock::userFunction(
			'current_filter',
			array(
				'return' => 'woocommerce_settings_api_form_fields_gateway_id',
			)
		);
		\WP_Mock::userFunction(
			'get_option',
			array(
				'args'   => array( 'siteurl' ),
				'return' => 'https://example.org',
			)
		);

		$sut = new Settings_API();

		$result = $sut->add_link_to_gateway_settings_page( array() );

		$this->assertArrayHasKey( 'bh-wc-set-gateway-by-url', $result );

		$new_fields = $result['bh-wc-set-gateway-by-url'];

		$this->assertIsArray( $new_fields );

		$this->assertArrayHasKey( 'type', $new_fields );
		$this->assertEquals( 'text', $new_fields['type'] );

	}
}
