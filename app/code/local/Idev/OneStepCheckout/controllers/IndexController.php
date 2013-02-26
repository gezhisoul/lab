<?php
class Idev_OneStepCheckout_IndexController extends Mage_Core_Controller_Front_Action {

    public function getOnepage() {
        return Mage::getSingleton('checkout/type_onepage');
    }

    public function successAction() {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function indexAction() {
        /**
         * 购物券的有效性判断
         */
        $quote = $this->getOnepage()->getQuote();
/**
        if (Mage::getSingleton('rewards/session')->isCartOverspent()) {
            Mage::getSingleton('checkout/session')->addError('你的积分不够，将无法进行结账。');
            $this->_redirect('checkout/cart');
            return;
        }
*/
        $couponCode = Mage::getSingleton('core/session')->getXianshicouponCode();
        if ($couponCode) {
            $couponCode = Mage::helper('coupon')->convertCheckoutCode($couponCode);
            if ($couponCode != Mage::getSingleton('checkout/cart')->getQuote()->getCouponCode()) {
                Mage::getSingleton('checkout/session')->addError('优惠券代码不正确');
                $this->_redirect('checkout/cart');
                return;
            }
        }
        if (!$quote->hasItems() || $quote->getHasError()) {
            $this->_redirect('checkout/cart');
            return;
        }
        if (!$quote->validateMinimumAmount()) {
            $error = Mage::getStoreConfig('sales/minimum_order/error_message');
            Mage::getSingleton('checkout/session')->addError($error);
            $this->_redirect('checkout/cart');
            return;
        }
        $this->loadLayout();

        if(Mage::helper('onestepcheckout')->isEnterprise() && Mage::helper('customer')->isLoggedIn()){

            $customerBalanceBlock = $this->getLayout()->createBlock('enterprise_customerbalance/checkout_onepage_payment_additional', 'customerbalance', array('template'=>'onestepcheckout/customerbalance/payment/additional.phtml'));
            $customerBalanceBlockScripts = $this->getLayout()->createBlock('enterprise_customerbalance/checkout_onepage_payment_additional', 'customerbalance_scripts', array('template'=>'onestepcheckout/customerbalance/payment/scripts.phtml'));

            $rewardPointsBlock = $this->getLayout()->createBlock('enterprise_reward/checkout_payment_additional', 'reward.points', array('template'=>'onestepcheckout/reward/payment/additional.phtml', 'before' => '-'));
            $rewardPointsBlockScripts = $this->getLayout()->createBlock('enterprise_reward/checkout_payment_additional', 'reward.scripts', array('template'=>'onestepcheckout/reward/payment/scripts.phtml', 'after' => '-'));

            $this->getLayout()->getBlock('choose-payment-method')
            ->append($customerBalanceBlock)
            ->append($customerBalanceBlockScripts)
            ->append($rewardPointsBlock)
            ->append($rewardPointsBlockScripts)
            ;
        }

        $this->renderLayout();
    }
}
