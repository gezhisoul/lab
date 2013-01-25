<?php
/**

 */
$this->startSetup();

        
$sql = 'ALTER TABLE `review_detail` ADD `reply` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL';
$row = Mage::getSingleton('core/resource')->getConnection('core_write')->query($sql);


$this->endSetup();


// EOF