<?php

class Fanxiang_Coupon_Model_Coupon extends Mage_Core_Model_Abstract
{
     protected function _construct() 
	    { 
	        $this->_init('coupon/coupon'); 
	    } 
      
      public function getCustomerEmail()
      {
         	$read= Mage::getSingleton('core/resource')->getConnection('core_read');
        	$value=$read->query("SELECT yonghu FROM `youhuiquan`  GROUP BY yonghu ");
          $customerIds = array();
          while($row = $value->fetch()) {
               $customerIds[] = $row['yonghu'];
          }
          if($customerIds){
                        $emails = Mage::getResourceModel('customer/customer_collection')
                    ->addAttributeToSelect('email')
                    ->addAttributeToFilter('entity_id',$customerIds);
          $emails =  $emails->load();
          
          $array = array();
          foreach($emails as $email){
              $key = $email['entity_id'];
              $array[$key] = $email['email'];
          }  
         return $array;
          }else{
            return '';
          }          

         
      }
      
      public function getGuizehao()
      {
          $read= Mage::getSingleton('core/resource')->getConnection('core_read');
        	$value=$read->query("SELECT guizeihao FROM `youhuiquan`  GROUP BY guizeihao ");
          $guizeihaos = array();
          while($row = $value->fetch()) {
               $guizeihao = $row['guizeihao']; 
               $guizeihaos[$guizeihao] = $guizeihao;
          }
          return $guizeihaos;
      }
}