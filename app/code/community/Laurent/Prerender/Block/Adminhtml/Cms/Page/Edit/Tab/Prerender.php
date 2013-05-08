<?php

/*
 * @category   Laurent
 * @package    Laurent_Prerender
 * @copyright  Copyright (c) 2011 Laurent Clouet
 * @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 * @author     Laurent Clouet <laurent35240@gmail.com>
 */

/**
 * Block for putting prerender link in CMS page
 *
 */
class Laurent_Prerender_Block_Adminhtml_Cms_Page_Edit_Tab_Prerender 
    extends Mage_Adminhtml_Block_Widget_Form 
    implements Mage_Adminhtml_Block_Widget_Tab_Interface {
    
    protected function _prepareForm()
    {
        /* @var $model Mage_Cms_Model_Page */
        $model = Mage::registry('cms_page');

        /*
         * Checking if user have permissions to save information
         */
        if ($this->_isAllowedAction('save')) {
            $isElementDisabled = false;
        } else {
            $isElementDisabled = true;
        }


        $form = new Varien_Data_Form();

        $form->setData('html_id_prefix', 'page_');

        $fieldset = $form->addFieldset('base_fieldset', array('legend' => $this->__('Prerender Link')));

        $fieldset->addField('prerender_link', 'text', array(
            'name'      => 'prerender_link',
            'label'     => $this->__('Link'),
            'title'     => $this->__('Link'),
            'disabled'  => $isElementDisabled,
            'note'      => $this->__('Link for the most likely next page.<br/>It will be prerendered in Google Chrome'),
        ));

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }
    
    /**
     * Return Tab label
     *
     * @return string
     */
    public function getTabLabel() {
        return $this->__('Prerender Link');
    }

    /**
     * Return Tab title
     *
     * @return string
     */
    public function getTabTitle() {
        return $this->__('Prerender Link');
    }

    /**
     * Can show tab in tabs
     *
     * @return boolean
     */
    public function canShowTab() {
        //This tab is displayed only in guessing mode
        return (Mage::getStoreConfig('system/prerender/mode') == Laurent_Prerender_Model_Adminhtml_Config_Mode::MODE_GUESSING);
    }

    /**
     * Tab is hidden
     *
     * @return boolean
     */
    public function isHidden() {
        return false;
    }
    
    /**
     * Check permission for passed action
     *
     * @param string $action
     * @return bool
     */
    protected function _isAllowedAction($action)
    {
        /** @var Mage_Admin_Model_Session $adminSession */
        $adminSession = Mage::getSingleton('admin/session');
        return $adminSession->isAllowed('cms/page/' . $action);
    }

}
