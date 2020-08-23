<?php

namespace app\controller;
use think\facade\Validate;
use think\Request;

class Login
{
    private $toast='public/toast';
    public function index()
    {
        return view('index');
    }
    public function check(Request $request)
    {
        // dump($request->param());

        // $data=$_POST;
        // dump($data);

        $data=$request->param();

        //错误集合
        $errors=[];

        // //验证
        $validata=Validate::rule([
            'name'=>'unique:auth,name^password',
            
        ]);
        $result=$validata->check([
            'name'=>$data['name'],
            'password'=>$data['password']
        ]);

        //错误
        if($result){
            $errors[]='用户名或密码错误';
        }

        //验证码验证

        if(!captcha_check($data['code'])){
            $errors[]='验证码不正确';
        }
        
        //判断跳转

        if(!empty($errors)){
            // return view($this->toast,[
            //     'infos'=>$errors,
            //     'url_text'=>'返回登录',
            //     'url_path'=>url('/login')
            // ]);
            dd($errors);
        }else{
            session('wowowo',$data['name']);
            return redirect('/user');
        }
        
            





            
        // $validata=Validate::rule([
        //     'captcha'=>'require|captcha'
        // ]);
        // $result=$validata->check([
        //     'captcha'=>$data['code']
        // ]);
        // dump($result);
    }
}