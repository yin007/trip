<?php

namespace app\api\controller;

use app\common\controller\Api;
use think\Db;
/**
 * 优惠券接口
 */
class Coupon extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];

    /**
     * 优惠券列表
     * @param integer $type 状态值0未使用,1已使用,2已到期
     */
    public function index()
    {
        $userid =  unlock_url($this->request->header("userid"));
        $type = $this->request->param('type');
        $time = time();
        if($type == 2){
            $arr = Db::name('coupon_record')
                ->alias('a')
                ->where(['a.user_id'=>$userid])
                ->where('abletime','<',$time)
                ->join('coupon b','a.coupon_id = b.id')
                ->field('a.*,b.title,b.price,abletime')
                ->select();
        }else{
            $arr = Db::name('coupon_record')
                ->alias('a')
                ->where(['a.user_id'=>$userid,'status'=>$type])
                ->where('abletime','>',$time)
                ->join('coupon b','a.coupon_id = b.id')
                ->field('a.*,b.title,b.price,abletime')
                ->select();
        }
        $this->success('请求成功',$arr);
    }

//    /**
//     * 可使用优惠券列表
//     * @param string $order_sn
//     */
//    public function coupon()
//    {
//        $userid =  unlock_url($this->request->header("userid"));
//        $order_sn = $this->request->param('order_sn');
//        $price = Db::name('order')->where(['order_sn'=>$order_sn])->sum('price');
//        $time = time();
//        $arr = Db::name('coupon_record')
//            ->alias('a')
//            ->where(['a.user_id'=>$userid,'status'=>0])
//            ->where('abletime','>',$time)
//            ->where('price','<',$price)
//            ->join('coupon b','a.coupon_id = b.id')
//            ->field('a.*,b.title,b.price,abletime')
//            ->select();
//
//        $this->success('请求成功',$arr);
//    }
}
