<?php
/**
 * The functionality which runs on woocommerce_init – the crux of the plugin.
 *
 * @link       http://github.com/BrianHenryIE/bh-wc-set-gateway-by-url/
 * @since      1.0.0
 *
 * @package brianhenryie/bh-wc-set-gateway-by-url
 */

namespace BrianHenryIE\WC_Set_Gateway_By_URL\WooCommerce;

use Psr\Log\LoggerAwareTrait;
use WC_Payment_Gateways;

/**
 * A single function which tries to set the payment gateway if it's requested and valid.
 *
 * Exits early if it's not set; exits silently if it's not valid.
 *
 * @package brianhenryie/bh-wc-set-gateway-by-url
 *
 * @author     Brian Henry <BrianHenryIE@gmail.com>
 */
class WooCommerce_Init {

	use LoggerAwareTrait;

	const QUERYSTRING_PARAMETER_NAME = 'payment_gateway';

	/**
	 * If the `payment_gateway` querystring parameter is present and valid,
	 * set the `WC()->session` `chosen_payment_method` as requested,
	 * so the customer will reach their checkout with that gateway selected.
	 *
	 * @hooked init
	 */
	public function set_payment_gateway_from_url(): void {

		// This input is not coming from a WordPress page so cannot have a nonce.
		// phpcs:disable WordPress.Security.NonceVerification.Recommended
		if ( ! isset( $_GET[ self::QUERYSTRING_PARAMETER_NAME ] ) ) {

			// Nothing to do here.
			return;
		}

		$preferred_gateway = sanitize_text_field( wp_unslash( $_GET[ self::QUERYSTRING_PARAMETER_NAME ] ) );

		// To allow using shorter strings in the URL than the true gateway id.
		$preferred_gateway = apply_filters( 'set_payment_gateway_from_url', $preferred_gateway );

		/** @var array<string, \WC_Payment_Gateway> $payment_gateways */
		$payment_gateways = WC_Payment_Gateways::instance()->payment_gateways();

		if ( array_key_exists( $preferred_gateway, $payment_gateways ) ) {

			foreach ( $payment_gateways as $gateway_id => $gateway ) {
				$gateway->chosen = ( $gateway_id === $preferred_gateway );
			}

			WC()->session->set( 'chosen_payment_method', $preferred_gateway );

			$this->logger->info( 'Set user\'s gateway to ' . $preferred_gateway );
		} else {
			$this->logger->info( 'Unknown gateway id specified:' . $preferred_gateway );
		}
	}
}
