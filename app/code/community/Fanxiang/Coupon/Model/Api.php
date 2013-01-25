<?php


class Fanxiang_Coupon_Model_Api extends Mage_Api_Model_Resource_Abstract
{
      public function update($couponId,$status)
      {
          $coupon = Mage::getModel('coupon/coupon')->load($couponId);
          $coupon->setZhuangtai($status);
          try{ 
          $coupon->save();
          }catch (Mage_Core_Exception $e) {
            $this->_fault('data_invalid', $e->getMessage());
          }
          return true;
      }
      
      public function create($coupons)
      {
          $write = Mage::getSingleton('core/resource')->getConnection('core_write');
          try{
          foreach($coupons as $coupon)
          {
              $youhuiquanhao  =  $coupon['couponId'];
              $guizehao =  $coupon['guizehao'];
              $zhuangtai = $coupon['status'];
              $jine = $coupon['jine'];
              $leixing = $coupon['type'];
              $write->query("insert into youhuiquan (youhuiquanhao,guizeihao,zhuangtai,jine,leixing) values ('$youhuiquanhao','$guizehao',$zhuangtai,$jine,$leixing)");
          }
          }catch (Mage_Core_Exception $e) {
            $this->_fault('data_invalid', $e->getMessage());
        }
          return  true;
      }
}