
<?php
class Fanxiang_Qlogin_Model_Resource_Mysql4_Sessionpost extends Mage_Core_Model_Mysql4_Abstract{ 
	    protected function _construct() 
	    { 
	        $this->_init('qlogin/sessionpost', 'session_id'); 
	    }    
	}