<?php

namespace app\api\controller;

use app\common\controller\Api;
use app\common\library\Sms as Smslib;
use app\common\model\User;
use think\Db;

/**
 * 手机短信接口
 */
class Sms extends Api
{

    protected $noNeedLogin = '*';
    protected $noNeedRight = '*';

    public function _initialize()
    {
        parent::_initialize();
        //刪除今日凌晨之前的驗證碼
        $datatime = strtotime(date('Y-m-d'));
        DB::name('sms')->where('times','< time',$datatime)->delete();
    }


    /**
     * 发送验证码
     *
     * @param string $mobile 手机号
     * @param string $event 事件类型(1是注册,2是登陆,3是改密码,4修改手機號)
     */
    public function send()
    {
        $mobile = $this->request->request("mobile");
        $event = $this->request->request("event");

        if (!$mobile || !\think\Validate::regex($mobile, "^1\d{10}$")) {
            $this->error(__('手机号不正确'));
        }


/*        $sms = \app\common\model\Sms::
        where(['mobile' => $mobile, 'event' => $event])
            ->order('id', 'DESC')
            ->find();
        if ($sms && time() - $sms['createtime'] < 60) {
            $this->error(__('发送频繁'));
        }
        $ipSendTotal = \app\common\model\Sms::where(['ip' => $this->request->ip()])->whereTime('createtime', '-1 hours')->count();
        if ($ipSendTotal >= 5) {
            $this->error(__('发送频繁'));
        }*/


        if($event == 1){
            $str = '你的注册验证码是:';
        }elseif ($event == 2){
            $str = '你的登陆验证码是:';
        }elseif ($event == 3){
            $str = '你用于修改密码的验证码是:';
        }elseif ($event == 4){
            $str = '你用于修改手机号的验证码是:';
        }

        $smsd = new \addons\clsms\library\Clsms();
        $code = rand(1000,9999);
        $ret = $smsd->mobile($mobile)->msg($str.$code.',请勿泄露他人')->send();
        if ($ret) {
            Db::name('sms')->insert([
                'mobile'=>$mobile,
                'ip'=>$this->request->ip(),
                'code'=>$code,
                'event'=>$event,
                'times'=>time(),
                'createtime'=>time()
            ]);
            $this->success(__('发送成功'));
        } else {
            $this->error(__('发送失败'));
        }
    }

    /**
     * 检测验证码
     *
     * @param string $mobile 手机号
     * @param string $event 事件名称
     * @param string $captcha 验证码
     */
    public function check()
    {
        $mobile = $this->request->request("mobile");
        $event = $this->request->request("event");
        $captcha = $this->request->request("captcha");

        if (!$mobile || !\think\Validate::regex($mobile, "^1\d{10}$")) {
            $this->error(__('手机号不正确'));
        }
        $sms = \app\common\model\Sms::
        where(['mobile' => $mobile, 'event' => $event])
            ->order('id', 'DESC')
            ->find();
        if (!$sms) {
            $this->error('验证码错误');
        }
        if($captcha != $sms['code']){
            $this->error('验证码错误');
        }else{
            $this->success('验证码正确');
        }



    }

}
