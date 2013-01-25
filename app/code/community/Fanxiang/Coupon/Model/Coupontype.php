<?php
//优惠券类型
class Fanxiang_Coupon_Model_Coupontype  extends Mage_Core_Model_Abstract
{

     protected function _construct() 
	    { 
	        $this->_init('coupon/coupontype'); 
	    }
      
      public function toOptionArray()
      {
        /*return array(
            array('value'=>0, 'label'=>'免邮'),
            array('value'=>1, 'label'=>'满200减100'),
            array('value'=>2, 'label'=>'10元现金券'),
            array('value'=>3, 'label'=>'20元现金券'),
        );  */
       return $this->getCollection(); 
      }
      
      public function getTypes()
      {
         return $this->getCollection(); 
      
       /* return array(
            0=> '免邮',
            1=> '满200减100',
            2=> '10元现金券',
            3=> '20元现金券',
        ); */
      }
}