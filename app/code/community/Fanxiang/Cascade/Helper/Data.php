<?php

class Fanxiang_Cascade_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getCityJson($region_id)
    {
      $collection = Mage::getModel('cascade/city')->getCollection()
                    ->addFieldToFilter('region_id',$region_id); 
      
      $citys = array();
      foreach ($collection as $city)
      {
          $citys[] = array(
                        'value'=>$city->getCityId(),
                        'caption'=>$city->getCityName()
                    );
      }
      $json = Mage::helper('core')->jsonEncode($citys);
          
      return  $json;
    }
    
    
    public function getDistrictJson($city_id)
    {
       $collection = Mage::getModel('cascade/district')->getCollection()
                    ->addFieldToFilter('city_id',$city_id);
       $districts = array();  
       foreach ($collection as $district) 
       {
                $districts[] = array(
                        'value'=>$district->getPostcode (),
                        'caption'=>$district->getDistrictName()
                    );
       }
            $json = Mage::helper('core')->jsonEncode($districts);
          
      return  $json;           
    }
    
    public function updateCityName($observer)
    {
        $order = $observer->getEvent()->getOrder();
      //  $quote = $observer->getEvent()->getQuote();
       
       // Mage::log(var_export( $quote->getBillingAddress()), null, "logfile.log");  
    }



   






}
