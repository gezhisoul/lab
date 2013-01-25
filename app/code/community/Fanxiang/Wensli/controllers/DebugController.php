<?php
/**
 * @author wangxianbin@vanthink.net
 * @date 2012-09-26 16:04
 */


/**
 * @module Fanxiang_Wensli
 * @category Controller
 * 调试用的controller
 */


class Fanxiang_Wensli_DebugController extends Mage_Core_Controller_Front_Action {

    public function indexAction() {
        print "Hello world";
    }

    public function testProductViewedAction() {
        print "11";
        $this->renderLayout();
        print "22";
    }
}