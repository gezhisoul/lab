<?php


class Fanxiang_Coupon_Block_Adminhtml_Coupontype_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
             public function __construct()
        {   
            parent::__construct();
            $this->setId('coupontypeGrid');
        //    $this->setDefaultSort('identifier');
        //    $this->setDefaultDir('ASC');
        }
        
                protected function _prepareCollection()
        {
            $collection = Mage::getResourceModel('coupon/coupontype_collection');
          //  $collection->join('customer/entity', 'main_table.yonghu = entity_id', 'email');
            $this->setCollection($collection);
    
            return parent::_prepareCollection();
        }
        
         protected function _prepareColumns()
         {
            $this->addColumn('typeid', array(
            'header'    => 'ID',
            'width'     => '50px',
            'index'     => 'typeid',
          
        )); 
        
            $this->addColumn('name', array(
            'header'    => '类型名称',
            'width'     => '50px',
            'index'     => 'name',
          
        )); 
        
            $this->addColumn('prefix', array(
            'header'    => '优惠券号前缀',
            'width'     => '50px',
            'index'     => 'prefix',
          
        )); 
            $this->addColumn('jine', array(
            'header'    => '优惠券金额',
            'width'     => '50px',
            'index'     => 'jine',
          
        )); 
        
         
         }
         
             public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id'=>$row->getId()));
    }
}