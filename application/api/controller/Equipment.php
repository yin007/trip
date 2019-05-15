<?php

namespace app\api\controller;

use app\admin\model\EquipmentCategory;
use app\common\controller\Api;
use app\common\model\Category;
use think\Db;

/**
 * 设备接口
 */
class Equipment extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];
    /**
     * 设备列表
     * @param integer $type 分类id,全部为空
     * @return \think\Response
     */
    public function index()
    {
        $this->auth->getUserinfo();
        $category_id = $this->request->param('type');
        if($category_id == ''){
            $re = Db::name('equipment')->where('status',1)->field("id,title,logoimage,price")->select();
            foreach ($re as $v){

                $v['logoimage'] = Env::get("app.host").$v['logoimage'];
            }

        }else{
            $re = Db::name('equipment')->where(['status'=>1,'category_id'=>$category_id])->field("id,title,logoimage,price")->select();
            foreach ($re as $v){
                $v['logoimage'] = Env::get("app.host").$v['logoimage'];
            }
        }
        if($re){

            $this->success('成功',$re);
        }else{
            $this->error('失败');
        }
    }

    /**
     * 设备分类
     *
     * @return \think\Response
     */
    public function category()
    {
        $re = Db::name('equipment_category')->field(['id','name'])->select();
        if($re){
            $this->success('成功',$re);
        }else{
            $this->error('失败');
        }
    }


}
