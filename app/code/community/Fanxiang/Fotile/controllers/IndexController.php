<?php

/**
 * @controller Fotile module default controller
 */

class Fanxiang_Fotile_IndexController extends Mage_Core_Controller_Front_Action {

    public function indexAction() {
        $this->getResponse()->setBody('Hello world');
    }

    public function regionqueryAction() {
		$this->loadLayout();
        $this->renderLayout();
    }
}