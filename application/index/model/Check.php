<?php
namespace app\index\model;

use think\Model;

/**
* @author myzly<nkzxwgr@163.com>
*/

class Check extends Model{
    protected $field = ['id', 'user_id', 'code', 'func', 'add_time'];

    protected $insert = ['add_time', 'code'];

    protected $pk = 'id';

    protected $type = [
        'id' => 'integer',              //标记ID
        'user_id' => 'integer',         //相关用户ID
        'code' => 'text',               //验证码
        'func' => 'text',               //功能
        'add_time' => 'integer'         //添加的时间
    ];

    protected $lastResult = null;

    public function GetResult(){
        return $this->lastResult;
    }

    /**
    * 添加验证码
    * 
    * @param    int $userId 
    * @param    string $func     
    * @return   boolean
    */
    public function AddCheck($userId, $func){
        $this->lastResult = null;

        $data = [
            'user_id' => $userId,
            'func'  => $func
        ];

        if($result = self::create($data)) {
            $this->lastResult = $result->toArray();
            return true;
        } else {
            $this->lastResult = "数据库错误";
            return false;
        }
    }

    /**
    * 验证code是否正确
    * 
    * @param    int $userId
    * @param    string $code
    * @param    string $func
    * @return   boolean
    */
    public function VerifyCheck($userId, $code, $func){
        $this->lastResult = null;

        $map = [
            'user_id' => $userId,
            'code' => $code,
            'func' => $func
        ];

        if($result = self::get($map)) {
            $this->lastResult = $result->toArray();
            return true;
        } else {
            $this->lastResult = "未找到";
            return false;
        }
    }

    /**
    * 删除该code
    * 
    * @param    int $id 
    * @return   boolean
    */
    public function DeleteCheck($id){
        $this->lastResult = null;
        $check = self::get($id);

        if($check) {
            if($check->delete()) {
                $this->lastResult = $check->toArray();
                return true;
            } else {
                $this->lastResult = "数据库错误";
                return false;
            }
        } else {
            $this->lastResult = "未找到";
            return false;
        }
    }

    protected function SetAddTimeAttr(){
        return time();
    }

    protected function SetCodeAttr(){
        while(true) {
            $code = md5(md5(rand(1,1000000000).'myzly').'myzly');
            if(!self::get(['code' => $code])) {
                break;
            }
        }
        return $code;
    }
}