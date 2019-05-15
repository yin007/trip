<?php

namespace app\admin\controller;

use app\common\controller\Backend;
use EasyWeChat\Factory;
use think\Db;

/**
 * 租赁订单管理
 *
 * @icon fa fa-circle-o
 */
class Order extends Backend
{
    
    /**
     * Order模型对象
     * @var \app\admin\model\Order
     */
    protected $model = null;
    protected $searchFields = ['order_sn'];

    public function _initialize()
    {
        parent::_initialize();
        $this->model = new \app\admin\model\Order;
        $this->view->assign("statusList", $this->model->getStatusList());
    }
    
    /**
     * 默认生成的控制器所继承的父类中有index/add/edit/del/multi五个基础方法、destroy/restore/recyclebin三个回收站方法
     * 因此在当前控制器中可不用编写增删改查的代码,除非需要自己控制这部分逻辑
     * 需要将application/admin/library/traits/Backend.php中对应的方法复制到当前控制器,然后进行修改
     */
    

    /**
     * 查看
     */
    public function index()
    {
        //当前是否为关联查询
        $this->relationSearch = true;
        //设置过滤方法
        $this->request->filter(['strip_tags']);
        if ($this->request->isAjax())
        {
            //如果发送的来源是Selectpage，则转发到Selectpage
            if ($this->request->request('keyField'))
            {
                return $this->selectpage();
            }
            list($where, $sort, $order, $offset, $limit) = $this->buildparams();
            $total = $this->model
                    ->with(['user','equipment','shop'])
                    ->where($where)
                    ->order($sort, $order)
                    ->group('order_sn')
                    ->count();

            $list = $this->model
                    ->with(['user','equipment','shop'])
                    ->where($where)
                    ->order($sort, $order)
                    ->limit($offset, $limit)
                    ->group('order_sn')
                    ->select();

            foreach ($list as $row) {
                $orders = $this->model->where(['order_sn'=>$row->order_sn])->select();
                $title = array();
                $price = 0;
                $depositprice = 0;
                $allprice = 0;
                foreach($orders as $v){
                    $title[] = $v->title;
                    $price += $v->price*$v->num;
                    $depositprice += $v->depositprice*$v->num;
                    $allprice += $v->allprice;
                }
                $row->title = implode(',',$title);
                $row->price = number_format($price,2,".","");
                $row->depositprice = number_format($depositprice,2,".","");
                $row->allprice = number_format($allprice,2,".","");
                $row->getRelation('user')->visible(['username','mobile']);
				$row->getRelation('shop')->visible(['name']);
            }
            $list = collection($list)->toArray();
            $result = array("total" => $total, "rows" => $list);

            return json($result);
        }
        return $this->view->fetch();
    }
    public function edit($ids = NULL)
    {
        $row = $this->model->get(['order_sn'=>$ids]);
        if (!$row)
            $this->error(__('No Results were found'));
        $adminIds = $this->getDataLimitAdminIds();
        if (is_array($adminIds)) {
            if (!in_array($row[$this->dataLimitField], $adminIds)) {
                $this->error(__('You have no permission'));
            }
        }
        if ($this->request->isPost()) {
            $params = $this->request->post("row/a");
            if ($params) {
                $params['starttime'] = strtotime($params['starttime']);
                $params['endtime'] = strtotime($params['endtime']);
                $result = Db::name('order')->where(['order_sn'=>$ids])->update($params);
                if ($result !== false) {
                    $this->success();
                } else {
                    $this->error($row->getError());
                }
            }
            $this->error(__('Parameter %s can not be empty', ''));
        }
        $goods = $this->model->all(['order_sn'=>$ids]);
        $price = 0;
        $depositprice = 0;
        $allprice = 0;
        foreach($goods as $v){
            $price += $v->price*$v->num;
            $depositprice += $v->depositprice*$v->num;
            $allprice += $v->allprice;
        }
        $this->view->assign("goods", $goods);
        $this->view->assign("row", $row);
        $this->view->assign("price", number_format($price,2,".",""));
        $this->view->assign("depositprice", number_format($depositprice,2,".",""));
        $this->view->assign("allprice", number_format($allprice,2,".",""));
        return $this->view->fetch();
    }
    /**
     * 退还押金
     */
    public function refund($ids){
        $row = Db::name('order1')->where('order_sn',$ids)->find();
        if ($this->request->isPost()){
            $params = $this->request->post("row/a");
            if ($params) {
                $order1 = Db::name('order1')->where('order_sn',$row['order_sn'])->find();
                if($order1['allprice'] < $params['refund']){
                    $this->error('退款金额不能大于支付金额');
                }
                if($params['refund'] <= 0){
                    $this->error('退款金额必须大于0');
                }
                $max_time = strtotime('+1 week',$row['paytime']);
                if(time()>$max_time){
                    return json(['state'=>'error','message'=>'已超过微信可退款时间，请选择其他方法退款']);
                }
//                $PayTools=new \PayTools();
//                $order_status=$PayTools->checkPayStatus($row['order_sn'],1,'wx',1)['pay_status'];
//                if ($order_status!=='SUCCESS') {
//                    return  json(['state'=>'error','message'=>'该订单不可退款']);
//                }
                $data['back_sn'] = build_order_no(1);
//                $total_fee= 0.01;
//                $data['pay_money'] = $data['back_money'] = $total_fee;
                $data['pay_money'] =$order1['allprice'];
                $data['back_money'] = $params['refund'];
                $data['user_id'] = $row['user_id'];
                $data['order_sn'] = $row['order_sn'];
                $config = [
                    // 必要配置
                    'app_id'             => 'wx6de23865414dc10a',
                    'mch_id'             => '1518511921',
                    'key'                => 'fdq532dfk09suit2hoidus78dhw9udhs',   // API 密钥

                    // 如需使用敏感接口（如退款、发送红包等）需要配置 API 证书路径(登录商户平台下载 API 证书)
                    'cert_path'          => ROOT_PATH.'cert/apiclient_cert.pem', // XXX: 绝对路径！！！！
                    'key_path'           => ROOT_PATH.'cert/apiclient_key.pem',      // XXX: 绝对路径！！！！
                  //  'notify_url'         => 'http://fly.dev.whbpkj.com/api/notify/refund_notify',     // 你也可以在下单时单独设置来想覆盖它
                ];
                $app = Factory::payment($config);
            // 参数分别为：商户订单号、商户退款单号、订单金额、退款金额、其他参数
            $res =   $app->refund->byOutTradeNumber($row['order_sn'], $data['back_sn'],  $data['pay_money']*100, $data['back_money']*100,['refund_desc' => '退押金','notify_url' =>'https://wechat.thinkwindtech.com/api/notify/refund_notify']);
            if($res['result_code'] == 'SUCCESS'){
                Db::name('order')->where('order_sn',$ids)->update(['back_sn'=>$data['back_sn'],'refund'=>$data['back_money']]);
                $this->success('申请退款成功');
            }else{
                $this->error($res['err_code_des']);
            }
        }
        }
        $this->assign('row',$row);
        return $this->view->fetch();
    }

}
