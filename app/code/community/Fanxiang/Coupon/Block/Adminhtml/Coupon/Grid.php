<?php
class Fanxiang_Coupon_Block_Adminhtml_Coupon_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
         public function __construct()
        {   
            parent::__construct();
            $this->setId('couponGrid');
            $this->setDefaultSort('youhuiquanhao');
            $this->setDefaultDir('ASC');
            $this->setSaveParametersInSession(true);
        }
        
        protected function _prepareCollection()
        {
            $collection = Mage::getResourceModel('coupon/coupon_collection');
          //  $collection->join('customer/entity', 'main_table.yonghu = entity_id', 'email');
            $this->setCollection($collection);
    
            return parent::_prepareCollection();
        }
        
         protected function _prepareColumns()
         {
            $this->addColumn('youhuiquanhao', array(
            'header'    => '优惠券号',
            'width'     => '50px',
            'index'     => 'youhuiquanhao',
          
        )); 
        
$this->addColumn('guizeihao', array(
            'header'    => '规则号',
            'width'     => '50px',
            'index'     => 'guizeihao',
            'type'      =>  'options',
            'options'   =>  Mage::getSingleton('coupon/coupon')->getGuizehao(),
        )); 
        
         
         $this->addColumn('zhuangtai', array(
            'header'    => '状态',
            'width'     => '30px',
            'index'     => 'zhuangtai',
            'type'      =>  'options',
            'options'   =>  Mage::getSingleton('coupon/couponStatus')->toOptionArray(),
        ));
        
          $store = $this->_getStore();
         $this->addColumn('jine', array(
            'header'    => '金额',
            'width'     => '30px',
            'type'  => 'price',
            'currency_code' => $store->getBaseCurrency()->getCode(),
            'index'     => 'jine',
          
        ));
        
         $types =  Mage::getSingleton('coupon/coupontype')->getTypes();
         $options = array();
         foreach($types as $type){
              $typeid=$type['typeid'];
              $name = $type['name']; 
              $options[$typeid] = $name;
         }
         $this->addColumn('leixing', array(
            'header'    => '类型',
            'width'     => '50px',
            'index'     => 'leixing',
            'type'      =>  'options',
            'options'   =>  $options,
        ));
        
         $this->addColumn('dindanhao', array(
            'header'    => '订单号',
            'width'     => '50px',
            'index'     => 'dindanhao',
          
        ));
        
          $this->addColumn('yonghu', array(
            'header'    => '用户',
            'width'     => '50px',
            'index'     => 'yonghu',
            'type'      =>  'options',
            'options'   =>  Mage::getSingleton('coupon/coupon')->getCustomerEmail(),
          
        )); 
         
            $this->addColumn('huoqushijian', array(
            'header'    => '生成时间',
            'width'     => '50px',
            'type' => 'datetime',
            'index'     => 'huoqushijian',
          
        )); 
        
            $this->addColumn('shiyongshijian', array(
            'header'    => '使用时间',
            'width'     => '50px',
            'type' => 'datetime',
            'index'     => 'shiyongshijian',
          
        ));
         }
         
             protected function _prepareMassaction()
            {
                $this->setMassactionIdField('youhuiquanhao');
                $this->getMassactionBlock()->setFormFieldName('coupon');
        
        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => '删除',
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => '您确认吗？'
        ));
        $statuses = Mage::getSingleton('coupon/couponStatus')->toOptionArray();
        //array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> '修改状态',
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => '状态',
                         'values' => $statuses
                     )
             ),
             'confirm'  => '您确认吗？'
        ));
        return $this;
            }
         
         protected function _getStore()
          {
              $storeId = (int) $this->getRequest()->getParam('store', 0);
              return Mage::app()->getStore($storeId);
          }
         
         
}