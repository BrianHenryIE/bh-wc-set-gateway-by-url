<?php

namespace BrianHenryIE\WC_Set_Gateway_By_URL\API;

/**
 * Class Settings_WP_Unit_Test
 *
 * @package BrianHenryIE\WC_Set_Gateway_By_URL\API
 * @coversDefaultClass \BrianHenryIE\WC_Set_Gateway_By_URL\API\Settings
 */
class Settings_WP_Unit_Test extends \Codeception\TestCase\WPTestCase {

	/**
	 * Verify the version in settings matches the versions in the main plugin file.
	 *
	 * @covers ::get_plugin_version
	 */
	public function test_settings_version() {

		global $plugin_root_dir;

		$settings = new Settings();

		$plugin_data = get_plugin_data( "$plugin_root_dir/{$settings->get_plugin_slug()}.php", false, false );

		$this->assertEquals( $settings->get_plugin_version(), $plugin_data['Version'] );

        $plugin_file = file_get_contents( $plugin_root_dir . '/bh-wc-set-gateway-by-url.php' );

        if( 1 !== preg_match('/define\( \'BH_WC_SET_GATEWAY_BY_URL_VERSION\', \'(\d+\.\d+\.\d+)\' \);/', $plugin_file, $output_array) ) {
            $this->fail();
        }

        $bh_wc_set_gateway_by_url_version = $output_array[1];

        $this->assertEquals( $bh_wc_set_gateway_by_url_version, $plugin_data['Version'] );
        $this->assertEquals( $settings->get_plugin_version(), $bh_wc_set_gateway_by_url_version );
	}

}
