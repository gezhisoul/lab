<?php
         

class Fanxiang_Coupon_Block_Createtype_Form extends Mage_Adminhtml_Block_Widget_Form
{
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
}