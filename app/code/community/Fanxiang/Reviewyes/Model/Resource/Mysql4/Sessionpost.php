
<?php
class Fanxiang_Reviewyes_Model_Resource_Mysql4_Sessionpost extends Mage_Core_Model_Mysql4_Abstract{ 
	    protected function _construct() 
	    { 
	        $this->_init('reviewyes/sessionpost', 'id'); 
	    }
            
        public function table()
        {
           return $this->getTable('reviewyes/sessionpost');
        } 
      /**  **/
	}