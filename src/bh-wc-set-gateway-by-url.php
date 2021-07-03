<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://github.com/BrianHenryIE/bh-wc-set-gateway-by-url/
 * @since             1.0.0
 * @package           BH_WC_Set_Gateway_By_URL
 *
 * @wordpress-plugin
 * Plugin Name:       Set Gateway By URL
 * Plugin URI:        http://github.com/BrianHenryIE/bh-wc-set-gateway-by-url/
 * Description:       Use <em>?payment_gateway=gateway_id</em> in URLs sent to customers to set the WooCommerce checkout payment gateway for them.
 * Version:           1.0.5
 * Author:            Brian Henry
 * Author URI:        https://BrianHenry.ie
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       bh-wc-set-gateway-by-url
 * Domain Path:       /languages
 */

namespace BrianHenryIE\WC_Set_Gateway_By_URL;

use BrianHenryIE\WC_Set_Gateway_By_URL\API\Settings;
use BrianHenryIE\WC_Set_Gateway_By_URL\Includes\BH_WC_Set_Gateway_By_URL;
use BrianHenryIE\WC_Set_Gateway_By_URL\WP_Logger\Logger;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

require_once plugin_dir_path( __FILE__ ) . 'autoload.php';

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'BH_WC_SET_GATEWAY_BY_URL_VERSION', '1.0.0' );

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function instantiate_bh_wc_set_gateway_by_url() {


	return $plugin;
}

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and frontend-facing site hooks.
 */
$GLOBALS['bh_wc_set_gateway_by_url'] = $bh_wc_set_gateway_by_url = instantiate_bh_wc_set_gateway_by_url();
$bh_wc_set_gateway_by_url->run();
	new BH_WC_Set_Gateway_By_URL( $settings, $logger );
