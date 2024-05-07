<?php

namespace Kussin\ArticleDataEnhancer\Cron;

use Kussin\ArticleDataEnhancer\Traits\CsvTrait;
use Kussin\ArticleDataEnhancer\Traits\LoggerTrait;
use Kussin\ArticleDataEnhancer\Traits\ProcessFlagTrait;
use OxidEsales\Eshop\Application\Controller\FrontendController;
use OxidEsales\Eshop\Core\DatabaseProvider;
use OxidEsales\Eshop\Core\Registry;

class Importer extends FrontendController
{
    use CsvTrait;
    use LoggerTrait;
    use ProcessFlagTrait;

    private $_aFileList = null;

    /**
     * @return string
     */
    public function render()
    {
        if ($this->_getFileList()) {
            $this->_import();

        } else {
            // CLEANUP
            $this->_removeFlag();

            $this->_info('No import files found.');

            echo 'No import files found.';
        }

        exit;
    }

    private function _getFileList()
    {
        if ($this->_aFileList === null) {
            $aFileList = array();

            // CONFIG
            $aImportMapping = Registry::getConfig()->getConfigParam('aKussinArticleDataEnhancerImportMapping');

            // IMPORT PATH
            $sImportBasePath = Registry::getConfig()->getConfigParam('sShopDir') . 'import/article-data-enhancer/';

            foreach ($aImportMapping as $sFilename => $sMapping) {
                $sFilePath = str_replace('//', '/', implode('/', array(
                    $sImportBasePath,
                    $sFilename,
                )));

                if (file_exists($sFilePath)) {
                    // MAPPING
                    $aMapping = array();
                    foreach (explode('|', $sMapping) as $sKey) {
                        list($sField, $sLabel) = explode(':', $sKey);
                        $aMapping[$sField] = $sLabel;
                    }

                    // ADD TO FILE LIST
                    $aFileList[] = array(
                        'filename' => $sFilename,
                        'filepath' => $sFilePath,
                        'mapping' => $aMapping,
                    );
                }
            }

            $this->_aFileList = count($aFileList) > 0 ? $aFileList : false;
        }

        return $this->_aFileList;
    }

    private function _import()
    {
        if (!$this->_hasFlag()) {
            $this->_setFlag();

            // PROCESS IMPORT
            foreach ($this->_getFileList() as $aFile) {
                $this->_info('Start importing file: ' . $aFile['filename']);

                // LOAD CSV
                $aCsvData = $this->_getCsvData(
                    $aFile['filepath']
                );

                // SAVE DATA
                $this->_save(
                    $aFile['filename'],
                    $aCsvData,
                    $aFile['mapping']
                );

                $this->_info('End importing file: ' . $aFile['filename']);
            }

            $this->_removeFlag();

        } else {
            $this->_info('Importer already running.');
        }
    }

    protected function _save($sFilename, $aCsvDate, $aMapping)
    {
        foreach ($aCsvDate as $aRow) {
            $sProductNumber = $aRow[$aMapping['OXARTNUM']];
            $sVendorCode = md5(strtok($sFilename, '_'));
            $sEan = $aRow[$aMapping['OXEAN']];

            try {
                // INSERT or UPDATE data to db table `kussin_article_data_enhancer`
                $sQuery = 'SELECT count(*) FROM `kussin_article_data_enhancer` WHERE (`ProductNumber` = ?) AND (`VendorCode` = ?);';
                $iCount = DatabaseProvider::getDb()->getOne($sQuery, array($sProductNumber, $sVendorCode));

                if ($iCount > 0) {
                    // UPDATE
                    $sQuery = 'UPDATE `kussin_article_data_enhancer` SET `EAN` = ?, `Data` = ? WHERE (`ProductNumber` = ?) AND (`VendorCode` = ?);';
                    DatabaseProvider::getDb()->execute($sQuery, array($sEan, json_encode($aRow, JSON_UNESCAPED_UNICODE), $sProductNumber, $sVendorCode));

                    $this->_debug('UPDATE: ' . json_encode($aRow));
                } else {
                    // INSERT
                    $sQuery = 'INSERT INTO `kussin_article_data_enhancer` (`ProductNumber`, `VendorCode`, `EAN`, `Data`) VALUES (?, ?, ?, ?);';
                    DatabaseProvider::getDb()->execute($sQuery, array($sProductNumber, $sVendorCode, $sEan, json_encode($aRow, JSON_UNESCAPED_UNICODE)));

                    $this->_debug('INSERT: ' . json_encode($aRow));
                }

            } catch (\Exception $oException) {
                // ERROR
                $this->_error($oException->getMessage());
                continue;
            }
        }
    }
}
