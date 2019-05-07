<?php
namespace app\api\controller;

use app\common\controller\Api;
use think\Controller;
use think\Db;
use think\Exception;
require_once(VENDOR_PATH.'WxpayAPI'.DS.'lib'.DS.'WxPay.Api.php');
require_once(VENDOR_PATH.'WxpayAPI'.DS.'example'.DS.'WxPay.JsApiPay.php');
require_once(VENDOR_PATH.'WxpayAPI'.DS.'example'.DS.'phpqrcode/phpqrcode.php');
/**
 * 微信支付
 */
class WechatPay extends Api
{

	protected $noNeedLogin = ['*'];
	protected $noNeedRight = ['*'];

	/**
	 * 立即支付
	 * @param string $order_sn 订单编号
	 * @param string $coupon_record_id 优惠券ID
	 */
	public function wxpayjs()
	{
		$order_sn = $this->request->param('order_sn');
		$coupon_record_id = $this->request->param('coupon_record_id');
		$orders=Db::name('order')->where('order_sn',$order_sn)->select();
		$total_fee = 0;
		foreach($orders as $v){
			$total_fee+=$v['allprice'];
			$user_id = $v['user_id'];
			$title[]=$v['title'];
			$id[]=$v['equipment_id'];
		}
		$order1 = Db::name('order1')->where('order_sn',$order_sn)->find();
		$coupon_money = 0;
		if(!empty($coupon_record_id)){
			$coupon_record = Db::name('coupon_record')
						->field('a.id,b.price')
						->alias('a')
						->join('coupon b','a.coupon_id = b.id')
						->where(['a.id'=>$coupon_record_id,'a.status'=>0])
						->where('b.abletime > '.time())
						->find();
			$coupon_money = $coupon_record['price'];
		}
		if(!$order1){
			$price = $total_fee-$coupon_money;
			if($price <= 0){
				$price = 0.01;
			}
			$order1 = Db::name('order1')->insert([
					'order_sn'=>$order_sn,
					'user_id'=>$user_id,
					'allprice'=>$price,
					'status'=>0,
					'createtime'=>time(),
					'coupon_record_id'=>$coupon_record_id
			]);
		}else{
			$coupon_record = Db::name('coupon_record')
					->field('a.id,b.price')
					->alias('a')
					->join('coupon b','a.coupon_id = b.id')
					->where(['a.id'=>$order1['coupon_record_id'],'a.status'=>0])
					->where('b.abletime > '.time())
					->find();
			if(empty($coupon_record) && $order1['coupon_record_id'] >0){
				$this->error('该订单中优惠券已被使用，请重新下单！');
			}
			$price = $order1['allprice'];
		}
		$PayTools=new \PayTools();
		$res=$PayTools->checkPayStatus($order_sn,1);
		if ($res['pay_status']==1) {
			 $this->error('该订单已支付');
		}
		$openId = Db::name('user')->where(['id'=>$user_id])->value('openid');
		$data = [
			'title'=>implode(',',$title),
			'order_sn'=>$order_sn,
			'id'=>implode(',',$id),
			'allprice'=>$price,
			'openId'=>$openId,
		];
		// $url = get_route();
		// $openId=cur_openid();
		// $tools = new \JsApiPay();
		// $total_fee=bcmul($data['pay_money'],100);
		// $input = new \WxPayUnifiedOrder();
		// $input->SetBody($data['goods_name']);//商品简述
		// $input->SetAttach("备注:".$data['buyer_remark']);//附加信息
		// $input->SetOut_trade_no($order_sn);//订单流水号，32个字符内
		// $input->SetProduct_id($data['id']);//商品id
		// $input->SetTotal_fee($total_fee);//最终金额
		// $input->SetTime_start(date("YmdHis"));
		// $input->SetTime_expire(date("YmdHis", time() + 3000));//支付失效时间，30秒
		// $input->SetNotify_url("$url/pc/notify/wxpayjs");//回调地址
		// $input->SetTrade_type("JSAPI");
		// $input->SetOpenid($openId);
		// $res=\WxPayApi::unifiedOrder($input);
		// if ($res['return_code']=='FAIL'||$res['result_code']=='FAIL') {
		//     return $this->error($res['err_code_des']);
		// }
		// $jsApiParameters = $tools->GetJsApiParameters($res);
		$jsApiParameters = $PayTools->wxpayjs($data);
		$this->success('支付中',\GuzzleHttp\json_decode($jsApiParameters));
	}

}