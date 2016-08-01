<?php
namespace app\index\controller;

use think\Controller;
use app\index\model\User;

class Index extends Controller{
    public function index(){
        $user = User::find(1);
        dump($user);
    }
}
