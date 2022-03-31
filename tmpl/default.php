<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_pinellocarosello
 *
 * @copyright   Copyright (C) 2005 - 2022 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
if ($jq == 1) {
    JHtml::_('jquery.framework');
}
if ($fancybox == 1) {
    $document->addScript(JURI::base() . 'modules/mod_pinellocarosello/assets/fancybox.umd.js');
    $document->addStyleSheet(JURI::base() . 'modules/mod_pinellocarosello/assets/fancybox.css');
}

$document->addScript(JURI::base() . 'modules/mod_pinellocarosello/assets/owl.carousel.min.js');

$js_code = 'jQuery(document).ready(function () {
                jQuery("#' . $owl_id . '").owlCarousel({
                    autoplay: '. $autoplay .',
                    loop: '. $loop .',
                    autoplaySpeed: ' . $gumberspeed . ', 
                    navigation: false, 
                    dotsSpeed: 400,
                    items: '.$gumberitems.',
                    dots: ' . $paginationbool . ', 
                    nav: ' . $navigationbool . ',
                    mouseDrag: false,
                    //navText: [\'<i class="fa fa-chevron-left"></i>\',\'<i class="fa fa-chevron-right"></i>\'],
                    navText : [,],';
if ($lazyloadbool) {
    $js_code .= 'lazyLoad: '. $lazyload .',
                 lazyLoadEager: '. $lazyloadeager.',';
}
$js_code .= '});';

if ($enable_fancyboxbool) {
    $js_code .= 'Fancybox.bind("#'.$owl_id.' .owl-item:not(.cloned) a[data-fancybox=\'gallery_'.$owl_id.'\']", {
                    Toolbar: {
                        display: [
                        { id: "counter", position: "left" },
                        "close"
                        ],
                    },
                    Thumbs: {
                        autoStart: false
                    },
                });';
}

$js_code .= '});';

$document->addScriptDeclaration($js_code);
?>

<div id="<?php echo $owl_id; ?>" class="owl-carousel owl-theme">

    <?php
    if ($bigcaption) {
        $wrapperclass="carousel-wrapper-big";
        $captionclass="carousel-caption-big";
    } else {
        $wrapperclass="carousel-wrapper-small";
        $captionclass="carousel-caption-small";
    }
        
    for ($i = 1; $i < 11; $i++) {
        $number = 'image' . $i;
        $captionnr = 'caption' . $i;
        $titlenr = 'title' . $i;
        $linknr = 'link'.$i;
        $newlink = $gumber_img[$linknr];
        
        echo '<div class="item myrelative">';
        //$gumberCarousel == 'I'
            if ($enable_fancyboxbool) {
                echo '<a href="'.$gumber_img[$number].'" data-fancybox="gallery_'. $owl_id .'" '.
                (!is_null($caption)?' data-caption="'.$gumber_img[$titlenr].'">':'>');
            } else if (!is_null($newlink)) {
                echo '<a href="'.$newlink.'">';
            }
            
            if ($gumber_img[$number]) {
                echo '<img '. ($lazyload ? 'class="owl-lazy" data-src="'.JURI::base().$gumber_img[$number].'" data-src-retina="'.JURI::base().$gumber_img[$number].'"' : 'src="'.$gumber_img[$number].'"')
                .' alt="'.$gumber_img[$titlenr].'">';
            }
                    
            if ($enable_fancyboxbool || !is_null($newlink)) {
                echo '</a>';
            }

            echo '<div class="'.$wrapperclass.'">
                    <div class="'.$captionclass.'">
                        <h5>'.$gumber_img[$titlenr].'</h5>
                        <div>'.$gumber_img[$captionnr].'</div>
                    </div>
                  </div>';
                    
        echo '</div>';
    }
    ?>
</div>