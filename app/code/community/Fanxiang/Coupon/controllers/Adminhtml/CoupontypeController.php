<?php

/**
 * 
 * Access like 
 * https://magenti.co/alpha/
 * or
 * https://magenti.co/alpha/index/index/
 * 
 */
class Fanxiang_Coupon_Adminhtml_CoupontypeController extends Mage_Adminhtml_Controller_Action
{
     	public function indexAction()
    	{
        $this->loadLayout();
    		$this->_setActiveMenu('promo/coupon');
        $this->_title('管理优惠券类型');
        $this->_addContent($this->getLayout()->createBlock('coupon/adminhtml_coupontype'));
        $this->renderLayout();
          
    	}
      
      	public function newAction()
    	{
        $this->loadLayout();
    		$this->_setActiveMenu('promo/coupon');
        $this->_title('管理优惠券类型');
        $this->_addContent($this->getLayout()->createBlock('coupon/createtype'));
        $this->renderLayout();
    	}
      
            	public function editAction()
    	{
        $this->loadLayout();
    		$this->_setActiveMenu('promo/coupon');
        $this->_title('编辑优惠券类型');
        $this->_addContent($this->getLayout()->createBlock('coupon/createtype'));
        $this->renderLayout();
    	}
      
      public function createAction()
      {
          $name=$this->getRequest()->getParam("name");
          $prefix=$this->getRequest()->getParam("prefix");
          $jine =  $this->getRequest()->getParam("jine");
          
          $coupontype = Mage::getModel('coupon/coupontype');
          $id = $this->getRequest()->getParam('id');
          
          if (!is_null($id)) {
              $coupontype->load($id);
          }
          if($name && $prefix && $jine){
                       
                  $coupontype->setName($name);
                  $coupontype->setPrefix($prefix);
                  $coupontype->setJine($jine);
                  
                  $coupontype->save(); 
               //  exit($name.$prefix.$jine);
                  $this->_redirect('*/*/');
          }else{
                 $this->_redirect('*/*/');
          }
          

      }
      
      public function deleteAction(){
          $coupontype = Mage::getModel('coupon/coupontype');
          if ($id = (int)$this->getRequest()->getParam('id')) {
           try {
                $coupontype->load($id);
                $coupontype->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess('优惠券类型成功删除');
                $this->getResponse()->setRedirect($this->getUrl('*/adminhtml_coupontype'));
                return;
          }catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->getResponse()->setRedirect($this->getUrl('*/adminhtml_coupontype/edit', array('id' => $id)));
                return;
            }
            }
         
            $this->_redirect('*/adminhtml_coupontype');
         
      }
      


}