<?php
class Fanxiang_Coupon_Block_Adminhtml_Coupon_Customer extends Mage_Adminhtml_Block_Widget_Grid
{
         public function __construct()
        {   
            parent::__construct();
            $this->setId('couponGrid');
        //    $this->setDefaultSort('identifier');
        //    $this->setDefaultDir('ASC');
        }
        
        protected function _prepareCollection()
        {
            $collection = Mage::getResourceModel('coupon/coupon_collection')
                          ->addFieldToFilter('yonghu', $this->_getCustomer()->getId());
          
            $this->setCollection($collection);
    
            return parent::_prepareCollection();
        }
        
         protected function _prepareColumns()
         {
         
                   $store = $this->_getStore();
         $this->addColumn('jine', array(
            'header'    => '金额',
            'width'     => '30px',
            'type'  => 'price',
            'currency_code' => $store->getBaseCurrency()->getCode(),
            'index'     => 'jine',
          
        ));
        
                 $this->addColumn('zhuangtai', array(
            'header'    => '状态',
            'width'     => '30px',
            'index'     => 'zhuangtai',
            'type'      =>  'options',
            'options'   =>  Mage::getSingleton('coupon/couponStatus')->toOptionArray(),
        ));
        
            $this->addColumn('youhuiquanhao', array(
            'header'    => '优惠券号',
            'width'     => '50px',
            'index'     => 'youhuiquanhao',
          
        )); 
        
 
        
         
        
        
         
         $this->addColumn('leixing', array(
            'header'    => '类型',
            'width'     => '50px',
            'index'     => 'leixing',
            'type'      =>  'options',
            'options'   =>  Mage::getSingleton('coupon/couponType')->getTypes(),
        ));
        
         $this->addColumn('dindanhao', array(
            'header'    => '订单号',
            'width'     => '50px',
            'index'     => 'dindanhao',
          
        ));
        
          $this->addColumn('yonghu', array(
            'header'    => '用户',
            'width'     => '50px',
            'index'     => 'yonghu',
          
        ));  
         
         }
         
         protected function _getStore()
          {
              $storeId = (int) $this->getRequest()->getParam('store', 0);
              return Mage::app()->getStore($storeId);
          }
          
        public function _getCustomer()
    {
        if ($this->hasCustomer()) {
            return $this->getData('customer');
        }
        if (Mage::registry('current_customer')) {
            return Mage::registry('current_customer');
        }
        if (Mage::registry('customer')) {
            return Mage::registry('customer');
        }
        Mage::throwException(Mage::helper('customer')->__('Can\'t get customer instance'));
    }
         
         
}