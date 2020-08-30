<?php
declare (strict_types = 1);

namespace app\validate;

use think\Validate;

class User extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
        'username'=>'require|min:2|max:7|chsDash|unique:user',
        'password'=>'require|min:6',
        'passwordnot'=>'require|confirm:password',
        'email'=>'require|email|unique:user',
        'agree'=>'require|accepted',
        '__token__'=>'require|token',

        'newpasswordnot'=>'min:6|requireWith:newpassword|confirm:newpassword'

        
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [

        'agree.require'=>'必须同意此协议',
        'passwordnot.require'=>'密码确认不能为空',
        '__token__.require'=>'令牌不得为空',
        '__token__.token'=>'请刷新页面，重新提交',

        'newpasswordnot.min'=>'新密码不得小于六位',
        'newpasswordnot.requireWidth'=>'新密码不得为空',
        'newpasswordnot.confirm'=>'新密码必须一致'
    ];

    //场景验证
    protected $scene =[
        'insert'=>['username','email','password','passwordnot','agree','__token__'],
        'edit'=>['__token__','newpasswordnot']
    ];
}
