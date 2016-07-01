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
class Technooze_Tnav_Model_Tnav extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('tnav/tnav');
    }

    public function getChildCategories(){
        $id = $this->getId();
        $ids = $this->getData('children_ids');
        if(empty($ids)){
            return false;
        }
        $ids = explode(',', $ids);

     
        
        $collection = Mage::getModel('catalog/category')
            ->getCollection()
            ->addFieldToFilter('is_active',1)
            ->addFieldToFilter('entity_id', array("in"=>$ids))
            ->addAttributeToSelect('*');
        
        $strSort = 'FIELD(entity_id, \''.implode('\', \'', $ids).'\')';
        
        $collection->getSelect()->order(new Zend_Db_Expr($strSort));
        
        return $collection;
        
    }

    public function getThumbnail(){
        return Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . $this->getData('thumbnail');
    }

    public function getUrl(){
        return Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB) . trim($this->getData('url_key'), '/');
    }
}
