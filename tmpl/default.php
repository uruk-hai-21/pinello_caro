<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_pinellocarosello
 *
 * @copyright   Copyright (C) 2005 - 2023 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
if ($jq == 1) {
    JHtml::_('jquery.framework');
}
if ($fancybox == 1) {
    $document->addScript('modules/mod_pinellocarosello/assets/fancybox.umd.js');
    $document->addStyleSheet('modules/mod_pinellocarosello/assets/fancybox.css');
}

$document->addScript('modules/mod_pinellocarosello/assets/owl.carousel.min.js');


// echo JVERSION;


$modId = 'mod-custom' . $module->id;

$header_tag = json_decode($module->params)->header_tag;
$header_class = json_decode($module->params)->header_class;
// $moduleclass_sfx = json_decode($module->params)->moduleclass_sfx;
$module_tag = json_decode($module->params)->module_tag;
?>

<<?php echo $module_tag; ?> id="<?php echo $modId; ?>" <?php echo (($moduleclass_sfx != "") ? ' class="' . $moduleclass_sfx . '"' : ""); ?>>
    <?php if ($module->showtitle == 1) : ?>
        <<?php echo $header_tag; ?> class="<?php echo $header_class; ?>"><?php echo $module->title ?></<?php echo $header_tag; ?>>
    <?php endif ?>

    <?php
    if ($responsive == 1) {
        $responsive_settings = json_decode($responsive_settings->scalar);
        $responsive_paramns = "";
        $responsive_paramns_thumb = "";
        foreach ($responsive_settings as $v) {
            $responsive_paramns .= $v->breakpoint_resp . " : 
                            {
                                items : " .  $v->nrOfItems_resp . ",
                                dots: " . ($thumbnailsnav == 1 ? 'false' : $v->pagination_resp) . ", 
                                nav : " .  $v->navigation_resp . "
                            }, ";
            $responsive_paramns_thumb .= $v->breakpoint_resp . " : 
                            {
                                items : " .  $v->thumbs_item_resp . "
                            }, ";
        }
    }

    $js_code =          '
                    jQuery(document).ready(function () {
                        var sync1 = jQuery("#' . $owl_id . '");';

    if ($thumbnailsnav) {
        $js_code .=         '
                        var sync2 = jQuery("#' . $owl_id . '_nav_thumbs");
                        var slidesPerPage = 4; //globaly define number of elements per page
                        var syncedSecondary = false;
                        ';
    };

    $js_code .= '
                        jQuery(sync1).owlCarousel({
                            autoplay: ' . $autoplay . ',
                            loop: ' . $loop . ',
                            autoplayTimeout: ' . $gumberspeed . ',
                            autoplayHoverPause: true,
                            // navSpeed: ' . $gumberspeed . ',
                            navigation: false, 
                            // dotsSpeed: ' . $gumberspeed . ',
                            items: ' . $gumberitems . ',
                            dots: ' . ($thumbnailsnav == 1 ? "false" : $paginationbool) . ', 
                            nav: ' . $navigationbool . ',
                            ' . ($responsive == 1 ? 'responsiveClass: true,
                            responsive: {
                                ' . $responsive_paramns . '
                                        },' : "") . '
                            mouseDrag: false,
                            //navText: [\'<i class="fa fa-chevron-left"></i>\',\'<i class="fa fa-chevron-right"></i>\'],
                            navText : [,],';

    if ($lazyloadbool) {
        $js_code .= '
                            lazyLoad: ' . $lazyload . ',
                            lazyLoadEager: ' . $lazyloadeager . ',';
    }


    $js_code .=             '
                        })';

    if ($thumbnailsnav) {
        $js_code .= ".on('changed.owl.carousel', syncPosition)";
    }

    $js_code .= ';';

    if ($thumbnailsnav) {
        $js_code .= '
    sync2
    .on("initialized.owl.carousel", function() {
    sync2
      .find(".owl-item")
      .eq(0)
      .addClass("current");
  })
    .owlCarousel({
    items: ' . $thumbs_item . ',
    ' . ($responsive == 1 ? 'responsiveClass: true,
    responsive: {
        ' . $responsive_paramns_thumb . '
                },' : "") . '
    dots: false,
    nav: false,
    smartSpeed: 1000,
    slideSpeed: 1000,
    slideBy: 1, //alternatively you can slide by 1, this way the active slide will stick to the first item in the second carousel
    responsiveRefreshRate: 100
  })
    .on("changed.owl.carousel", syncPosition2);
  
    function syncPosition(el) {';

        if ($loop) {
            $js_code .= '
        var count = el.item.count - 1;
        var current = Math.round(el.item.index - el.item.count / 2 - 0.5);
  
        if (current < 0) {
          current = count;
        }
        if (current > count) {
          current = 0;
        }';
        } else {
            $js_code .= '
        var current = el.item.index;';
        };
        $js_code .= '
    sync2
    .find(".owl-item")
    .removeClass("current")
    .eq(current)
    .addClass("current");
    var onscreen = sync2.find(".owl-item.active").length - 1;
    var start = sync2
    .find(".owl-item.active")
    .first()
    .index();
    var end = sync2
    .find(".owl-item.active")
    .last()
    .index();

    if (current > end) {
        sync2.data("owl.carousel").to(current, 100, true);
    }
    if (current < start) {
        sync2.data("owl.carousel").to(current - onscreen, 100, true);
    }
    }

    function syncPosition2(el) {
    if (syncedSecondary) {
        var number = el.item.index;
        sync1.data("owl.carousel").to(number, 100, true);
    }
    }

    sync2.on("click", ".owl-item", function(e) {
    e.preventDefault();
    var number = jQuery(this).index();
    sync1.data("owl.carousel").to(number, 300, true);
    });
    ';
    }


    if ($enable_fancyboxbool) {
        $js_code .= '
    Fancybox.bind("#' . $owl_id . ' .owl-item a[data-fancybox=\'gallery_' . $owl_id . '\']", {
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


    $js_code .=         '
                    });
';

    $document->addScriptDeclaration($js_code);
    ?>

    <div id="<?php echo $owl_id; ?>" class="owl-carousel owl-theme">

        <?php
        if ($bigcaption) {
            $wrapperclass = "carousel-wrapper-big";
            $captionclass = "carousel-caption-big";
        } else {
            $wrapperclass = "carousel-wrapper-small";
            $captionclass = "carousel-caption-small";
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
                        case 'pc_alt':
                            $alt = $value3;
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
                        echo '<a href="' . $img . '" data-fancybox="gallery_' . $owl_id . '" ' .
                            (!is_null($caption) ? ' data-caption="' . $title . '">' : '>');
                    } else if (!is_null($link) && $link != "") {
                        echo '<a href="' . $link . '">';
                    }
                    if ($img) {
                        echo '<img ' . ($lazyload ? 'class="owl-lazy" data-src="' . $img . '" data-src-retina="' . $img . '"' : 'src="' . $img . '"')
                            . ' alt="' . $alt . '">';
                    }
                    echo '<div class="' . $wrapperclass . ($img ? ' img-txt' : ' no-img-txt') . ' ">
                        <div class="' . $captionclass . '">
                            <h5>' . $title . '</h5>
                            <div>' . $caption . '</div>
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


    <?php
    if ($thumbnailsnav) {


        echo '<div id="' . $owl_id . '_nav_thumbs" class="owl-carousel owl-theme">';

        foreach ($pc_items as $keyt => $valuet) {
            $jsont = json_decode($valuet, true);
            foreach ($jsont as $key2t => $value2t) {
                foreach ($value2t as $key3t => $value3t) {
                    switch ($key3t) {
                        case 'pc_image':
                            $imgt = $value3t;
                            break;
                        case 'pc_title':
                            $titlet = $value3t;
                            break;
                        default:
                            break;
                    }
                }


                echo '
                    <div class="item myrelative">';
                if ($imgt) {
                    echo '
                    <img src="' . $imgt . '" alt="' . $titlet . '">';
                }
                echo '
                    </div>';
            }
        }
        echo '</div>';
    }
    ?>

</<?php echo $module_tag; ?>>