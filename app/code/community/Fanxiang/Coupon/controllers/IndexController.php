<?php

/**
 * 
 * Access like 
 * https://magenti.co/alpha/
 * or
 * https://magenti.co/alpha/index/index/
 * 
 */
class Fanxiang_Coupon_IndexController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
	{
          $this->loadLayout();
		$this->renderLayout();
	}
	
	public function createAction()
	{

	}	
}