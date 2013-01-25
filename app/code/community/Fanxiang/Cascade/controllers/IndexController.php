<?php
/**
 * 
 * Access like 
 * https://magenti.co/alpha/
 * or
 * https://magenti.co/alpha/index/index/
 * 
 */
class Fanxiang_Cascade_IndexController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
	{
       // exit('fdsfgsd');
	}
	
	public function createAction()
	{
	}
  
  public function getCityAction()
  {
      $region_id = $this->getRequest()->getParam('region_id');

      $json = Mage::helper('cascade')->getCityJson($region_id);
         
      echo  $json;
  }
  
  public function getDistrictAction()
  {
      $city_id = $this->getRequest()->getParam('city_id');

      $json = Mage::helper('cascade')->getDistrictJson($city_id);
         
      echo  $json;
  }  
  
  	
}