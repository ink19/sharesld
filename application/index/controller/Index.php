<?php
namespace app\index\controller;

use think\Controller;
use app\index\model\User;

class Index extends Controller{
    public function index(){
        $username = rand();
        $password = rand();
        $email = rand();
        $User = new User;
        if($User->ProveLogin($username, $password)) {
            return <<< END
usename: {$id}<br/>
password: {$password}<br />
email: {$email}
END;
        } else {
            return "error";
        }
    }
}
