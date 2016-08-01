<?php
namespace app\index\model;

use think\Model;

/**
* @author myzly<nkzxwgr@163.com>
*/

class FirstDomain extends Model{
    protected $field = ['id', 'first_domain', 'dns_server', 'data', 'importent_sub_domain'];

    protected $type = [
        'data' => 'json',
        'importent_sub_domain' => 'json'
    ];

    protected $pk = 'id';

    protected $lastResult = null;

    public function GetResult(){
        return $this->lastResult;
    }

    /**
    * 添加顶级域名
    * 
    * @param    string $first_domain
    * @param    array $data
    * @return   boolean
    */
    public function AddFirstDomain($firstDomain, $dnsServer,$data){
        $this->lastResult = null;

        if(self::get(['first_domain' => $firstDomain])) {
            $this->lastResult = "已添加该域名";
            return fasle;
        } else {
            if($result = $this->save(['first_domain' => $first_domain, 'dns_server' => $dnsServer, 'data' => $data, 'importent_sub_domain' => '[]'])) {
                $this->lastResult = self::get(['first_domain' => $firstDomain])->toArray();
                return true;
            } else {
                $this->lastResult = "数据库错误";
                return false;
            }
        }
    }

    /**
    * 修改信息
    * 
    * @param    string $firstDomain
    * @param    array   $data
    * @return   boolean
    */
    public function ChangeFirstDomainInfo($firstDomain, $data){
        $this->lastResult = null;
        $firstDomain = self::get(['first_domain' => $firstDomain]);

        if($firstDomain) {
            $firstDomain->data = $data;
            if($firstDomain->save()) {
                $this->lastResult = $firstDomain->toArray();
                return true;
            } else {
                $this->lastResult = "数据库错误";
                return false;
            }
        } else {
            $this->lastResult = "域名不存在";
            return false;
        }
    }

    /**
    * 修改重要的子域名
    * 
    * @param    int $id
    * @param    array $importantSubDomain
    * @return   boolean
    */
    public function ChangeFirstDomainImportantSubDomain($id, $importantSubDomain){
        $this->lastResult = null;
        
        if($firstDomain = self::get($id)) {
            $firstDomain->importent_sub_domain = $importantSubDomain;

            if($firstDomain->save()) {
                $this->lastResult = $firstDomain->toArray();
                return true;
            } else {
                $this->lastResult = '数据库错误';
                return false;
            }
        } else {
            $this->lastResult = "域名不存在";
            return false;
        }
    }

    /**
    * 获取域名列表
    * 
    * @return   boolean
    */
    public function GetFirstDomainList(){
        $this->lastResult = null;

        $result = self::field('id,first_domain')->select();

        foreach ($result as $key => $value) {
            $result[$key] = $value->toArray();
        }

        $this->lastResult = $result;

        return true;
    }

    /**
    * 验证是否为保留域名
    * 
    * @param    int     $id
    * @return   string  $
    */
    public function VerifyImportant(){
        
    }
}