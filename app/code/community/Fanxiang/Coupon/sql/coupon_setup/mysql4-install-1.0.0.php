<?php
/**

 */
$this->startSetup();

        
$sql = 'CREATE TABLE IF NOT EXISTS `youhuiquan` (
  `youhuiquanhao` varchar(20) NOT NULL,
  `guizeihao` varchar(20) NOT NULL,
  `zhuangtai` int(4) NOT NULL,
  `jine` decimal(12,4) NOT NULL,
  `leixing` int(4) NOT NULL,
  `dindanhao` varchar(20) NOT NULL,
  `laiyuan` int(4) NOT NULL ,
  `laiyuandindanhao` varchar(20) NOT NULL,
  `yonghu` int(8) NOT NULL,
  `huoqushijian` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `shiyongshijian` datetime NOT NULL,
  PRIMARY KEY (`youhuiquanhao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8';
$row = Mage::getSingleton('core/resource')->getConnection('core_write')->query($sql);

 $sql = 'CREATE TABLE IF NOT EXISTS `youhuiquantype` (
  `typeid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `prefix` varchar(4) NOT NULL,
  `jine` varchar(8) NOT NULL,
  PRIMARY KEY (`typeid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1';
$row = Mage::getSingleton('core/resource')->getConnection('core_write')->query($sql);


$this->endSetup();
