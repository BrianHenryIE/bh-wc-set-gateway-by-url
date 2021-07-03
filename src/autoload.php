<?php
/**
 * Loads all required classes
 *
 * Uses PSR4 & wp-namespace-autoloader.
 *
 * @link              http://github.com/BrianHenryIE/bh-wc-set-gateway-by-url/
 * @since             1.0.0
 * @package           BH_WC_Set_Gateway_By_URL
 *
 * @see https://github.com/pablo-sg-pacheco/wp-namespace-autoloader/
 */

namespace BrianHenryIE\WC_Set_Gateway_By_URL;

use BrianHenryIE\WC_Set_Gateway_By_URL\Pablo_Pacheco\WP_Namespace_Autoloader\WP_Namespace_Autoloader;


// The plugin-scoped namespace for composer required libraries, as specified in composer.json Mozart config.
$dep_namespace = 'BH_WC_Set_Gateway_By_URL';
// The Mozart config `dep_directory` adjusted for relative path.
$dep_directory = '/vendor/';

spl_autoload_register(
	function ( $namespaced_class_name ) use ( $dep_namespace, $dep_directory ) {

		$autoload_directory = __DIR__ . $dep_directory . '/';

		// The class name with its true namespace.
		$bare_namespaced_class_name = preg_replace( "#$dep_namespace\\\*#", '', $namespaced_class_name );

		$file_path = $autoload_directory . str_replace( '\\', '/', $bare_namespaced_class_name ) . '.php';

		if ( file_exists( $file_path ) ) {
			require_once $file_path;
		}
	}
);

$wpcs_autoloader = new WP_Namespace_Autoloader();
$wpcs_autoloader->init();
