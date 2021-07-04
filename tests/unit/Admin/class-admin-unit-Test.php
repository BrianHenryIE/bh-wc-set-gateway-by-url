<?php

namespace BrianHenryIE\WC_Set_Gateway_By_URL\Admin;

use BrianHenryIE\ColorLogger\ColorLogger;
use BrianHenryIE\WC_Set_Gateway_By_URL\API\Settings_Interface;
use \Psr\Log\NullLogger;

/**
 * Class Admin_Unit_Test
 *
 * @package BrianHenryIE\WC_Set_Gateway_By_URL\Admin
 * @coversDefaultClass \BrianHenryIE\WC_Set_Gateway_By_URL\Admin\Admin
 */
class Admin_Unit_Test  extends \Codeception\Test\Unit {

	protected function setup() : void {
		// parent::setUp();
		\WP_Mock::setUp();
	}

	public function tearDown(): void {
		\WP_Mock::tearDown();
		parent::tearDown();
	}

	public function test_css_is_enqueued() {

		global $plugin_root_dir;

		$logger = new ColorLogger();

		$settings = $this->makeEmpty(
			Settings_Interface::class,
			array(
				'get_plugin_slug'    => 'bh-wc-set-gateway-by-url',
				'get_plugin_version' => '1.0.0',
			)
		);

		$sut = new Admin( $settings, $logger );

		\WP_Mock::userFunction(
			'plugin_dir_url',
			array(
				'return' => $plugin_root_dir . '/admin/',
			)
		);

		$css_file = $plugin_root_dir . '/admin/css/bh-wc-set-gateway-by-url-admin.css';

		\WP_Mock::userFunction(
			'wp_enqueue_style',
			array(
				'times' => 1,
				'args'  => array( 'bh-wc-set-gateway-by-url', $css_file, array(), '1.0.0', 'all' ),
			)
		);

		$sut->enqueue_styles();

		$this->assertFileExists( $css_file );
	}
}
