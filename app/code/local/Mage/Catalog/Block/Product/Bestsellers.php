<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @copyright   Copyright (c) 2009 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Product list toolbar
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_Catalog_Block_Product_Bestsellers extends Mage_Core_Block_Template
{
     public function getBestsellers()
     {
        $totalPerPage = ($this->show_total) ? $this->show_total : 5;
        
        $visibility = array(
                              Mage_Catalog_Model_Product_Visibility::VISIBILITY_BOTH,
                              Mage_Catalog_Model_Product_Visibility::VISIBILITY_IN_CATALOG
                          );
        $storeId = Mage::app()->getStore()->getId();
        $_productCollection = Mage::getModel('catalog/product')->getCollection()
                                      ->addAttributeToSelect('*')
                                      ->addAttributeToFilter('visibility', $visibility)
                                      //->addAttributeToFilter('has_options', 1) 
                                      ->addUrlRewrite()     
                                      //->addCategoryFilter($_featcategory)   //全部产品的排行
                                      ->setOrder('sales', 'desc')
                                      
                                      ->setPageSize($totalPerPage)->setCurPage(1); 
        return  $_productCollection;
     }


}