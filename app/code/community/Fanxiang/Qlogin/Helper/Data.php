<?php
class Fanxiang_Qlogin_Helper_Data extends Mage_Core_Helper_Abstract
{   
     public function registerBindqq($observer){
     /**
         $qq_id = Mage::app()->getRequest()->getParam('qq_id');
         if($qq_id){
           $customer = $observer->getEvent()->getCustomer();
           $customer->setQqId($qq_id); 
            

         }
         */
            Mage::getSingleton('core/session')->setQqloginId('');
            Mage::getSingleton('core/session')->setQqName(''); 
     } 
     
     
     public function loginBindqq($observer){
         $qq_id = Mage::app()->getRequest()->getParam('qqlogin_id');
         if($qq_id){
           $customer = $observer->getEvent()->getCustomer();
           $customer->setQqloginId($qq_id); 
           $customer->save();

         }
            Mage::getSingleton('core/session')->setQqloginId('');
            Mage::getSingleton('core/session')->setQqName(''); 
     } 
}