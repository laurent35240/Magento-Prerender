<?php

/*
 * @category   Laurent
 * @package    Laurent_Prerender
 * @copyright  Copyright (c) 2011 Laurent Clouet
 * @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 * @author     Laurent Clouet <laurent35240@gmail.com>
 */


class Laurent_Prerender_Model_Adminhtml_Config_Mode
{

    const MODE_GUESSING = 'guessing';
    const MODE_LOG_BASED = 'log_based';

    /**
     * Give array of mode available for prerender link
     * @return array Different mode available for prerender links
     */
    public function toOptionArray()
    {
        return array(
            array(
                'value' => self::MODE_GUESSING,
                'label' => Mage::helper('prerender')->__('Guessing mode')
            ),
            array(
                'value' => self::MODE_LOG_BASED,
                'label' => Mage::helper('prerender')->__('Based on Logs mode')
            ),
        );
    }

}
