<?php
/**
 * Functionality which modifies the WooCommerce settings pages.
 * This adds a link for users to find and use.
 *
 * @link       http://github.com/BrianHenryIE/bh-wc-set-gateway-by-url/
 * @since      1.0.0
 *
 * @package    BH_WC_Set_Gateway_By_URL
 * @subpackage BH_WC_Set_Gateway_By_URL/woocommerce
 */

namespace BrianHenryIE\WC_Set_Gateway_By_URL\WooCommerce;

use Psr\Log\LoggerAwareTrait;
use WC_Payment_Gateways;

/**
 * Runs on woocommerce_loaded (init was too early) to find the list of gateways, then registers its function
 * to add instructions to each payment gateway's settings page.
 *
 * @package    BH_WC_Set_Gateway_By_URL
 * @subpackage BH_WC_Set_Gateway_By_URL/woocommerce
 * @author     Brian Henry <BrianHenryIE@gmail.com>
 */
class Settings_API {

	use LoggerAwareTrait;

	/**
	 * Filters each payment gateway's settings output to print out the gateway id on the WC Settings API page.
	 *
	 * @see WC_Settings_API::get_form_fields()
	 *
	 * @hooked woocommerce_after_register_post_type
	 */
	public function register_filter_on_each_gateway(): void {

		$gateway_ids = array_keys( WC_Payment_Gateways::instance()->payment_gateways() );

		foreach ( $gateway_ids as $gateway_id ) {
			add_filter( "woocommerce_settings_api_form_fields_{$gateway_id}", array( $this, 'add_link_to_gateway_settings_page' ), 20, 1 );
		}

	}

	/**
	 * The form field to add to each settings page.
	 *
	 * @param array<string|int, mixed> $form_fields The gateway's existing settings.
	 * @return array<string|int, mixed>
	 */
	public function add_link_to_gateway_settings_page( array $form_fields ): array {

		$filter_name = current_filter();
		$gateway_id  = substr( $filter_name, strlen( 'woocommerce_settings_api_form_fields_' ) );

		$form_fields['bh-wc-set-gateway-by-url'] = array(
			'title'       => __( 'Set Gateway by URL', 'bh-wc-set-gateway-by-url' ),
			'type'        => 'text',
			'description' => __( 'This link can be used to send customers so this gateway is chosen when they reach checkout.', 'bh-wc-set-gateway-by-url' ),
			'default'     => get_option( 'siteurl' ) . '/?payment_gateway=' . $gateway_id,
			'desc_tip'    => true,
			'class'       => 'bh_wc_set_gateway_by_url',
			'css'         => 'width: 100%;',
		);

		return $form_fields;
	}
}

