<?php
namespace app\index\model;

use think\Model;

/**
* @author myzly<nkzxwgr@163.com>
*/

class Check extends Model{
    protected $field = ['id', 'user_id', 'code', 'func', 'add_time'];

    protected $insert = ['add_time', 'code'];

    
}