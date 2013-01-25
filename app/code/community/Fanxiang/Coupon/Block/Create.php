<?php


class Fanxiang_Coupon_Block_Create extends Mage_Adminhtml_Block_Widget_Form_Container
{
      public function __construct()
      {
           parent::__construct();
           
           $this->_updateButton('save', 'label', '生成优惠券');
           
           $this->setTemplate('coupon/createcoupon.phtml');
      
      }
      


        public function getHeaderText()
        {
          
           return '管理优惠券';
            
        }
        
        public function getCreatUrl()
        {
            return $this->getUrl('*/*/create');
        }
        
}