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
class Technooze_Tnav_Block_Adminhtml_Tnav_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'tnav';
        $this->_controller = 'adminhtml_tnav';
        
        $this->_updateButton('save', 'label', Mage::helper('tnav')->__('Save Category'));
        $this->_updateButton('delete', 'label', Mage::helper('tnav')->__('Delete Category'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('tnav_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'tnav_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'tnav_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('tnav_data') && Mage::registry('tnav_data')->getId() ) {
            return Mage::helper('tnav')->__("Edit Category '%s'", $this->htmlEscape(Mage::registry('tnav_data')->getName()));
        } else {
            return Mage::helper('tnav')->__('Add Category');
        }
    }
}