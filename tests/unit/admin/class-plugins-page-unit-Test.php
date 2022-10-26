<?php
/**
 * Tests for Plugins_Page_Test. Tests the settings link is correctly added on plugins.php.
 *
 * @package brianhenryie/bh-wc-set-gateway-by-url
 * @author Brian Henry <BrianHenryIE@gmail.com>
 */

namespace BrianHenryIE\WC_Set_Gateway_By_URL\Admin;

use BrianHenryIE\WC_Set_Gateway_By_URL\Settings_Interface;
use Codeception\Stub\Expected;
use DOMDocument;

/**
 * @coversDefaultClass \BrianHenryIE\WC_Set_Gateway_By_URL\Admin\Plugins_Page
 */
class Plugins_Page_Unit_Test extends \Codeception\Test\Unit {

	protected function setUp(): void {
		\WP_Mock::setUp();
	}

	protected function tearDown(): void {
		parent::tearDown();
		\WP_Mock::tearDown();
	}

	/**
	 * @covers ::action_links
	 *
	 * phpcs:disable WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
	 * phpcs:disable WordPress.PHP.NoSilencedErrors.Discouraged
	 */
	public function test_action_links(): void {

		$expected_anchor    = '/wp-admin/admin.php?page=wc-settings&tab=checkout';
		$expected_link_text = 'Gateways';

		$settings = $this->makeEmpty( Settings_Interface::class );

		\WP_Mock::userFunction(
			'admin_url',
			array(
				'times'  => 1,
				'args'   => array( 'admin.php?page=wc-settings&tab=checkout' ),
				'return' => '/wp-admin/admin.php?page=wc-settings&tab=checkout',
			)
		);

		$sut = new Plugins_Page( $settings );

		$result = $sut->action_links( array(), '', array(), '' );

		$this->assertGreaterThan( 0, count( $result ), 'The plugin action link was definitely not added.' );

		$first_link = $result[0];

		$dom = new DOMDocument();

		@$dom->loadHtml( mb_convert_encoding( $first_link, 'HTML-ENTITIES', 'UTF-8' ) );

		$nodes = $dom->getElementsByTagName( 'a' );

		$this->assertEquals( 1, $nodes->length );

		$node = $nodes->item( 0 );

		$actual_anchor    = $node->getAttribute( 'href' );
		$actual_link_text = $node->nodeValue;

		$this->assertEquals( $expected_anchor, $actual_anchor );
		$this->assertEquals( $expected_link_text, $actual_link_text );
	}


	/**
	 * Verify the link to the plugin's GitHub is correctly added. This was originally for
	 * a non WordPress Plugin Directory plugin, but seems OK to use here.
	 */
	public function test_plugin_meta_github_link() {

		$settings = $this->makeEmpty(
			Settings_Interface::class,
			array(
				'get_plugin_basename' => Expected::once(
					function() {
						return 'bh-wc-set-gateway-by-url/bh-wc-set-gateway-by-url.php'; }
				),
				'get_plugin_slug'     => Expected::once(
					function() {
						return 'bh-wc-set-gateway-by-url'; }
				),
			)
		);

		$sut = new Plugins_Page( $settings );

		$result = $sut->row_meta( array(), 'bh-wc-set-gateway-by-url/bh-wc-set-gateway-by-url.php', array(), '' );

		$expected = '<a target="_blank" href="https://github.com/BrianHenryIE/bh-wc-set-gateway-by-url">View plugin on GitHub</a>';

		$this->assertContains( $expected, $result );
	}

}
