<?php
namespace app\index\controller;

use think\Controller;
use app\index\model\User;

class Index extends Controller{
    public function index(){
        $userName = cookie('userName');
        $password = cookie('password');
        if($userName && $password) {

        } else {

        }
    }
}
