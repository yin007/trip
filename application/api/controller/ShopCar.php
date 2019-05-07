<?php

namespace app\api\controller;

use app\common\controller\Api;
use think\Db;
use think\Env;

/**
 * 购物车
 */
class ShopCar extends Api
{

    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];
    /**
     * 添加购物车
     * @param integer $shopid 门店id
     * @param integer $eid 设备id
     * @param integer $num 商品数量
     * @param string $start_city  出发地
     * @param string $destination_city  目的地
     * @param int $start_shop  出发门店
     * @param integer $destination_shop 目的地门店
     * @param string $hbnumber 航班号
     * @param string $hbtime  起飞时间
     * @return \think\Response
     */
    public function index()
    {
        $shopid = $this->request->param('shopid');
        $eid = $this->request->param('eid');
        $num = $this->request->param('num');
        $start_shop = $this->request->param('start_shop');
        $destination_shop = $this->request->param('destination_shop');
        $hbnumber = $this->request->param('hbnumber');
        $hbtime = $this->request->param('hbtime');
        $start_city = $this->request->param('start_city');
        $destination_city = $this->request->param('destination_city');
        $uid =  unlock_url($this->request->header("userid"));
        if((int)$start_shop < 1 || (int)$destination_shop <1 || !$hbnumber || !$hbtime || !$start_city || !$destination_city){
            $this->error('请到首页完善租赁信息',['code'=>202]);
        }
        $re = Db::name('shopcar')
            ->where([
                'equipment_id'=>$eid,
                'user_id'=>$uid,
                'start_city'=>$start_city,
                'destination_city'=>$destination_city,
                'start_shop'=>$start_shop,
                'destination_shop'=>$destination_shop,
            ])
            ->find();
        if($re){
            Db::name('shopcar')
                ->where(['id'=>$re['id']])
                ->update([
                    'num'=>$re['num']+$num,
                    'hbnumber'=>$hbnumber,
                    'hbtime'=>$hbtime,
                ]);
        }else{
            $re = Db::name('shopcar')->insert([
                'user_id'=>$uid,
                'shop_id'=>$shopid,
                'num'=>$num,
                'equipment_id'=>$eid,
                'start_city'=>$start_city,
                'destination_city'=>$destination_city,
                'start_shop'=>$start_shop,
                'destination_shop'=>$destination_shop,
                'hbnumber'=>$hbnumber,
                'hbtime'=>$hbtime,
                'createtime'=>time()
            ]);
        }
        Db::name('shopcar')
            ->where([
                'start_shop'=>$start_shop,
                'destination_shop'=>$destination_shop
            ])->update([
                'hbnumber'=>$hbnumber,
                'hbtime'=>$hbtime,
            ]);
        if($re){
            $this->success('成功');
        }else{
            $this->error('失败');
        }

    }

    /**
     * 购物车列表
     * @param integer $shopid 出发地门店id,0表示没有选择出发地
     * @return \think\Response
     */
    public function car()
    {
        $shopid = $this->request->param('shopid');
        $where = '';
        if($shopid){
            $where = 'a.shop_id = '.$shopid;
        }
        $uid =  unlock_url($this->request->header("userid"));
        $re = Db::name('shopcar')
            ->alias('a')
            ->where('a.user_id',$uid)
            ->where($where)
            ->join('shop b','a.shop_id = b.id')
            ->join('equipment c', 'a.equipment_id = c.id')
            ->field('a.id,a.createtime,a.num,b.name,c.title,c.logoimage,c.price,c.depositprice,c.price')
            ->select();
        foreach ($re as &$v){
            $v['logoimage'] = Env::get('app.host').$v['logoimage'];
            $v['total'] = $v['price']+$v['depositprice'];
        }

        $this->success('成功',$re);


    }

    /**
     * 购物车付款
     * @param string $cid 购物车id
     * @param string $num 商品数量
     * @return \think\Response
     */
    public function carpay()
    {
        $cid = $this->request->param('cid');
        $uid =  unlock_url($this->request->header("userid"));
        $user = Db::name('user')->where('id',$uid)->find();
        if(!$user['mobile']){
            // 跳转到绑定手机号
            $this->error('请绑定手机号',['code'=>201]);
        }
        $order_sn = build_order_no(1);
        if($cid){
            $cid = explode(',',$cid);
        }else{
            $this->error('购物车内没有商品');
        }
        $start_shop = Db::name('shopcar')->where('user_id',$uid)->where('id','in',$cid)->group('start_shop')->select();
        $destination_shop = Db::name('shopcar')->where('user_id',$uid)->where('id','in',$cid)->group('destination_shop')->select();
//        $hbnumber = Db::name('shopcar')->where('user_id',$uid)->where('id','in',$cid)->group('hbnumber')->select();
//        $hbtime = Db::name('shopcar')->where('user_id',$uid)->where('id','in',$cid)->group('hbtime')->select();
        if(count($start_shop)  !== 1 ){
            $this->error('当前存在多个出发地，请选择单个出发地',['code'=>203]);
        }
        if(count($destination_shop) !== 1){
            $this->error('当前存在多个目的地，请选择单个目的地',['code'=>203]);
        }
//        if(count($hbnumber) !== 1){
//            $this->error('当前存在多个航班，请选择单个航班',['code'=>203]);
//        }
//        if(count($hbtime) !== 1){
//            $this->error('当前存在多个航班起飞时间，请选择单个起飞时间',['code'=>203]);
//        }
        Db::startTrans();
        try{
            foreach ($cid as $k => $v) {
                //查购物车里的商
                $d = Db::name('shopcar')->where(['id' => $v, 'user_id' => $uid])->find();
                //查对应商品
                $e = Db::name('equipment')->where('id' , $d['equipment_id'])->find();
                if (!$e || $e['status'] == 0) {
                    $this->error('购物车有商品不存在或者已下架');
                }
                if($d['num'] > $e['stock']){
                    $this->error('购物车有商品库存不足',null);
                }
                if ($e['shop_id'] == $destination_shop) {
                    $this->error('产品门店和目的地门店不能为同一个门店');
                }
                //插入订单详情表
                $data[]=[
                    'order_sn'=>$order_sn,
                    'equipment_id'=>$e['id'],
                    'num'=>$d['num'],
                    'price'=>$e['price'],
                    'depositprice'=>$e['depositprice'],
                    'title'=>$e['title'],
                    'logoimage'=>$e['logoimage'],
                    'detailimages'=>$e['detailimages'],
                    'allprice'=>($e['depositprice'] + $e['price'])*$d['num'],
                    'createtime'=>time(),
                    'user_id'=>$uid,
                    'start_city'=>$d['start_city'],
                    'destination_city'=>$d['destination_city'],
                    'start_shop'=>$e['shop_id'],
                    'destination_shop'=>$d['destination_shop'],
                    'hbnumber'=>$d['hbnumber'],
                    'hbtime'=>$d['hbtime']
                ];
            }
            Db::name('order')->insertAll($data);
            //删除购物车的商品
                Db::name('shopcar')->where('id','in',$cid)->delete();
            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            $this->error('失败');
        }
        $this->success('订单生成成功',$order_sn);
    }
    /**
     * 修改数量
     * @param int $id 购物车id
     * @param int $num 对应的商品数量
     * @return \think\Response
     */
    public function carnum(){
        $id = $this->request->param('id');
        $num =$this->request->param('num');
        $uid =  unlock_url($this->request->header("userid"));
        $re = Db::name('shopcar')->where(['id'=>$id,'user_id'=>$uid])->update(['num'=>$num]);
        if($re){
            $this->success();
        }else{
            $this->error('失败');
        }
    }
    /**
     * 删除购物车产品
     *
     * @param  integer  $id
     * @return \think\Response
     */
    public function delete()
    {
        $id = $this->request->param('id');
        $uid =  unlock_url($this->request->header("userid"));
        $re = Db::name('shopcar')->where(['id'=>$id,'user_id'=>$uid])->delete();
        if($re){
            $this->success('商品删除成功');
        }else{
            $this->error('失败');
        }
    }
}
