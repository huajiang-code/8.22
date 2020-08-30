<?php
namespace app\controller;

use app\BaseController;
use app\model\Auth;

class Index extends BaseController
{
    public function index()
    {
        return  Auth::select();
    }

    
}
