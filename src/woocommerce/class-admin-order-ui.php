<?php
/**
 * WooCommerce (7.0) does not respect the chosen payment method for manually created orders when
 * customers use the "Customer payment page →" link, i.e. what is chosen by the admin/shop manager
 * is not the selected gateway on the "Pay for order" page. This code adds the chosen payment gateway
 * to the URL that is shared.
 *
 * @package brianhenryie/bh-wc-set-gateway-by-url
 */

namespace BrianHenryIE\WC_Set_Gateway_By_URL\WooCommerce;

use WC_Order;

/**
 * If the payment method has been set, it is added to the customer URL.
 */
class Admin_Order_UI {

	/**
	 * If the payment gateway has been set, append it to the "Customer payment page →" URL.
	 *
	 * @see WC_Order::get_checkout_payment_url()
	 * @see woocommerce/includes/admin/meta-boxes/class-wc-meta-box-order-data.php
	 *
	 * @hooked woocommerce_get_checkout_payment_url
	 *
	 * @param string   $pay_url The existing URL to the "Pay for order" page.
	 * @param WC_Order $order The WooCommerce order the link is being fetched for.
	 *
	 * @return string
	 */
	public function add_payment_gateway_to_customer_payment_page_url( string $pay_url, WC_Order $order ): string {

		$order_payment_method = $order->get_payment_method();

		if ( ! empty( $order_payment_method ) ) {
			$pay_url = add_query_arg( array( WooCommerce_Init::QUERYSTRING_PARAMETER_NAME => $order_payment_method ), $pay_url );
		}

		return $pay_url;
	}
}
