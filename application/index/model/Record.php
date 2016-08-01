<?php
namespace app\index\model;

use think\Model;
use app\index\validate\Record as RecordValidate;
/**
* @author myzly<nkzxwgr@163.com>
*/

class Record extends Model{
    protected $type = [
        'id' => 'integer',                  //记录id
        'sub_domain' => 'text',             //子域名前缀
        'first_domain_id' => 'integer',     //顶域名id
        'type' => 'text',                   //类型
        'value' => 'text',                  //值
        'data' => 'json',                   //一些专用数据(json)
        'user_id' => 'integer',             //用户ID
        'rand_code' => 'integer'            //随机参数
    ];

    protected $field = ['id', 'sub_domain', 'first_domain_id', 'type', 'value', 'data', 'user_id', 'rand_code'];

    protected $pk = 'id';

    protected $auto = ['rand_code'];

    protected $lastResult = null;

    public function GetResult() {
        return $this->lastResult;
    }

    /**
    * 添加记录
    * 
    * @param    array 
    * @return  
    */
    public function AddRecord($data){
        $validateRecord = new RecordValidate;

        if($validateRecord->check($data)) {
            if($id = $this->save($data)) {
                $this->lastResult = self::find($id)->toArray();
                return true;
            } else {
                $this->lastResult = "数据库发生错误";
                return false;
            }
        } else {
            $this->lastResult = $validateRecord->getError();
            return false;
        }
    }

    /**
    * 修改记录
    * 
    * @param    int $id         记录ID
    * @param    array $data     数据
    * @return   boolean
    */
    public function ChangeRecordInfo($id, $data){
        $user = self::get($id);
        $user->type = $data['type'];
        $user->value = $data['value'];
        $user->data = $data['data'];
        $validateRecord = new RecordValidate;

        if($validateRecord->check($user->toArray())) {
            if($user->save()) {
                $this->lastResult = $user->toArray();
                return true;
            } else {
                $this->lastResult = "数据库发生错误";
                return false;
            }
        } else {
            $this->lastResult = $validateRecord->getError();
            return false;
        }
    }

    /**
    * 删除记录
    * 
    * @param    int $id    记录ID
    * @return   boolen
    */
    public function DeleteRecord($id){
        $this->lastResult = null;
        $record = self::get($id);

        $this->lastResult = $record->toArray();
        if($record->delete()) {
            $this->lastResult = $record->toArray();
            return true;
        } else {
            $this->lastResult = "数据库错误";
            return false;
        }
    }

    /**
    * 获取Record信息
    * 
    * @param    int $id
    * @return   boolean
    */
    public function GetRecordInfo($id){
        $this->lastResult = null;
        $record = self::get($id);
        if($record) {
            $this->lastResult = $record->toArray();
            return true;
        } else {
            $this->lastResult = "数据库错误";
            return false;
        }
    }

    /**
    * 通过用户id获取记录列表
    * 
    * @param    int $id     
    * @return   boolean
    */
    public function GetRecordListByUserId($userId){
        $this->lastResult = null;

        $result = self::all(['user_id' => $userId]);
        foreach ($result as $key => $value) {
            $result[$key] = $value->toArray();
        }
        $this->lastResult = $result;
        return true;
    }

    /**
    * 确定是否已存在该域名
    * 
    * @param    string $sub_domain 
    * @param    int $first_domain_id    
    * @return   boolean
    */
    public function VerifyEnable($sub_domain, $first_domain_id){
        $this->lastResult = null;
        if($result = self::find(['sub_domain' => $sub_domain, 'first_domain_id' => $first_domain_id])) {
            $this->lastResult = $result->toArray();
            return true;
        } else {
            return false;
        }
    }

    protected function SetRandCodeAttr(){
        return rand();
    }
}