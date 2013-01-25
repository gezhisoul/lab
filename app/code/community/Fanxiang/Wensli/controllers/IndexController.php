/**
 * @author wangxianbin@vanthink.net
 * @date 2012-09-26 16:04
 */


/**
 * @module Fanxiang_Wensli
 * @category Controller
 * default controller
 */

class Fanxiang_Wensli_IndexController extends Mage_Core_Controller_Front_Action {

    public function indexAction() {
        print "Hello world";
    }

    public function testProductViewedAction() {
        $this->loadLayout();
        $this->renderLayout();
    }
}