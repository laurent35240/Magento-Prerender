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
 * Usefull class for Magento Selenium Tests
 *
 */
class MagentoTestCase extends PHPUnit_Extensions_SeleniumTestCase{
    
    protected function setUp() {
        $this->setBrowser('*chrome');
        $this->setBrowserUrl('http://www.magento-prerender.dev/');
    }


    protected function logToBO(){
        //Connection to BO
        $this->open("/admin");
        $this->type("id=username", LOGIN_BO);
        $this->type("id=login", PASSWORD_BO);
        $this->click("css=input.form-button");
        $this->waitForPageToLoad("30000");
    }
    
    protected function setPrerenderMode($mode){
        $this->open('http://www.magento-prerender.dev/index.php/admin/system_config/edit/section/system/');
        $this->click("id=system_prerender-head");
        $this->select("id=system_prerender_mode", "value=$mode");
        $this->click("//div[@id='content']/div/div[2]/table/tbody/tr/td[2]/button");
        $this->waitForPageToLoad("30000");
    }
    
}

?>
