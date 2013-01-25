<?php




class Fanxiang_Coupon_Block_Adminhtml_Coupon extends Mage_Adminhtml_Block_Widget_Grid_Container
{
       /**
     * Block constructor
     */
    public function __construct()
    {
        $this->_blockGroup = 'coupon';
        $this->_controller = 'adminhtml_coupon';
        $this->_headerText = '管理优惠券';
        $this->_addButtonLabel = '新增优惠券';
        parent::__construct();
    }
}