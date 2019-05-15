<?php

namespace app\api\controller;

use app\common\controller\Api;

use app\common\library\Sms;
use fast\Random;
use think\Db;
use think\Validate;
use app\admin\model\User as Member;

/**
 * 会员接口
 */
class User extends Api
{

    protected $noNeedLogin = ['login', 'mobilelogin', 'register', 'resetpwd', 'changeemail', 'changemobile', 'third','user','bindcard','card'];
    protected $noNeedRight = '*';

    public function _initialize()
    {
        parent::_initialize();
    }

    /**
     * 会员中心
     */
    public function index()
    {
        $this->success('', ['welcome' => $this->auth->nickname]);
    }

    /**
     * 会员登录
     * 
     * @param string $mobile 账号
     * @param string $password 密码
     */
    public function login()
    {
        $mobile = $this->request->request('mobile');
        $password = $this->request->request('password');
        if (!$mobile || !$password)
        {
            $this->error('数据不能为空');
        }

        if ($mobile && !Validate::regex($mobile, "^1\d{10}$"))
        {
            $this->error('手机号格式不正确!');
        }

        $user = Db::name('user')->where('mobile',$mobile)->field("id,username,username,mobile,openid,avatar,salt,password")->find();
        if(!$user){
            $this->error('该用户不存在!');
        }
        $npassword = md5($password .$user['salt']);
        if($npassword != $user['password']){
            $this->error('密码错误!');
        }

        $this->success('登陆成功',$user);

    }

    /**
     * 手机验证码登录
     * 
     * @param string $mobile 手机号
     * @param string $captcha 验证码
     */
    public function mobilelogin()
    {
        $mobile = $this->request->request('mobile');
        $captcha = $this->request->request('captcha');
        if (!$mobile || !$captcha)
        {
            $this->error(__('Invalid parameters'));
        }
        if (!Validate::regex($mobile, "^1\d{10}$"))
        {
            $this->error(__('Mobile is incorrect'));
        }
        if (!Sms::check($mobile, $captcha, 'mobilelogin'))
        {
            $this->error(__('Captcha is incorrect'));
        }
        $user = User::getByMobile($mobile);

        if ($user)
        {
            //如果已经有账号则直接登录
            $ret = $this->auth->direct($user->id);
        }
        else
        {
            $ret = $this->auth->register($mobile, Random::alnum(), '', $mobile, []);
        }
        if ($ret)
        {
            Sms::flush($mobile, 'mobilelogin');
            $data = ['userinfo' => $this->auth->getUserinfo()];
            $this->success(__('Logged in successful'), $data);
        }
        else
        {
            $this->error($this->auth->getError());
        }
    }

    /**
     * 注册会员
     * 
     * @param string $tuiphone 推荐人号码
     * @param string $password 密码
     * @param string $mobile 手机号
     */
    public function register()
    {
        $userid = unlock_url($this->request->header("userid"));
        $tuiphone = $this->request->request('tuiphone');
        $password = $this->request->request('password');
        $mobile = $this->request->request('mobile');
        $salt = rand(1000,9999);
        if (!$mobile || !$password)
        {
            $this->error('数据不能为空');
        }
        if ($mobile && !Validate::regex($mobile, "^1\d{10}$"))
        {
            $this->error('手机号格式不正确!');
        }
        //$ret = $this->auth->register($username, $password, $mobile, []);
        $password = md5($password . $salt);
        $ret = Member::where('id',$userid)->update([
            'salt'=>$salt,
            'password'=>$password,
            'tuiphone'=>$tuiphone,
            'mobile'=>$mobile
        ]);
        if ($ret)
        {
            $data = Member::where('id',$userid)->find();

            $this->success('注册成功!', $data);
        }
        else
        {
            $this->error('注册失败!');
        }
    }

    /**
     * 注销登录
     */
    public function logout()
    {
        $this->auth->logout();
        $this->success(__('Logout successful'));
    }

    /**
     * 修改会员个人信息
     * 
     * @param string $avatar 头像地址
     * @param string $username 用户名
     * @param string $nickname 昵称
     * @param string $bio 个人简介
     */
    public function profile()
    {
        $user = $this->auth->getUser();
        $username = $this->request->request('username');
        $nickname = $this->request->request('nickname');
        $bio = $this->request->request('bio');
        $avatar = $this->request->request('avatar');
        $exists = \app\common\model\User::where('username', $username)->where('id', '<>', $this->auth->id)->find();
        if ($exists)
        {
            $this->error(__('Username already exists'));
        }
        $user->username = $username;
        $user->nickname = $nickname;
        $user->bio = $bio;
        $user->avatar = $avatar;
        $user->save();
        $this->success();
    }


