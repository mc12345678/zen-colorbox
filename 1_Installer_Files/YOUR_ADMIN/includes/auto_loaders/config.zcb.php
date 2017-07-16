<?php
/**
 * Zen Colorbox
 *
 * @copyright 2013 C Jones
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: config.zcb.php 1.3 01/20/2014 C Jones $
 */


if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
} 

if (IS_ADMIN_FLAG === true) { // Verify that file is in the admin.
  $autoLoadConfig[999][] = array(
    'autoType' => 'init_script',
    'loadFile' => 'init_zcb_config.php'
  );
} else {
  trigger_error('Install file attempted in location not related to the admin.', E_USER_WARNING);
  @unlink(__FILE__); // Remove this file if it was placed in the store side.
}

// uncomment the following line to perform a uninstall
// $uninstall = 'uninstall';