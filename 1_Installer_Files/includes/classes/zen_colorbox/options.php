<?php
/**
 * Zen Colorbox
 *
 * @author niestudio (daniel [dot] niestudio [at] gmail [dot] com)
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: options.php 2012-04-30 niestudio $
 */

?>
  opacity:<?php echo ZEN_COLORBOX_OVERLAY_OPACITY; ?>
  ,speed:<?php echo ZEN_COLORBOX_RESIZE_DURATION; ?>
  ,initialWidth:<?php echo ZEN_COLORBOX_INITIAL_WIDTH; ?>
  ,initialHeight:<?php echo ZEN_COLORBOX_INITIAL_HEIGHT; ?>
  ,overlayClose:<?php echo ZEN_COLORBOX_CLOSE_OVERLAY; ?>
  ,loop:<?php echo ZEN_COLORBOX_LOOP; ?>
<?php if (defined('ZEN_COLORBOX_PREV_TEXT')) { ?>
  ,prev:"<?php echo ZEN_COLORBOX_PREV_TEXT; ?>"
<?php } ?>
<?php if (defined('ZEN_COLORBOX_NEXT_TEXT')) { ?>
  ,next:"<?php echo ZEN_COLORBOX_NEXT_TEXT; ?>"
<?php } ?>
<?php if (defined('ZEN_COLORBOX_CLOSE_TEXT')) { ?>
  ,close:"<?php echo ZEN_COLORBOX_CLOSE_TEXT; ?>"
<?php } ?>
<?php if (defined('ZEN_COLORBOX_XHRERROR_TEXT')) { ?>
  ,xhrError:"<?php echo ZEN_COLORBOX_XHRERROR_TEXT; ?>"
<?php } ?>
<?php if (defined('ZEN_COLORBOX_IMGERROR_TEXT')) { ?>
  ,imgError:"<?php echo ZEN_COLORBOX_IMGERROR_TEXT; ?>"
<?php } ?>
<?php if (defined('ZEN_COLORBOX_TRANSITION') && ZEN_COLORBOX_TRANSITION != '') { ?>
  ,transition:"<?php echo ZEN_COLORBOX_TRANSITION; ?>"
<?php } ?>
  <?php

if (ZEN_COLORBOX_SLIDESHOW == 'true')
{
?>
  ,slideshow:<?php echo ZEN_COLORBOX_SLIDESHOW; ?>
  ,slideshowAuto:<?php echo ZEN_COLORBOX_SLIDESHOW_AUTO; ?>
  ,slideshowSpeed:<?php echo ZEN_COLORBOX_SLIDESHOW_SPEED; ?>
  ,slideshowStart:"<?php echo ZEN_COLORBOX_SLIDESHOW_START_TEXT; ?>"
  ,slideshowStop:"<?php echo ZEN_COLORBOX_SLIDESHOW_STOP_TEXT; ?>"
<?php
}
?>,current:<?php
if (ZEN_COLORBOX_COUNTER == 'true') 
{
	?>"<?php echo sprintf(ZEN_COLORBOX_COUNTER1_TEXT, '{current}', '{total}'); ?>"<?php
}
else 
{
	?>"<?php echo sprintf(ZEN_COLORBOX_COUNTER3_TEXT, '{current}', '{total}'); ?>"<?php
}

