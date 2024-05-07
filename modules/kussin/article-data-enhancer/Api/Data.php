<?php

namespace Kussin\ArticleDataEnhancer\Api;

use Kussin\ArticleDataEnhancer\Traits\LoggerTrait;
use OxidEsales\Eshop\Application\Controller\FrontendController;
use OxidEsales\Eshop\Core\Registry;

class Data extends FrontendController
{
    use LoggerTrait;


    /**
     * @return string
     */
    public function render()
    {
        $sProductId = Registry::getConfig()->getRequestParameter('product_id');

        $this->_debug('API call for product ID: ' . $sProductId);

        // INIT DATA
        $oData = new \Kussin\ArticleDataEnhancer\Core\Data();

        // RESPONSE
        echo json_encode($oData->getArticleData($sProductId));
        exit;
    }
}
