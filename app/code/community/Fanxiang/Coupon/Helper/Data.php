<?php
class Fanxiang_Coupon_Helper_Data extends Mage_Core_Helper_Abstract
{
      //Alex  优惠券
    public function convertCheckoutCode($couponCode)
    {    
        if(!$couponCode){
            return $couponCode;
        }
        $coupon = Mage::getModel('coupon/coupon'); 
        $coupon->load($couponCode);

        if($coupon->getData('zhuangtai')!='2'){ 
           return 'notexist';
        }
        $guizehao = $coupon->getData('guizeihao'); 
        if($guizehao){
           return $guizehao;
        }else{
           return 'notexist';
        }
      
        
    }
    //订单生成时保存订单号到优惠券表 
    public function saveDindanhao($observer)
    {
      $order = $observer->getEvent()->getOrder();
        
      
      $youhuiquanhao = Mage::getSingleton('core/session')->getXianshicouponCode();
      if($youhuiquanhao){
         $coupon = Mage::getModel('coupon/coupon')->load($youhuiquanhao);
         $coupon->setDindanhao($order->getIncrementId());
         $coupon->setZhuangtai(1);
         $coupon->setShiyongshijian(date('Y-m-d H:i:s')); 
         $coupon->save(); 
      }
      $youhuiquanhao = Mage::getSingleton('core/session')->setXianshicouponCode('');
     // Mage::log($order->getIncrementId(), null, "logfile.log");
       
     //订单生成时判断是否有需要按规则赠送的优惠券
     
      $customersId = $order->getCustomer()->getId();
 
              if(Mage::getSingleton('checkout/session')->getPresentCoupon() == 'true'){
                        $collection = Mage::getResourceModel('coupon/coupon_collection')
                    ->addFieldToFilter('zhuangtai', 2)
                    ->addFieldToFilter('leixing',  Mage::getSingleton('checkout/session')->getPresentCouponType())
                    ->addFieldToFilter('yonghu', 0)
                    ->addFieldToFilter('dindanhao', '')
                    ->setPageSize(Mage::getSingleton('checkout/session')->getPresentCouponNumber())->setCurPage(1);
                    
                          foreach($collection as $coupon){
                         $youhuiquanhao =  $coupon->getYouhuiquanhao();
                         $coupon = Mage::getModel('coupon/coupon')->load($youhuiquanhao); 
                         $coupon->setYonghu($customersId);
                         $coupon->save();

                           }  
              }
              
              Mage::getSingleton('checkout/session')->setPresentCoupon('false');  
    }
    
    public function  registerSendcoupon($observer){
         $customer =   $observer->getEvent()->getCustomer();
         $coupontype = Mage::getStoreConfig('coupon/coupon/register'); 
        // Mage::log($customer->getId(), null, "logfile.log");
         $coupon =  Mage::getResourceModel('coupon/coupon_collection')
                    ->addFieldToFilter('zhuangtai', 2)
                    ->addFieldToFilter('leixing', $coupontype)
                    ->addFieldToFilter('yonghu', 0)
                    ->addFieldToFilter('dindanhao', '')
                    ->getFirstItem();
                    $coupon->setYonghu($customer->getId());
                    $coupon->save();
                    //var_export($coupon);
    }
    
    //按促销规则送优惠券
    public function  presentCoupon($observer){

       $form = $observer->getForm();
       $fieldset=$form->getElement('action_fieldset');
       $options = '';
       foreach ($fieldset->getElements() as $element) {
             if($element->getName() == 'simple_action'){
                $options = $element->getOptions();
             } 
            }
            //送优惠券
            $options['present_coupon'] = '送X张Y类型优惠券(优惠金额为Y)'; 
            
            $fieldset->removeField('simple_action');
            $fieldset->addField('simple_action', 'select', array(
            'label'     => Mage::helper('salesrule')->__('Apply'),
            'name'      => 'simple_action',
            'options'    => $options,
                ),'^'); 
   
    
    }
    //购物车页面应用规则
    public function applyCartRule($observer){
        
          $Controller = $observer->getControllerAction();
      if ($Controller instanceof Mage_Checkout_CartController) {
                $actionName = $Controller->getFullActionName();
                $cart=Mage::getSingleton('checkout/cart');
                $quote=$cart->getQuote();
                $actions=array('add','addgroup','updatePost','delete','couponPost','estimateUpdatePost');
                foreach ($actions as $action) {
     
                    if($actionName=='checkout_cart_'.$action){
                        $appliedRuleIds=$quote->getAppliedRuleIds();
                        foreach (explode(',',$appliedRuleIds) as $appliedRuleId) {
                            $rule = Mage::getModel('salesrule/rule')->load($appliedRuleId);
                            $simpleAction=$rule->getSimpleAction();

                            if (!(stripos($simpleAction, 'present_coupon')===false)){
                                // Mage::log((int)$rule->getDiscountAmount(),null,'logfile.log');
                                // Mage::log($rule->getDiscountStep(),null,'logfile.log');
                                 Mage::getSingleton('checkout/session')->setPresentCoupon('true'); 
                                 Mage::getSingleton('checkout/session')->setPresentCouponType((int)$rule->getDiscountAmount()); 
                                 Mage::getSingleton('checkout/session')->setPresentCouponNumber($rule->getDiscountStep());    
  
                            }else{
                              Mage::getSingleton('checkout/session')->setPresentCoupon('false'); 
                              Mage::getSingleton('checkout/session')->setPresentCouponType(''); 
                              Mage::getSingleton('checkout/session')->setPresentCouponNumber('');      
                            }
                        }

                    }
                }
            }
    
    }
}