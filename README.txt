=== Set WooCommerce Payment Gateway by URL ===
Contributors: BrianHenryIE
Donate link: http://github.com/BrianHenryIE/bh-wc-set-gateway-by-url/
Tags: woocommerce, payment-gateway, url
Requires at least: 3.6.0
Tested up to: 6.0
Requires PHP: 7.4
WC requires at least: 2.2
WC tested up to: 5.1
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Set the WooCommerce payment gateway in URLs sent to customers.

== Description ==

Add `?payment_gateway=preferred_gateway_id` to links in emails you send to your customers, and when they reach the
checkout, that will be the selected payment gateway.

A WordPress filter exists so the text in the URL can be set to whatever you prefer.

[Technical detail is on GitHub](https://github.com/brianhenryie/bh-wc-set-gateway-by-url/).

== Screenshots ==

1. Demonstration link for using the plugin
2. Demonstration link in context where it can be found
2. The plugins.php entry
2. Demonstration of the WooCommerce Customer Payment Page link being automatically updated


== Changelog ==

= 1.2.1 =

* Fix: patches not applied to dependencies, fatal error

= 1.2.0 =

* Add: link to WooCommerce/Settings/Payments as "Gateways" link on plugins.php
* Add: wp_options setting for log level
* Dev: change autoloader
* Remove: build/dev files unintentionally included in archive

= 1.1.1 =

* Update project structure

= 1.1.0 =

* Also set WC_Payment_Gateway::chosen on all active gateways
* Add payment gateway to admin order UI Customer payment page link

= 1.0.6 =
* Bugfix: Moved to later hooks to fix WC_Order error in other plugins when WC_Payment_Gateways::instance() was run before the CPT was registered.

= 1.0.5 =
* WordPress.org deployment had missed some files

= 1.0 =
* A modest publication