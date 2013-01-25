<?php





class Fanxiang_Coupon_Block_Customer extends Mage_Core_Block_Template
{
       public function getCustomerCoupon($customerId)
       {
            $collection = Mage::getResourceModel('coupon/coupon_collection')
                          ->addFieldToFilter('yonghu', $customerId);
            return  $collection; 
       }
       
       public function ConvertZhuangtai($zhuangtaiId)
       {
           $statuses = Mage::getSingleton('coupon/couponStatus')->toOptionArray();
           return  $statuses[$zhuangtaiId];
       }
       
       public function ConvertLeixing($leixingId)
       {
           $types = Mage::getSingleton('coupon/couponType')->getTypes();
           return  $types[$leixingId];
       }

}