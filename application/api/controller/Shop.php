<?php

namespace app\api\controller;
use app\common\controller\Api;
use think\Db;

/**
 * 门店接口
 */
class Shop extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];
    /**
     * 门店详情
     * @param integer $shop_id
     * @return \think\Response
     */
    public function index()
    {
        $shop_id = $this->request->param('shop_id');

        $re = Db::name('shop')
            ->alias('a')
            ->where('a.id',$shop_id)
            ->join('shopjc b','jc_id = b.id')
            ->field('a.*,b.name as shopname,b.city')
            ->find();
        if($re){

            $this->success('成功',$re);
        }else{
            $this->error('失败');
        }
    }


}
