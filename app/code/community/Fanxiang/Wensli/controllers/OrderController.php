<?php
/**
 * Sales orders controller
 *
 * @category   Fanxiang
 * @package    Fanxiang_Wensli
 * @author     wangxianbin@vanthink.net
 */

class Fanxiang_Wensli_OrderController extends Mage_Core_Controller_Front_Action {
    /**
     * cancel order action
     */
    public function cancelAction() {
        $data = $this->getRequest()->getQuery();
        if ($data['orderid']) {
            $order = Mage::getModel('sales/order')->loadByIncrementId($data['orderid']);
            $order->cancel();
            $order->save();
            Mage::getSingleton('core/session')->addSuccess('订单取消成功！');
            $this->_redirect('sales/order/history');
        } else {
            Mage::getSingleton('core/session')->addError('请选择你需要取消的订单');
            $this->_redirect('sales/order/history');
        }
    }
}
?>