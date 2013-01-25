<?php


class Fanxiang_Coupon_Block_Createtype extends Mage_Adminhtml_Block_Widget_Form_Container
{
      public function __construct()
      {
           parent::__construct();
           
           $this->_updateButton('save', 'label', '保存优惠券类型');
           
           $this->setTemplate('coupon/createcoupontype.phtml');
      
      }
      


        public function getHeaderText()
        {
          
           return '管理优惠券类型';
            
        }
        
        public function getCreatUrl()
        {
            return $this->getUrl('*/*/create');
        }
        
}