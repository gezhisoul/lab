<?php




class Fanxiang_Coupon_Block_Cart_Coupon extends Mage_Checkout_Block_Cart_Coupon
{
    public function getCouponCode()
    {   
        return Mage::getSingleton('core/session')->getXianshicouponCode();
    }


}