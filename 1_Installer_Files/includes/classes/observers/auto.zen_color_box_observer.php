<?php
/**
 * File contains just the observer class
 *
 * @copyright Copyright 2006-2017 Zen Cart Development Team
 * @copyright Copyright 2017 mc12345678 http://mc12345678.com
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version GIT: $Id: Author: mc12345678  Created for v1.5.6 $
 */
/**
 * observer class for Zen Colorbox plugin that extends the base class and
 * supports the catalog side.
 * - package provided with auto.xxx.php style observer functional for ZC 1.5.3 and above.
 * applicable notifiers may not exist in ZC versions pre ZC 1.5.5,
 * files (ie. admin/includes/classes/orders.php) may not extend the base or include some sort of notifier.
 * pre-ZC 1.5.3 will not call the update camelized functions, instead they will call the update function.
 * pre-ZC 1.5.3 only passes the first parameter of the notifier (three are received).
 *   the remaining parameters would have to be obtained by use of a global variable. The update 
 *   camelized functions can then be called with the obtained data.
 *
 * @package zen_colorbox
 */

class zcObserverZenColorBoxObserver extends base {
    
    public function __construct() {
        $attachNotifier = array();
        $attachNotifier[] = 'NOTIFY_MODULES_ADDITIONAL_IMAGES_SCRIPT_LINK';
        $attachNotifier[] = 'NOTIFY_MODULES_ADDITIONAL_IMAGES_THUMB_SLASHES';
        
        $this->attach($this, $attachNotifier);
    }
    
    
    /**
     * ZC 1.5.6 added:
     *
     *   // -----
     *   // This notifier lets any image-handler "massage" the name of the current thumbnail image name (with appropriate
     *   // slashes for javascript/jQuery display):
     *   //
     *   // $p1 ... (n/a) ... An empty array, not applicable.
     *   // $p2 ... (r/w) ... A reference to the "slashed" thumbnail image name.
     *   //
     *   $GLOBALS['zco_notifier']->notify('NOTIFY_MODULES_ADDITIONAL_IMAGES_THUMB_SLASHES', array(), $thumb_slashes);
     *
     **/
    public function updateNotifyModulesAdditionalImagesThumbSlashes(&$callingClass, $notifier, $paramsArray, &$thumb_slashes) {
        $thumb_slashes = preg_replace("/([^\\\\])'/", '$1\\\'', $thumb_slashes);
    }
    
    /**
     *  ZC 1.5.6 introduced:
     *    $script_link = false;
     *    $link_parameters = 'class="additionalImages centeredContent back"' . ' ' . 'style="width:' . $col_width . '%;"';
     *     $GLOBALS['zco_notifier']->notify(
     *         'NOTIFY_MODULES_ADDITIONAL_IMAGES_SCRIPT_LINK',
     *         array(
     *             'flag_display_large' => $flag_display_large,
     *             'products_name' => $products_name,
     *             'products_image_large' => $products_image_large,
     *             'thumb_slashes' => $thumb_slashes,
     *             'index' => $i
     *         ),
     *         $script_link,
     *         $link_parameters
     *     );
     **/
    public function updateNotifyModulesAdditionalImagesScriptLink(&$callingClass, $notifier, $paramsArray, &$script_link, &$link_parameters) {
    
        //$script_link = results from zen_colorbox.
        // if $col_width is modified then need to reset the link_parameters.
        if (function_exists('zen_colorbox')) {
            $script_link = false;
            
            $flag_display_large = $paramsArray['flag_display_large'];
            $products_name = $paramsArray['products_name'];
            $products_image_large = $paramsArray['products_image_large'];
            $thumb_slashes = $paramsArray['thumb_slashes'];
            $i = $paramsArray['index'];

            include DIR_WS_MODULES . zen_get_module_directory('zen_colorbox.php');
        }
    }
    
    
    public function update(&$callingClass, $notifier, $paramsArray) {
        if ($notifier == 'NOTIFY_MODULES_ADDITIONAL_IMAGES_SCRIPT_LINK') {
            $this->updateNotifyModulesAdditionalImagesScriptLink($callingClass, $notifier, $paramsArray, $GLOBALS['script_link'], $GLOBALS['link_parameters']);
        }
        
        if ($notifier == 'NOTIFY_MODULES_ADDITIONAL_IMAGES_THUMB_SLASHES') {
            $this->updateNotifyModulesAdditionalImagesThumbSlashes($callingClass, $notifier, $paramsArray, $GLOBALS['thumb_slashes']);
        }
    }
}
