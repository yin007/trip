<?php

namespace app\admin\model;

use think\Model;

class Shopcar extends Model
{
    // 表名
    protected $name = 'shopcar';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    
    // 追加属性
    protected $append = [

    ];
    

    







    public function user()
    {
        return $this->belongsTo('User', 'user_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }


    public function equipment()
    {
        return $this->belongsTo('Equipment', 'equipment_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }


    public function shop()
    {
        return $this->belongsTo('Shop', 'shop_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }
}
