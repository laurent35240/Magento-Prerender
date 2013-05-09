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
 * Selenium tests for Prerender module in Log Base Mode
 *
 */
class LogBasedModeTest extends MagentoTestCase{
    
    /**
     * @test
     */
    public function checkNoPrerenderFieldForCmsPages(){
        //Putting correct mode for this tests
        $this->logToBO();
        $this->setPrerenderMode('log_based');
        
        //Checking that prerender tab is not anymore present on cms editing page
        $this->open('/admin/cms_page/edit/page_id/2/');
        $this->assertFalse($this->isElementPresent("css=#page_tabs_prerender > span"));
    }
    
    /**
     * @test
     */
    public function goodPrerenderLinkAfterGoingFiveTimesThroughSameLink(){
        //Putting correct mode for this tests
        $this->logToBO();
        $this->setPrerenderMode('log_based');
        
        //Going five time to same product page from one category page
        for($i=0; $i<5; $i++){
            $this->open('/apparel.html');
            $this->click("link=Coalesce: Functioning On Impatience T-Shirt");
            $this->waitForPageToLoad("30000");
        }
        
        //Refreshing cache
        $this->open("/admin/cache/");
        $this->click("//div[@id='page:main-container']/div[2]/table/tbody/tr/td[2]/button");
        $this->waitForPageToLoad("30000");
        
        //Checking that category page has now the product link has prerender link
        $this->open('/apparel.html');
        $this->assertElementPresent("//link[@rel='prerender' and @href='http://www.magento-prerender.dev/coalesce-functioning-on-impatience-t-shirt.html']");
    }
    
}
