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
class Technooze_Tnav_Block_Tnav extends Mage_Core_Block_Template
{
    public function _prepareLayout()
    {
    	return parent::_prepareLayout();
    }

    public function getTnav(){
        if (!$this->hasData('tnav')) {
            $tnav = Mage::getModel('tnav/tnav')
              ->getCollection()
              ->addFieldToFilter('status', 1);
            $this->setData('tnav', $tnav);
        }
        return $this->getData('tnav');
    }
}