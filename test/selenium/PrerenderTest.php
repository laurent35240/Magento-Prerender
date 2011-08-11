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
 
    public function testSettingPrerenderOnHomePage()
    {
        $urlToPrerender = 'http://www.magento-prerender.dev/test';
        
        //Connection to BO
        $this->open("/admin");
        $this->type("id=username", LOGIN_BO);
        $this->type("id=login", PASSWORD_BO);
        $this->click("css=input.form-button");
        $this->waitForPageToLoad("30000");
        
        //Editing prerender link for home page
        $this->open('/admin/cms_page/edit/page_id/2/');
        $this->click("css=#page_tabs_prerender > span");
        $this->type("id=page_prerender_link", $urlToPrerender);
        $this->click("//div[@id='content']/div/div[2]/p/button[4]");
        $this->waitForPageToLoad("30000");
        
        //Opening home on FO
        $this->open('/');
        
        //Checking that prerender link is correct there
        $this->assertElementPresent("//link[@rel='prerender' and @href='$urlToPrerender']");
    }
    
}

?>
