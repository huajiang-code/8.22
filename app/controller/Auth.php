<?php
declare (strict_types = 1);

namespace app\controller;

use think\Request;


use app\model\Auth as AuthModel;
use think\exception\ValidateException;
use app\validate\User as UserValidate;
use think\facade\View;
use app\middleware\Auth as AuthMiddleware;

class Auth
{
    protected $middleware=[AuthMiddleware::class];
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
        $list=AuthModel::with(['role'])->withSearch(['name'],[
            'name'=>request()->param('name'),
        ])->paginate([
            'list_rows'=>3,
            'query'=>request()->param()
        ]);

        foreach ($list as $key=>$obj)
        {
            foreach($obj->role as $r)
            {
                $obj->roles.=$r->type.'|';
            }
            $obj->roles=substr(trim($obj->roles),0,-1);
        }   

        return view('index',[
            'list'=>$list
            
        ]);
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
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
        //
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
    }
}
