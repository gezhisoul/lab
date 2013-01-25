<?php

/**
 * 
 * 
 * 
 * 
 * 
 */
class Fanxiang_Reviewyes_IndexController extends Mage_Core_Controller_Front_Action
{
    public function testAction()
    {
        $where = array(
            'customer_id'=>'1',
            'product_id'=>'14',
        );
        
        $test = $this->mysql('*',$where);
        print_r($test);
    }
    public function mysql($select,$where)
    {

        $where = $this->where($where);
        
        $read = Mage::getSingleton('core/resource')->getConnection('core_read');
        
        $table = Mage::getModel('reviewyes/resource_mysql4_sessionpost')->table();
        
        $sql = "select ".$select." from ".$table." where ".$where.""; //
        
        $res = $read->fetchAll($sql);
        
        return $res;
      /**  **/

     /**   **/
    }
    public function where($where)
    {
        if(is_array($where))
        {
            $w = '';
            foreach($where as $k => $v)
            {
                $w.= $k.' = '.$v.' and '; 
            }
            $w = substr($w,0,-5);
            
            return $w;
        }
    }


}