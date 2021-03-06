<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.linkedin.com/in/sajmirdoko/
 * @since      1.0.0
 *
 * @package    Woo_Additional_Checkout_Fees
 * @subpackage Woo_Additional_Checkout_Fees/admin/partials
 */
;?>

<?php if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}?>

<div class="wrap">

  <h2><?php echo esc_html(get_admin_page_title()); ?></h2>
  <hr>
  <?php settings_errors();?>
  <form method="post" name="additional_checkout_fees_options" id="additional_checkout_fees_options" action="options.php">

<?php
//Plugin options
$options = get_option($this->plugin_name);
$activate = ($options) ? $options['activate'] : 0;
$display_billing = ($options) ? $options['display-billing'] : 'Additional Fee';
$options_fields = ($options) ? $options['fields'] : '';
$fields = array();
if ($options_fields != '') {
    $fields = $options_fields;
}

settings_fields($this->plugin_name);
do_settings_sections($this->plugin_name);
$checked = $selected = $disabled = NULL;
?>

    <div id="poststuff">
        <div id="post-body" class="metabox-holder columns-2">
            <!-- main content -->
            <div id="post-body-content">
                <div class="postbox">
                    <h2><span><?php esc_attr_e('Plugin Settings', $this->plugin_name);?></span></h2>
                    <br>
                    <div class="inside">
                        <fieldset>
                            <legend class="screen-reader-text"><span>Additional Fees Options</span></legend>
                            <label for="<?php echo $this->plugin_name; ?>_activate">
                                <input name="<?php echo $this->plugin_name; ?>[activate]" type="checkbox" id="<?php echo $this->plugin_name; ?>_activate" value="1" <?php checked($activate, 1);?>/>
                                <span><?php esc_attr_e('Activate additional checkout fees?', $this->plugin_name);?></span>
                            </label>
                        </fieldset>
                        <br>
                        <fieldset>
                            <legend class="screen-reader-text"><span>Text that displays on billing</span></legend>
                            <input type="text" name="<?php echo $this->plugin_name; ?>[display-billing]" value="<?php echo !empty($display_billing) ? $display_billing : 'Additional Fee'; ?>" maxlength="50" class="all-options" />
                            <span class="description"><?php esc_attr_e('Text on billing', $this->plugin_name);?></span>
                        </fieldset>
                    </div>
                </div>
            </div>
            <div id="post-body-content">
                <table class="widefat" id="fee_fields">
                    <tr>
                        <th class="row-title"><b><?php esc_attr_e('Additional Fee Options', $this->plugin_name);?></b></th>
                    </tr>
                    <?php if (!empty($fields)): ?>
                        <?php foreach ($fields as $key => $field): ?>
                        <tr class="fieldset">
                            <td>
                                <fieldset>
                                    <input type="text" name="<?php echo $this->plugin_name; ?>[fields][<?php echo $key; ?>][]" value="<?php echo !empty($field) ? $field[0] : 'field'; ?>" class="all-options" />
                                    <span class="description"><?php esc_attr_e('Fee Description', $this->plugin_name);?></span>
                                </fieldset>
                            </td>
                            <td>
                                <fieldset>
                                    <input type="number" name="<?php echo $this->plugin_name; ?>[fields][<?php echo $key; ?>][]" value="<?php echo !empty($field) ? $field[1] : 'field'; ?>" class="all-options" />
                                    <span class="description"><?php esc_attr_e('Fee Price', $this->plugin_name);?></span>
                                </fieldset>
                            </td>
                            <?php if (count($fields) > 1): ?>
                                <td>
                                <a class="button-secondary button-small delete_fee_option" href="#" title="Delete Fee">Delete Fee Option</a>
                                </td>
                            <?php endif;?>
                        </tr>
                        <?php endforeach;?>
                    <?php else: ?>
                    <tr class="fieldset">
                        <td>
                            <fieldset>
                                <input type="text" name="<?php echo $this->plugin_name; ?>[fields][additional-fee-1][]" value="First Additional Fee" class="all-options" />
                                <span class="description"><?php esc_attr_e('Fee Description', $this->plugin_name);?></span>
                            </fieldset>
                        </td>
                        <td>
                            <fieldset>
                                <input type="number" name="<?php echo $this->plugin_name; ?>[fields][additional-fee-1][]" value="10" class="all-options" />
                                <span class="description"><?php esc_attr_e('Fee Price', $this->plugin_name);?></span>
                            </fieldset>
                        </td>
                    </tr>
                    <?php endif;?>
                </table>
                <br>
                <a class="button-secondary button-small" href="#" id="add_fee" title="<?php esc_attr_e('Add Fee Option', $this->plugin_name);?>"><?php esc_attr_e('Add Fee Option', $this->plugin_name);?></a>
            </div>

            <!-- sidebar -->
            <!-- <div id="postbox-container-1" class="postbox-container">
                <div class="meta-box-sortables">
                    <div class="postbox">
                        <div class="inside">
                            <p>Everything you see here</p>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
        <br class="clear">
    </div>

<?php submit_button(__('Save Options', $this->plugin_name), 'primary', 'submit', TRUE);?>
</form>
</div>