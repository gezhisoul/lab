<?php
//优惠券状态
class Fanxiang_Coupon_Model_CouponStatus
{
      public function toOptionArray()
      {
        return array(
            0=> '作废',
            1=> '不可用',
            2=> '可使用',
            3=> '已使用',
        );
        

      }
}