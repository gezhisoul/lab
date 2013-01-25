<?php

/**
 * 
 * 
 * 
 * 
 * 
 */
class Fanxiang_Qlogin_IndexController extends Mage_Core_Controller_Front_Action
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
    //require_once  'weibo/weibooauth.php';
    require_once 'qq/oauth/redirect_to_login.php';
    
    define( "QQ_AID" , Mage::getStoreConfig('qlogin/key/aid') ); 
    define( "QQ_SKEY" , Mage::getStoreConfig('qlogin/key/skey') );
    define( "CALLBACK",Mage::getStoreConfig('qlogin/key/callback'));
    
         
    //echo QQ_AID.'---'.QQ_SKEY.'---'.CALLBACK;
    $redirect = redirect_to_login(QQ_AID, QQ_SKEY, CALLBACK);
    echo '<script>window.location.href="'.$redirect.'"</script>';
     if ($_SESSION["token"] != "" and $_SESSION["secret"] !="")
    {
        
        $sessionpost = Mage::getModel('qlogin/sessionpost');
        $sessionpost->setToken($_SESSION["token"]);
        $sessionpost->setSecret($_SESSION["secret"]);
        $sessionpost->save();
       // Mage::app()->getFrontController()->getResponse()->setRedirect($redirect)->sendResponse();
        
    }
    
     
    //echo Mage::getSingleton('core/session')->getSecret();
    //echo $redirect;
    //Mage::app()->getFrontController()->getResponse()->setRedirect($redirect)->sendResponse();
    
    
	}
    public function notifyAction()
    {
       //require_once 'QQ/oauth/get_access_token.php';
       
        define( "QQ_AID" , Mage::getStoreConfig('qlogin/key/aid') ); 
        define( "QQ_SKEY" , Mage::getStoreConfig('qlogin/key/skey') );
        require_once 'qq/oauth/get_access_token.php';
        require_once 'qq/oauth/get_user_info.php';
        $token = $_REQUEST["oauth_token"];
        $read= Mage::getSingleton('core/resource')->getConnection('core_read');  
        $value=$read->query("SELECT secret FROM qq_session WHERE token='$token'");  
        $row = $value->fetch(); 
        
       
      
       $access_str = get_access_token(QQ_AID, QQ_SKEY, $_REQUEST["oauth_token"], $row['secret'], $_REQUEST["oauth_vericode"]);
       
        $result = array();
        parse_str($access_str, $result);

        $_SESSION["token"]   = $result["oauth_token"];
        $_SESSION["secret"]  = $result["oauth_token_secret"]; 
        $_SESSION["openid"]  = $result["openid"];
        
        $arr = get_user_info(QQ_AID, QQ_SKEY, $_SESSION["token"], $_SESSION["secret"], $_SESSION["openid"]);
        //var_export($arr); 
        if(Mage::getSingleton('core/session')->getQqloginId()){
          $this->loadLayout();    
        //  $this->getLayout()->getBlock('root')->setTemplate("page/1column.phtml");
          
          $this->renderLayout(); 
        }else{
         
            $customer = Mage::getResourceModel('customer/customer_collection')->addAttributeToFilter('qqlogin_id',$_SESSION["openid"])->getFirstItem();
          //  var_export($customer);
          //  echo $customer->getData('entity_id');
           
          if($customer->getData('entity_id')){  
              Mage::getSingleton('customer/session')->setCustomerAsLoggedIn($customer);
              Mage::getSingleton('core/session')->setQqName($arr['nickname']);
              $this->_redirectUrl(Mage::getUrl().'customer/account/');
          }else{
              Mage::getSingleton('core/session')->setQqName($arr['nickname']);
              Mage::getSingleton('core/session')->setQqloginId($_SESSION["openid"]);     
              $this->loadLayout();
          	//	$this->getLayout()->getBlock('root')->setTemplate("page/1column.phtml");
          		
          		$this->renderLayout();
          }

        }
    }
   
  
}