<?php




class Fanxiang_Coupon_Block_Adminhtml_Coupontype extends Mage_Adminhtml_Block_Widget_Grid_Container
{
       /**
     * Block constructor
     */
    public function __construct()
    {
        $this->_blockGroup = 'coupon';
        $this->_controller = 'adminhtml_coupontype';
        $this->_headerText = '管理优惠券类型';
        $this->_addButtonLabel = '新增优惠券类型';
        parent::__construct();
    }
}