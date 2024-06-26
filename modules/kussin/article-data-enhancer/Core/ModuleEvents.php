<?php

declare(strict_types=1);

namespace Kussin\ArticleDataEnhancer\Core;

use OxidEsales\Eshop\Core\DatabaseProvider;
use OxidEsales\Eshop\Core\Registry;

final class ModuleEvents
{
    public static function onActivate(): void
    {
        // REGISTER MODULE
        self::_register();

        // INITIONALIZE
        self::_createArticleDataEnhancerTable();
    }

    private static function _hasDbTable($sTable): bool
    {
        $sQuery = "SHOW TABLES LIKE '$sTable';";
        $oResult = DatabaseProvider::getDb()->getAll($sQuery);

        return ($oResult == FALSE) ? FALSE : TRUE;
    }

    private static function _hasDbTableColumn($sTable, $sColumn): bool
    {
        $sQuery = "SHOW COLUMNS FROM `$sTable` LIKE '$sColumn';";
        $oResult = DatabaseProvider::getDb()->getAll($sQuery);

        return ($oResult == FALSE) ? FALSE : TRUE;
    }

    private static function _addNewColumn($sTable, $aColumns): void
    {
        foreach ($aColumns as $aColumn) {
            $sName = $aColumn['name'];
            $sSettings = $aColumn['settings'];

            if (!self::_hasDbTableColumn($sTable, $sName)) {
                $sQuery = "ALTER TABLE `$sTable` ADD COLUMN `$sName` $sSettings;";
                DatabaseProvider::getDb()->execute($sQuery);
            }
        }
    }

    private static function _hasDbEntry($sTable, $sOxid): bool
    {
        $sQuery = "SELECT * FROM `$sTable` WHERE OXID LIKE '$sOxid';";
        $oResult = DatabaseProvider::getDb()->getAll($sQuery);

        return ($oResult == FALSE) ? FALSE : TRUE;
    }

    private static function _createArticleDataEnhancerTable(): void
    {
        if (!self::_hasDbTable('kussin_article_data_enhancer')) {
            $sQuery = file_get_contents(__DIR__ . '/../sql/insert.sql');
            DatabaseProvider::getDb()->execute($sQuery);
        }
    }

    private static function _register($sLicenseFile = 'modules/kussin/article-data-enhancer/license.txt', $iTimeout = 500): void
    {
        try {
            // CREATE LICENSE FILE
            $sFilename = str_replace('//', '/', Registry::getConfig()->getConfigParam('sShopDir') . '/' . $sLicenseFile);
            if (!file_exists($sFilename)) {
                touch($sFilename);
            }

            // CLIENT ADDRESS
            if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                $sClientIp = $_SERVER['HTTP_CLIENT_IP'];

            } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $sClientIp = $_SERVER['HTTP_X_FORWARDED_FOR'];

            } else {
                $sClientIp = $_SERVER['REMOTE_ADDR'];
            }

            // RESISTER MODULE
            $rCurl = curl_init('https://register.kussin-module.de/');
            curl_setopt($rCurl, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($rCurl, CURLOPT_POSTFIELDS, array(
                'license_url' => Registry::getConfig()->getConfigParam('sSSLShopURL') . '/' . $sLicenseFile,
                'remote_ip' => $sClientIp,
                'timestamp' => date('Y-m-d H:i:s'),
            ));
            curl_setopt($rCurl,CURLOPT_TIMEOUT,$iTimeout);
            curl_exec($rCurl);
            curl_close($rCurl);

        } catch (\Exception $oException) {
            // ERROR
        }
    }
}
