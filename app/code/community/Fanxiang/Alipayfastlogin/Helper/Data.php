<?php
class Fanxiang_Alipayfastlogin_Helper_Data extends Mage_Core_Helper_Abstract
{   
    public function registerBindalipay($observer)
    {
        //Mage::getSingleton('core/session')->setAlipayId('');
        //Mage::getSingleton('core/session')->setAlipayName(''); 
        //Mage::getSingleton('core/session')->setAlipayToken('');
    } 
      
    public function loginBindalipay($observer)
    {
        //$alipay_id = Mage::app()->getRequest()->getParam('alipay_id');
        //if ($alipay_id) {
        //    $customer = $observer->getEvent()->getCustomer();
        //    $customer->setAlipayId($alipay_id); 
        //    $customer->save();
        //}
        //Mage::getSingleton('core/session')->setAlipayId('');
        //Mage::getSingleton('core/session')->setAlipayName(''); 
        //Mage::getSingleton('core/session')->setAlipayToken('');
    } 
    
    public function logoutBindalipay($observer)
    {
        Mage::getSingleton('core/session')->setAlipayId('');
        Mage::getSingleton('core/session')->setAlipayName(''); 
        Mage::getSingleton('core/session')->setAlipayToken('');    
    }
}