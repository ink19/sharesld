<?php
namespace app\index\validate;

use think\Validate;

/**
* @author myzly<nkzxwgr@163.com>
*/

class User extends Validate{
    protected $rule = [
        'username' => 'alphaDash|length:3,16',
        'password' => 'min:3',
        'email' => 'email'
    ];

    protected $message = [
        'username.alphaDash' => '用户名只允许字母,数字,下划线或破折号',
        'username.length' => '用户名长度为3-16',
        'password.min' => '密码长度必须大于3',
        'email' => '邮箱格式错误'
    ];

    protected $scene = [
        'add' => ['username', 'password', 'email'],
        'edit' => ['password', 'email']
    ];
}