<?php

class Fanxiang_Alipayfastlogin_IndexController extends Mage_Core_Controller_Front_Action
{
  	public function indexAction()
  	{
    		$this->loadLayout();
    		$this->getLayout()->getBlock('root')->setTemplate("page/1column.phtml");
    		$this->renderLayout();	
  	}
	
  	public function loginAction()
  	{
        define("ALIPAY_PARTNER", Mage::getStoreConfig('alipayfastlogin/key/partner')); 
        define("ALIPAY_KEY", Mage::getStoreConfig('alipayfastlogin/key/key'));
        define("ALIPAY_RETURN_URL", Mage::getUrl().'alipayfastlogin/index/notify/');
        
        $aliapy_config['partner'] = ALIPAY_PARTNER;
        $aliapy_config['key'] = ALIPAY_KEY;
        $aliapy_config['return_url'] = ALIPAY_RETURN_URL;
        $aliapy_config['sign_type'] = 'MD5';
        $aliapy_config['input_charset'] = 'utf-8';
        $aliapy_config['transport'] = 'http';
        
        require_once("alipay/lib/alipay_service.class.php");
        
        $anti_phishing_key  = '';
        $exter_invoke_ip = '';
        
        $parameter = array(
        		"service"			=> "alipay.auth.authorize",
        		"target_service"	=> 'user.auth.quick.login',
        		
        		"partner"			=> trim($aliapy_config['partner']),
        		"_input_charset"	=> trim(strtolower($aliapy_config['input_charset'])),
            "return_url"		=> trim($aliapy_config['return_url']),
        
            "anti_phishing_key"	=> $anti_phishing_key,
        		"exter_invoke_ip"	=> $exter_invoke_ip
        );
        
        //构造快捷登录接口
        $alipayService = new AlipayService($aliapy_config);
        $html_text = $alipayService->alipay_auth_authorize($parameter);
        echo $html_text;
  	}	
  
