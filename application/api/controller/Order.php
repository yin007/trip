<?php

namespace app\api\controller;

use app\common\controller\Api;
use think\Db;
use think\Env;

/**
 * 订单中心
 */
class Order extends Api
{

    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];
    /**
     * 获取订单
     * @param integer $type 类型参数 0：获取所有订单 1：获取待支付订单 2：获取未领取订单 3：获取已领取订单 4：获取已完成订单
     * @return \think\Response
     */
    public function index()
    {
        $uid = unlock_url($this->request->header("userid"));

        if(!$uid){
            $this->error('缺少参数userid');
        }
        //类型参数 0：获取所有订单 1：获取待支付订单 2：获取未领取订单 3：获取已领取订单 4：获取已完成订单
        $type = $this->request->param('type',0);
        //获取全部订单
        if($type==0){
            $orders = Db::table('zd_order')
                ->join('zd_shop','zd_order.start_shop=zd_shop.id')
                ->where('zd_order.user_id','=',$uid)
                ->where('zd_order.is_delete','=',0)
                ->field('zd_order.id as order_id,zd_shop.name as shop_name,zd_order.order_sn,zd_order.title as good_name,zd_order.price,zd_order.depositprice,zd_order.status,zd_order.num,zd_order.logoimage,zd_order.status')
                ->order('zd_order.createtime desc')
                ->group('zd_order.order_sn')
                ->select();
//            foreach($orders as $k=>$v){
//                $result[$v['order_sn']][]    =   $v;
//            }
        }
        //待支付订单
        elseif ($type==1){
            $orders = Db::table('zd_order')
                ->join('zd_shop','zd_order.start_shop=zd_shop.id')
                ->where('zd_order.user_id','=',$uid)
                ->where('zd_order.status',1)
                ->where('zd_order.is_delete','=',0)
                ->field('zd_order.id as order_id,zd_shop.name as shop_name,zd_order.order_sn,zd_order.title as good_name,zd_order.price,zd_order.depositprice,zd_order.status,zd_order.num,zd_order.logoimage')
                ->order('zd_order.createtime desc')
                ->group('zd_order.order_sn')
                ->select();
        }
        //未领取订单
        elseif ($type==2){
            $orders = Db::table('zd_order')
                ->join('zd_shop','zd_order.start_shop=zd_shop.id')
                ->where('zd_order.user_id','=',$uid)
                ->where('zd_order.status',2)
                ->where('zd_order.is_delete','=',0)
                ->field('zd_order.id as order_id,zd_shop.name as shop_name,zd_order.order_sn,zd_order.title as good_name,zd_order.price,zd_order.depositprice,zd_order.status,zd_order.num,zd_order.logoimage')
                ->order('zd_order.createtime desc')
                ->group('zd_order.order_sn')
                ->select();
        }
        //已领取订单
        elseif ($type==3){
            $orders = Db::table('zd_order')
                ->join('zd_shop','zd_order.start_shop=zd_shop.id')
                ->where('zd_order.user_id','=',$uid)
                ->where('zd_order.status',3)
                ->where('zd_order.is_delete','=',0)
                ->field('zd_order.id as order_id,zd_shop.name as shop_name,zd_order.order_sn,zd_order.title as good_name,zd_order.price,zd_order.depositprice,zd_order.status,zd_order.num,zd_order.logoimage')
                ->order('zd_order.createtime desc')
                ->group('zd_order.order_sn')
                ->select();
        } //已完成订单
        elseif ($type==4) {
            $orders = Db::table('zd_order')
                ->join('zd_shop','zd_order.start_shop=zd_shop.id')
                ->where('zd_order.user_id','=',$uid)
                ->where('zd_order.status',4)
                ->where('zd_order.is_delete','=',0)
                ->field('zd_order.id as order_id,zd_shop.name as shop_name,zd_order.order_sn,zd_order.title as good_name,zd_order.price,zd_order.depositprice,zd_order.status,zd_order.num,zd_order.logoimage')
                ->order('zd_order.createtime desc')
                ->group('zd_order.order_sn')
                ->select();
        }
        //已完成订单
        elseif ($type==5) {
            $orders = Db::table('zd_order')
                ->join('zd_shop','zd_order.start_shop=zd_shop.id')
                ->where('zd_order.user_id','=',$uid)
                ->where('zd_order.status',5)
                ->where('zd_order.is_delete','=',0)
                ->field('zd_order.id as order_id,zd_shop.name as shop_name,zd_order.order_sn,zd_order.title as good_name,zd_order.price,zd_order.depositprice,zd_order.status,zd_order.num,zd_order.logoimage')
                ->order('zd_order.createtime desc')
                ->group('zd_order.order_sn')
                ->select();
        }
        //取消订单
        else{
            $orders = Db::table('zd_order')
                ->join('zd_shop','zd_order.start_shop=zd_shop.id')
                ->where('zd_order.user_id','=',$uid)
                ->where('zd_order.status',6)
                ->where('zd_order.is_delete','=',0)
                ->field('zd_order.id as order_id,zd_shop.name as shop_name,zd_order.order_sn,zd_order.title as good_name,zd_order.price,zd_order.depositprice,zd_order.status,zd_order.num,zd_order.logoimage')
                ->order('zd_order.createtime desc')
                ->group('zd_order.order_sn')
                ->select();
        }
        foreach ($orders as &$v){
            $order = Db::name('order')->where(['order_sn'=>$v['order_sn']])->field('title,price,depositprice,allprice,num,logoimage')->select();
            foreach($order as &$item){
                $item['logoimage'] = Env::get('app.host').$item['logoimage'];
                $item['total'] = number_format($item['allprice'],2,".","");
            }
            $v['goods'] = $order;
        }
        $this->success('获取订单成功',$orders);
    }

    /**
     *  确认下单页面
     * @param string $order_sn 订单编号
     */
    public function orderconfirm(){
        $ordersn = $this->request->param('order_sn');
        $re = Db::name('order')
            ->alias('a')
            ->where(['a.order_sn'=>$ordersn])
            ->join('shop b','a.start_shop = b.id')
            ->field('a.destination_shop,a.hbnumber,a.hbtime,b.name as start_shop_name,b.phone,b.address')
            ->find();
        $name = Db::name('shop')->where(['id'=>$re['destination_shop']])->find();
        $re['destination_shop_name']=$name['name'];
        $re['destination_shop_address']=$name['address'];
        $re['destination_shop_phone']=$name['phone'];
        $this->success('获取成功',$re);
    }

    /**
     * 订单详情
     * @param integer $order_sn 订单编号
     * @return \think\Response
     */
    public function orderdetail()
    {
        $order_sn = $this->request->param('order_sn');
        $re = Db::name('order')
            ->alias('a')
            ->where(['a.order_sn'=>$order_sn])
            ->join('shop b','a.start_shop = b.id')
            ->field('a.*,b.name as start_shop_name,b.phone,b.address')
            ->find();
        $order1 = Db::name('order1')->where('order_sn',$order_sn)->find();
        $coupon_money = 0;
        if($order1['coupon_record_id'] > 0){
            $coupon_record = Db::name('coupon_record')
                ->field('a.id,b.price')
                ->alias('a')
                ->join('coupon b','a.coupon_id = b.id')
                ->where(['a.id'=>$order1['coupon_record_id']])
                ->find();
            $coupon_money = $coupon_record['price'];
        }
        $orders = Db::name('order')->where(['order_sn'=>$order_sn])->field('title,price,depositprice,allprice,num,logoimage')->select();
        $depositprice = 0;
        $allprice = 0;
        foreach($orders as &$item){
            $item['logoimage'] = Env::get('app.host').$item['logoimage'];
            $depositprice += $item['depositprice']*$item['num'];
            $allprice += $item['allprice'];
          //  $item['total'] = number_format(($item['price'] + $item['depositprice'])*$item['num'],2,".",""); 
        }
        $re['depositprice'] = number_format($depositprice,2,".","");
        $re['allprice'] = number_format($allprice,2,".","");
        $re['coupon_money'] = $coupon_money;
        $re['goods'] = $orders;

        $this->success('订单详情获取成功',$re);

    }
    /**
     *  领取设备
     * @param integer $order_sn 订单编号
     * @return \think\Response
     */
    public function orderreceive(){
        $order_sn = $this->request->param('order_sn');
        $order = Db::name('order')->where(['order_sn'=>$order_sn,'status'=>2])->select();
        if($order){
            $re = Db::name('order')->where(['order_sn'=>$order_sn])->update(['status'=>3,'starttime'=>time()]);
            if($re){
                $this->success('领取成功',$re);
            }else{
                $this->error('领取失败');
            }
        }else{
            $this->error('没有该订单');
        }
    }
    /**
     *  取消订单
     * @param integer $order_sn 订单编号
     * @return \think\Response
     */
    public function ordercancel(){
        $order_sn = $this->request->param('order_sn');
        $order = Db::name('order')->where(['order_sn'=>$order_sn])->select();
        if($order){
            $re = Db::name('order')->where('order_sn',$order_sn)->update(['status'=>6]);
            if($re){
                $this->success('取消成功',$re);
            }else{
                $this->error('取消失败');
            }
        }else{
            $this->error('没有该订单');
        }
    }
    /**
     *  删除订单
     * @param integer $order_sn 订单编号
     * @return \think\Response
     */
    public function orderdel(){
        $order_sn = $this->request->param('order_sn');
        $order = Db::name('order')->where(['order_sn'=>$order_sn])->find();
        if($order){
            $re = Db::name('order')->where('order_sn',$order_sn)->update(['is_delete'=>1]);
            if($re){
                $this->success('删除成功',$re);
            }else{
                $this->error('删除失败');
            }
        }else{
            $this->error('没有该订单');
        }
    }
    /**
     *  归还设备
     * @param integer $order_sn 订单编号
     * @return \think\Response
     */
    public function orderend(){
        $order_sn = $this->request->param('order_sn');
        $orders = Db::name('order')->where(['order_sn'=>$order_sn,'status'=>3])->select();
        if($orders){
            foreach($orders as $order){
                $re = Db::name('order')->where('id',$order['id'])->update(['status'=>4,'endtime'=>time()]);
                $equipment= Db::name('equipment')->where('id',$order['equipment_id'])->find();
                $destination_shop_equipment = Db::name('equipment')->where(['shop_id'=>$order['destination_shop'],'sku'=>$equipment['sku']])->find();
                if($destination_shop_equipment){
                    Db::name('equipment')->where('id',$destination_shop_equipment['id'])->setInc('stock',$order['num']);
                }else{
                    Db::name('equipment')->insert([
                        'category_id'=>$equipment['category_id'],
                        'shop_id'=>$order['destination_shop'],
                        'title'=>$equipment['title'],
                        'logoimage'=>$equipment['logoimage'],
                        'detailimages'=>$equipment['detailimages'],
                        'price'=>$equipment['price'],
                        'depositprice'=>$equipment['depositprice'],
                        'status'=>$equipment['status'],
                        'content'=>$equipment['content'],
                        'stock'=>$order['num'],
                        'sku'=>$equipment['sku'],
                        'createtime'=>time(),
                    ]);
                }
            }
            if($re){
                $this->success('归还成功',$re);
            }else{
                $this->error('归还失败');
            }
        }else{
            $this->error('没有该订单');
        }
    }
}
