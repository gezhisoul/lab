<?php
class Fanxiang_Reviewyes_Helper_Data extends Mage_Core_Helper_Abstract
{
  public function savereview($observer)
  {

    $order = $observer->getEvent()->getOrder();
    
    $increment_id = $order->getIncrementId();
    
    $Customer_id = $order->getCustomerId();
    
    foreach($order->getAllItems() as $item)
    {
        $product_id = $item->getProductId();
        
        $product = Mage::getModel('catalog/product')->load($product_id);
        
        $parent_id = $product->loadParentProductIds()->getData('parent_product_ids');
        
        if($parent_id)
        {
            foreach($parent_id as $id)
            {
                $product_id = $id;
            }
        }
        $r_statuts = 1;
                
        $write = Mage::getSingleton('core/resource')->getConnection('core/write');
        
        //$table = Mage::getModel('reviewyes/resource_mysql4_sessionpost')->table();
        
        $sql = "INSERT INTO review_yes (customer_id,product_id,order_id,r_status) VALUES('".$Customer_id."','".$product_id."','".$increment_id."','".$r_statuts."')";
        
        $write->query($sql,array('name','pass'));
 
        
    }
    
  } 
  public function reviewpost($observer)
  {

    $review = $observer->getEvent()->getData();
    
    foreach($review as $v)
    {
        $customer_id = $v['customer_id'];
        
        $product_id = $v['entity_pk_value'];
        
        $write = Mage::getSingleton('core/resource')->getConnection('core_write');
        
        //$table = Mage::getModel('reviewyes/resource_mysql4_sessionpost')->table();
        
        $sql = "UPDATE review_yes SET r_status = 0 WHERE customer_id ='".$customer_id."' and product_id ='".$product_id."'";
            
        $write->query($sql,array('name','pass'));
    }

        
        
  } 
     
}