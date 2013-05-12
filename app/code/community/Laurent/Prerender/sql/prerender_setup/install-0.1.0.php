<?php

/*
 * @category   Laurent
 * @package    Laurent_Prerender
 * @copyright  Copyright (c) 2011 Laurent Clouet
 * @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 * @author     Laurent Clouet <laurent35240@gmail.com>
 * 
 * Add prerender link field for cms pages
 */

/* @var $this Mage_Core_Model_Resource_Setup */

$this->startSetup();

$this->getConnection()->addColumn(
    $this->getTable('cms/page'),
    'prerender_link',
    array(
        'type'      => Varien_Db_Ddl_Table::TYPE_TEXT,
        'length'    => 255,
        'nullable'  => true,
        'comment'   => 'Next url for prerender meta tag',
    )
);

$this->endSetup();

