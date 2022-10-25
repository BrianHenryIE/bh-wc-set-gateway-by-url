<?php

namespace BrianHenryIE\WC_Set_Gateway_By_URL\API;

/**
 * @coversDefaultClass \BrianHenryIE\WC_Set_Gateway_By_URL\API\Settings
 */
class Settings_Unit_Test extends \Codeception\Test\Unit {

	protected function setup() : void {
		\WP_Mock::setUp();
	}

	public function tearDown(): void {
		\WP_Mock::tearDown();
		parent::tearDown();
	}

	/**
	 * @covers ::get_plugin_slug
	 */
	public function test_plugin_slug() {
		$sut = new Settings();

		$this->assertEquals( 'bh-wc-set-gateway-by-url', $sut->get_plugin_slug() );
	}

	/**
	 * @covers ::get_plugin_basename
	 */
	public function test_plugin_basename() {
		$sut = new Settings();

		$this->assertEquals( 'bh-wc-set-gateway-by-url/bh-wc-set-gateway-by-url.php', $sut->get_plugin_basename() );
	}

	/**
	 * @covers ::get_plugin_name
	 */
	public function test_plugin_name() {
		$sut = new Settings();

		$this->assertEquals( 'Set Gateway by URL', $sut->get_plugin_name() );
	}

	/**
	 * @covers ::get_log_level
	 */
	public function test_get_log_level(): void {

		\WP_Mock::userFunction(
			'get_option',
			array(
				'times'  => 1,
				'args'   => array( 'bh_wc_set_gateway_by_url_log_level', 'info' ),
				'return' => 'info',
			)
		);

		$sut = new Settings();

		$this->assertEquals( 'info', $sut->get_log_level() );
	}
}
