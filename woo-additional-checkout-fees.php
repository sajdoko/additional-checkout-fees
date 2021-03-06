<?php

/**
 * The plugin bootstrap file
 *
 * @link              https://www.linkedin.com/in/sajmirdoko/
 * @since             1.0.0
 * @package           Woo_Additional_Checkout_Fees
 *
 * @wordpress-plugin
 * Plugin Name:       WooCommerce Additional Checkout Fees
 * Plugin URI:        https://github.com/sajdoko/woo-additional-checkout-fees
 * Description:       WooCommerce Additional Checkout Fees does just that! Adds an additional fee at checkout, preferably with the option for the client to choose.
 * Version:           1.0.1
 * Author:            sajdoko
 * Author URI:        https://www.linkedin.com/in/sajmirdoko/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woo-additional-checkout-fees
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

/**
 * Currently plugin version.
 */
define('WOO_ADDITIONAL_CHECKOUT_FEES_VERSION', '1.0.1');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woo-additional-checkout-fees-activator.php
 */
function activate_woo_additional_checkout_fees() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-woo-additional-checkout-fees-activator.php';
    Woo_Additional_Checkout_Fees_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woo-additional-checkout-fees-deactivator.php
 */
function deactivate_woo_additional_checkout_fees() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-woo-additional-checkout-fees-deactivator.php';
    Woo_Additional_Checkout_Fees_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_woo_additional_checkout_fees');
register_deactivation_hook(__FILE__, 'deactivate_woo_additional_checkout_fees');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-woo-additional-checkout-fees.php';


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_woo_additional_checkout_fees() {

    $plugin = new Woo_Additional_Checkout_Fees();
    $plugin->run();

}
run_woo_additional_checkout_fees();
