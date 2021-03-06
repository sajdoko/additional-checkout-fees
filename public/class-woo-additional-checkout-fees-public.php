<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.linkedin.com/in/sajmirdoko/
 * @since      1.0.0
 *
 * @package    Woo_Additional_Checkout_Fees
 * @subpackage Woo_Additional_Checkout_Fees/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Woo_Additional_Checkout_Fees
 * @subpackage Woo_Additional_Checkout_Fees/public
 * @author     sajdoko <sajdoko@gmail.com>
 */
class Woo_Additional_Checkout_Fees_Public {

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
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {

        // enqueue only if is cart or checkout page
        if (!(is_cart() || is_checkout())) {
            return;
        }
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/woo-additional-checkout-fees-public.css', array(), $this->version, 'all');

    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

        // // enqueue only if is cart or checkout page
        // if (!(is_cart() || is_checkout())) {
        //     return;
        // }
        // wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/woo-additional-checkout-fees-public.js', array('jquery'), $this->version, false);

    }

    /**
     * echo the additional fee choises in frontend
     *
     * @since    1.0.0
     */
    public function additional_checkout_fees_choice() {

        $chosen = WC()->session->get('additional_fee_chosen');
        $chosen = empty($chosen) ? WC()->checkout->get_value('additional_fee_choice') : $chosen;
        $chosen = empty($chosen) ? 'no_option' : $chosen;

        //Plugin options
        $options = get_option($this->plugin_name);
        $activate = ($options) ? $options['activate'] : 0;
        $display_billing = ($options) ? $options['display-billing'] : 'Additional Fee';
        $options_fields = ($options) ? $options['fields'] : '';
        $fields = array();
        if ($options_fields != '') {
            $fields = $options_fields;
        }

        $options_arr = array();

        if (!empty($fields)) {
            foreach ($fields as $key => $field) {
                $options_arr[$key] = $field[0];
            }
        }
        $args = array(
            'type' => 'radio',
            'class' => array('input-radio'),
            'options' => $options_arr,
            'default' => $chosen,
            'label_class' => array('inline-block'),
            'required' => true,
        );
        if ($activate == 1 && count($fields) >= 1) {
            echo '<div id="checkout-radio">';
            echo "<h3>$display_billing</h3>";
            woocommerce_form_field('additional_fee_choice', $args, $chosen);
            echo '</div>';
        }

    }

    /**
     * Handle and add the fee value.
     *
     * @since    1.0.0
     */
    public function additional_checkout_fees_choice_fee($cart) {

        if (is_admin() && !defined('DOING_AJAX')) {
            return;
        }

        //Plugin options
        $options = get_option($this->plugin_name);
        $activate = ($options) ? $options['activate'] : 0;
        $display_billing = ($options) ? $options['display-billing'] : 'Additional Fee';
        $options_fields = ($options) ? $options['fields'] : '';
        $fields = array();
        if ($options_fields != '') {
            $fields = $options_fields;
        }

        if ($activate != 1 && count($fields) < 1) {
            return;
        }

        $fee = 0;
        $additional_fee_radio = WC()->session->get('additional_fee_chosen');
        if (array_key_exists($additional_fee_radio, $fields)) {
            $fee = $fields[$additional_fee_radio][1];
            $cart->add_fee(__($display_billing, 'woocommerce'), $fee);
        }

    }

    /**
     * Update checkout on choice change.
     *
     * @since    1.0.0
     */
    public function additional_checkout_fees_choice_refresh() {
        if (!(is_checkout() || is_cart())) {
            return;
        }
        echo "<script type=\"text/javascript\">
                    jQuery( function($){
                        $('form.checkout').on('change', 'input[name=additional_fee_choice]', function(e){
                            e.preventDefault();
                            var p = $(this).val();
                            $.ajax({
                                type: 'POST',
                                url: wc_checkout_params.ajax_url,
                                data: {
                                    'action': 'woo_get_ajax_data',
                                    'additional_fee_choice_radio': p,
                                },
                                success: function (result) {
                                    $('body').trigger('update_checkout');
                                }
                            });
                        });
                    });
            </script>";
    }

    /**
     * Set the choice to the session.
     *
     * @since    1.0.0
     */
    public function additional_checkout_fees_choice_set_session() {
        if (isset($_POST['additional_fee_choice_radio'])) {
            $additional_fee_choice_radio = sanitize_key($_POST['additional_fee_choice_radio']);
            WC()->session->set('additional_fee_chosen', $additional_fee_choice_radio);
            echo json_encode($additional_fee_choice_radio);
        }
        die();
    }

}
