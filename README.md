[![WordPress tested 5.7](https://img.shields.io/badge/WordPress-v5.7%20tested-0073aa.svg)](https://wordpress.org/plugins/bh-wc-set-gateway-by-url) [![PHPCS WPCS](https://img.shields.io/badge/PHPCS-WordPress%20Coding%20Standards-8892BF.svg)](https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards) [![PHPStan ](.github/phpstan.svg)](https://github.com/szepeviktor/phpstan-wordpress)  [![PHPUnit ](.github/coverage.svg)](https://brianhenryie.github.io/bh-wc-set-gateway-by-url/)

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

Clone this repo, open PhpStorm, then run `composer install` to install the dependencies.

```
git clone https://github.com/brianhenryie/bh-wc-set-gateway-by-url.git;
cd bh-wc-set-gateway-by-url
open -a PhpStorm ./;
composer install;
```

For integration and acceptance tests, a local webserver must be running with `localhost:8080/bh-wc-set-gateway-by-url/` pointing at the root of the repo. MySQL must also be running locally – with two databases set up with:

```
mysql_username="root"
mysql_password="secret"

# export PATH=${PATH}:/usr/local/mysql/bin

# Make .env available 
# To bash:
# export $(grep -v '^#' .env.testing | xargs)
# To zsh:
# source .env.testing

# Create the database user:
# MySQL
# mysql -u $mysql_username -p$mysql_password -e "CREATE USER '"$TEST_DB_USER"'@'%' IDENTIFIED WITH mysql_native_password BY '"$TEST_DB_PASSWORD"';";
# or MariaDB
# mysql -u $mysql_username -p$mysql_password -e "CREATE USER '"$TEST_DB_USER"'@'%' IDENTIFIED BY '"$TEST_DB_PASSWORD"';";

# Create the databases:
mysql -u $mysql_username -p$mysql_password -e "CREATE DATABASE "$TEST_SITE_DB_NAME"; USE "$TEST_SITE_DB_NAME"; GRANT ALL PRIVILEGES ON "$TEST_SITE_DB_NAME".* TO '"$TEST_DB_USER"'@'%';";
mysql -u $mysql_username -p$mysql_password -e "CREATE DATABASE "$TEST_DB_NAME"; USE "$TEST_DB_NAME"; GRANT ALL PRIVILEGES ON "$TEST_DB_NAME".* TO '"$TEST_DB_USER"'@'%';";

# Import the acceptance database:
mysql -u $mysql_username -p$mysql_password $TEST_SITE_DB_NAME < tests/_data/dump.sql 
 ```

### WordPress Coding Standards

See documentation on [WordPress.org](https://make.wordpress.org/core/handbook/best-practices/coding-standards/) and [GitHub.com](https://github.com/WordPress/WordPress-Coding-Standards).

Correct errors where possible and list the remaining with:

```
vendor/bin/phpcbf; vendor/bin/phpcs
```

### Tests

Tests use the [Codeception](https://codeception.com/) add-on [WP-Browser](https://github.com/lucatume/wp-browser) and include vanilla PHPUnit tests with [WP_Mock](https://github.com/10up/wp_mock).

Run tests with:

```
vendor/bin/codecept run unit;
vendor/bin/codecept run wpunit;
vendor/bin/codecept run integration;
vendor/bin/codecept run acceptance;
```

Show code coverage (unit+wpunit):

```
XDEBUG_MODE=coverage composer run-script coverage-tests 
```

Static analysis:

```
vendor/bin/phpstan analyse --memory-limit 1G
```

To save changes made to the acceptance database:

```
export $(grep -v '^#' .env.testing | xargs)
mysqldump -u $TEST_SITE_DB_USER -p$TEST_SITE_DB_PASSWORD $TEST_SITE_DB_NAME > tests/_data/dump.sql
```

To clear Codeception cache after moving/removing test files:

```
vendor/bin/codecept clean
```

### More Information

See [github.com/BrianHenryIE/WordPress-Plugin-Boilerplate](https://github.com/BrianHenryIE/WordPress-Plugin-Boilerplate) for initial setup rationale.

## Acknowledgements

I credit the spare time I had to publish this to COVID-19. Stay safe.