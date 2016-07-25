<?php
namespace app\index\model;

use think\Model;


/**
* 用户类
* 字段 id username password email create_time login_time
* @author myzly<nkzxwgr@163.com>
*/

class User extends Model{
    
    protected $auto = ['password', 'rand_code'];

    protected $insert = ['create_time'];

    protected $lastResult;

    /**
    * 返回上次操作的值
    * 
    * @return   maxed   上次操作的值
    */
    public function GetResult(){
        return $this->lastResult;
    }

    /**
    * 验证登入
    * GetResult 返回用户信息
    * 
    * @param    string $username    用户名
    * @param    string $password    密码
    * @return   boolean
    */
    public function ProveLogin($username, $password){
        $this->lastResult = null;

        $map = [
            'username' => $username,
            'password' => md5($password)
        ];
        if($result = $this->where($map)->find()) {
            $this->lastResult = $result;
            return true;
        } else {
            return false;
        }
    }

    /**
    * 添加用户
    * GetReturn 返回用户信息
    * 
    * @param    string $username    用户名
    * @param    string $password    密码
    * @param    string $email       邮箱
    * @return   boolean
    */
    public function AddUser($username, $password, $email){
        //重置
        $this->lastResult = null;

        $data = [
            'username' => $username,
            'password' => $password,
            'email' => $email
        ];

        if($id = $this->save($data)) {
            $this->lastResult = $this->find($id)->toArray();
            return true;
        } else {
            return false;
        }
    }

    /**
    * 修改用户资料
    * 
    * @param    int $id         用户ID
    * @param    array $data     资料
    * @return   boolean
    */
    public function ChangUserInfo($id, $data){
        $user = self::find($id);

        if($data['email']) {
            $user->email = $data['email'];
        } 

        if($data['password']) {
            $user->password = $data['password'];
        }

        if($user->save()) {
            $this->lastResult = $user->toArray();
            return true;
        } else {
            return false;
        }
    }

    /**
    * 自动修改密码
    */
    protected function SetPasswordAttr($value, $data){
        if($value == $data['password']) {
            return $value;
        } else {
            return md5($value);
        }
    }

    /**
    * 在数据不变的情况下,也能知道是否修改成功
    */
    protected function SetRandCodeAttr(){
        return rand();
    }

    /**
    * 创建时间
    *    
    */
    protected function SetCreateTimeAttr(){
      return time();  
    }
}