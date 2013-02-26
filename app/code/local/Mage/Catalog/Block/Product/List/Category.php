<?php


/**
 * product box show by category
 * @author wangxianbin@vanthink.net
 */
class Mage_Catalog_Block_Product_List_Category extends Mage_Catalog_Block_Product_List {
    const DATE_RANGE = 1;
    /* @var Mage_Catalog_Model_Category */
    private $_currentCategory = null;

    protected function _getProductCollection()
    {
        if (is_null($this->_productCollection)) {
            $layer = Mage::getModel('catalog/layer');
            // if this is a product view page
            if (Mage::registry('product')) {
                // get collection of categories this product is associated with
                $categories = Mage::registry('product')->getCategoryCollection()
                    ->setPage(1, 1)
                    ->load();
                // if the product is associated with any category
                if ($categories->count()) {
                    // show products from this category
                    $category = $categories->getLastItem();
                    /* @var Mage_Catalog_Model_Category */
                    $this->setCurrentCategory($category);
                    $layer->setCurrentCategory($category);
                }
            } else { // other pages

                if ($categoryId = $this->getCategoryId()) {
                    $category = Mage::getModel('catalog/category')->load($categoryId);
                    /* @var Mage_Catalog_Model_Category */
                    $this->setCurrentCategory($category);
                    $layer->setCurrentCategory($category);
                }
            }
            $collection = $layer->getProductCollection();
            $collection->setPageSize($this->getCount());
            $this->_productCollection = $collection->load();
        }
        return $this->_productCollection;
    }

    public function getCategoryId() {
        $categoryId = parent::getCategoryId();
        if (strpos($categoryId, "/")!==false) {
            $splitCategiryId = split("/", $categoryId);
            return end($splitCategiryId);
        }
        return $categoryId;
    }

    /**
     * set current category
     * @param Mage_Catalog_Model_Category $category
     */
    public function setCurrentCategory($category) {
        $this->_currentCategory = $category;
        return $this;
    }

    /**
     * get current category
     * @return Mage_Catalog_Model_Category
     */
    public function getCurrentCategory() {
        if ($this->_currentCategory===NULL) {
            if ($categoryId = $this->getCategoryId()) {
                $category = Mage::getModel('catalog/category')->load($categoryId);
                $this->setCurrentCategory($category);
            }
        }
        return $this->_currentCategory;
    }

    /**
     * get current category children categories
     * @return Mage_Catalog_Model_Resource_Eav_Mysql4_Category_Collection
     */
    public function getChildrenCategories() {
        if ($category = $this->getCurrentCategory()) {
            return $category->getChildrenCategories();
        }
        return NULL;
    }

    /**
     * determine whether has special tag
     * @param Mage_Catalog_Model_Product $product
     * @param String $tagName
     * @param Const $form DATA_RANGE|BOOLEAN
     * @return Boolean
     */
    public function hasSpecialTag($product, $tagName, $form=self::DATE_RANGE) {
        // TODO when form is boolean
        switch ($form) {
            case self::DATE_RANGE:
                $fromDate = $product->getData($tagName.'_from_date');
                $toDate = $product->getData($tagName.'_to_date');
                $now = time();

                $datetimeValidtion = '/\d{4}-\d{1,2}-\d{1,2} \d{2}:\d{2}:\d{2}/i';
                if (!empty($fromDate) && !empty($toDate)
                    && preg_match($datetimeValidtion, $fromDate)
                    && preg_match($datetimeValidtion, $toDate)) {
                    $fromDateTimestamp = strtotime($fromDate);
                    $toDateTimestamp = strtotime($toDate);
                    return ($fromDateTimestamp < $now && $toDateTimestamp > $now);
                }

                if (!empty($fromDate)
                    && preg_match($datetimeValidtion, $fromDate)) {
                    $fromDateTimestamp = strtotime($fromDate);
                    return $fromDateTimestamp < $now;
                }
                if (!empty($toDate)
                    && preg_match($datetimeValidtion, $toDate)) {
                    $toDateTimestamp = strtotime($toDate);
                    return $toDateTimestamp > $now;
                }
                break;
        }
        return false;
    }
}