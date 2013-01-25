<?php
class Fanxiang_Salessort_Helper_Data extends Mage_Core_Helper_Abstract
{ 
          //按真实销量
/**       
          public function refreshSales($observer)
          {
              $order = $observer->getEvent()->getOrder();
              foreach ($order->getAllItems() as $item) {
                 $product = Mage::getModel('catalog/product')->load($item->getData('product_id')); 
                 	$_product = Mage::getResourceModel('reports/product_collection')
              	            ->addAttributeToSelect(array('entity_id'))
              	            ->addOrderedQty()
              	            ->addAttributeToFilter('entity_id', $product->getId())
                            ->getFirstItem();
                 
                 $product->setData('sales',$_product->getOrderedQty()); 
                 $product->save();
              }
              
          }
      **/
      
      //可手动作假的销量，同时按订单量增长
       public function refreshSales($observer)
          {
              $order = $observer->getEvent()->getOrder();
              foreach ($order->getAllItems() as $item) {
                 $product = Mage::getModel('catalog/product')->load($item->getData('product_id'));
                 $product->setData('sales',(int)($product->getData('sales')+$item->getQtyOrdered()));
                 $product->save();
              }
 
          }
    
    

}