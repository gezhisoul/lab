<?php
/**

 */
$this->startSetup();

        
$setup = new Mage_Eav_Model_Entity_Setup('core_setup');
$AttrCode = 'weibo_id';
$settings = array (
    'position' => 1,
    'required'=> 0
);
$setup->addAttribute('1', $AttrCode, $settings);


$this->endSetup();


// EOF