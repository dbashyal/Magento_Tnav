<?php
/**
 * Technooze_Stores extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   Technooze
 * @package    Technooze_Stores
 * @copyright  Copyright (c) 2008 Technooze LLC
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * admin product edit tabs
 *
 * @category   Technooze
 * @package    Technooze_Stores
 * @author     Technooze <info@technooze.com>
 */
class Technooze_Tnav_Block_Adminhtml_Tnav_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('tnav_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('tnav')->__('Category Information'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label'     => Mage::helper('tnav')->__('Category Information'),
            'title'     => Mage::helper('tnav')->__('Category Information'),
            'content'   => $this->getLayout()->createBlock('tnav/adminhtml_tnav_edit_tab_form')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }
}
