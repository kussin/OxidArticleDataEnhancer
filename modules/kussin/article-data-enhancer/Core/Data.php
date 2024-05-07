<?php

namespace Kussin\ArticleDataEnhancer\Core;

use OxidEsales\Eshop\Core\DatabaseProvider;
use OxidEsales\Eshop\Core\Registry;

class Data
{
    public function getArticleData(string $sArticleId, $iLimit = 10): array
    {
        $aArticleData = array();

        // QUERY
        $sQuery = 'SELECT DISTINCT
            `VendorCode`,
            `Data`
        FROM 
            `kussin_article_data_enhancer`
        WHERE 
            (ProductNumber = "' . $sArticleId . '")
            OR (EAN = "' . $sArticleId . '")
        LIMIT 
            ' . $iLimit . ';';

        $oResult = DatabaseProvider::getDb(DatabaseProvider::FETCH_MODE_ASSOC)->select($sQuery);

        if ($oResult != false && $oResult->count() > 0) {
            while (!$oResult->EOF) {
                $aRow = $oResult->getFields();

                $aArticleData[$aRow['VendorCode']] = json_decode($aRow['Data']);

                //do something
                $oResult->fetchRow();
            }
        }

        return $aArticleData;
    }
}
