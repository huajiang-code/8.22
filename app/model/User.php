<?php

namespace app\model;

use think\Model;

class User extends Model
{
    //一对一Hobby
    public function hobby()
    {
        return $this->hasOne(Hobby::class,'user_id','id');
    }

    //搜索器
    public function searchGenderAttr($query,$value)   //返回的是查询条件
    {
        return $value?$query->where('gender',$value):'';
    }
    //username搜索器
    public function searchUsernameAttr($query,$value)
    {
        return $value?$query->where('username','like','%'.$value.'%'):'';
    }
    //email搜索器
    public function searchEmailAttr($query,$value)
    {
        return $value?$query->where('email','like','%'.$value.'%'):'';
    }
    //create_time搜索器
    public function searchCreateTimeAttr($query,$value)
    {
        return $value?$query->order('create_time',$value):'';
    }


    // status获取器
    public function getStatusAttr($value)
    {
        $status=[0=>'待审核',1=>"通过"];
        return $status[$value];
    }
    
    //badage获取器 （虚拟字段）
    public function getBadgeAttr($value,$data)
    {
       return  $data['status']?'success':'warning';
    }
}