<?php

namespace app\api\controller;

use app\admin\model\Massage;
use app\admin\model\System;
use app\common\controller\Api;
use think\Db;
use think\Env;
/**
 * 其他接口
 */
class Other extends Api
{

    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];
    /**
     * 意见反馈
     * @param string $content 意见内容
     * @return \think\Response
     */
    public function content()
    {
        /*$user = unserialize($this->request->header('token'));*/
        $userid =  unlock_url($this->request->header("userid"));
        $content = $this->request->param('content');
        if ($content == ''&& !$userid)
        {
            $this->error('数据不能为空');
        }
        $re = Db::name('suggestion')->insert([
            'user_id'=>$userid,
            'content'=>$content,
            'createtime'=>time()
        ]);

        if($re){
            $this->success('成功');
        }else{

            $this->error('失败');
        }

    }

    /**
     * 常见问题
     *
     * @return \think\Response
     */
    public function wenti()
    {
        $re = Db::name('problem')->select();
        if($re){
            $this->success('成功',$re);
        }else{
            $this->error('失败');
        }
    }

    /**
     * 关于我们
     *
     */
    public function my()
    {
        $re = System::find();
        $re['logoimage'] = Env::get('app.host').$re['logoimage'];
        if($re){
            $this->success('成功',$re);
        }else{
            $this->error('失败');
        }
    }

    /**
     * 我的消息
     * @return \think\Response
     */
    public function message()
    {
        //$uid =$this->auth->id;
        $uid =  unlock_url($this->request->header("userid"));
        $re = Db::name('massage')->where('user_id',$uid)->select();
        $this->success('成功',$re);
    }

    /**
     * 消息详情页.
     *
     * @param  integer  $id
     * @return \think\Response
     */
    public function detail()
    {
        $id = $this->request->param('id');
        $re = Massage::where('id',$id)->find();
        if($re){
            Massage::where('id',$id)->update(['status'=>1]);
            $this->success('成功',$re);
        }else{
            $this->error('失败');
        }
    }

}
