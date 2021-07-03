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
 * Runs on woocommerce_init to add instuctions to each payment gateway's settings page. *
 *
 * @package    BH_WC_Set_Gateway_By_URL
 * @subpackage BH_WC_Set_Gateway_By_URL/woocommerce
 * @author     Brian Henry <BrianHenryIE@gmail.com>
 */
class Settings_API {

	/**
	 * Filters each payment gateway's settings output to print out the gateway id on the WC Settings API page.
	 *
	 * @see WC_Settings_API::get_form_fields()
	 *
	 * @hooked woocommerce_init
	 */
	public function add_links_to_gateway_settings_pages(): void {

		$gateway_ids = array_keys( WC_Payment_Gateways::instance()->payment_gateways() );

		foreach ( $gateway_ids as $gateway_id ) {

			$add_instruction = function( $form_fields ) use ( $gateway_id ) {

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
			};

			add_filter( "woocommerce_settings_api_form_fields_{$gateway_id}", $add_instruction, 20, 1 );

		}

	}
}

