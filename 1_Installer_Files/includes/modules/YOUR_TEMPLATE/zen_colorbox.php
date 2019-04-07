<?php
/**
 * Zen Colorbox
 *
 * @author niestudio (daniel [dot] niestudio [at] gmail [dot] com)
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: zen_colorbox.php 2012-04-30 niestudio $
 */

  if (ZEN_COLORBOX_STATUS == 'true') {
    if (ZEN_COLORBOX_GALLERY_MODE == 'true') {
      $data_colorbox = 'colorbox';
    } else {
      $data_colorbox = 'colorbox-' . rand(100, 999);
    }
    $script_link = '<script type="text/javascript"><!--' . "\n" . 'document.write(\'' . ($flag_display_large ? '<a href="' . zen_colorbox($products_image_large, addslashes($products_name), defined('LARGE_IMAGE_WIDTH') ? LARGE_IMAGE_WIDTH : '', defined('LARGE_IMAGE_HEIGHT') ? LARGE_IMAGE_HEIGHT : '') . '" data-cbox-rel="' . $data_colorbox . '" title="' . zen_output_string_protected($products_name) . '">' . $thumb_slashes . '<br \/>' . TEXT_CLICK_TO_ENLARGE . '<\/a>' : $thumb_slashes) . '\');' . "\n" . '//--></script>';
  } else {
    $script_link = '<script type="text/javascript"><!--' . "\n" . 'document.write(\'' . ($flag_display_large ? '<a href="javascript:popupWindow(\\\'' . str_replace($products_image_large, urlencode(addslashes($products_image_large)), $large_link) . '\\\')">' . $thumb_slashes . '<br \/>' . TEXT_CLICK_TO_ENLARGE . '<\/a>' : $thumb_slashes) . '\');' . "\n" . '//--></script>';
  }
