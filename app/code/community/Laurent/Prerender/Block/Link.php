<?php

/*
 * @category   Laurent
 * @package    Laurent_Prerender
 * @copyright  Copyright (c) 2011 Laurent Clouet
 * @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 * @author     Laurent Clouet <laurent35240@gmail.com>
 */

/**
 * Block for displaying pre-rendering link in HTML <head>
 *
 */
class Laurent_Prerender_Block_Link extends Mage_Core_Block_Template {

    protected $_prerenderLink = null;

    /**
     * Get block cache life time
     *
     * @return int
     */
    public function getCacheLifetime() {
        return 86400;
    }

    /**
     * Get cache key informative items
     *
     * @return array
     */
    public function getCacheKeyInfo()
    {
        $cacheKeyInfo = parent::getCacheKeyInfo();
        $cacheKeyInfo[] = $this->getRequest()->getRequestUri();

        return $cacheKeyInfo;
    }

    /**
     * Get tags array for saving cache
     *
     * @return array
     */
    public function getCacheTags() {
        $cacheTags = parent::getCacheTags();
        $cacheTags[] = Mage_Cms_Model_Page::CACHE_TAG;

        return $cacheTags;
    }

    /**
     * Get prerender url link for current page viewed
     * @return string Url of link to prerender empty strong if no link to prerender
     */
    public function getPrerenderLink() {
        if (is_null($this->_prerenderLink)) {
            if (Mage::getStoreConfig('system/prerender/mode') == Laurent_Prerender_Model_Adminhtml_Config_Mode::MODE_GUESSING) {
                //Guessing Mode
                
                $this->_prerenderLink = '';

                //Prerender link for cms page
                /** @var Mage_Cms_Model_Page $cmsPage */
                $cmsPage = Mage::getSingleton('cms/page');
                if ($cmsPage->getId()) {
                    $this->_prerenderLink = $cmsPage->getData('prerender_link');
                }

                //Prerender link for category page
                $category = Mage::registry('current_category');
                if ($category && $category->getId()) {
                    /** @var Mage_Catalog_Model_Layer $layer */
                    $layer = Mage::getSingleton('catalog/layer');
                    if ($layer) {
                        $productCollection = $layer->getProductCollection();

                        //Loading blocks useful for getting next page url
                        $pagerBlock = new Mage_Page_Block_Html_Pager();
                        $toolbarBlock = new Mage_Catalog_Block_Product_List_Toolbar();

                        $pagerBlock->setLimit($toolbarBlock->getLimit());
                        $pagerBlock->setCollection($productCollection);

                        if (!$pagerBlock->isLastPage()) {
                            $this->_prerenderLink = $pagerBlock->getNextPageUrl();
                        }
                    }
                }
            }
            else{
                //Log Based Mode
                $url = $this->getRequest()->getRequestUri();
                /** @var Laurent_Prerender_Helper_Data $prerenderHelper */
                $prerenderHelper = $this->helper('prerender');
                $this->_prerenderLink = $prerenderHelper->getMostCommonNextUrl($url);
            }
        }

        return $this->_prerenderLink;
    }

}
