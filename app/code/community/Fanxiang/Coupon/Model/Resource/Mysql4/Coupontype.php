<?php

class Fanxiang_Coupon_Model_Resource_Mysql4_Coupontype extends Mage_Core_Model_Mysql4_Abstract
{
   	    protected function _construct() 
  	    { 
  	        $this->_init('coupon/coupontype', 'typeid'); 
  	    } 
}