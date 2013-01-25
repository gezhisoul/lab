<?php
/**

 */
$this->startSetup();


$this->addAttribute('catalog_category', 'layer_attribute_with_category', array(
	'type'            => 'varchar',
	'label'           => 'Layer Attribute With Category',
	'input'           => 'multiselect',
	'source'          => 'fxlayer/config_source_attribute',
	'backend'         => 'fxlayer/category_attribute_backend_layerby',
	'global'          => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
	'required'        => 0,
	'default'         => '',
	'user_defined'    => 0,
	//'apply_to'        => 'simple',
	//'is_configurable' => true
));

$this->endSetup();


// EOF