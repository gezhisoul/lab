<?php

/**
 * 
 * 
 * 
 * 
 * 
 */
class Fanxiang_Weibologin_IndexController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
	{
		
		
		$this->loadLayout();
		$this->getLayout()->getBlock('root')->setTemplate("page/1column.phtml");
		//$this->getLayout()->getBlock('content')->insert($this->getLayout()->createBlock('alpha/alpha'));
		$this->renderLayout();	
	}
	
	public function loginAction()
	{
   require_once  'weibo/weibooauth.php';
    define( "WB_AKEY" , Mage::getStoreConfig('weibologin/key/akey') ); 
    define( "WB_SKEY" , Mage::getStoreConfig('weibologin/key/skey') );
   
   $o = new WeiboOAuth( WB_AKEY , WB_SKEY  );

    $keys = $o->getRequestToken();
    $aurl = $o->getAuthorizeURL( $keys['oauth_token'] ,false , Mage::getUrl().'weibologin/index/notify/');
    
    $_SESSION['keys'] = $keys;
    
    Mage::app()->getFrontController()->getResponse()->setRedirect($aurl)->sendResponse();



	}	
  
  //返回接收入口
  public function notifyAction()
  {
    if(Mage::getSingleton('core/session')->getWeiboId()){
      $this->loadLayout();
    	//	$this->getLayout()->getBlock('root')->setTemplate("page/1column.phtml");
    		
    		$this->renderLayout(); 
    }else{
    require_once  'weibo/weibooauth.php';
    define( "WB_AKEY" , Mage::getStoreConfig('weibologin/key/akey') ); 
    define( "WB_SKEY" , Mage::getStoreConfig('weibologin/key/skey') );
    $o = new WeiboOAuth( WB_AKEY , WB_SKEY , $_SESSION['keys']['oauth_token'] , $_SESSION['keys']['oauth_token_secret']  );
  
    $last_key = $o->getAccessToken(  $_REQUEST['oauth_verifier'] ) ;
    
    $_SESSION['last_key'] = $last_key;
    
    $c = new WeiboClient( WB_AKEY , WB_SKEY , $_SESSION['last_key']['oauth_token'] , $_SESSION['last_key']['oauth_token_secret']  );
    $ms  = $c->home_timeline(); // done
    $me = $c->verify_credentials();
 
    $customer = Mage::getResourceModel('customer/customer_collection')->addAttributeToFilter('weibo_id',$me['id'])->getFirstItem();
    if($customer->getData('entity_id')){
       Mage::getSingleton('customer/session')->setCustomerAsLoggedIn($customer);
       Mage::getSingleton('core/session')->setWeiboName($me['name']);
       $this->_redirectUrl(Mage::getUrl().'customer/account/');
    }else{
        Mage::getSingleton('core/session')->setWeiboName($me['name']);
        Mage::getSingleton('core/session')->setWeiboId($me['id']);
        $this->loadLayout();
    	//	$this->getLayout()->getBlock('root')->setTemplate("page/1column.phtml");
    		
    		$this->renderLayout();
    }
     
    }
  
  }
  
  
}