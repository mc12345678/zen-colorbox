<?php
/**
 * Zen Colorbox
 *
 * @author niestudio (daniel [dot] niestudio [at] gmail [dot] com)
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: autoload_default.php 2012-04-30 niestudio $
 */
?>
jQuery(function($) {
	$("a[data-cbox-rel^='colorbox']").colorbox({<?php require(DIR_FS_CATALOG . DIR_WS_CLASSES . 'zen_colorbox/options.php'); ?>});;
  // Disable Colorbox on main reviews page image
  $("#productMainImageReview a").removeAttr("data-cbox-rel");
});
