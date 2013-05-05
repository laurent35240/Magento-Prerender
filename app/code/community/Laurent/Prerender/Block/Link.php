<?php

/*
 * @category   Laurent
 * @package    Laurent_Prerender
 * @copyright  Copyright (c) 2011 Laurent Clouet
 * @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 * @author     Laurent Clouet <laurent35240@gmail.com>
 */

/**
 * Block for displaying prerendering link in HTML <head>
 *
 */
class Laurent_Prerender_Block_Link extends Mage_Core_Block_Template {

    protected $_prerenderLink = null;

    public function getCacheLifetime() {
        return 86400;
    }

    public function getCacheKey() {
        $key = 'PRERENDER_LINK_';
        $key .= sha1($this->getRequest()->getRequestUri());

        return $key;
    }

    public function getCacheTags() {
        return array(
            Mage_Cms_Model_Page::CACHE_TAG,
        );
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
                $cmsPage = Mage::getSingleton('cms/page');
                if ($cmsPage->getId()) {
                    $this->_prerenderLink = $cmsPage->getPrerenderLink();
                }

                //Prerender link for category page
                $category = Mage::registry('current_category');
                if ($category && $category->getId()) {
                    $layer = Mage::getSingleton('catalog/layer');
                    if ($layer) {
                        $productCollection = $layer->getProductCollection();

                        //Loading blocks usefull for getting next page url
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
                $this->_prerenderLink = Mage::helper('prerender')->getMostCommonNextUrl($url);
            }
        }

        return $this->_prerenderLink;
    }

}
