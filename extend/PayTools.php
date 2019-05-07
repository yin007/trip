<?php

/**
 * 支付辅助类
 * 集成微信、支付宝支付、订单查询、退款
 */
require_once(VENDOR_PATH.'WxpayAPI'.DS.'lib'.DS.'WxPay.Api.php');
require_once(VENDOR_PATH.'WxpayAPI'.DS.'example'.DS.'WxPay.NativePay.php');
require_once(VENDOR_PATH.'WxpayAPI'.DS.'example'.DS.'phpqrcode/phpqrcode.php');
//require_once(VENDOR_PATH."alipay_pc".DS."AopSdk.php");
require_once(VENDOR_PATH.'WxpayAPI'.DS.'example'.DS.'WxPay.JsApiPay.php');
//require_once(VENDOR_PATH.'alipay_direct'.DS.'alipay_submit.class.php');
use think\Db;
class PayTools 
{

    // public function __construct()
    // {
    //     $mchid=cache('sysconfig')['mchid'];
    //     if ($mchid) {
    //         define('MCH_ID', $mchid);
    //     }else{
    //         define('MCH_ID', '1491419362');
    //     }
        
    // }

    /**
     * 查询订单支付状态
     * @param  [type]  $order_sn    [内部订单流水号]
     * @param  integer $retype      [返回数据类型，默认为json 1：数组，0：json]
     * @param  integer $paytype     [支付类型]根据支付类型查询相应的平台订单状态 paytype=wx || paytype=ali
     * @param  integer $getstate    [是否获取第三方接口支付状态]
     * @return [array||json]        pay_status=> 默认[1：已支付，0：未支付] 当$getstate=1，获取第三方接口返回的支付状态
     */
    public function checkPayStatus($order_sn,$retype=0,$paytype=0,$getstate=0)
    {
        $result='';
        $order_status=Db::name('order1')->where('order_sn',$order_sn)->value('status');
        if ($order_status===1) {
            $pay_status=1;
        }
        else{
            $pay_status=0;
        }
        //微信支付
        if (strtolower($paytype)==='wx') {
            $pay_status=$this->wxquery($order_sn,$getstate);
        }
        //支付宝支付
        else if (strtolower($paytype)==='ali') {
            $pay_status=$this->aliquery($order_sn,$getstate);
        }
        $result=['pay_status'=>$pay_status];
        if ($retype) {
            return $result;
        }else{
            return json($result);
        }
    }
    /**
     * 微信支付订单查询
     * @param  integer $getstate [是否获取第三方接口支付状态]
     * @return [type]            [1：已支付，0：:未支付，-1：其他]
     */
    public function wxquery($order_sn,$getstate=0)
    {   
        $input=new \WxPayOrderQuery();
        $input->SetOut_trade_no($order_sn);
        $res=\WxPayApi::orderQuery($input);
        $trade_state=$res['trade_state'];
        // SUCCESS — 支付成功
        // REFUND — 转入退款
        // NOTPAY — 未支付
        // CLOSED — 已关闭
        // REVOKED — 已撤销 （刷卡支付）
        // USERPAYING -- 用户支付中
        // PAYERROR -- 支付失败
        if ($getstate) {
            return $trade_state;
        }
        if ($res['trade_state']=='SUCCESS') {
            return '1';
        }else if ($trade_state=='NOTPAY') {
            //未支付
            return '0';
        }else{
            return '-1';
        }
    }
        /**
     * 支付宝支付订单查询
     * @param  integer $getstate [是否获取第三方接口支付状态]
     * @return [type]            [1：已支付，0：:未支付，-1：其他]
     */
    public function aliquery($order_sn,$getstate=0)
    {  
        $aop = new \AopClient ();   
        $config=config('alipay');
        $aop->appId = $config['app_id'];  
        $aop->alipayrsaPublicKey =$config['alipayrsaPublicKey'];  
        $aop->rsaPrivateKey = $config['merchant_private_key'];
        $request = new \AlipayTradeQueryRequest ();
        $request->setBizContent("{" .
        "\"out_trade_no\":\"$order_sn\"," .
        "\"trade_no\":\"\"" .
        "}");
        $result = $aop->execute ( $request); 
        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
        $resultCode = $result->$responseNode->code;
        $trade_status=$result->$responseNode->trade_status;
        //交易状态：WAIT_BUYER_PAY（交易创建，等待买家付款）、TRADE_CLOSED（未付款交易超时关闭，或支付完成后全额退款）、TRADE_SUCCESS（交易支付成功）、TRADE_FINISHED（交易结束，不可退款）
        if(!empty($resultCode)&&$resultCode == 10000){
            if ($getstate) {
                return $trade_status;
            }
            if ($trade_status=='TRADE_SUCCESS') {
                //已支付
                return '1';
            }else {
                return '0';
            }
            
        } else {
            //查询失败
            return '-1';
        }
    }
    public function wx_refund($data)
    {
        $pay_money=bcmul($data['pay_money'],100);
        $back_money=bcmul($data['back_money'],100);
        $input = new \WxPayRefund();
        $input->SetOut_trade_no($data['order_sn']);
        $input->SetTotal_fee($pay_money);
        $input->SetRefund_fee($back_money);
        $input->SetOut_refund_no($data['back_sn']);
        $input->SetOp_user_id($data['user_id']);//操作用户id
        $res=\WxPayApi::refund($input);
        if ($res['result_code']=='SUCCESS') {
            //退款成功
            
            return  ['state'=>'success','message'=>'退款成功','third_back_sn'=>$res['transaction_id']];
        }
        else{
            //退款失败
            return ['state'=>'error','message'=>'退款失败,请检查退款信息是否填写准确'];
        }
    }
    public function ali_refund($data)
    {
        $operator_id=session('admin_id');//操作用户id
        $refund_reason=empty($data['reason'])?'正常退款':$data['reason'];//退款理由
        $aop = new \AopClient ();
        $config=config('alipay');
        $aop->appId = $config['app_id'];
        $aop->rsaPrivateKey =$config['merchant_private_key'];
        $aop->alipayrsaPublicKey=$config['alipayrsaPublicKey'];
        $request = new AlipayTradeRefundRequest ();
        $request->setBizContent("{" .
        "\"out_trade_no\":\"".$data['order_sn']."\"," .
        "\"trade_no\":\"\"," .
        "\"refund_amount\":".$data['back_total']."," .
        "\"refund_reason\":\"$refund_reason\"," .
        "\"out_request_no\":\"".$data['back_sn']."\"," .
        "\"operator_id\":\"$operator_id\"," .//操作用户id
        "\"goods_detail\":[{" .
        "       \"goods_id\":\"".$data['sku_id']."\"," .
        "       \"goods_name\":\"".$data['goods_name']."\"," .
        "       \"quantity\":1," .
        "       \"price\":".$data['back_total']."," .
        "       \"body\":\"".$data['goods_name']."\"" .
        "        }]" .
        "  }"); 
        $result = $aop->execute ( $request); 

        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
        $resultCode = $result->$responseNode->code;
        $is_refund=$result->$responseNode->fund_change;
        if(!empty($resultCode)&&$resultCode == 10000){
            if ($is_refund=='Y') {
                //退款成功
                
                return  ['state'=>'success','message'=>'退款成功','third_back_sn'=>$result->$responseNode->trade_no];
            }else{
                //退款失败
                return ['state'=>'error','message'=>'已退款'];
            }
            
        } else {
            //退款失败
            return ['state'=>'error','message'=>'退款失败,请检查退款信息是否填写准确'];
        }
    }
    public function wxqrpay($data)
    {
        $data['total_fee']=bcmul($data['pay_money'],100);
        $url = get_route();
        $wxpay=new \WxPayApi();
        $input = new \WxPayUnifiedOrder();
        $input->SetBody($data['goods_name']);//商品简述
        $input->SetAttach("备注:".$data['buyer_remark']);//附加信息
        $input->SetOut_trade_no($data['order_sn']);//订单流水号，32个字符内
        $input->SetProduct_id($data['id']);//商品id
        $input->SetTotal_fee($data['total_fee']);//最终金额
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 3000));//支付失效时间，30秒
        $input->SetNotify_url("$url/pc/notify/wxqrpay");//回调地址
        $input->SetTrade_type("NATIVE");
        $notify=new \NativePay();
        $res=$wxpay->unifiedOrder($input);
        return $res;
    }
    public function wxpayh5($data)
    {
        $url = get_route();
        $tools = new \JsApiPay();
        $total_fee=bcmul($data['pay_money'],100);
        $input = new \WxPayUnifiedOrder();
        $input->SetBody($data['goods_name']);//商品简述
        $input->SetAttach("备注:".$data['buyer_remark']);//附加信息
        $input->SetOut_trade_no($data['order_sn']);//订单流水号，32个字符内
        $input->SetProduct_id($data['id']);//商品id
        $input->SetTotal_fee($total_fee);//最终金额
        //$input->SetGoods_tag("test");//商品标签
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 3000));//支付失效时间，30秒
        $input->SetNotify_url("$url/pc/notify/wxpayh5");//回调地址
        $input->SetTrade_type("MWEB");
        $res=\WxPayApi::unifiedOrder($input);
        return $res;
    }
    public function wxpayjs($data)
    {
        $url = get_route();
        $tools = new \JsApiPay();
        $total_fee=bcmul($data['allprice'],100);
        $input = new \WxPayUnifiedOrder();
        $input->SetBody($data['title']);//商品简述
        $input->SetAttach("备注:");//附加信息
        $input->SetOut_trade_no($data['order_sn']);//订单流水号，32个字符内
        $input->SetProduct_id($data['id']);//商品id
        $input->SetTotal_fee($total_fee);//最终金额
//        $input->SetTotal_fee(1);//最终金额
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 3000));//支付失效时间，30秒
        $input->SetNotify_url("$url/api/notify/wxpayjs");//回调地址
        $input->SetTrade_type("JSAPI");
        $input->SetOpenid($data['openId']);
        $res=\WxPayApi::unifiedOrder($input);
        if ($res['return_code']=='FAIL'||$res['result_code']=='FAIL') {
            return ['state'=>'error','message'=>$res['err_code_des']];
        }
        $jsApiParameters = $tools->GetJsApiParameters($res);
        return $jsApiParameters;
    }
    public function aliqrpay($data)
    {
        $url = get_route();
        $aop = new \AopClient ();   
        $config=config('alipay');
        $aop->appId = $config['app_id'];  
        $aop->alipayPublicKey =$config['alipay_public_key'];  
        $aop->rsaPrivateKey = $config['merchant_private_key'];
        $request = new \AlipayTradePagePayRequest ();  
        $request->setReturnUrl("$url/pc/notify/aliqrpay");//支付成功跳转页面  
        $request->setNotifyUrl("$url/pc/notify/aliqrpay");  
        $request->setBizContent('{"product_code":"FAST_INSTANT_TRADE_PAY","out_trade_no":"'.$data['order_sn'].'","subject":"'.$data['goods_name'].'","total_amount":"'.$data['pay_money'].'","body":"'.$data['goods_name'].'"}');
        //请求  
        $result = $aop->pageExecute ($request);
        return $result;
    }
    public function Alipay($data)
    {
        $url = get_route();
        $aop = new AopClient ();
        $config=config('alipay');
        $aop->appId =$config['app_id'];
        $aop->rsaPrivateKey =$config['merchant_private_key'];
        $aop->alipayrsaPublicKey=$config['alipay_public_key'];
        $request = new \AlipayTradeWapPayRequest ();
        $request->setReturnUrl("$url/pc/notify/alipay");//支付成功跳转页面  
        $request->setNotifyUrl("$url/pc/notify/alipay"); 
        $request->setBizContent('{"product_code":"FAST_INSTANT_TRADE_PAY","out_trade_no":"'.$data['order_sn'].'","subject":"'.$data['goods_name'].'","total_amount":"'.$data['pay_money'].'","body":"'.$data['goods_name'].'"}');
        $result = $aop->pageExecute ( $request);
        return $result;
    }

    public function toAccount_ali($data)
    {
        $url = get_route();
        $aop = new AopClient ();
        $config=config('alipay');
        $aop->appId =$config['app_id'];
        $aop->rsaPrivateKey =$config['merchant_private_key'];
        $aop->alipayrsaPublicKey=$config['alipayrsaPublicKey'];
        $request = new AlipayFundTransToaccountTransferRequest ();
        $request->setReturnUrl("$url/pc/notify/toAccount_ali");//支付成功跳转页面  
        $request->setNotifyUrl("$url/pc/notify/toAccount_ali");
        $request->setBizContent("{" .
            "\"out_biz_no\":\"".$data['order_sn']."\"," .
            "\"payee_type\":\"ALIPAY_LOGONID\"," .
            "\"payee_account\":\"".$config['payee_account']."\"," .
            "\"amount\":\"".$data['pay_money']."\",
        }");
        $result = $aop->execute ( $request); 
        return $result;
    }


    public function alipay_direct($data)
    {
        $url = get_route();
        $config=config('alipay');
        $alipay_config=[
            'partner'=>$config['partner'],
            'seller_id'=>$config['partner'],
            'private_key'=>$config['merchant_private_key'],
            'alipay_public_key'=>$config['alipay_public_key'],
            'notify_url'=>"$url/pc/notify/alipay_direct",
            'return_url'=>"$url/pc/notify/alipay_direct",
            'sign_type'=>'RSA',
            'input_charset'=>'utf-8',
            'transport'=>'https',
            'payment_type'=>1,
            'service'=>"create_direct_pay_by_user",
            // 'anti_phishing_key'=>'',
            // 'exter_invoke_ip'=>'',
            'cacert'=>VENDOR_PATH.'alipay_direct'.DS.'cacert.pem',
        ];

        $parameter = array(
            "service"       => $alipay_config['service'],
            "partner"       => $alipay_config['partner'],
            "seller_id"  => $alipay_config['seller_id'],
            "payment_type"  => $alipay_config['payment_type'],
            "notify_url"    => $alipay_config['notify_url'],
            "return_url"    => $alipay_config['return_url'],

            "out_trade_no"  => $data['order_sn'],
            "subject"   => $data['goods_name'],
            "total_fee" => $data['pay_money'],
            //"body"  => '',
            "_input_charset"    => 'utf-8'
        );
        // dump($parameter);
        //dd($alipay_config);
        $alipaySubmit = new AlipaySubmit($alipay_config);
        $html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
        return $html_text;
    }

   
}