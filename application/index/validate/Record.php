<?php
namespace app\index\validate;

use think\Validate;

/**
* @author myzly<nkzxwgr@163.com>
*/

class Record extends Validate{
    protected $rule = [
        'sub_domain' => 'alphaDash',
        'first_domain_id' => 'number',
    ];

    protected $message = [
        'sub_domain.alphaDash' => '该域名不合法',
        'first_domain_id.number' => '出现错误'
    ];
}