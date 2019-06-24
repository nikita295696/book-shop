<?php
/**
 * Created by PhpStorm.
 * User: ПК
 * Date: 19.07.2018
 * Time: 15:10
 */

namespace mvc\model;


use config\DbConfig;

class ActiveRecord
{
    private $fields;
    private $properties = [];
    private $operatorSave;
    public function __construct($operator = 'insert')
    {
        $this->fields = array();
        $this->operatorSave = $operator;
        try {
            $db = self::getConnection();

            $stmt = $db->query('select * from '.static::tableName().'');

            $columnCount = $stmt->columnCount();

            if($columnCount > 0)
            {
                for($i = 0; $i < $columnCount; $i++)
                {
                    $this->fields[] = $stmt->getColumnMeta($i)['name'];
                }
            }



        } catch (\PDOException $ex) {
            echo "Error: " . $ex->getMessage() . "\n";
        }
    }

    public static function getConnection(){
        $conf = DbConfig::$config;
        $db = new \PDO($conf['dsn'],
            $conf['username'], $conf['password']);
        $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        return $db;
    }

    public function __set($name, $value)
    {
        if(in_array($name, $this->fields)) {
            $this->properties[$name] = $value;
        }
    }

    public function __get($name)
    {
        if(in_array($name, $this->fields)) {
            return $this->properties[$name];
        }
        return null;
    }

    public function __isset($name)
    {
        return key_exists($name, $this->properties);
    }

    public function getFields()
    {
        return $this->fields;
    }

    public function save(){
        $query = '';
        if(count($this->properties) > 0) {
            switch (strtolower($this->operatorSave)) {
                case 'insert':
                    {
                        foreach ($this->properties as $key => $value)
                        {
                            $mssColumn[] = $key;
                            $mssValue[] = $value;
                        }

                        $str_columns = '';
                        $str_values = '';

                        for($i = 0; $i < count($mssColumn) - 1; $i++)
                        {
                            $str_columns .= $mssColumn[$i] . ', ';
                            $str_values .= "'$mssValue[$i]'" . ', ';
                        }

                        $str_columns .= $mssColumn[count($mssColumn) - 1];
                        $str_values .= $mssValue[count($mssColumn) - 1];

                        $query = "INSERT INTO ".self::tableName()." ($str_columns) VALUES ($str_values);";
                        break;
                    }
                case 'update':
                    {
                        $i = 0;
                        $where = "";
                        $set = "";
                        foreach ($this->properties as $key => $value)
                        {
                            if($i === 0)
                            {
                                $where = "$key = '$value'";
                            }
                            else if($i === count($this->properties) - 1)
                            {
                                $set .= " $key = '$value' ";
                            }
                            else{
                                $set .= " $key = '$value', ";
                            }
                            $i++;
                        }
                        $query = "UPDATE ".self::tableName()." set $set where $where";
                        break;
                    }
            }

            try {
                $db = self::getConnection();

                $db->query($query);

                if($this->operatorSave == 'insert'){
                    return $db->lastInsertId();
                }
                else{
                    return 1;
                }

            } catch (\PDOException $ex) {
                echo "Error: " . $ex->getMessage() . "\n";
            }
        }
    }

    public function delete(){
        $i = 0;
        $delete = false;
        foreach ($this->properties as $key => $value)
        {
            $delete = " $key = '$value' ";
            if($i > 0)
            {
                break;
            }
        }
        if($delete !== false) {
            $query = "DELETE FROM ".self::tableName()." WHERE $delete";

            try {
                $db = self::getConnection();

                $db->query($query);

            } catch (\PDOException $ex) {
                echo "Error: " . $ex->getMessage() . "\n";
            }
        }
    }

    private static function invokeDb($query, $condition,$params){
        $stmt = null;
        if(isset($condition) && !empty($condition) && isset($params) && !empty($params))
        {
            try {
                if(is_string($condition)) {
                    $query .= " where $condition ";
                }else if(is_array($condition) && count($condition) > 0){
                    $query .= " where $condition[0] ";
                    foreach ($condition as $key => $value){
                        $query .= $key == 0 ? " where $value " : " and $value";
                    }
                }

                $db = self::getConnection();

                $stmt = $db->prepare($query);

                $stmt->execute($params);

            } catch (\PDOException $ex) {
                echo "Error: " . $ex->getMessage() . "\n";
            }
        }
        else{
            try {
                $db = self::getConnection();

                $stmt = $db->prepare($query);

                $stmt->execute();

            } catch (\PDOException $ex) {
                echo "Error: " . $ex->getMessage() . "\n";
            }
        }
        return $stmt;
    }

    private static function invokeDbPk($query){
        $stmt = null;

        try {

            $db = self::getConnection();

            $stmt = $db->prepare($query);

            $stmt->execute();

        } catch (\PDOException $ex) {
            echo "Error: " . $ex->getMessage() . "\n";
        }


        return $stmt;
    }

    public static function find($condition,$params){
        $query = "select * from " . static::tableName() . "  ";
        $stmt = self::invokeDb($query, $condition,$params);
        if($stmt !== null)
        {
            $arr = $stmt->fetch(\PDO::FETCH_ASSOC);
            $arcls = new static('update');
            foreach ($arr as $key => $value)
            {
                $arcls->$key = $value;
            }

            return $arcls;
        }
        else{
            return null;
        }
    }

    public static function findByPk($postID){
        $post = new static();
        $query = "select * from " . self::tableName() . " where " . $post->getFields()[0] . " = $postID";

        $stmt = static::invokeDbPk($query);
        if($stmt !== null)
        {
            $arr = $stmt->fetch(\PDO::FETCH_ASSOC);
            $arcls = new static('update');
            foreach ($arr as $key => $value)
            {
                $arcls->$key = $value;
            }

            return $arcls;
        }
        else{
            return null;
        }
    }

    public static function findAll($condition,$params){
        $query = "select * from " . static::tableName() . "  ";
        $stmt = static::invokeDb($query, $condition,$params);
        if($stmt !== null)
        {
            $arcls = [];
            $arr = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            foreach ($arr as $column) {

                $columnArcls = new static('update');
                foreach ($column as $key => $value) {
                    $columnArcls->$key = $value;
                }
                $arcls[] = $columnArcls;
            }

            return $arcls;
        }
        else{
            return array();
        }
    }

    public static function count($condition,$params){
        return count(static::findAll($condition, $params));
    }

    public static function tableName()
    {
        return DbConfig::$config['table_prefix'] . strtolower(static::className());
    }

    public static function className()
    {
        try {
            $class = new \ReflectionClass(static::class . "");
            return $class->getShortName();
        } catch (\ReflectionException $e) {
        }
    }
}