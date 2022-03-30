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


if ($gumberCarousel == 'O') {
    $document->addScriptDeclaration('jQuery(document).ready(function () {
            jQuery("#' . $owl_id . '").owlCarousel({
                autoplay: '. $autoplay .',
                loop: '. $loop .',
                navigation: false, 
                dotsSpeed: 400,
                items: 1,
                dots:' . $paginationbool . ', 
                nav:' . $navigationbool . ',
                //navText: [\'<i class="fa fa-chevron-left"></i>\',\'<i class="fa fa-chevron-right"></i>\'],
                navText : [,],
            });
        });');
} elseif ($gumberCarousel == 'I') {
    $document->addScriptDeclaration('jQuery(document).ready(function () {
            jQuery("#' . $owl_id . '").owlCarousel({
                autoplay: '. $autoplay .',
                loop: '. $loop .',
                autoplaySpeed: ' . $gumberspeed . ', 
                items : ' . $gumberitems . ',
                dots:' . $paginationbool . ', 
                nav:' . $navigationbool . ', 
                itemsDesktop : [1199,3],
                itemsDesktopSmall : [979,3]
            });
        });');
} elseif ($gumberCarousel == 'L') {
    $document->addScriptDeclaration('jQuery(document).ready(function () {
            jQuery("#' . $owl_id . '").owlCarousel({
                autoplay: '. $autoplay .',
                items : ' . $gumberitems . ',
                dots:' . $paginationbool . ', 
                nav:' . $navigationbool . ',     
                itemsDesktop : [1199,3],
                itemsDesktopSmall : [979,3]
            });
        });');
} elseif ($gumberCarousel == 'F') {
    $document->addScriptDeclaration('jQuery(document).ready(function () {
            jQuery("#' . $owl_id . '").owlCarousel({
                autoplay: '. $autoplay .',
                loop: '. $loop .',
                lazyLoad: '. $lazyload .',
                //loop: false,
                //rewind: true,
                mouseDrag: false,
                touchDrag: true,
                navigation: false, 
                dotsSpeed: 400,
                items: 1,
                dots:' . $paginationbool . ', 
                nav:' . $navigationbool . ',
                //navText: [\'<i class="fa fa-chevron-left"></i>\',\'<i class="fa fa-chevron-right"></i>\'],
                navText : [,],
            });
        });
        Fancybox.bind("#'.$owl_id.' .owl-item:not(.cloned) a[data-fancybox=\'gallery_'.$owl_id.'\']", {
            Toolbar: {
                display: [
                  { id: "counter", position: "left" },
                  "close"
                ],
              },
            Thumbs: {
                autoStart: false
            },
          });
        ');
}
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
        if ($gumber_img[$number]) {
            // if ($caption) {
                $newlink = $gumber_img[$linknr];
                
                    echo '<div class="item myrelative">';
                            if($gumberCarousel == 'F'){
                                echo '<a href="'.$gumber_img[$number].'" data-fancybox="gallery_'. $owl_id .'" '.
                                (!is_null($caption)?' data-caption="'.$gumber_img[$titlenr].'">':'>')
                                .'<img '. 
                                ($lazyload ? 'class="owl-lazy" data-src="'.JURI::base().$gumber_img[$number].'" data-src-retina="'.JURI::base().$gumber_img[$number].'"' : 'src="'.$gumber_img[$number].'"')
                                .' alt="'.$gumber_img[$titlenr].'"></a>';
                                    
                            } else {
                                echo '<img '. 
                                ($lazyload ? 'class="owl-lazy" data-src="'.JURI::base().$gumber_img[$number].'" data-src-retina="'.JURI::base().$gumber_img[$number].'"' : 'src="'.$gumber_img[$number].'"')
                                .' alt="'.$gumber_img[$titlenr].'">'.
                                (!is_null($newlink)?'<a href="'.$newlink.'">':'').
                                    '<div class="'.$wrapperclass.'">
                                        <div class="'.$captionclass.'">
                                            <h5>'.$gumber_img[$titlenr].'</h5>
                                            <div>'.$gumber_img[$captionnr].'</div>
                                        </div>
                                    </div>'.
                                (!is_null($newlink)?'</a>':'');
                            }
                            echo '</div>';
        }
    }
    ?>
</div>