    //返回接收入口
    public function notifyAction()
    {
        if (Mage::getSingleton('core/session')->getAlipayId()) {    
            $this->loadLayout();
        		$this->renderLayout(); 
        } else {
            define("ALIPAY_PARTNER", Mage::getStoreConfig('alipayfastlogin/key/partner')); 
            define("ALIPAY_KEY", Mage::getStoreConfig('alipayfastlogin/key/key'));
            define("DOMAIN", Mage::getStoreConfig('alipayfastlogin/key/domain'));
            define("ALIPAY_RETURN_URL", Mage::getUrl().'alipayfastlogin/index/notify/');
            
            $aliapy_config['partner'] = ALIPAY_PARTNER;
            $aliapy_config['key'] = ALIPAY_KEY;
            $aliapy_config['return_url'] = ALIPAY_RETURN_URL;
            $aliapy_config['sign_type'] = 'MD5';
            $aliapy_config['input_charset'] = 'utf-8';
            $aliapy_config['transport'] = 'http';
            
            require_once("alipay/lib/alipay_notify.class.php");
            
            $alipayNotify = new AlipayNotify($aliapy_config);
            $verify_result = $alipayNotify->verifyReturn();
            if ($verify_result) { 
                $user_id = $_GET['user_id'];	
                $token = $_GET['token'];	
                $real_name = $_GET['real_name'];
            }
     
            $customer = Mage::getResourceModel('customer/customer_collection')->addAttributeToFilter('alipay_id', $user_id)->getFirstItem();
            
            if ($customer->getData('entity_id')) {
                Mage::getSingleton('customer/session')->setCustomerAsLoggedIn($customer);
                
                Mage::getSingleton('core/session')->setAlipayName($real_name);
                Mage::getSingleton('core/session')->setAlipayId($user_id);
                Mage::getSingleton('core/session')->setAlipayToken($token);
                
                $this->_redirectUrl(Mage::getUrl().'customer/account/');
            } else {
                $email = $user_id."@".DOMAIN;
                $password = rand(100000,999999);
                
                if (!$customer = Mage::registry('current_customer')) {
                    $customer = Mage::getModel('customer/customer')->setId(null);
                }
                
                $firstname = Mage::helper('core/string')->cut_str($real_name, 1, 0);
                $lastname = Mage::helper('core/string')->cut_str($real_name, strlen($real_name), 1);
                
                $customer->setFirstname($firstname);
                $customer->setLastname($lastname);            
                $customer->setPassword($password);
                $customer->setEmail($email);
                $customer->setAlipayId($user_id);
                $customer->save();
                
                $customer = Mage::getResourceModel('customer/customer_collection')->addAttributeToFilter('alipay_id', $user_id)->getFirstItem();
                Mage::getSingleton('customer/session')->setCustomerAsLoggedIn($customer);
                
                
                Mage::getSingleton('core/session')->setAlipayName($real_name);
                Mage::getSingleton('core/session')->setAlipayId($user_id);
                Mage::getSingleton('core/session')->setAlipayToken($token);
                //$this->loadLayout();
            		//$this->renderLayout();
                $this->_redirectUrl(Mage::getUrl().'customer/account/');
            }
        }
    }
    
    
    public function addressAction()
    {
        define("ALIPAY_PARTNER", Mage::getStoreConfig('alipayfastlogin/key/partner')); 
        define("ALIPAY_KEY", Mage::getStoreConfig('alipayfastlogin/key/key'));
        define("ALIPAY_RETURN_URL", Mage::getUrl().'alipayfastlogin/index/addressnotify/');
        
        $aliapy_config['partner'] = ALIPAY_PARTNER;
        $aliapy_config['key'] = ALIPAY_KEY;
        $aliapy_config['return_url'] = ALIPAY_RETURN_URL;
        $aliapy_config['sign_type'] = 'MD5';
        $aliapy_config['input_charset'] = 'utf-8';
        $aliapy_config['transport'] = 'http';
        
        require_once("alipay/lib/alipay_service.class.php");
        
        //授权令牌，该参数的值由快捷登录接口(alipay.auth.authorize)的页面跳转同步通知参数中获取
        $token  = Mage::getSingleton('core/session')->getAlipayToken();    
        
        //构造要请求的参数数组
        $parameter = array(
        		"service"			=> "user.logistics.address.query",
        		"partner"			=> trim($aliapy_config['partner']),
        		"_input_charset"	=> trim(strtolower($aliapy_config['input_charset'])),
            "return_url"		=> trim($aliapy_config['return_url']),
            "token"				=> $token
        );
        
        //构造快捷登录用户物流地址查询接口
        $alipayService = new AlipayService($aliapy_config);
        $html_text = $alipayService->user_logistics_address_query($parameter);
        echo $html_text;
    }
    
    
    public function addressnotifyAction()
    {
        if (Mage::getSingleton('core/session')->getAlipayId()) {
            
            define("ALIPAY_PARTNER", Mage::getStoreConfig('alipayfastlogin/key/partner')); 
            define("ALIPAY_KEY", Mage::getStoreConfig('alipayfastlogin/key/key'));
            define("ALIPAY_RETURN_URL", Mage::getUrl().'alipayfastlogin/index/addressnotify/');
            
            $aliapy_config['partner'] = ALIPAY_PARTNER;
            $aliapy_config['key'] = ALIPAY_KEY;
            $aliapy_config['return_url'] = ALIPAY_RETURN_URL;
            $aliapy_config['sign_type'] = 'MD5';
            $aliapy_config['input_charset'] = 'utf-8';
            $aliapy_config['transport'] = 'http';
            
            require_once("alipay/lib/alipay_notify.class.php"); 
            
            $alipayNotify = new AlipayNotify($aliapy_config);
            $verify_result = $alipayNotify->verifyNotify();   
            
            if ($verify_result) {
                //支付宝用户id
                $user_id = $_POST['user_id'];
            	  //用户选择的收货地址
                $receive_address = (get_magic_quotes_gpc()) ? stripslashes($_POST['receive_address']) : $_POST['receive_address'];        
            
                //对receive_address做XML解析，获得各节点信息
              	$doc = new DOMDocument();
              	$doc->loadXML($receive_address);
              	//获取地址
              	$address = '';
              	if(!empty($doc->getElementsByTagName( "address" )->item(0)->nodeValue)) {
              		$address = $doc->getElementsByTagName( "address" )->item(0)->nodeValue;
              	}
              	
                echo $address;
                
              	//获取收货人名称
              	$fullname = '';
              	if(!empty($doc->getElementsByTagName( "fullname" )->item(0)->nodeValue)) {
              		$fullname = $doc->getElementsByTagName( "fullname" )->item(0)->nodeValue;
              	}
                
                echo $fullname;
                exit;
                
                $this->_redirectUrl(Mage::getUrl().'onestepcheckout/');
                
            } else {
                
            }
        } else {
            $this->_redirectUrl(Mage::getUrl().'alipayfastlogin/index/login/');  
        }     
    }
}