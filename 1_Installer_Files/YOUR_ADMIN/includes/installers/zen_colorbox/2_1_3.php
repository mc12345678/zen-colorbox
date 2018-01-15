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
  
*/

$zc150 = (PROJECT_VERSION_MAJOR > 1 || (PROJECT_VERSION_MAJOR == 1 && substr(PROJECT_VERSION_MINOR, 0, 3) >= 5));
$zc130 = (PROJECT_VERSION_MAJOR > 1 || (PROJECT_VERSION_MAJOR == 1 && substr(PROJECT_VERSION_MINOR, 0, 3) >= 3));
if ($zc150 || $zc130) { // continue Zen Cart 1.5.0 or Zen Cart 1.3.x


} // END OF VERSION 1.5.x and 1.3.X INSTALL
