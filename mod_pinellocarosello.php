<?php

/**
 * @package  mod_pinellocarosello
 * Author:   Publygoo - publygoo.it
 * Version:  1.0.6
 * Created:  January 2022
 * Updated:  June 2022
 * 
 * @copyright   Copyright (C) 2005 - 2022 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
$document = JFactory::getDocument();
$bigcaption = $params->get('bigcaption');

$document->addStyleSheet(JURI::base() . '/modules/mod_pinellocarosello/assets/owl.carousel.min.css');
$document->addStyleSheet(JURI::base() . '/modules/mod_pinellocarosello/assets/owl.theme.default.min.css');
$document->addStyleSheet(JURI::base() . '/modules/mod_pinellocarosello/assets/outsmartitowl.css');    

$gumberCarousel = $params->get('carousel_type');
$gumberspeed = $params->get('CarSpeed');
$gumberitems = $params->get('nrOfItems');
$paginationbool = 'false';
$navigationbool = 'false';
$laziloadbool = 'false';
$pagination = $params->get('pagination',1);
$lazyload = $params->get('lazyLoad',0);
$lazyloadeager = $params->get('lazyLoadEager');
$navigation = $params->get('navigation',0);
$loop = $params->get('loop',0);
$autoplay = $params->get('autoplay',0);
$caption = $params->get('mycaption');
$fancybox = $params->get('add_fancybox');

if ($pagination){
    $paginationbool = 'true';
}
if ($navigation){
    $navigationbool = 'true';
}
if ($lazyload){
    $laziloadbool = 'true';
}
    
$jq = $params->get('add_jquery');
$owl_id = "owl-" . $module->id;

//variables are declared image1 to 10
$gumber_img = array();
for ($i = 1; $i < 11; $i++) {
    $number= 'image'.$i;
    $captionnr ='caption'.$i;
    $titlenr = 'title'.$i;
    $linknr = 'link'.$i;
    $gumber_img[$number] = $params->get($number);
    $gumber_img[$captionnr] = $params->get($captionnr);
    $gumber_img[$titlenr] = $params->get($titlenr);
    $gumber_img[$linknr]= $params->get($linknr);
}
require JModuleHelper::getLayoutPath('mod_pinellocarosello', $params->get('layout', 'default'));