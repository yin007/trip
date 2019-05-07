<?php

namespace app\api\controller;

use app\admin\model\Equipment;
use app\admin\model\System;
use app\common\controller\Api;
use EasyWeChat\Factory;
use think\Db;
use think\Env;

/**
 * 首页接口
 */
class Index extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];

    /**
     * 首页
     * @param string $city 地点名字
     * @param int $shopid 出发地门店id
     */
    public function index()
    {
        $data = [];

        //轮播图
        $banner = explode(',',System::value('bannerimages'));
        $arr = [];
        foreach ($banner as $v){
//            $v = Env::get('database.hostname').$v;
            $arr[] = Env::get("app.host").$v;

        }
        $data['banner'] = $arr;
        //首页推荐设备
        $city = $this->request->param('city');
        $shopid = $this->request->param('shopid');
        $eq_ids = array();
        if((int)$shopid > 0){
            $eq_ids[] = $shopid;
        }else if($city){
            $jc = Db::name('shopjc')->where('city','like','%'.$city.'%')->select();
            $ids = array();
            foreach ($jc as $v){
                $ids[] = $v['id'];
            }
            $arr = Db::name('shop')
                ->alias('a')
                ->where('a.jc_id','in',implode(',',$ids))
                ->join('shopjc b','a.jc_id = b.id')
                ->field('a.*,b.name as jichangname')
                ->select();
            foreach ($arr as $value){
                $eq_ids[] = $value['id'];
            }
        }
        $equipment = Equipment::where('status',1)->field("id,title,logoimage,price,stock")->where('shop_id','in',implode(',',$eq_ids))->limit('4')->select();
        foreach ($equipment as $v){
//            $v = Env::get('database.hostname').$v;
            $v['logoimage'] = Env::get("app.host").$v['logoimage'];
        }
        $data['equipment']= $equipment;

        //公告
        $announcement = Db::name('announcement')->select();
        $data['announcement'] = $announcement;
        $this->success('请求成功',$data);
    }

    /**
     * 设备详情
     * @param integer $eid 设备ID
     */
    public function equidetail()
    {
        $eid = $this->request->param('eid');


        //$equipment = Equipment::where('id',$eid)->join('equipment_category','ca')->find();
        $equipment = Db::name('equipment')
            ->alias('a')
            ->where('a.id',$eid)
            ->join('equipment_category b','a.category_id = b.id')
            ->join('shop c','a.shop_id = c.id')
            ->field('a.*,b.name,c.name as shopname')
            ->find();

       $equipment['logoimage'] = Env::get("app.host") . $equipment['logoimage'];

        $arr= [];
        foreach (explode(',', $equipment['detailimages']) as $v){
            $arr[] = Env::get("app.host") . $v;
        }
        $equipment['detailimages'] = $arr;
        $equipment['total'] = $equipment['price']+$equipment['depositprice'];
        $this->success('请求成功',$equipment);
    }

    /**
     * 下单地址
     * @param int $eid 设备id
     */
    public function equiaddress(){
        $eid = $this->request->param('eid');
        $equipment = Db::name('equipment')
            ->alias('a')
            ->where('a.id',$eid)
            ->join('shop c','a.shop_id = c.id')
            ->field('c.name,c.phone,c.address')
            ->find();
        $this->success('请求成功',$equipment);
    }
    /**
     * 门店列表
     * @param string $city 地点名字
     */
    public function address()
    {
        $city = $this->request->param('city');
        $jc = Db::name('shopjc')->where('city','like','%'.$city.'%')->select();
        if(!$jc){
            $this->error('此城市没有门店');
        }
        $ids = array();
        foreach ($jc as $v){
            $ids[] = $v['id'];
        }
        $arr = Db::name('shop')
            ->alias('a')
            ->where('a.jc_id','in',implode(',',$ids))
            ->join('shopjc b','a.jc_id = b.id')
            ->field('a.*,b.name as jichangname')
            ->select();
        $this->success('请求成功',$arr);
    }

    /**
     * 飞机航班列表
     * @param string $start_city 飞机起飞地
     * @param string $destination_city 飞机目的地
     */
    public function hb(){
        $start_city = $this->request->param('start_city');
        $destination_city = $this->request->param('destination_city');
        $hb = Db::name('hb')->where('start_city','like','%'.$start_city.'%')->where('destination_city','like','%'.$destination_city.'%')->select();
        $this->success('请求成功',$hb);
    }
    /**
     * 立即租赁
     * @param integer $shop_id  门店id
     * @param integer $type 分类id,如果是全部请传空
     */
    public function zu()
    {
        $shopid = $this->request->param('shop_id');
        $type = $this->request->param('type');

        if($type == ''){
            $arr = Db::name('equipment')
                ->alias('a')
                ->where('a.shop_id',$shopid)
                ->join('equipment_category b','a.category_id = b.id')
                ->field('a.id,a.title,a.logoimage,a.price,a.stock,b.name as categoryname')
                ->select();
            foreach ($arr as &$v){
                $v['logoimage'] = Env::get("app.host") . $v['logoimage'];

            }

            $this->success('请求成功',$arr);
        }else{
            $arr = Db::name('equipment')
                ->alias('a')
                ->where(['a.shop_id'=>$shopid,'a.status'=>1,'a.category_id'=>$type])
                ->join('equipment_category b','a.category_id = b.id')
                ->field('a.id,a.title,a.logoimage,a.price,b.name as categoryname')
                ->select();
            foreach ($arr as &$v){
                $v['logoimage'] = Env::get("app.host") . $v['logoimage'];

            }

            $this->success('请求成功',$arr);
        }

    }

    /**
     * 确认订单
     * @param integer $eid 设备ID
     * @param string $start_city 出发地城市
     * @param string $destination_city 目的地城市
     * @param integer $start_shop 出发地门店ID
     * @param integer $destination_shop 目的地门店ID
     * @param integer $num 商品数量
     * @param string $hbnumber 航班号
     * @param string $hbtime 航班时间
     * @param string $hbtime 航班时间
     */
    public function order()
    {
        $eid = $this->request->param('eid');
        $start_city = $this->request->param('start_city');
        $destination_city = $this->request->param('destination_city');
        $start_shop = $this->request->param('start_shop');
        $destination_shop = $this->request->param('destination_shop');
        $userid =  unlock_url($this->request->header("userid"));
        $user = Db::name('user')->where('id',$userid)->find();
        if(!$user['mobile']){
            // 跳转到绑定手机号
            $this->error('请绑定手机号',['code'=>201]);
        }
        $num = $this->request->param('num');
        $hbnumber = $this->request->param('hbnumber');
        $hbtime = $this->request->param('hbtime');
        $destination_shop = (int)$destination_shop;
        $start_shop = (int)$start_shop;
        if(empty($start_city) || empty($destination_city) || empty($start_shop) || empty($destination_shop)){
            //跳转到首页
            $this->error('出发门店或目的地门店不能为空',['code'=>202]);
        }

        if(!$hbnumber || !$hbtime){
            $this->error('航班号或航班时间不能为空',['code'=>202]);
        }
        if($start_city == $destination_city){
            $this->error('出发地和目的地不能为同一个地方',['code'=>204]);
        }
        $eq = Db::name('equipment')->where('id',$eid)->find();
        if($eq['status'] !== 1){
            $this->error('该商品已下架',null);
        }
        if($num > $eq['stock']){
            $this->error('该商品库存不足',null);
        }
        $order_sn = build_order_no(1);

        $allprice = ($eq['price'] + $eq['depositprice']) * $num;

        $re = Db::name('order')->insert([
            'order_sn'=>$order_sn,
            'equipment_id'=>$eid,
            'start_city'=>$start_city,
            'destination_city'=>$destination_city,
            'start_shop'=>$eq['shop_id'],
            'destination_shop'=>$destination_shop,
            'num'=>$num,
            'price'=>$eq['price'],
            'depositprice'=>$eq['depositprice'],
            'title'=>$eq['title'],
            'logoimage'=>$eq['logoimage'],
            'detailimages'=>$eq['detailimages'],
            'allprice'=>$allprice,
            'createtime'=>time(),
            'user_id'=>$userid,
            'hbnumber'=>$hbnumber,
            'hbtime'=>$hbtime
        ]);

        if($re){
            $this->success('下单成功',$order_sn);
        }else{
            $this->error('失败',null);
        }
    }

    /**
     * 分享链接地址
     */
        public function fen()
    {
//        $jsapiTicket = get_ticket();
//        //$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
//        $url = "$_SERVER[REQUEST_SCHEME]://$_SERVER[HTTP_HOST]".'/vue/#/';
//        $timestamp = time();
//        $nonceStr = createNonceStr();
//        $string = "jsapi_ticket={$jsapiTicket}&noncestr={$nonceStr}&timestamp={$timestamp}&url={$url}";
//        $signature = sha1($string);
//        $signPackage = array(
//            "appId" => 'wx6de23865414dc10a' ,
//            "nonceStr" => $nonceStr,
//            "url" => $url,
//            "timestamp" => $timestamp,
//            "signature" => $signature,
//            "rawString" => $string
//        );
        $config = [
            // 必要配置
            'app_id'             => 'wx6de23865414dc10a',
            'secret' => 'e517ddb289ec59f19c4b4345347a287c',

        ];
            $api_list = array('updateAppMessageShareData', 'updateTimelineShareData','onMenuShareTimeline','onMenuShareAppMessage','onMenuShareQQ','onMenuShareQZone');
            $app = Factory::officialAccount($config);
            $app->jssdk->setUrl('https://wechat.thinkwindtech.com/vue/');
            $re =  $app->jssdk->buildConfig($api_list,true,false,true);
        $this->success('请求成功',\GuzzleHttp\json_decode($re));
    }

}
