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
  V2.1, What changed:
    Added JSON response information when retrieving results.
    Incorporated the use of Zen Cart's provided zcJS when it is available.
    Made the DPU class part of the overall system to better support additional observers as needed.
    Rewrote the data collection about a product to improve ability to compare to the active cart.
    Modified quantity reporting to provide quantity already in cart for selected attributes if the quantity is greater than zero.
    Incorporated forum correction for operation when DPU_SHOW_LOADING_IMAGE is set to false.
    Maintained the "default" XML response if JSON is not requested to align with potential historical alterations.
    Added the restoration of the price display if the transaction fails.
    Added jscript function to perform data/screen update/swap.
    Added this additional installer feature to support improved installation/version control.
*/


$zc150 = (PROJECT_VERSION_MAJOR > 1 || (PROJECT_VERSION_MAJOR == 1 && substr(PROJECT_VERSION_MINOR, 0, 3) >= 5));
if ($zc150) { // continue Zen Cart 1.5.0

    // Initialize the variable.
    $sort_order = array();

    /*
     * Add Values to Zen Colorbox Configuration Group (Admin > Configuration > Zen Colorbox)
     *   Identify the order in which the keys should be added for display.
    */
    $sort_order = array(
                    array('configuration_group_id' => array('value' => $configuration_group_id,
                                                   'type' => 'integer'),
                      'configuration_key' => array('value' => $module_constant . '_VERSION',
                                                   'type' => 'string'),
                      'configuration_title' => array('value' => 'Zen Colorbox Version',
                                                   'type' => 'string'),
                      'configuration_value' => array('value' => '1.0',
                                                   'type' => 'string'),
                      'configuration_description' => array('value' => 'Zen Colorbox Version',
                                                   'type' => 'string'),
                      'date_added' => array('value' => 'NOW()',
                                                   'type' => 'noquotestring'),
                      'use_function' => array('value' => 'NULL',
                                                   'type' => 'noquotestring'),
                      'set_function' => array('value' => 'zen_cfg_select_option(array(\'1.0\'),',
                                                   'type' => 'string'),
                      ),
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
                      'set_function' => array('value' => 'zen_cfg_select_option(array(''0'', ''0.1'', ''0.2'', ''0.3'', ''0.4'', ''0.5'', ''0.6'', ''0.7'', ''0.8'', ''0.9'', ''1''),',
                                                   'type' => 'noquotestring'),
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
                      'set_function' => array('value' => 'zen_cfg_select_option(array(\'true\', \'false\'),'
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
                                                   'type' => 'noquotestring'),
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

    $Zen_ColorboxPageExists = FALSE;

    // Attempt to use the ZC function to test for the existence of the page otherwise detect using SQL.
    if (function_exists('zen_page_key_exists'))
    {
        $Zen_ColorboxPageExists = zen_page_key_exists('config' . $admin_page);
    } else {
        $Zen_ColorboxPageExists_result = $db->Execute("SELECT FROM " . TABLE_ADMIN_PAGES . " WHERE page_key = 'config" . $admin_page . "' LIMIT 1");
        if ($Zen_ColorboxPageExists_result->EOF && $Zen_ColorboxPageExists_result->RecordCount() == 0) {
        } else {
            $Zen_ColorboxPageExists = TRUE;
        }
    }

    // if the admin page is not installed, then insert it using either the ZC function or straight SQL.
    if (!$Zen_ColorboxPageExists)
    {
        if ((int)$configuration_group_id > 0) {

            $page_sort_query = "SELECT MAX(sort_order) + 1 as max_sort FROM `". TABLE_ADMIN_PAGES ."` WHERE menu_key='configuration'";
            $page_sort = $db->Execute($page_sort_query);
            $page_sort = $page_sort->fields['max_sort'];

            zen_register_admin_page('config' . $admin_page,
                                'BOX_CONFIGURATION_' . str_replace(' ', '_', strtoupper($module_name)),
                                'FILENAME_CONFIGURATION',
                                'gID=' . $configuration_group_id,
                                'configuration',
                                'Y',
                                $page_sort);

            $messageStack->add('Enabled ' . $module_name . ' Configuration Menu.', 'success');
        }

        foreach ($sort_order as $config_key => $config_item) {

            $sql = "INSERT IGNORE INTO " . TABLE_CONFIGURATION . " (configuration_group_id, configuration_key, configuration_title, configuration_value, configuration_description, sort_order, date_added, use_function, set_function)
              VALUES (:configuration_group_id:, :configuration_key:, :configuration_title:, :configuration_value:, :configuration_description:, :sort_order:, :date_added:, :use_function:, :set_function:)
              ON DUPLICATE KEY UPDATE configuration_group_id = :configuration_group_id:";
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

    } else {

        foreach ($sort_order as $config_key => $config_item) {

            $sql = "UPDATE ".TABLE_CONFIGURATION." SET sort_order = :sort_order:, configuration_group_id = :configuration_group_id: WHERE configuration_key = :configuration_key:";
            $sql = $db->bindVars($sql, ':sort_order:', ((int)$config_key + 1) * 10, 'integer');
            $sql = $db->bindVars($sql, ':configuration_key:', $config_item['configuration_key']['value'], $config_item['configuration_key']['type']);
            $sql = $db->bindVars($sql, ':configuration_group_id:', $config_item['configuration_group_id']['value'], $config_item['configuration_group_id']['type']);
            $db->Execute($sql);
        }


        $messageStack->add('Updated sort order configuration for ' . $module_name , 'success');
    } // End of New Install

} // END OF VERSION 1.5.x INSTALL
