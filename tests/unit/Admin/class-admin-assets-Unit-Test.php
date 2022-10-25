<?php

namespace BrianHenryIE\WC_Set_Gateway_By_URL\Admin;

use BrianHenryIE\ColorLogger\ColorLogger;
use BrianHenryIE\WC_Set_Gateway_By_URL\Settings_Interface;
use \Psr\Log\NullLogger;

/**
 * @coversDefaultClass \BrianHenryIE\WC_Set_Gateway_By_URL\Admin\Admin_Assets
 */
class Admin_Assets_Unit_Test  extends \Codeception\Test\Unit {

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

		$sut = new Admin_Assets( $settings, $logger );

		\WP_Mock::userFunction(
			'plugin_dir_url',
			array(
				'return' => 'http://example.org/wp-content/plugins/bh-wc-set-gateway-by-url',
			)
		);

		$css_file = $plugin_root_dir . '/assets/bh-wc-set-gateway-by-url-admin.css';
		$css_url = 'http://example.org/wp-content/plugins/bh-wc-set-gateway-by-url/assets/bh-wc-set-gateway-by-url-admin.css';

		\WP_Mock::userFunction(
			'wp_enqueue_style',
			array(
				'times' => 1,
				'args'  => array( 'bh-wc-set-gateway-by-url', $css_url, array(), '1.0.0', 'all' ),
			)
		);

		$sut->enqueue_styles();

		$this->assertFileExists( $css_file );
	}
}
