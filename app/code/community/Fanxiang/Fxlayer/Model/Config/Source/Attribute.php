<?php
/**
 */
class Fanxiang_Fxlayer_Model_Config_Source_Attribute
	extends Mage_Eav_Model_Entity_Attribute_Backend_Abstract
{
    public function toOptionArray()
    {
        $collections = Mage::getResourceModel('catalog/product_attribute_collection')
            ->addVisibleFilter()
            ->addIsFilterableFilter()
            ->setOrder('position', 'asc');
            
            $attributes =array();
              foreach($collections as $collection){
                $attribute = array();
                $attribute['value'] = $collection->getAttributeCode();
                $attribute['label'] = $collection->getFrontendLabel();
                $attributes[] = $attribute;
              }
        return $attributes;

    }
    
    public function getAllOptions()
    {
    	return $this->toOptionArray();
    }
}