<?php




    $installer = $this; 
	$installer->startSetup(); 
	$installer->run(" 
    
    	    CREATE TABLE `{$this->getTable('qq_session')}` (
              `session_id` INT(11) NOT NULL AUTO_INCREMENT,
              `token` TEXT,
              `secret` TEXT,
              `date` DATETIME DEFAULT NULL,
              `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
              PRIMARY KEY (`session_id`)
            ) ENGINE=MYISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;
      
	"); 
    
    $setup = new Mage_Eav_Model_Entity_Setup('core_setup');
    $AttrCode = 'qq_id';
    $settings = array (
        'position' => 1,
        'required'=> 0
    );
    $setup->addAttribute('1', $AttrCode, $settings);

	$installer->endSetup();
/** create sql **/   



// EOF