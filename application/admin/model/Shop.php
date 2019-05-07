<?php

namespace app\admin\model;

use think\Model;

class Shop extends Model
{
    // 表名
    protected $name = 'shop';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    
    // 追加属性
    protected $append = [

    ];
    

    







    public function shopjc()
    {
        return $this->belongsTo('Shopjc', 'jc_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }
}
