<?php
         

class Fanxiang_Coupon_Block_Create_Form extends Mage_Adminhtml_Block_Widget_Form
{
   /**
     * Init form
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('block_form');
    //    $this->setTitle(Mage::helper('cms')->__('Block Information'));
    }
    
    
        protected function _prepareLayout()
    {
        parent::_prepareLayout();

    }
    
    
    protected function _prepareForm()
    {   
     	$form = new Varien_Data_Form();
	  	$this->setForm($form);
	  	$fieldset = $form->addFieldset('coupon_form', array('legend'=>'生成优惠券'));
      
      $fieldset->addField('guizeihao', 'text', array(
		  'label'     => '规则号',
		  'class'     => 'required-entry',
		  'required'  => true,
		  'name'      => 'guizeihao',
		));
    
      $fieldset->addField('type', 'select', array(
		  'label'     => '类型',
		  'class'     => 'required-entry',
		  'required'  => true,
		  'name'      => 'leixing',
      'values'    =>  Mage::getModel('coupon/couponType')->toOptionArray(),
		));   
   
   
    
    
        //$form->setAction($this->getUrl('*/*/save'));
        $form->setUseContainer(true);
        $this->setForm($form);
    
       return parent::_prepareForm();  
    }
}