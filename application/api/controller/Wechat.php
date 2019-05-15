<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 2019/4/11
 * Time: 16:08
 */

namespace app\api\controller;

use app\common\controller\Api;
use app\common\controller\Backend;
use EasyWeChat\Factory;
use app\admin\model\User;
use think\Db;

/**
 * 微信接口
 * @package app\api\controller
 * @ApiInternal
 */
class Wechat extends Backend
{

    // 无需验证登录的方法
    protected $noNeedLogin = ['*'];
    // 无需要判断权限规则的方法
    protected $noNeedRight = ['*'];

    protected  $config;

    protected  $app;

    public function __construct( )
    {
       $this->config = [
           'app_id' => 'wx6de23865414dc10a',
           'secret' => 'e517ddb289ec59f19c4b4345347a287c',

           // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
           'response_type' => 'array',

           'oauth' => [
               'scopes'   => ['snsapi_userinfo'],
               'callback' => '/api/wechat/callback',
           ],
       ];
        $this->app = Factory::officialAccount($this->config);
    }


    /**
     * 微信授权
     *
     * @ApiTitle    (微信授权)
     * @ApiSummary  (微信调起授权)
    })
     */
    public function login()
    {
        // 未登录
        if (!session('wechat')) {
            $app = $this->app;
            $oauth = $app->oauth;
            $oauth->redirect()->send();
        }else{
            // 已经登录过
            $token = session('wechat');
            return redirect('https://wechat.thinkwindtech.com/vue/#/?token='.$token);

        }
    }


    /**
     * 微信授权回调
     */
    public function callback()
    {
        $oauth = $this->app->oauth;
       // 获取 OAuth 授权结果用户信息
        $user = $oauth->user()->toArray();
        $res = User::where('openid',$user['id'])->find();

        if($res){
            Db::name('user')->where('id',$res['id'])->update(['logintime'=>time()]);
            $userid = $res['id'];
            //return redirect('http://fly.dev.whbpkj.com/vue/#/?token='.$token);
        }else{
            $userid = User::insertGetId([
                'username'=>$user['name'],
                'nickname'=>$user['nickname'],
                'openid'=>$user['id'],
                'group_id' => 2,
                'avatar' => $user['avatar'],
                'gender' => $user['original']["sex"],
                'logintime' => time(),
                'jointime' => time(),
            ]);


        }
/*
        $this->auth->direct($userid);
        $token= $this->auth->getToken();
        session('wechat',$token);*/

        $token = lock_url($userid);

        session('wechat',$token);
        return redirect('https://wechat.thinkwindtech.com/vue/#/?token='.$token);
/*        if($re){

            session('wechat',$token);
            return redirect('http://fly.dev.whbpkj.com/vue/#/?token='.$token);
        }else{
            $url = 'http://fly.dev.whbpkj.com/api/wechat/login';
            header("Location:" . $url);
            die();

        }*/



    }

}