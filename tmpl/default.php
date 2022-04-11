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
    $js_code .= 'Fancybox.bind("#'.$owl_id.' .owl-item a[data-fancybox=\'gallery_'.$owl_id.'\']", {
                    Toolbar: {
                        display: [
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

    foreach ($pc_items as $key => $value) {
        $json = json_decode($value, true);
        foreach ($json as $key2 => $value2) {
            foreach ($value2 as $key3 => $value3) {
                switch ($key3) {
                    case 'pc_image':
                        $img = $value3;
                        break;
                    case 'pc_caption':
                        $caption = $value3;
                        break;
                    case 'pc_title':
                        $title = $value3;
                        break;
                    case 'pc_link':
                        $link = $value3;
                        break;
                    default:
                        break;
                }
            }

            if ($img || $title != '' || $caption != '') {
                echo '<div class="item myrelative">';
                    if ($enable_fancyboxbool == true && $img) {
                        echo '<a href="'.$img.'" data-fancybox="gallery_'. $owl_id .'" '.
                        (!is_null($caption)?' data-caption="'.$title.'">':'>');
                    } else if (!is_null($link) && $link != '') {
                        echo '<a href="'.$link.'">';
                    }
                    if ($img) {
                        echo '<img '. ($lazyload ? 'class="owl-lazy" data-src="'.JURI::base().$img.'" data-src-retina="'.JURI::base().$img.'"' : 'src="'.$img.'"')
                        .' alt="'.$title.'">';
                    }
                    echo '<div class="'.$wrapperclass . ($img ? ' img-txt' : ' no-img-txt').' ">
                        <div class="'.$captionclass.'">
                            <h5>'.$title.'</h5>
                            <div>'.$caption.'</div>
                        </div>
                    </div>';
                    if ($enable_fancyboxbool == true || !is_null($link)) {
                        echo '</a>';
                    }
                echo '</div>';
            }
        }
    }
    ?>
</div>
