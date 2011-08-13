<?php

/*
 * @category   Laurent
 * @package    Laurent_Prerender
 * @copyright  Copyright (c) 2011 Laurent Clouet
 * @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 * @author     Laurent Clouet <laurent35240@gmail.com>
 */

//Check file constants_ex.php and rename it consttans.php
require_once 'constants.php'; 

/**
 * Selenium tests for Prerender module
 *
 */
class PrerenderTest extends PHPUnit_Extensions_SeleniumTestCase{
    
    protected function setUp()
    {
        $this->setBrowser('*chrome');
        $this->setBrowserUrl('http://www.magento-prerender.dev/');
    }
    
    protected function setPrerenderOnHomePage($prerenderLink){
        //Connection to BO
        $this->open("/admin");
        $this->type("id=username", LOGIN_BO);
        $this->type("id=login", PASSWORD_BO);
        $this->click("css=input.form-button");
        $this->waitForPageToLoad("30000");
        
        //Editing prerender link for home page
        $this->open('/admin/cms_page/edit/page_id/2/');
        $this->click("css=#page_tabs_prerender > span");
        $this->type("id=page_prerender_link", $prerenderLink);
        $this->click("//div[@id='content']/div/div[2]/p/button[5]");
        $this->waitForPageToLoad("30000");
    }
    
    /**
     * @test
     */
    public function setPrerenderOnHomePageAndCheckValueSaved(){
        $urlToPrerender = 'http://www.magento-prerender.dev/test';
        
        $this->setPrerenderOnHomePage($urlToPrerender);
        
        //Checking that value is saved
        $this->click("css=#page_tabs_prerender > span");
        $this->assertValue("id=page_prerender_link", $urlToPrerender);
    }
 
    /**
     * @test
     */
    public function setPrerenderOnHomePageAndCheckOnFront()
    {
        $urlToPrerender = 'http://www.magento-prerender.dev/test2';
        
        $this->setPrerenderOnHomePage($urlToPrerender);
        
        //Opening home on FO
        $this->open('/');
        
        //Checking that prerender link is correct there
        $this->assertElementPresent("//link[@rel='prerender' and @href='$urlToPrerender']");
    }
    
    /**
     * @test
     */
    public function checkPrerenderOnCategoryWithNextPage()
    {
        $categoryPage = 'http://www.magento-prerender.dev/music.html';
        $categoryNextPage = 'http://www.magento-prerender.dev/music.html?p=2';
        
        $this->open($categoryPage);
        
        //Checking that prerender link is correct there
        $this->assertElementPresent("//link[@rel='prerender' and @href='$categoryNextPage']");
    }
    
    /**
     * @test
     */
    public function checkPrerenderOnCategoryWithNoNextPage()
    {
        $categoryPage = 'http://www.magento-prerender.dev/music.html?limit=15';
        
        $this->open($categoryPage);
        
        //Checking that there is no prerender link
        $this->assertFalse($this->isElementPresent("//link[@rel='prerender']"));
    }
    
}

?>
