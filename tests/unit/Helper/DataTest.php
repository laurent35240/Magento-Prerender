<?php

/*
 * @category   Laurent
 * @package    Laurent_Prerender
 * @copyright  Copyright (c) 2011 Laurent Clouet
 * @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 * @author     Laurent Clouet <laurent35240@gmail.com>
 */

/**
 * Tests for class Laurent_Prerender_Helper_Data
 *
 */
class DataTest extends PHPUnit_Framework_TestCase{
   
    public $helper;
    
    public function setUp() {
        $this->helper = Mage::helper('prerender');
    }
    
    /**
     * @test
     */
    public function getMostCommonNextUrlWithAndWithouDomain(){
        $urlWithDomain = 'http://www.magento-prerender.dev/music.html';
        $urlWithoutDomain = '/music.html';
        
        $nextForUrlWithDomain = $this->helper->getMostCommonNextUrl($urlWithDomain);
        $nextForUrlWithoutDomain = $this->helper->getMostCommonNextUrl($urlWithoutDomain);
        
        $this->assertEquals($nextForUrlWithDomain, $nextForUrlWithoutDomain);
    }
    
    /**
     * @test
     */
    public function getMostCommonNextUrlWithAndWithoutRewrite(){
        $urlWithRewrite = 'http://www.magento-prerender.dev/music.html';
        $urlWithoutRewrite = 'http://www.magento-prerender.dev/catalog/category/view/id/3';
        
        $nextForUrlWithRewrite = $this->helper->getMostCommonNextUrl($urlWithRewrite);
        $nextForUrlWithoutRewrite = $this->helper->getMostCommonNextUrl($urlWithoutRewrite);
        
        $this->assertEquals($nextForUrlWithRewrite, $nextForUrlWithoutRewrite);
    }
    
    /**
     * @test
     */
    public function getRewrittenUrlWithAndWithoutParam(){
        $urlWithParam = 'http://www.magento-prerender.dev/catalog/category/view/id/3?p=1';
        $urlWithoutParam = 'http://www.magento-prerender.dev/catalog/category/view/id/3';
        
        $rewrittenUrlWithParam = $this->helper->getRewrittenUrl($urlWithParam);
        $rewrittenUrlWithoutParam = $this->helper->getRewrittenUrl($urlWithoutParam);
        
        $this->assertEquals($rewrittenUrlWithParam, $rewrittenUrlWithoutParam . '?p=1');
    }
    
}
