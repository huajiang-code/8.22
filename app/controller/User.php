<?php
declare (strict_types = 1);

namespace app\controller;

use think\Request;

use app\model\User as UserModel;
use think\exception\ValidateException;
use app\validate\User as UserValidate;
use think\facade\View;
use app\middleware\Auth as AuthMiddleware;

class User
{
    protected $middleware=[AuthMiddleware::class];
    /**
     * 
     * @var string
     */

     private $toast='public/toast';



    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    { 
        return view('index',[
            'list'=>UserModel::withSearch(['gender','username','email','create_time'],[
                'gender'=>request()->param('gender'),
                'username'=>request()->param('username'),
                'email'=>request()->param('email'),
                'create_time'=>request()->param('create_time'),
            ])->paginate([
                'list_rows'=>3,
                'query'=>request()->param()
            ]),
            'orderTime'=>request()->param('create_time')=="desc"?'asc':'desc',
        ]);
        //
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
        return view('create');
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        
        $shuju=$request->param();
        try{
            validate(UserValidate::class)->batch(true)->check($shuju);

        }catch(ValidateException $exception){
            $data=$exception->getError();
            // dd($data);

            //在input后面提示错误信息，提交一次，提示一次
            // return view('create',[
            //     'data'=>$data
            // ]);

            return view('./view/public/toast.html',[
                'infos'=>$data,
                'url_text'=>'重新提交',
                'url_path'=>url('/user/create')
            ]);
        }
        // dd($request->param());


        //写入数据库

        //密码加密
        $shuju['password']=sha1($shuju['password']);
        $id=UserModel::create($shuju)->getData('id');

        //关联保存
        UserModel::find($id)->hobby()->save([
            'content'=>$shuju['hobby'],
        ]);


        return $id?view($this->toast,[
            'infos'=>['恭喜，注册成功'],    //因为在html页面使用volist遍历的数组infos，所以这里要写中括号
            'url_text'=>'去使用',
            'url_path'=>url('/user')
        ]):'注册失败';



    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
        
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
       
        return view('edit',[
            'obj'=>UserModel::find($id)
        ]);
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //在这里为了避免验证其他字段，要做场景验证

        $shuju=$request->param();
        
        try{
            validate(UserValidate::class)
                    ->scene('edit')
                    ->batch(true)
                    ->check($shuju);

        }catch(ValidateException $exception){
            $data=$exception->getError();
            // dd($data);

            //在input后面提示错误信息，提交一次，提示一次
            // return view('create',[
            //     'data'=>$data
            // ]);

            return view('./view/public/toast.html',[
                'infos'=>$data,
                'url_text'=>'重新提交',
                'url_path'=>url('/user/'.$id.'/edit')
            ]);
        }


        //如果有密码则写入
        if(!empty($shuju['newpasswordnot']))
        {
            $shuju['password']=sha1($shuju['newpasswordnot']);
        }
        
        return UserModel::update($shuju)?view('./view/public/toast.html',[
            'infos'=>['恭喜，修改成功'],    //因为在html页面使用volist遍历的数组infos，所以这里要写中括号
            'url_text'=>'回主页',
            'url_path'=>url('/user')
        ]):'修改失败';
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
        return UserModel::destroy($id)?view('./view/public/toast.html',[
            'infos'=>['恭喜，删除成功'],    //因为在html页面使用volist遍历的数组infos，所以这里要写中括号
            'url_text'=>'去首页',
            'url_path'=>url('/user')
        ]):'删除失败';
    }
}
