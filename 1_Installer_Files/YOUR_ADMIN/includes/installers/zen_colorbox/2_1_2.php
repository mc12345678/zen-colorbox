<?php
/**
 * Zen Colorbox
 *
 * @copyright 2013 C Jones
 * @copyright Copyright 2003-2017 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: mc12345678 thanks to bislewl 6/9/2015
 */
/*
  V2.1.2, What changed:
  
  - Updated installer/updater to support upgrade checking independent of other plugins.
  - Updated code in support of anticipated changes for PHP 7.2.
  - Corrected reported issue for some environments where ZEN_COLORBOX_COUNTER is not equal to true.
  - Corrected use of zen_colorbox for usage on the checkout_payment page to use a javascript link.
  - Added Configuration key to support Upgrade from pre 2.1.0 as intended.
  
*/

$zc150 = (PROJECT_VERSION_MAJOR > 1 || (PROJECT_VERSION_MAJOR == 1 && substr(PROJECT_VERSION_MINOR, 0, 3) >= 5));
$zc130 = (PROJECT_VERSION_MAJOR > 1 || (PROJECT_VERSION_MAJOR == 1 && substr(PROJECT_VERSION_MINOR, 0, 3) >= 3));
if ($zc150 || $zc130) { // continue Zen Cart 1.5.0 or Zen Cart 1.3.x

    // Initialize the variable.
    $sort_order = array();

    /*
     * Add Values to Zen Colorbox Configuration Group (Admin > Configuration > Zen Colorbox)
     *   Identify the order in which the keys should be added for display.
    */
    $sort_order = array(
                array('configuration_group_id' => array('value' => $configuration_group_id,
                                                   'type' => 'integer'),
                      'configuration_key' => array('value' => 'ZEN_COLORBOX_STATUS',
                                                   'type' => 'string'),
                      'configuration_title' => array('value' => '<b>Zen Colorbox</b>',
                                                   'type' => 'string'),
                      'configuration_value' => array('value' => 'true',
                                                   'type' => 'string'),
                      'configuration_description' => array('value' => '<br />If true, all product images on the following pages will be displayed within a lightbox:<br /><br />- document_general_info<br />- document_product_info<br />- page (EZ-Pages)<br />- product_free_shipping_info<br />- product_info<br />- product_music_info<br />- product_reviews<br />- product_reviews_info<br />- product_reviews_write<br /><br /><b>Default: true</b>',
                                                   'type' => 'string'),
                      'date_added' => array('value' => 'NOW()',
                                                   'type' => 'noquotestring'),
                      'use_function' => array('value' => 'NULL',
                                                   'type' => 'noquotestring'),
                      'set_function' => array('value' => 'zen_cfg_select_option(array(\'true\', \'false\'),',
                                                   'type' => 'string'),
                      ),
                    array('configuration_group_id' => array('value' => $configuration_group_id,
                                                   'type' => 'integer'),
                      'configuration_key' => array('value' => $module_constant . '_PLUGIN_CHECK',
                                                   'type' => 'string'),
                      'configuration_title' => array('value' => $module_name . ' (Update Check)',
                                                   'type' => 'string'),
                      'configuration_value' => array('value' => SHOW_VERSION_UPDATE_IN_HEADER,
                                                   'type' => 'string'),
                      'configuration_description' => array('value' => 'Allow version checking if Zen Cart version checking enabled<br/><br/>If false, no version checking performed.<br/>If true, then only if Zen Cart version checking is on:',
                                                   'type' => 'string'),
                      'date_added' => array('value' => 'NOW()',
                                                   'type' => 'noquotestring'),
                      'use_function' => array('value' => 'NULL',
                                                   'type' => 'noquotestring'),
                      'set_function' => array('value' => 'zen_cfg_select_option(array(\'true\', \'false\'),',
                                                   'type' => 'string'),
                      ),
                    array('configuration_group_id' => array('value' => $configuration_group_id,
                                                   'type' => 'integer'),
                      'configuration_key' => array('value' => $module_constant . '_VERSION',
                                                   'type' => 'string'),
                      'configuration_title' => array('value' => $module_name . ' Version',
                                                   'type' => 'string'),
                      'configuration_value' => array('value' => '0.0.0',
                                                   'type' => 'string'),
                      'configuration_description' => array('value' => $module_name . ' Version',
                                                   'type' => 'string'),
                      'date_added' => array('value' => 'NOW()',
                                                   'type' => 'noquotestring'),
                      'use_function' => array('value' => 'NULL',
                                                   'type' => 'noquotestring'),
                      'set_function' => array('value' => 'zen_cfg_select_option(array(\'0.0.0\'),',
                                                   'type' => 'string'),
                      ),
                array('configuration_group_id' => array('value' => $configuration_group_id,
                                                   'type' => 'integer'),
                      'configuration_key' => array('value' => 'ZEN_COLORBOX_OVERLAY_OPACITY',
                                                   'type' => 'string'),
                      'configuration_title' => array('value' => 'Overlay Opacity',
                                                   'type' => 'string'),
                      'configuration_value' => array('value' => '0.6',
                                                   'type' => 'string'),
                      'configuration_description' => array('value' => '<br />Controls the transparency of the overlay.<br /><br /><b>Default: 0.6</b>',
                                                   'type' => 'string'),
                      'date_added' => array('value' => 'NOW()',
                                                   'type' => 'noquotestring'),
                      'use_function' => array('value' => 'NULL',
                                                   'type' => 'noquotestring'),
                      'set_function' => array('value' => 'zen_cfg_select_option(array(\'0\', \'0.1\', \'0.2\', \'0.3\', \'0.4\', \'0.5\', \'0.6\', \'0.7\', \'0.8\', \'0.9\', \'1\'),',
                                                   'type' => 'string'),
                      ),
                array('configuration_group_id' => array('value' => $configuration_group_id,
                                                   'type' => 'integer'),
                      'configuration_key' => array('value' => 'ZEN_COLORBOX_RESIZE_DURATION',
                                                   'type' => 'string'),
                      'configuration_title' => array('value' => 'Resize Duration',
                                                   'type' => 'string'),
                      'configuration_value' => array('value' => '400',
                                                   'type' => 'string'),
                      'configuration_description' => array('value' => '<br />Controls the speed of the image resizing.<br /><br />Note: This value is measured in milliseconds.<br /><br /><b>Default: 400</b><br />',
                                                   'type' => 'string'),
                      'date_added' => array('value' => 'NOW()',
                                                   'type' => 'noquotestring'),
                      'use_function' => array('value' => 'NULL',
                                                   'type' => 'noquotestring'),
                      'set_function' => array('value' => 'NULL',
                                                   'type' => 'noquotestring'),
                      ),
                array('configuration_group_id' => array('value' => $configuration_group_id,
                                                   'type' => 'integer'),
                      'configuration_key' => array('value' => 'ZEN_COLORBOX_INITIAL_WIDTH',
                                                   'type' => 'string'),
                      'configuration_title' => array('value' => 'Initial Width',
                                                   'type' => 'string'),
                      'configuration_value' => array('value' => '250',
                                                   'type' => 'string'),
                      'configuration_description' => array('value' => '<br />If Enable Resize Animations is set to true, the lightbox will resize its width from this value to the current image width, when first displayed.<br /><br />Note: This value is measured in pixels.<br /><br /><b>Default: 250</b><br />',
                                                   'type' => 'string'),
                      'date_added' => array('value' => 'NOW()',
                                                   'type' => 'noquotestring'),
                      'use_function' => array('value' => 'NULL',
                                                   'type' => 'noquotestring'),
                      'set_function' => array('value' => 'NULL',
                                                   'type' => 'noquotestring'),
                      ),
                array('configuration_group_id' => array('value' => $configuration_group_id,
                                                   'type' => 'integer'),
                      'configuration_key' => array('value' => 'ZEN_COLORBOX_INITIAL_HEIGHT',
                                                   'type' => 'string'),
                      'configuration_title' => array('value' => 'Initial Height',
                                                   'type' => 'string'),
                      'configuration_value' => array('value' => '250',
                                                   'type' => 'string'),
                      'configuration_description' => array('value' => '<br />If Enable Resize Animations is set to true, the lightbox will resize its height from this value to the current image height, when first displayed.<br /><br />Note: This value is measured in pixels.<br /><br /><b>Default: 250</b><br />',
                                                   'type' => 'string'),
                      'date_added' => array('value' => 'NOW()',
                                                   'type' => 'noquotestring'),
                      'use_function' => array('value' => 'NULL',
                                                   'type' => 'noquotestring'),
                      'set_function' => array('value' => 'NULL',
                                                   'type' => 'noquotestring'),
                      ),
                array('configuration_group_id' => array('value' => $configuration_group_id,
                                                   'type' => 'integer'),
                      'configuration_key' => array('value' => 'ZEN_COLORBOX_COUNTER',
                                                   'type' => 'string'),
                      'configuration_title' => array('value' => 'Display Image Counter',
                                                   'type' => 'string'),
                      'configuration_value' => array('value' => 'true',
                                                   'type' => 'string'),
                      'configuration_description' => array('value' => '<br />If true, the image counter will be displayed (below the caption of each image) within the lightbox.<br /><br /><b>Default: true</b>',
                                                   'type' => 'string'),
                      'date_added' => array('value' => 'NOW()',
                                                   'type' => 'noquotestring'),
                      'use_function' => array('value' => 'NULL',
                                                   'type' => 'noquotestring'),
                      'set_function' => array('value' => 'zen_cfg_select_option(array(\'true\', \'false\'),',
                                                   'type' => 'string'),
                      ),
                array('configuration_group_id' => array('value' => $configuration_group_id,
                                                   'type' => 'integer'),
                      'configuration_key' => array('value' => 'ZEN_COLORBOX_CLOSE_OVERLAY',
                                                   'type' => 'string'),
                      'configuration_title' => array('value' => 'Close on Overlay Click',
                                                   'type' => 'string'),
                      'configuration_value' => array('value' => 'false',
                                                   'type' => 'string'),
                      'configuration_description' => array('value' => '<br />If true, the lightbox will close when the overlay is clicked.<br /><br /><b>Default: false</b>', '".$zcb_configuration_id."',
                                                   'type' => 'string'),
                      'date_added' => array('value' => 'NOW()',
                                                   'type' => 'noquotestring'),
                      'use_function' => array('value' => 'NULL',
                                                   'type' => 'noquotestring'),
                      'set_function' => array('value' => 'zen_cfg_select_option(array(\'true\', \'false\'),',
                                                   'type' => 'string'),
                      ),
                array('configuration_group_id' => array('value' => $configuration_group_id,
                                                   'type' => 'integer'),
                      'configuration_key' => array('value' => 'ZEN_COLORBOX_LOOP',
                                                   'type' => 'string'),
                      'configuration_title' => array('value' => 'Loop',
                                                   'type' => 'string'),
                      'configuration_value' => array('value' => 'true',
                                                   'type' => 'string'),
                      'configuration_description' => array('value' => '<br />If true, Images will loop in both directions.<br /><br /><b>Default: true</b>',
                                                   'type' => 'string'),
                      'date_added' => array('value' => 'NOW()',
                                                   'type' => 'noquotestring'),
                      'use_function' => array('value' => 'NULL',
                                                   'type' => 'noquotestring'),
                      'set_function' => array('value' => 'zen_cfg_select_option(array(\'true\', \'false\'),',
                                                   'type' => 'string'),
                ),
                array('configuration_group_id' => array('value' => $configuration_group_id,
                                                   'type' => 'integer'),
                      'configuration_key' => array('value' => 'ZEN_COLORBOX_SLIDESHOW',
                                                   'type' => 'string'),
                      'configuration_title' => array('value' => '<b>Slideshow</b>',
                                                   'type' => 'string'),
                      'configuration_value' => array('value' => 'false',
                                                   'type' => 'string'),
                      'configuration_description' => array('value' => '<br />If true, Images will display as a slideshow.<br /><br /><b>Default: false</b>',
                                                   'type' => 'string'),
                      'date_added' => array('value' => 'NOW()',
                                                   'type' => 'noquotestring'),
                      'use_function' => array('value' => 'NULL',
                                                   'type' => 'noquotestring'),
                      'set_function' => array('value' => 'zen_cfg_select_option(array(\'true\', \'false\'),',
                                                   'type' => 'string'),
                ),
                array('configuration_group_id' => array('value' => $configuration_group_id,
                                                   'type' => 'integer'),
                      'configuration_key' => array('value' => 'ZEN_COLORBOX_SLIDESHOW_AUTO',
                                                   'type' => 'string'),
                      'configuration_title' => array('value' => '&nbsp; Slideshow Auto Start',
                                                   'type' => 'string'),
                      'configuration_value' => array('value' => 'true',
                                                   'type' => 'string'),
                      'configuration_description' => array('value' => '<br />If true, your slideshow will auto start.<br /><br /><b>Default: true</b>',
                                                   'type' => 'string'),
                      'date_added' => array('value' => 'NOW()',
                                                   'type' => 'noquotestring'),
                      'use_function' => array('value' => 'NULL',
                                                   'type' => 'noquotestring'),
                      'set_function' => array('value' => 'zen_cfg_select_option(array(\'true\', \'false\'),',
                                                   'type' => 'string'),
                ),
                array('configuration_group_id' => array('value' => $configuration_group_id,
                                                   'type' => 'integer'),
                      'configuration_key' => array('value' => 'ZEN_COLORBOX_SLIDESHOW_SPEED',
                                                   'type' => 'string'),
                      'configuration_title' => array('value' => '&nbsp; Slideshow Speed',
                                                   'type' => 'string'),
                      'configuration_value' => array('value' => '2500',
                                                   'type' => 'string'),
                      'configuration_description' => array('value' => '<br />Sets the speed of the slideshow <br /><br />Note: This value is measured in milliseconds.<br /><br /><b>Default: 2500</b>',
                                                   'type' => 'string'),
                      'date_added' => array('value' => 'NOW()',
                                                   'type' => 'noquotestring'),
                      'use_function' => array('value' => 'NULL',
                                                   'type' => 'noquotestring'),
                      'set_function' => array('value' => 'NULL',
                                                   'type' => 'noquotestring'),
                ),
                array('configuration_group_id' => array('value' => $configuration_group_id,
                                                   'type' => 'integer'),
                      'configuration_key' => array('value' => 'ZEN_COLORBOX_SLIDESHOW_START_TEXT',
                                                   'type' => 'string'),
                      'configuration_title' => array('value' => '&nbsp; Slideshow Start Text',
                                                   'type' => 'string'),
                      'configuration_value' => array('value' => 'start slideshow',
                                                   'type' => 'string'),
                      'configuration_description' => array('value' => '<br />Link text to start the slideshow.<br /><br /><b>Default: start slideshow</b>',
                                                   'type' => 'string'),
                      'date_added' => array('value' => 'NOW()',
                                                   'type' => 'noquotestring'),
                      'use_function' => array('value' => 'NULL',
                                                   'type' => 'noquotestring'),
                      'set_function' => array('value' => 'NULL',
                                                   'type' => 'noquotestring'),
                ),
                array('configuration_group_id' => array('value' => $configuration_group_id,
                                                   'type' => 'integer'),
                      'configuration_key' => array('value' => 'ZEN_COLORBOX_SLIDESHOW_STOP_TEXT',
                                                   'type' => 'string'),
                      'configuration_title' => array('value' => '&nbsp; Slideshow Stop Text',
                                                   'type' => 'string'),
                      'configuration_value' => array('value' => 'stop slideshow',
                                                   'type' => 'string'),
                      'configuration_description' => array('value' => '<br />Link text to stop the slideshow.<br /><br /><b>Default: stop slideshow</b>',
                                                   'type' => 'string'),
                      'date_added' => array('value' => 'NOW()',
                                                   'type' => 'noquotestring'),
                      'use_function' => array('value' => 'NULL',
                                                   'type' => 'noquotestring'),
                      'set_function' => array('value' => 'NULL',
                                                   'type' => 'noquotestring'),
                ),
                array('configuration_group_id' => array('value' => $configuration_group_id,
                                                   'type' => 'integer'),
                      'configuration_key' => array('value' => 'ZEN_COLORBOX_GALLERY_MODE',
                                                   'type' => 'string'),
                      'configuration_title' => array('value' => '<b>Gallery Mode</b>',
                                                   'type' => 'string'),
                      'configuration_value' => array('value' => 'true',
                                                   'type' => 'string'),
                      'configuration_description' => array('value' => '<br />If true, the lightbox will allow additional images to quickly be displayed using previous and next buttons.<br /><br /><b>Default: true</b>',
                                                   'type' => 'string'),
                      'date_added' => array('value' => 'NOW()',
                                                   'type' => 'noquotestring'),
                      'use_function' => array('value' => 'NULL',
                                                   'type' => 'noquotestring'),
                      'set_function' => array('value' => 'zen_cfg_select_option(array(\'true\', \'false\'),',
                                                   'type' => 'string'),
                ),
                array('configuration_group_id' => array('value' => $configuration_group_id,
                                                   'type' => 'integer'),
                      'configuration_key' => array('value' => 'ZEN_COLORBOX_GALLERY_MAIN_IMAGE',
                                                   'type' => 'string'),
                      'configuration_title' => array('value' => '&nbsp; Include Main Image in Gallery',
                                                   'type' => 'string'),
                      'configuration_value' => array('value' => 'true',
                                                   'type' => 'string'),
                      'configuration_description' => array('value' => '<br />If true, the main product image will be included in the lightbox gallery.<br /><br /><b>Default: true</b>',
                                                   'type' => 'string'),
                      'date_added' => array('value' => 'NOW()',
                                                   'type' => 'noquotestring'),
                      'use_function' => array('value' => 'NULL',
                                                   'type' => 'noquotestring'),
                      'set_function' => array('value' => 'zen_cfg_select_option(array(\'true\', \'false\'),',
                                                   'type' => 'string'),
                ),
                array('configuration_group_id' => array('value' => $configuration_group_id,
                                                   'type' => 'integer'),
                      'configuration_key' => array('value' => 'ZEN_COLORBOX_EZPAGES',
                                                   'type' => 'string'),
                      'configuration_title' => array('value' => '<b>EZ-Pages Support</b>',
                                                   'type' => 'string'),
                      'configuration_value' => array('value' => 'true',
                                                   'type' => 'string'),
                      'configuration_description' => array('value' => '<br />If true, the lightbox effect will be used for linked images on all EZ-Pages.<br /><br /><b>Default: true</b>',
                                                   'type' => 'string'),
                      'date_added' => array('value' => 'NOW()',
                                                   'type' => 'noquotestring'),
                      'use_function' => array('value' => 'NULL',
                                                   'type' => 'noquotestring'),
                      'set_function' => array('value' => 'zen_cfg_select_option(array(\'true\', \'false\'),',
                                                   'type' => 'string'),
                ),
                array('configuration_group_id' => array('value' => $configuration_group_id,
                                                   'type' => 'integer'),
                      'configuration_key' => array('value' => 'ZEN_COLORBOX_FILE_TYPES',
                                                   'type' => 'string'),
                      'configuration_title' => array('value' => '&nbsp; File Types',
                                                   'type' => 'string'),
                      'configuration_value' => array('value' => 'jpg,png,gif',
                                                   'type' => 'string'),
                      'configuration_description' => array('value' => '<br />On EZ-Pages, the lightbox effect will be applied to all images with one of the following file types.<br /><br /><b>Default: jpg,png,gif</b><br />',
                                                   'type' => 'string'),
                      'date_added' => array('value' => 'NOW()',
                                                   'type' => 'noquotestring'),
                      'use_function' => array('value' => 'NULL',
                                                   'type' => 'noquotestring'),
                      'set_function' => array('value' => 'NULL',
                                                   'type' => 'noquotestring'),
                ),
    );

    foreach ($sort_order as $config_key => $config_item) {

        $sql = "INSERT IGNORE INTO " . TABLE_CONFIGURATION . " (configuration_group_id, configuration_key, configuration_title, configuration_value, configuration_description, sort_order, date_added, use_function, set_function)
          VALUES (:configuration_group_id:, :configuration_key:, :configuration_title:, :configuration_value:, :configuration_description:, :sort_order:, :date_added:, :use_function:, :set_function:)
          ON DUPLICATE KEY UPDATE configuration_group_id = :configuration_group_id:, sort_order = :sort_order:";
        $sql = $db->bindVars($sql, ':configuration_group_id:', $config_item['configuration_group_id']['value'], $config_item['configuration_group_id']['type']);
        $sql = $db->bindVars($sql, ':configuration_key:', $config_item['configuration_key']['value'], $config_item['configuration_key']['type']);
        $sql = $db->bindVars($sql, ':configuration_title:', $config_item['configuration_title']['value'], $config_item['configuration_title']['type']);
        $sql = $db->bindVars($sql, ':configuration_value:', $config_item['configuration_value']['value'], $config_item['configuration_value']['type']);
        $sql = $db->bindVars($sql, ':configuration_description:', $config_item['configuration_description']['value'], $config_item['configuration_description']['type']);
        $sql = $db->bindVars($sql, ':sort_order:', ((int)$config_key + 1) * 10, 'integer');
        $sql = $db->bindVars($sql, ':date_added:', $config_item['date_added']['value'], $config_item['date_added']['type']);
        $sql = $db->bindVars($sql, ':use_function:', $config_item['use_function']['value'], $config_item['use_function']['type']);
        $sql = $db->bindVars($sql, ':set_function:', $config_item['set_function']['value'], $config_item['set_function']['type']);
        $db->Execute($sql);
    }

    $messageStack->add('Inserted configuration for ' . $module_name , 'success');

} // END OF VERSION 1.5.x and 1.3.X INSTALL
