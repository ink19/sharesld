<?php
namespace app\index\controller;

use app\index\model\User;
use think\Log;


class Index{

    public function index(){
        Log::record('test');
        return json(User::all());
    }
}
