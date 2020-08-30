<?php

declare(strict_types=1);

namespace app\middleware;

use app\model\Auth as AuthMOdel;

class Auth
{

    /**
     * 
     * @var string
     */

    private $toast = 'public/toast';


    /**
     * 处理请求
     *
     * @param \think\Request $request
     * @param \Closure       $next
     * @return Response
     */
    public function handle($request, \Closure $next)
    {
        //


        //得到管理员

        $auth = AuthModel::where('name', session('wowowo'))->find();
        // return json($auth->role);
        //权限 模块/方法 列表
        $roles = [];

        //遍历角色列表
        foreach ($auth->role as $key => $obj) {
            //拆分uri，装入$roles数组

            foreach (explode(',', $obj->uri) as $value) {
                $roles[] = $value;
            }
        }

        //得到当前访问的uri
        $uri = $request->controller() . '/' . $request->action();



        //超管判断
        if ($roles[0] != 'All') {
            //权限范围提示
            if (!in_array($uri, $roles)) {
                return view('./view/public/toast.html', [
                    'infos' => ['你没有操作权限'],
                    'url_text' => '返回首页',
                    'url_path' => url('/')
                ]);
            }
        }


        return $next($request);
    }
}
