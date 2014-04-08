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
class Technooze_Tnav_Block_Adminhtml_Tnav_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();

        $this->setId('tnavGrid');
        $this->setDefaultSort('tnav_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('tnav/tnav')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('tnav_id', array(
            'header'    => Mage::helper('tnav')->__('ID'),
            'align'     =>'right',
            'width'     => '50px',
            'index'     => 'tnav_id',
        ));

        $this->addColumn('name', array(
            'header'    => Mage::helper('tnav')->__('Category Name'),
            'align'     =>'left',
            'index'     => 'name',
        ));

        $this->addColumn('children_ids', array(
            'header'    => Mage::helper('tnav')->__('Sub Categories'),
            'align'     =>'left',
            'index'     => 'children_ids',
        ));

        $this->addColumn('status', array(
            'header'    => Mage::helper('tnav')->__('Status'),
            'align'     => 'left',
            'width'     => '80px',
            'index'     => 'status',
            'type'      => 'options',
            'options'   => array(
                1 => 'Enabled',
                2 => 'Disabled',
            ),
        ));

        $this->addColumn('action',array(
            'header'    =>  Mage::helper('tnav')->__('Action'),
            'width'     => '100',
            'type'      => 'action',
            'getter'    => 'getId',
            'actions'   => array(
                array(
                    'caption'   => Mage::helper('tnav')->__('Edit'),
                    'url'       => array('base'=> '*/*/edit'),
                    'field'     => 'id'
                )
            ),
            'filter'    => false,
            'sortable'  => false,
            'index'     => 'stores',
            'is_system' => true,
        ));
		
        $this->addExportType('*/*/exportCsv', Mage::helper('tnav')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('tnav')->__('XML'));

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('tnav_id');
        $this->getMassactionBlock()->setFormFieldName('tnav');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('tnav')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('tnav')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('tnav/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('tnav')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('tnav')->__('Status'),
                         'values' => $statuses
                     )
             )
        ));
        return $this;
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
}