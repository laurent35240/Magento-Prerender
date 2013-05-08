<?php

/*
 * @category   Laurent
 * @package    Laurent_Prerender
 * @copyright  Copyright (c) 2011 Laurent Clouet
 * @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 * @author     Laurent Clouet <laurent35240@gmail.com>
 */

/**
 * Helper ony needed for the moment for translations
 */
class Laurent_Prerender_Helper_Data extends Mage_Core_Helper_Abstract
{

    protected $_rewriteModel = null;

    /**
     * Get the most common next url from given url based on website logs
     *
     * @param string $url The url where from we want the most common next url
     * @return string Most commonly next url after given url
     */
    public function getMostCommonNextUrl($url)
    {
        $result = '';

        $url = $this->getRewrittenUrl($url);

        //Looking into logs
        /** @var Mage_Core_Model_Resource $resourceSingleton */
        $resourceSingleton = Mage::getSingleton('core/resource');
        $readAdapter = $resourceSingleton->getConnection('read');
        $logResourceModel = Mage::getResourceSingleton('log/log');
        $nbDays = Mage::getStoreConfig('system/prerender/days_period');
        $currentDate = Mage::app()->getLocale()->date();
        $minDate = $currentDate->sub($nbDays, Zend_Date::DAY_SHORT);

        $select = $readAdapter->select()
            ->from(
                array('url_info_table' => $logResourceModel->getTable('log/url_info_table')),
                array(
                    'next_url' => 'url',
                    'nb_clicks' => 'COUNT(*)'
                ))
            ->join(
                array('url_table' => $logResourceModel->getTable('log/url_table')),
                'url_info_table.url_id = url_table.url_id',
                array())
            ->where('url_info_table.referer = ?', $url)
            ->where('url_table.visit_time > ?', $minDate->toString(Zend_Date::ISO_8601))
            ->group('url_info_table.url')
            ->order('COUNT(*) DESC');

        $results = $readAdapter->fetchAll($select);

        if (count($results) > 0) {
            $nextUrl = $results[0]['next_url'];
            $result = $this->getRewrittenUrl($nextUrl);
        }

        return $result;
    }

    /**
     * Get rewritten version of an url
     * It add host if it was not given
     * @param string $url
     * @return string The rewritten url
     */
    public function getRewrittenUrl($url)
    {
        //Remove domain to url
        $domain = trim(Mage::getBaseUrl(), '/');
        $url = str_replace($domain, '', $url);

        //Remove first slash from url
        $url = trim($url, '/');

        //Remove params
        $urlParts = explode('?', $url, 2);
        $params = '';
        if (count($urlParts) == 2) {
            $url = $urlParts[0];
            $params = $urlParts[1];
        }

        //Check if an url rewrite exists for requested url
        //We need then the rewritten url for looking into logs
        $rewriteModel = $this->_getRewriteModel();
        $rewriteModel->load($url, 'target_path');
        if ($rewriteModel->getId()) {
            $url = $rewriteModel->getRequestPath();
        }

        //Add params
        if ($params != '') {
            $url .= '?' . $params;
        }

        //Add domain to url
        if (strpos($url, $domain) === false) {
            $url = $domain . '/' . $url;
        }

        return $url;
    }

    /**
     * Get cached rewrite model
     * @return Mage_Core_Model_Url_Rewrite
     */
    protected function _getRewriteModel()
    {
        if (is_null($this->_rewriteModel)) {
            $this->_rewriteModel = Mage::getModel('core/url_rewrite');
        }
        $this->_rewriteModel->setData(array());

        return $this->_rewriteModel;
    }

}
