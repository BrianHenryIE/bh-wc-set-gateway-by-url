[![WordPress tested 5.4](https://img.shields.io/badge/WordPress-v5.4%20tested-0073aa.svg)](https://wordpress.org/plugins/bh-wc-set-gateway-by-url) [![PHPCS WPCS](https://img.shields.io/badge/PHPCS-WordPress%20Coding%20Standards-8892BF.svg)](https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards)

# BH WC Set Gateway By URL

WooCommerce plugin to set which payment gateway will be selected when the customer reaches the checkout.

## Overview

Add `?payment_gateway=<gateway_id>` to the URL you send your customer and when they reach the checkout, that gateway will be selected. e.g. `https://store.brianhenry.ie/?payment_gateway=bitcoin`

Useful for running promotions specific to a payment type, e.g. a Bitcoin related promotion, and useful for sending failed payment emails to customers with links to the checkout to place the same order again using a specified gateway.

This plugin makes no theme/user-facing changes.

## Installation

Install `Set Gateway by URL` from [the WordPress plugin directory](https://wordpress.org/plugins/bh-wc-set-gateway-by-url).

There is no configuration needed.

## Recommendations

[Cart links for WooCommerce](https://wordpress.org/plugins/soft79-cart-links-for-woocommerce/) by Soft79 plugin adds similar functionality to WooCommerce allowing adding products to customers' carts via the URL, `?fill_cart=12,2x44`.

[WooCommerce Extended Coupon Features](https://wordpress.org/plugins/woocommerce-auto-added-coupons/) also by Soft79 enables applying coupons via URL, `?apply_coupon=my_coupon`.

[Autologin URLs](https://wordpress.org/plugins/bh-wp-autologin-urls/), [written by me](https://github.com/BrianHenryIE/BH-WP-Autologin-URLs), adds single-use login codes to URLs so customers can be logged in when they follow a link to your site.

Together, it is possible to send your customers URLs to your store's checkout which fill your customers' carts, apply a coupon, specify the payment gateway and as returning customers, have their billing and shipping information pre-filled!

## Operation

The general form is to add `?payment_gateway=<gateway_id>` to the URL querystring.

Gateways' ids do not necessarily match their titles, so this plugin adds a field on each gateway's settings page displaying a URL that can be copied and sent to customers.

If the gateway id is opaque or obtusely long, the filter `set_payment_gateway_from_url` exists so the text in the URL can be arbitrary.

```
/**
 * When ?payment_gateway=abbreviation is set, use the areallylonggatewayidthatyoudontwantinyoururl gateway.
 *
 * @hooked set_payment_gateway_from_url
 *
 * @see BH_WC_Set_Gateway_By_URL\woocommerce\WooCommerce_Init::set_payment_gateway_from_url()
 * 
 * @param string $gateway_id The gateway id used in the URL.
 * @return string The gatway id as understood by WooCommerce.
 */
function translate_set_payment_gateway_id( $payment_gateway ) {

	if( 'abbreviation' === $payment_gateway ) {
		$payment_gateway = 'areallylonggatewayidthatyoudontwantinyoururl';
	}

	return $payment_gateway;
}
```

## Implementation

The plugin is hooked on `woocommerce_init` and exits quickly if the `payment_gateway` querystring is not set.

If the specified gateway does not exist, the plugin exits silently.

No data is saved by the plugin.

## Inspiration

As I sought the solution for this myself, I found no plugin for it but did find a StackOverflow post [WooCommerce : Pre Setting Default Payment Method on Cart Page](https://stackoverflow.com/questions/38064231/woocommerce-pre-setting-default-payment-method-on-cart-page) which seems to get viewed ~50 times/month.

## Development

Unit, integration and acceptance tests have been run using [wp-browser](https://github.com/lucatume/wp-browser). The code conforms to [WordPress Coding Standards](https://codex.wordpress.org/WordPress_Coding_Standards). Issues and pull requests are welcome. To develop localy, follow my setup at: [BrianHenryIE/WordPress-Plugin-Boilerplate](https://github.com/BrianHenryIE/WordPress-Plugin-Boilerplate/).

## Acknowledgements

I credit the spare time I had to publish this to COVID-19. Stay safe.