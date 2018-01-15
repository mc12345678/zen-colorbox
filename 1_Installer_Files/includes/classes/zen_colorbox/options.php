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
  ,loop:<?php echo ZEN_COLORBOX_LOOP;

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
	?>"{current} of {total}"<?php
}
else 
{
	?>""<?php
}

