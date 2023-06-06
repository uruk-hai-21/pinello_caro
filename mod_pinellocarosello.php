<?php

/**
 * @package  mod_pinellocarosello
 * Author:   Publygoo - publygoo.it
 * Version:  1.3.0
 * Created:  January 2022
 * Updated:  June 2023
 * 
 * @copyright   Copyright (C) 2005 - 2023 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
$document = JFactory::getDocument();
$bigcaption = $params->get('bigcaption');

$document->addStyleSheet('modules/mod_pinellocarosello/assets/owl.carousel.min.css');
$document->addStyleSheet('modules/mod_pinellocarosello/assets/owl.theme.default.min.css');
$document->addStyleSheet('modules/mod_pinellocarosello/assets/pinellocarosello.css');    

// $gumberCarousel = $params->get('carousel_type');
$gumberspeed = $params->get('CarSpeed');
$gumberitems = $params->get('nrOfItems',1);
$paginationbool = 'false';
$navigationbool = 'false';
$lazyloadbool = 'false';
$enable_fancyboxbool = false;
$pagination = $params->get('pagination',1);
$lazyload = $params->get('lazyLoad',0);
$lazyloadeager = $params->get('lazyLoadEager',0);
$thumbnailsnav = $params->get('thumbnailsnav',0);
$thumbs_item = $params->get('thumbs_item',0);
$navigation = $params->get('navigation',0);
$loop = $params->get('loop',0);
$autoplay = $params->get('autoplay',0);
$caption = $params->get('mycaption');
$enable_fancybox = $params->get('enable_fancybox',0);
$fancybox = $params->get('add_fancybox',0);

if ($pagination){
    $paginationbool = 'true';
}
if ($navigation){
    $navigationbool = 'true';
}
if ($lazyload){
    $lazyloadbool = 'true';
}
if ($enable_fancybox){
    $enable_fancyboxbool = true;
}

$jq = $params->get('add_jquery');
$owl_id = "owl-" . $module->id;

// print_r($params);
$pc_items = (object)json_encode($params->get('pc_item'));

$responsive = $params->get('responsive',0);
$responsive_settings = (object)json_encode($params->get('responsive_settings'));

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx', ''), ENT_COMPAT, 'UTF-8');

require JModuleHelper::getLayoutPath('mod_pinellocarosello', $params->get('layout', 'default'));