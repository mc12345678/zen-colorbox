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
  V2.1.3, What changed:
  
  - Updated includes/templates/YOUR_TEMPLATE/jscript/jquery.colorbox-min.js to include previous
      orientation monitoring code to resize the colorbox when the device orientation change event is triggered.
      Thanks to Paul3468 for identifying the omission and suggesting the reincorporation of the code.
  - Updated readme file to correct a manual SQL entry for those wishing to install manually.  Does not affect the
      auto-installer which does not require the change.
  - Updated document.write style output to include escape characters as supposedly needed by report of a firefox
      plugin to validate the html of the pages.  Unable to reproduce the issue/concern, but similar escaping is
      performed in the header.php of the template when referencing jquery.  Marking as a difference to the base code
      because the base code does not escape this information.
  - Modified includes\classes\zen_colorbox\options.php to remove the output from a string to be echoed and instead to
      be text to be output as part of the html page and as necessary for php to be echoed.  This is intended to improve
      readability and make it easier to modify.
  - Moved language related items to the languages directory instead of the database or a class file in order to support
      multiple languages.  Language file is included in the base install with template override capability.
  - Revised the includes/classes/zen_color
  - Modified the ZC 1.5.0 installer to better support upgrade from a previous version supporting only a partial removal of previous data entries.
  - Added an observer to support the additional images file processing of Zen Cart 1.5.6.
  - Changed the html indicator for hooking into this program from rel= to data-cbox-rel=
  - Incorporated a check for 'LARGE_IMAGE_WIDTH' and 'LARGE_IMAGE_HEIGHT' setting to an empty string if not defined.
  - Updated jscript/jquery.colorbox-min.js to support jQuery 3.x.
  - Added plugin check to ensure that even on upgrade from older versions that in PHP 7.2+ environments that the constant
      is defined and removal by admin/includes/installers/zen_colorbox/uninstall_zcb.sql is not required.
  
*/

$zc150 = (PROJECT_VERSION_MAJOR > 1 || (PROJECT_VERSION_MAJOR == 1 && substr(PROJECT_VERSION_MINOR, 0, 3) >= 5));
$zc130 = (PROJECT_VERSION_MAJOR > 1 || (PROJECT_VERSION_MAJOR == 1 && substr(PROJECT_VERSION_MINOR, 0, 3) >= 3));

if ($zc150 || $zc130) { // continue Zen Cart 1.5.0 or Zen Cart 1.3.x

  if (file_exists(DIR_FS_CATALOG_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/zen_colorbox_language.php')) {
    require_once (DIR_FS_CATALOG_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/zen_colorbox_language.php');
  } elseif (file_exists(DIR_FS_CATALOG_LANGUAGES . $_SESSION['language'] . '/zen_colorbox_language.php')) {
    require_once (DIR_FS_CATALOG_LANGUAGES . $_SESSION['language'] . '/zen_colorbox_language.php');
  } else {
    include_once (DIR_FS_CATALOG_LANGUAGES . 'english/zen_colorbox_language.php');
  }

  if (!defined($module_constant . '_PLUGIN_CHECK')) {
    $db->Execute("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added, use_function, set_function) VALUES
                          ('" . $module_name . " (Update Check)', '" . $module_constant . "_PLUGIN_CHECK', '" . SHOW_VERSION_UPDATE_IN_HEADER . "', 'Allow version checking if Zen Cart version checking enabled<br/><br/>If false, no version checking performed.<br/>If true, then only if Zen Cart version checking is on:', " . $configuration_group_id . ", 15, NOW(), NULL, 'zen_cfg_select_option(array(\'true\', \'false\'),');");
    define($module_constant . '_PLUGIN_CHECK', true);
  }
  
  $this_files_version = str_replace("_", ".", substr($installer, 0, -1 * $file_extension_len));
  $return_cancel = true;

  if (!defined('ZEN_COLORBOX_PREV_TEXT')) {
    $messageStack->add("Language file for " . $module_name . " v" . $this_files_version . " is not accessible.", 'warning');
    unset($this_files_version);
    return true;
  }

  if (defined('ZEN_COLORBOX_SLIDESHOW_START_TEXT') && zen_get_configuration_key_value('ZEN_COLORBOX_SLIDESHOW_START_TEXT') === 'start slideshow') {
    $db->Execute("DELETE FROM " . TABLE_CONFIGURATION . " WHERE configuration_key = 'ZEN_COLORBOX_SLIDESHOW_START_TEXT'");
    if (function_exists('zen_record_admin_activity')) {
      zen_record_admin_activity('Deleted configuration key ZEN_COLORBOX_SLIDESHOW_START_TEXT', 'info');
    }
    $messageStack->add("Configuration table Slideshow Start Text for " . $module_name . " has been removd by v" . $this_files_version . " upgrade.", 'success');
    $return_cancel = false;
  } elseif (defined('ZEN_COLORBOX_SLIDESHOW_START_TEXT')) {
    $result = $db->Execute("SELECT configuration_key FROM " . TABLE_CONFIGURATION . " WHERE configuration_key = 'ZEN_COLORBOX_SLIDESHOW_START_TEXT'");
    if (!$result->EOF) {
      $messageStack->add("Configuration table Slideshow Start Text is still defined in the database and is not currently set to its default value of \'start slideshow\'. This prevents removal from the database in place of the language defined version as part of upgrade to " . $module_name . " v" . $this_files_version . ".", 'warning');
      $return_cancel = true;
    }
  }
  if (defined('ZEN_COLORBOX_SLIDESHOW_STOP_TEXT') && zen_get_configuration_key_value('ZEN_COLORBOX_SLIDESHOW_STOP_TEXT') === 'stop slideshow') {
    $db->Execute("DELETE FROM " . TABLE_CONFIGURATION . " WHERE configuration_key = 'ZEN_COLORBOX_SLIDESHOW_STOP_TEXT'");
    if (function_exists('zen_record_admin_activity')) {
      zen_record_admin_activity('Deleted configuration key ZEN_COLORBOX_SLIDESHOW_STOP_TEXT', 'info');
    }
    $messageStack->add("Configuration table Slideshow Stop Text for " . $module_name . " has been removd by v" . $this_files_version . " upgrade.", 'success');
    $return_cancel = ($return_cancel ? true : false);
  } elseif (defined('ZEN_COLORBOX_SLIDESHOW_STOP_TEXT')) {
    $result = $db->Execute("SELECT configuration_key FROM " . TABLE_CONFIGURATION . " WHERE configuration_key = 'ZEN_COLORBOX_SLIDESHOW_STop_TEXT'");
    if (!$result->EOF) {
      $messageStack->add("Configuration table Slideshow Stop Text is still defined in the database and is not currently set to its default value of \'stop slideshow\'. This prevents removal from the database in place of the language defined version as part of upgrade to " . $module_name . " v" . $this_files_version . ".", 'warning');
      $return_cancel = true;
    }
  }

  unset($this_files_version);
  return $return_cancel;
} // END OF VERSION 1.5.x and 1.3.X INSTALL