    /**
     * 修改手机号
     * 
     * @param string $oldphone 旧手机号
     * @param string $newphone 新手机号
     */
    public function changemobile()
    {
        $userid = unlock_url($this->request->header("userid"));
        $newphone = $this->request->request('newphone');
        $user = Db::name('user')->where('id',$userid)->find();
        if (!$newphone)
        {
            $this->error(__('Invalid parameters'));
        }
        if($user['mobile'] == $newphone){
            $this->error('新手机号与原手机号一样');
        }
        if (!Validate::regex($newphone, "^1\d{10}$"))
        {
            $this->error(__('Mobile is incorrect'));
        }
        if (Db::name('user')->where('mobile', $newphone)->where('id', '<>', $userid)->find())
        {
            $this->error(__('Mobile already exist'));
        }
        $re = Db::name('user')->where('id',$userid)->update(['mobile'=>$newphone]);
        if($re){
            $this->success('修改成功');
        }else{
            $this->success('修改失败');
        }


    }

    /**
     * 第三方登录
     * 
     * @param string $platform 平台名称
     * @param string $code Code码
     */
    public function third()
    {
        $url = url('user/index');
        $platform = $this->request->request("platform");
        $code = $this->request->request("code");
        $config = get_addon_config('third');
        if (!$config || !isset($config[$platform]))
        {
            $this->error(__('Invalid parameters'));
        }
        $app = new \addons\third\library\Application($config);
        //通过code换access_token和绑定会员
        $result = $app->{$platform}->getUserInfo(['code' => $code]);
        if ($result)
        {
            $loginret = \addons\third\library\Service::connect($platform, $result);
            if ($loginret)
            {
                $data = [
                    'userinfo'  => $this->auth->getUserinfo(),
                    'thirdinfo' => $result
                ];
                $this->success(__('Logged in successful'), $data);
            }
        }
        $this->error(__('Operation failed'), $url);
    }

    /**
     * 更改密码
     * @param string $oldpassword 原密码
     * @param string $newpassword 新密码
     */
    public function resetpwd()
    {
        $userid =  unlock_url($this->request->header("userid"));
        $newpassword = $this->request->request("newpassword");
        $oldpassword = $this->request->request("oldpassword");

        if (!$newpassword && !$oldpassword)
        {
            $this->error(__('Invalid parameters'));
        }

        if($newpassword == $oldpassword){
            $this->error('新密码不能和原密码相同');
        }
        $salt = Db::name('user')->where('id',$userid)->value('salt');
        if(Db::name('user')->where(['id'=>$userid,'password'=>md5($oldpassword.$salt)])){
            $this->error('原密码不正确');
        }
        $re = Db::name('user')->where('id',$userid)->update(['password'=>md5($newpassword.$salt)]);
        if ($re) {
            $this->success(__('Reset password successful'));
        } else {
            $this->error('修改失败');
        }
    }

    /**
     * 用户资料
     */
    public function user()
    {
        $userid = unlock_url($this->request->header("userid"));

        $re = Db::name('user')->where('id',$userid)->find();
        if ($re) {
            $this->success('成功',$re);
        } else {
            $this->error('失败');
        }
    }

    /**
     *  获取身份信息
     * @ApiReturn   ({
    'code':'200',
    'mesg':'返回成功'
    code 200  已绑定身份  code 203 未绑定身份 })
     */
    public function card(){
        $userid = unlock_url($this->request->header("userid"));
        $re = Db::name('user')->where('id',$userid)->field('rel_name,id_card')->find();
        if($re['rel_name'] && $re['id_card']){
            $re['id_card'] = substr($re['id_card'], 0, 4).'****'.substr($re['id_card'],-4);
            $re['code'] = 200;
            $this->success('成功',$re);
        }else{
            $re['code'] = 203;
            $this->success('成功',$re);
        }
    }

    /**
     * 绑定身份
     * @param string $rel_name 姓名
     * @param string $id_card 身份证号码
     * @throws \think\Exception
     */
    public function bindcard(){
        $userid = unlock_url($this->request->header("userid"));
        $rel_name = $this->request->request('rel_name');
        $id_card = $this->request->request('id_card');
        $re = Db::name('user')->where('id',$userid)->update(['rel_name'=>$rel_name,'id_card'=>$id_card]);
        if($re){
            $this->success('修改成功');
        }else{
            $this->success('修改失败');
        }
    }

}
