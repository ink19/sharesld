<?php
namespace app\index\model;

use think\Model;

/**
* @author myzly<nkzxwgr@163.com>
*/

class Configure extends Model{
    protected $type = ['value' => 'json'];

    protected $auto = ['rand_code'];

    protected $field = ['id', 'name', 'value', 'rand_code'];

    protected $pk = 'id';

    protected $lastResult = null;

    /**
    * 获取数据
    *    
    * @return   mixed
    */
    public function GetResult(){
        return $this->lastResult;
    }

    /**
    * 添加配置信息
    * 
    * @param    string  $name
    * @param    mixed   $value
    * @return   boolean
    */
    public function AddConfigure($name, $value){
        $this->lastResult = null;

        if(self::get(['name' => $name]->id)) {
            if($result = $this->add(['name' => $name, 'value' => $value])) {
                $this->lastResult = self::get($result)->toArray();
                return true;
            } else {
                $this->lastResult = "数据库错误";
                return false;
            }
        } else {
            return $this->ChangeConfigure($name, $value);
        }
    }

    /**
    * 获取配置信息
    * 
    * @param    string $name
    * @return   boolean
    */
    public function GetConfigure($name){
        $this->lastResult = null;

        $this->lastResult = self::get(['name' => $name])->toArray();
        return true;
    }

    /**
    * 修改配置信息
    * 
    * @param    string $name
    * @param    mix $value
    * @return   boolean
    */
    public function ChangeConfigure($name, $value){
        $this->lastResult = null;
        $configure = self::get(['name' => $name]);

        $configure->value = $value;

        if($configure->save()) {
            $this->lastResult - $configure->toArray();
            return true;
        } else {
            $this->lastResult = "数据库错误";
            return fasle;
        }
    }

    /**
    * 删除配置
    * 
    * @param    string $name   
    * @return   boolean
    */
    public function DeleteConfigure($name){
        $this->lastResult = null;
        $configure = self::get(['name' => $name]);
        
        if($configure->delete()) {
            $this->lastResult = $configure->toArray();
            return true;
        } else {
            $this->lastResult = "数据库错误";
            return false;
        }
    }

    protected function SetRandCodeAttr() {
        return rand();
    }
}