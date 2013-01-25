<?php 

require_once 'Mage/Checkout/controllers/CartController.php';  
class Fanxiang_Coupon_Checkout_CartController extends Mage_Checkout_CartController
{
   /**
     * Initialize coupon
     */
    public function couponPostAction()
    {    
        /**
         * No reason continue with empty shopping cart
         */  
        if (!$this->_getCart()->getQuote()->getItemsCount()) {
            $this->_goBack();
            return;
        }

        $couponCode = (string) $this->getRequest()->getParam('coupon_code');
        if ($this->getRequest()->getParam('remove') == 1) {
            $couponCode = '';
            Mage::getSingleton('core/session')->setXianshicouponCode($couponCode);
        } 
        $oldCouponCode = $this->_getQuote()->getCouponCode();

        if (!strlen($couponCode) && !strlen($oldCouponCode)) {
            $this->_goBack();
            return;
        }
       // Alex 优惠券
        $xianshicouponCode = $couponCode; 
        Mage::getSingleton('core/session')->setXianshicouponCode(strlen($xianshicouponCode) ? $xianshicouponCode : '');
        $couponCode=Mage::helper('coupon')->convertCheckoutCode($couponCode);
        
        try {
            $this->_getQuote()->getShippingAddress()->setCollectShippingRates(true);
            $this->_getQuote()->setCouponCode(strlen($couponCode) ? $couponCode : '')
                ->collectTotals()
                ->save();

            if ($couponCode) {
                if ($couponCode == $this->_getQuote()->getCouponCode()) {
                    $this->_getSession()->addSuccess(
                         $this->__('您已成功使用优惠券 "%s" ', Mage::helper('core')->htmlEscape($xianshicouponCode))
                    );
                }
                else {
                    $this->_getSession()->addError(
                        $this->__('优惠券代码不正确')
                    );
                }
            } else {
                $this->_getSession()->addSuccess($this->__('取消使用优惠券'));
            }

        }
        catch (Mage_Core_Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        }
        catch (Exception $e) {
            $this->_getSession()->addError($this->__('无法应用优惠券'));
        }

        $this->_goBack();
    }

}