<?php


namespace models\db\mysql\tables;


use mvc\model\ActiveRecord;
use mvc\model\IMigration;

class User extends ActiveRecord implements IMigration
{
    public static function tableName()
    {
        return "users";
    }

    public static function createTable()
    {
        // TODO: Implement createTable() method.
    }

    public static function getModelFileds()
    {
        return [
            'id' => "id",
            'displayName' => "displayName",
            'email' => "email",
            'password' => "password",
            'role' => "role"
        ];
    }

    public function toArray()
    {
        $obj = [];
        foreach (self::getModelFileds() as $key => $value){
            $obj[$key] = $this->$value;
        }
        return $obj;
    }

    public static function getHashPassword($pass){
        return md5(md5($pass) . "3!5");
    }
}