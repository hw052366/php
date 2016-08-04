<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/16
 * Time: 10:26
 */

namespace core;
use app\config\Config;
class Model extends \vendor\PDOWrapper
{
    public function __construct(){

        parent::__construct(Config::$config);
    }
    static function getModel($model=false)
    {
        if ($model === false) {
            $model=get_called_class();
        }
        static $obj = array();
        if (empty($obj[$model])) {
            $obj[$model] = new $model();
        }
        return $obj[$model];
    }
    public function findAll($where = '2 > 1')
    {
        $table=static :: $table;
        $sql = "select * from `{$table}` where {$where}";
        return $this->getAll($sql);
    }
    public function findById($id)
    {
        $sql = "select * from `".static::$table."` where id={$id}";
        return $this->getOne($sql);
    }
    public function find($where)
    {
        $table=static :: $table;
        $sql = "select * from `{$table}` where {$where}";
        //echo $sql;die;
        //print_r($this->exec($sql));die;
        return $this->getOne($sql);
    }
    public function deleteById($id)
    {
        $sql = "delete from `".static::$table."` where id={$id}";
        return $this->exec($sql);
    }
    public function findCount($where = '2 > 1')
    {
        $sql = "select count(*) as count from `".static::$table."` where {$where}";
       //echo $sql;
        return $this->getOne($sql)->count;
    }
    public function add($data)
    {
       $fields="";
        $fieldValues="";
        foreach($data as $field => $fieldValue) {
            $fields.="`{$field}`,";
            $fieldValues.="'{$fieldValue}',";
        }
        $fields=rtrim($fields,",");
        $fieldValues=rtrim($fieldValues,",");
        $table=static::$table;
        $sql="insert into `{$table}` ({$fields}) values ({$fieldValues})";
        //echo $sql;die;
        return $this->exec($sql);
    }
    public function updateById($id, $data)
    {
       $sets="";
        foreach($data as $field => $fieldValue) {
            $sets .= "`{$field}` = '{$fieldValue}',";
        }
        $table=static::$table;
        $sets = rtrim($sets,',');
        $sql="update $table set {$sets} where id = '$id'";
        //echo $sql;die;
        return $this->exec($sql);
    }
}