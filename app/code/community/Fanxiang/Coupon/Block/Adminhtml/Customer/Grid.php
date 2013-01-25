<?php





class Fanxiang_Coupon_Block_Adminhtml_Customer_Grid extends Mage_Adminhtml_Block_Customer_Grid
{

      protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('customer');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('customer')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('customer')->__('Are you sure?')
        ));

        $this->getMassactionBlock()->addItem('newsletter_subscribe', array(
             'label'    => Mage::helper('customer')->__('Subscribe to Newsletter'),
             'url'      => $this->getUrl('*/*/massSubscribe')
        ));

        $this->getMassactionBlock()->addItem('newsletter_unsubscribe', array(
             'label'    => Mage::helper('customer')->__('Unsubscribe from Newsletter'),
             'url'      => $this->getUrl('*/*/massUnsubscribe')
        ));

        $groups = $this->helper('customer')->getGroups()->toOptionArray();
        
        array_unshift($groups, array('label'=> '', 'value'=> ''));
        $this->getMassactionBlock()->addItem('assign_group', array(
             'label'        => Mage::helper('customer')->__('Assign a Customer Group'),
             'url'          => $this->getUrl('*/*/massAssignGroup'),
             'additional'   => array(
                'visibility'    => array(
                     'name'     => 'group',
                     'type'     => 'select',
                     'class'    => 'required-entry',
                     'label'    => Mage::helper('customer')->__('Group'),
                     'values'   => $groups
                 )
            )
        ));
        
        //赠送优惠券
        $types = Mage::getSingleton('coupon/coupontype')->toOptionArray();
                 $couponTypes = array();
         foreach($types as $type){
              $typeid=$type['typeid'];
              $name = $type['name']; 
              $couponTypes[$typeid] = $name;
         }
        array_unshift($couponTypes, array('label'=> '', 'value'=> ''));
        $this->getMassactionBlock()->addItem('give_coupon', array(
             'label'        => '赠送优惠券',
             'url'          => $this->getUrl('coupon/adminhtml_coupon/giveCoupon'),
             'additional'   => array(
                'visibility'    => array(
                     'name'     => 'coupontypes',
                     'type'     => 'select',
                     'class'    => 'required-entry',
                     'label'    => '优惠券类型',
                     'values'   => $couponTypes
                 )
            )
        ));
        


        return $this;
    }

}