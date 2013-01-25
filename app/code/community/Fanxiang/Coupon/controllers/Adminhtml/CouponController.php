<?php

/**
 * 
 * Access like 
 * https://magenti.co/alpha/
 * or
 * https://magenti.co/alpha/index/index/
 * 
 */
class Fanxiang_Coupon_Adminhtml_CouponController extends Mage_Adminhtml_Controller_Action
{

	public function indexAction()
	{
    $this->loadLayout();
		$this->_setActiveMenu('promo/coupon');
    $this->_title('管理优惠券');
    $this->_addContent($this->getLayout()->createBlock('coupon/adminhtml_coupon'));
    $this->renderLayout();
      
	}
  
	public function newAction()
	{
    $this->loadLayout();
		$this->_setActiveMenu('promo/coupon');
    $this->_title('管理优惠券');
    $this->_addContent($this->getLayout()->createBlock('coupon/create'));
    $this->renderLayout();
	}
  //批量生成优惠券
  public function createAction()
  {
    $guizehao=$this->getRequest()->getParam("guizeihao");
    $leixing=$this->getRequest()->getParam("leixing");
    $shuliang =  $this->getRequest()->getParam("shuliang");
    
           //保存到数据库

          	
     $write = Mage::getSingleton('core/resource')->getConnection('core_write');
 
          
     $type =  Mage::getModel('coupon/coupontype')->load($leixing);
      $jine = $type['jine'];
     //判断类型
     $prefix =$type['prefix'];
     /*switch ($leixing)
     {
       case 0:
         $prefix  = 'my';
         $jine = 0;
       break;
       case 1:
         $prefix  = 'mj';
         $jine = 100;
       break;
       case 2:
         $prefix  =  'xj';
         $jine = 10;
       break;
       case 3:
         $prefix  =  'xj';
         $jine = 20;
       break;
       default:
          $prefix ='';
     } */
     
     //生成随机数
     $youhuiquanhaos = Array();
    
     while(count($youhuiquanhaos)<$shuliang ){
        
         $youhuiquanhaos[$this->randomkeys(5)]='1';
     }
    
    // 获取流水号
    	$read= Mage::getSingleton('core/resource')->getConnection('core_read');
    	$value=$read->query("SELECT count(*)  FROM youhuiquan");
    	$row = $value->fetch();
    	
    //	print_r($row); // As Array
    $count = (int)$row['count(*)'];
    $sliushuihao = $count+1;
    
    //  exit(var_export($count));
     foreach($youhuiquanhaos as $key=>$value){
     $sliushuihaozfc = sprintf('%03s', $sliushuihao);

          $youhuiquanhao = $prefix;
          $youhuiquanhao.= substr($sliushuihaozfc,0,1);
          $youhuiquanhao.= substr($key,0,2);
          $youhuiquanhao.= substr($sliushuihaozfc,1);
          $youhuiquanhao.= substr($key,2); 
       
        	$write->query("insert into youhuiquan (youhuiquanhao,guizeihao,zhuangtai,jine,leixing) values ('$youhuiquanhao','$guizehao',2,$jine,$leixing)");
          $sliushuihao++;
         // break;
     }
     $this->_redirect('*/*/');
    // exit;
  }
  
  //后台会员管理页面批量赠送优惠券
  public function giveCouponAction()
  {
      $customers =  $this->getRequest()->getPost('customer');
      $count = count($customers);
      $coupontypes = $this->getRequest()->getPost('coupontypes');
      $collection = Mage::getResourceModel('coupon/coupon_collection')
                    ->addFieldToFilter('zhuangtai', 2)
                    ->addFieldToFilter('leixing', $coupontypes)
                    ->addFieldToFilter('yonghu', 0)
                    ->addFieldToFilter('dindanhao', '')
                    ->setPageSize($count)->setCurPage(1);
      $i=0;              
      foreach($collection as $coupon){
         $youhuiquanhao =  $coupon->getYouhuiquanhao();
         $coupon = Mage::getModel('coupon/coupon')->load($youhuiquanhao); 
         $coupon->setYonghu($customers[$i]);
         $coupon->save();
         $i++;
           var_export($coupon->getYouhuiquanhao()); 
      }              
      

     $this->_redirect('*/*/index');

  }
  
  
  
  function randomkeys($length)
  {
  	$pattern = '23456789abcdefghijkmnpqrstuvwxyz';    //字符池
    $patternlen = strlen($pattern);
    $key = '';
  	for($i=0;$i<$length;$i++)
  	{
  		$key .= $pattern{mt_rand(0,$patternlen)};    //生成php随机数
  	}
  	return $key;
  }
  
  //批量删除优惠券
  public function massDeleteAction(){
     $coupons = $this->getRequest()->getPost('coupon');
            if(!is_array($coupons)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('请选择优惠券'));
        } else{
            try{
               foreach ($coupons as $couponId){
                  $coupon = Mage::getModel('coupon/coupon')->load($couponId);
                  $coupon->delete();    
               }
               Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($coupons)
                    )
                );
            }catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        
        } 
    $this->_redirect('*/*/index');  
      
  }
  
  public function massStatusAction(){
           $coupons = $this->getRequest()->getPost('coupon');
            if(!is_array($coupons)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('请选择优惠券'));
        } else{
            try{
               foreach ($coupons as $couponId){
                  $coupon = Mage::getModel('coupon/coupon')->load($couponId);
                  $coupon->setZhuangtai($this->getRequest()->getParam('status'));
                  $coupon->save();    
               }
               Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully updated', count($coupons)
                    )
                );
            }catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        
        } 
    $this->_redirect('*/*/index'); 
  
  }	
}