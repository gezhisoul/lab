<?php
class Fanxiang_Canceled_Model_Order extends Mage_Core_Model_Abstract
{
      
      public function getCanceled()
      {
         //Mage::log('取消', null, "logfile.log"); 
        define( "CANCEL_PENDING" , Mage::getStoreConfig('canceled/configuration/cancel_pending'));
        define( "CANCEL_AFTER" , Mage::getStoreConfig('canceled/configuration/cancel_after'));
        
        if(CANCEL_PENDING)
        {
       // Mage::log('666', null, "logfile.log"); 
            $nowtime = time()+8*60*60;
            $end_date = date('Y-m-d',$nowtime-CANCEL_AFTER*24*60*60);  
            
            $orders = Mage::getModel('sales/order')
                    ->getCollection()
                    ->addAttributeToFilter('status','pending')
                    //->addAttributeToFilter('state','new')
                    ->addAttributeToFilter('created_at', array('date' => true, 'to' => $end_date )); 
                    
            foreach($orders as $order)
            {
           // Mage::log('777', null, "logfile.log"); 
                $order->cancel();
                $order->save();
            }
        }
        
      }

}