<?php
class Fanxiang_Weibologin_Helper_Data extends Mage_Core_Helper_Abstract
{   
     public function registerBindweibo($observer){
     /*
         $weibo_id = Mage::app()->getRequest()->getParam('weibo_id');
         if($weibo_id){
           $customer = $observer->getEvent()->getCustomer();
           $customer->setWeiboId($weibo_id); 
            

         } */
            Mage::getSingleton('core/session')->setWeiboId('');
            Mage::getSingleton('core/session')->setWeiboName(''); 
     } 
     
     
     public function loginBindweibo($observer){
         $weibo_id = Mage::app()->getRequest()->getParam('weibo_id');
         if($weibo_id){
           $customer = $observer->getEvent()->getCustomer();
           $customer->setWeiboId($weibo_id); 
            $customer->save();

         }
            Mage::getSingleton('core/session')->setWeiboId('');
            Mage::getSingleton('core/session')->setWeiboName(''); 
     } 
}