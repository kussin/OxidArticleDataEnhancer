<?php
/**
 * Metadata version
 */
$sMetadataVersion = '2.0';

use Kussin\ArticleDataEnhancer\Core\ModuleEvents;

// FILE PATH
$sModulePath = dirname(__FILE__);

/**
 * Module information
 */
$aModule = array(
    'id'           => 'kussin/article-data-enhancer',
    'title'        => 'Kussin | Article Data Enhancer for OXID eShop',
    'description'  => 'ChatGPT Integration for OXID eShop',
    'thumbnail'    => 'module.png',
    'version'      => '0.0.1',
    'author'       => 'Daniel Kussin',
    'url'          => 'https://www.kussin.de',
    'email'        => 'daniel.kussin@kussin.de',

    'extend'       => array(
    ),

    'events' => array(
        'onActivate' => ModuleEvents::class . '::onActivate',
    ),

    'controllers' => array(
    ),

    'templates' => array(
    ),

    'blocks' => array(
    )
);