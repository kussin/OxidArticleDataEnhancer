<?php
/**
 * Metadata version
 */
$sMetadataVersion = '2.0';

use Kussin\ArticleDataEnhancer\Core\ModuleEvents;
use Kussin\ArticleDataEnhancer\Cron\Importer;

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
        'articledataenhancer_importer' => Importer::class,
    ),

    'templates' => array(
    ),

    'blocks' => array(
    ),

    'settings' => array(
        array(
            'group' => 'sKussinArticleDataEnhancerImportSettings',
            'name' => 'aKussinArticleDataEnhancerImportMapping',
            'type' => 'aarr',
            'value' => array(
                'example.csv' => 'OXARTNUM:Artikelnummer|OXEAN:EAN',
            ),
        ),
        array(
            'group' => 'sKussinArticleDataEnhancerDebugSettings',
            'name' => 'blKussinArticleDataEnhancerDebugEnabled',
            'type' => 'bool',
            'value' => 0,
        ),
        array(
            'group' => 'sKussinArticleDataEnhancerDebugSettings',
            'name' => 'sKussinArticleDataEnhancerLogFilename',
            'type' => 'str',
            'value' => 'log/KUSSIN_ARTICLEDATAENHANCER.log',
        ),
    ),
);