# BH WC Set Gateway By URL

= 1.2.0 =

* Add: link to WooCommerce/Settings/Payments as "Gateways" link on plugins.php
* Add: wp_options setting for log level
* Dev: change autoloader
* Remove: build/dev files unintentionally included in archive

= 1.1.2 =

* Update GitHub Actions release script

= 1.1.1 = 24-Oct-2022

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