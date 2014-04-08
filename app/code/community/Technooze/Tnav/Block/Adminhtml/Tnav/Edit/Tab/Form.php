<?php
/**
 * Technooze_Tnav extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   Technooze
 * @package    Technooze_Tnav
 * @copyright  Copyright (c) 2008 Technooze LLC
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * @category   Technooze
 * @package    Technooze_Tnav
 * @author     Damodar Bashyal (http://dltr.org/)
 */
class Technooze_Tnav_Block_Adminhtml_Tnav_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        //$tnav_data = Mage::getModel('tnav')->load($this->getRequest()->getParam('id'));

        $fieldset = $form->addFieldset('tnav_form', array('legend'=>Mage::helper('tnav')->__('General Setup')));
        $fieldset->addField('name', 'text', array(
            'label'     => Mage::helper('tnav')->__('Category Name'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'name',
        ));

        $fieldset->addField('thumbnail', 'image', array(
            'label'     => Mage::helper('tnav')->__('Image'),
            'required'  => false,
            'name'      => 'thumbnail',
        ));

        $fieldset->addField('url_key', 'text', array(
            'label'     => Mage::helper('tnav')->__('URL'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'url_key',
            'note'      => Mage::helper('tnav')->__('e.g. themes.html'),
        ));

        $fieldset->addField('children_ids', 'text', array(
            'name'      => 'children_ids',
            'label'     => Mage::helper('tnav')->__('children_ids'),
            'title'     => Mage::helper('tnav')->__('children_ids'),
            'required'  => false,
            'note'      => Mage::helper('tnav')->__('category ids separated by comma'),
        ));

        $fieldset->addField('sort_order', 'text', array(
            'label'     => Mage::helper('tnav')->__('Sort Order'),
            'name'      => 'sort_order',
        ));

        $fieldset->addField('status', 'select', array(
            'label'     => Mage::helper('tnav')->__('Status'),
            'name'      => 'status',
            'values'    => array(
                array(
                    'value'     => 1,
                    'label'     => Mage::helper('tnav')->__('Enabled'),
                ),
                array(
                    'value'     => 2,
                    'label'     => Mage::helper('tnav')->__('Disabled'),
                ),
            ),
        ));

        Mage::dispatchEvent('tnav_adminhtml_edit_prepare_form', array('block'=>$this, 'form'=>$form));

        if ( Mage::getSingleton('adminhtml/session')->getTnavData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getTnavData());
            Mage::getSingleton('adminhtml/session')->setTnavData(null);
        }
        elseif ( Mage::registry('tnav_data') )
        {
            $form->setValues(Mage::registry('tnav_data')->getData());
        }

        return parent::_prepareForm();
    }
}