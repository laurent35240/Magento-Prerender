<?php

/*
 * @category   Laurent
 * @package    Laurent_Prerender
 * @copyright  Copyright (c) 2011 Laurent Clouet
 * @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 * @author     Laurent Clouet <laurent35240@gmail.com>
 */

require_once 'MagentoTestCase.php';

/**
 * Selenium tests for Prerender module in Guessing Mode
 *
 */
class GuessingModeTest extends MagentoTestCase{

    protected function setPrerenderOnHomePage($prerenderLink){
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
        //Putting correct mode for this tests
        $this->logToBO();
        $this->setPrerenderMode('guessing');
        
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
        //Putting correct mode for this tests
        $this->logToBO();
        $this->setPrerenderMode('guessing');
        
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
        //Putting correct mode for this tests
        $this->logToBO();
        $this->setPrerenderMode('guessing');
        
        $categoryPage = 'http://www.magento-prerender.dev/music.html';
        $categoryNextPage = 'http://www.magento-prerender.dev/music.html?p=2';
        
        $this->open($categoryPage);
        
        //Checking that prerender link is correct there
        $this->assertElementPresent("//link[@rel='prerender' and @href='$categoryNextPage']");
    }
    
    /**
     * @test
     */
    public function checkNoPrerenderOnCategoryWithNoNextPage()
    {
        //Putting correct mode for this tests
        $this->logToBO();
        $this->setPrerenderMode('guessing');
        
        $categoryPage = 'http://www.magento-prerender.dev/music.html?limit=15';
        
        $this->open($categoryPage);
        
        //Checking that there is no prerender link
        $this->assertFalse($this->isElementPresent("//link[@rel='prerender']"));
    }
    
    /**
     * @test
     */
    public function checkNoPrerenderOnCategoryModeListWithNoNextPage()
    {
        //Putting correct mode for this tests
        $this->logToBO();
        $this->setPrerenderMode('guessing');
        
        $categoryPage = 'http://www.magento-prerender.dev/music.html?mode=list';
        
        $this->open($categoryPage);
        
        //Checking that there is no prerender link
        $this->assertFalse($this->isElementPresent("//link[@rel='prerender']"));
    }
}

?>
