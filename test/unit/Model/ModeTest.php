<?php

/*
 * @category   Laurent
 * @package    Laurent_Prerender
 * @copyright  Copyright (c) 2011 Laurent Clouet
 * @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 * @author     Laurent Clouet <laurent35240@gmail.com>
 */

/**
 * Tests for Laurent_Prerender_Model_Adminhtml_Config_Mode
 *
 */
class ModeTest extends PHPUnit_Framework_TestCase{
    
    /**
     * @test
     */
    public function toOptionArrayHasGoodValues(){
        $expectedValues = array('guessing', 'log_based');
        
        $model = new Laurent_Prerender_Model_Adminhtml_Config_Mode();
        $values = array();
        foreach($model->toOptionArray() as $valueAndLabel){
            $values[] = $valueAndLabel['value'];
        }
        
        $this->assertEquals($expectedValues, $values);
    }
    
}

?>
