<?php
/**
 * Zen Colorbox
 *
 * @author niestudio (daniel [dot] niestudio [at] gmail [dot] com)
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: jquery_colorbox.php 2012-04-30 niestudio $
 */
 if (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/zen_colorbox_language.php')) {
   require (DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . $template_dir . '/zen_colorbox_language.php');
 } elseif (file_exists(DIR_WS_LANGUAGES . $_SESSION['language'] . '/zen_colorbox_language.php')) {
   require (DIR_WS_LANGUAGES . $_SESSION['language'] . '/zen_colorbox_language.php');
 } else {
   require (DIR_WS_LANGUAGES . 'english/zen_colorbox_language.php');
 }
echo '<script type="text/javascript" src="' . $template->get_template_dir('.js', DIR_WS_TEMPLATE, $current_page_base, 'jscript') . '/jquery.colorbox-min.js"></script>';
?>
<?php // <script language="javascript" type="text/javascript">