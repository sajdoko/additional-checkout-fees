<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.linkedin.com/in/sajmirdoko/
 * @since      1.0.0
 *
 * @package    Woo_Additional_Checkout_Fees
 * @subpackage Woo_Additional_Checkout_Fees/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woo_Additional_Checkout_Fees
 * @subpackage Woo_Additional_Checkout_Fees/admin
 * @author     sajdoko <sajdoko@gmail.com>
 */
class Woo_Additional_Checkout_Fees_Admin {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles($hook) {

        // // Load only on ?page=woo-additional-checkout-fees
        // if ($hook != 'woocommerce_page_woo-additional-checkout-fees') {
        //     return;
        // }
        // wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/woo-additional-checkout-fees-admin.css', array(), $this->version, 'all');

    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts($hook) {

        // Load only on ?page=woo-additional-checkout-fees
        if ($hook != 'woocommerce_page_woo-additional-checkout-fees') {
            return;
        }
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/woo-additional-checkout-fees-admin.js', array('jquery'), $this->version, false);

    }

    public function additional_checkout_fees_add_admin_menu() {

        /*
         * Add a submenu page for this plugin to the WooCommerce admin section.
         */
        add_submenu_page('woocommerce', __('WooCommerce Additional Checkout Fees Options', $this->plugin_name), __('Checkout Fees', $this->plugin_name), 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page')
        );
    }

    /**
     * Render the settings page for this plugin.
     *
     * @since    1.0.0
     */

    public function display_plugin_setup_page() {
        include_once 'partials/woo-additional-checkout-fees-admin-display.php';
    }

    /**
     * Add's action links to the plugins page.
     *
     * @since    1.0.0
     */

    public function additional_checkout_fees_add_action_links($links) {
        $links[] = '<a href="' . esc_url(get_admin_url(null, 'admin.php?page=' . $this->plugin_name)) . '">Settings</a>';
        return $links;
    }

    /**
     * Sanitize plugin input options.
     *
     * @since    1.0.0
     */
    public function validate_additional_checkout_fees_settings($input) {
        $valid = array();
        $valid['activate'] = (isset($input['activate']) && !empty($input['activate'])) ? 1 : 0;
        $valid['display-billing'] = (isset($input['display-billing']) && !empty($input['display-billing'])) ? sanitize_text_field($input['display-billing']) : 'Additional Fee';
        if (isset($input['fields']) && !empty($input['fields'])) {
            foreach ($input['fields'] as $key => $field) {
                $valid['fields'][$key] = (!empty($field)) ? ($field) : '';
            }
        }

        return $valid;
    }

    /**
     * Register plugin input options.
     *
     * @since    1.1.0
     */
    public function additional_checkout_fees_options_update() {
        register_setting($this->plugin_name, $this->plugin_name, array($this, 'validate_additional_checkout_fees_settings'));
    }

    public function additional_checkout_fees_disable_plugin() {
        if ( current_user_can('activate_plugins') && is_plugin_active( 'woo-additional-checkout-fees/woo-additional-checkout-fees.php' ) ) {
            deactivate_plugins( 'woo-additional-checkout-fees/woo-additional-checkout-fees.php' );

            // Hide the default "Plugin activated" notice
            if ( isset( $_GET['activate'] ) ) {
                unset( $_GET['activate'] );
            }
        }
    }

    public function additional_checkout_fees_show_notice() {
        echo sprintf(
            __( '<div class="error"><p><strong>%1$s</strong> %2$s</p></div>', $this->plugin_name ),
            $this->plugin_name,
            'requires Woocommerce plugin to be active!'
        );
    }
}
