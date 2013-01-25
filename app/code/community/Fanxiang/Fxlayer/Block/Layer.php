<?php





class Fanxiang_Fxlayer_Block_Layer extends Mage_Catalog_Block_Layer_View
{

      //获取后台给分类设置的属性项
      public function getLayerAttributes()
      {
      $atts = Mage::registry('current_category')->getData('layer_attribute_with_category');
      $attributes = array();
      if (empty($atts)) {
          $atts = array();
      }
      foreach($atts as $att){
          $label = Mage::getSingleton('eav/config')->getAttribute('catalog_product', $att)->getFrontendLabel();
          if (strpos($label, "-")!==false) {
              $labels = explode("-", $label);
              if (is_array($labels)) {
                  $label = end($labels);
              }
          }
          $attributes[$att] =  $label;
      }

       //   $attributes = array('tanziguige'=>'规格','huaxing'=>'花型');
          return $attributes;
      }

      public function getAttributeOptions($key)
      {
       $attribute = Mage::getSingleton('eav/config')->getAttribute('catalog_product', $key);
        if ($attribute->usesSource()) {
            $options = $attribute->getSource()->getAllOptions(false);

        }
        return    $options;

      }

      public function getLayerUrl($code,$value)
      {
         $url = $this->helper('core/url')->getCurrentUrl();
         $params = $this->getRequest()->getParams();
         if(count($params)>1){
            if(strstr($url,$code)){
                $param = $this->getRequest()->getParam($code);
                $url = str_replace($code.'='.$param,$code.'='.$value,$url);
            }else{
                $url.= '&'.$code.'='. $value;
            }
         }else{
            $url.= '?'.$code.'='. $value;
         }
         return $url;
      }

      public function isActive($code,$value='')
      {
        $param = $this->getRequest()->getParam($code);
        if($param == $value){
            return  true;
        }else{
            return  false;
        }

      }

      //不限或全部的url
      public function getAllUrl($code)
      {
          $url = $this->helper('core/url')->getCurrentUrl();
          $param = $this->getRequest()->getParam($code);
          if($param){
              $params = $this->getRequest()->getParams();
              if(count($params)==2){
                 $url = str_replace('?'.$code.'='.$param,'',$url);
              }else{
                 if(strstr($url,'&'.$code)){
                     $url = str_replace('&'.$code.'='.$param,'',$url);
                 }else{
                     $url = str_replace($code.'='.$param.'&','',$url);
                 }

              }
          }else{
             $url =  $this->helper('core/url')->getCurrentUrl();
          }

           return $url;
      }

}