<?php

namespace app\admin\controller\coupon;

use app\common\controller\Backend;
use think\Db;

/**
 * 优惠券
 *
 * @icon fa fa-circle-o
 */
class Coupon extends Backend
{
    
    /**
     * Coupon模型对象
     * @var \app\admin\model\Coupon
     */
    protected $model = null;

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Coupon;

    }
    
    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */

    /**
     * 发放优惠券
     */
    public function coupon_record($ids){
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");
            if ($params) {
                $user_id = explode(',',$params['user_id']);
                foreach($user_id as $value){
                    $add['user_id']= $value;
                    $add['coupon_id']= $ids;
                    $add['status']= 0;
                    $add['createtime']= time();
                    $result = Db::name('coupon_record')->insert($add);
                }
                if ($result !== false) {
                    $this->success();
                } else {
                    $this->error($this->model->getError());
                }
            }
        }
        return $this->view->fetch();
    }

}
