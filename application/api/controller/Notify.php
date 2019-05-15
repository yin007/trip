<?php
namespace app\api\controller;
use EasyWeChat\Factory;
use think\Db;
use think\Controller;
use think\Log;

/**
 * 微信支付完成的回调
 *
 */
class Notify extends Controller
{

	/**
	 * 公众号支付
	 * @return [type] [description]
	 */
	public function wxpayjs()
	{
		$payinfo='';
	  //$content=json_encode($data);
		$content=file_get_contents('php://input');
		if (empty($content)) {
			return '非法请求';
		}
		$postObj = simplexml_load_string($content, 'SimpleXMLElement', LIBXML_NOCDATA);
		$state=$postObj->result_code;
		$out_trade_no=$postObj->out_trade_no;
		$orderinfo=Db::name('order')->where('order_sn',$out_trade_no)->find();
	  //支付失败
		if ($state!='SUCCESS') {
			return 'fail';
		}
	  $transaction_id=json_decode(json_encode($postObj->transaction_id),true)[0];//微信订单号
	  $openid=json_decode(json_encode($postObj->openid),true)[0];
	  $fee=$postObj->cash_fee;
	  // file_put_contents(ROOT_PATH.'public'.DS.'notify.txt', $content." ---- ".date('Y/m/d H:i:s',time())." \t\n",FILE_APPEND);//debug
	  //更新支付记录信息
	  //更新订单信息
	  $order1 = Db::name('order1')->where('order_sn',$out_trade_no)->find();
		if($order1['coupon_record_id']){
			Db::name('coupon_record')->where('id',$order1['coupon_record_id'])->update(['status'=>1,'updatetime'=>time()]);
		}
	  Db::name('order')->where('order_sn',$out_trade_no)->update(['status'=>2,'paytime'=>time()]);
	  $order = Db::name('order')->where('order_sn',$out_trade_no)->select();
	  foreach($order as $value){
		Db::name('equipment')->where('id',$value['equipment_id'])->setDec('stock',$value['num']);
	  }
	  Db::name('order1')->where('order_sn',$out_trade_no)->update(['status'=>1,'paytime'=>time(),'updatetime'=>time()]);
	  return 'success';
	}
	/**
	 * 退款回调
	 * @return [type] [description]
	 */
	public function refund_notify(){
		$config = [
			// 必要配置
				'app_id'             => 'wx6de23865414dc10a',
				'mch_id'             => '1518511921',
				'key'                => 'fdq532dfk09suit2hoidus78dhw9udhs',   // API 密钥

			// 如需使用敏感接口（如退款、发送红包等）需要配置 API 证书路径(登录商户平台下载 API 证书)
				'cert_path'          => ROOT_PATH.'cert/apiclient_cert.pem', // XXX: 绝对路径！！！！
				'key_path'           => ROOT_PATH.'cert/apiclient_key.pem',      // XXX: 绝对路径！！！！
			//  'notify_url'         => 'https://wechat.thinkwindtech.com/api/notify/refund_notify',     // 你也可以在下单时单独设置来想覆盖它
		];
		$app = Factory::payment($config);
		$response = $app->handleRefundedNotify(function ($message, $reqInfo, $fail) {
			// 其中 $message['req_info'] 获取到的是加密信息
			// $reqInfo 为 message['req_info'] 解密后的信息
			// 你的业务逻辑...
			Db::name('order')->where('back_sn',$reqInfo['out_refund_no'])->update(['status'=>5]);
			return true; // 返回 true 告诉微信“我已处理完成”
			// 或返回错误原因 $fail('参数格式校验错误');
		});

		$response->send();

	}
}