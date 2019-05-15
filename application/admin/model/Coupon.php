<?php

namespace app\admin\model;

use think\Model;

class Coupon extends Model
{
    // 表名
    protected $name = 'coupon';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    
    // 追加属性
    protected $append = [
        'abletime_text'
    ];
    

    



    public function getAbletimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['abletime']) ? $data['abletime'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setAbletimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }


}
