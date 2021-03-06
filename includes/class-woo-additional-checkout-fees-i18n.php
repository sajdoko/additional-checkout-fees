<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://www.linkedin.com/in/sajmirdoko/
 * @since      1.0.0
 *
 * @package    Woo_Additional_Checkout_Fees
 * @subpackage Woo_Additional_Checkout_Fees/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Woo_Additional_Checkout_Fees
 * @subpackage Woo_Additional_Checkout_Fees/includes
 * @author     sajdoko <sajdoko@gmail.com>
 */
class Woo_Additional_Checkout_Fees_i18n {

    /**
     * Load the plugin text domain for translation.
     *
     * @since    1.0.0
     */
    public function load_plugin_textdomain() {

        load_plugin_textdomain(
            'woo-additional-checkout-fees',
            false,
            dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
        );

    }

}
