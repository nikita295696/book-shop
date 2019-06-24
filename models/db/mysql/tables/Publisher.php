<?php


namespace models\db\mysql\tables;


use mvc\model\ActiveRecord;
use mvc\model\IMigration;

class Publisher extends ActiveRecord implements IMigration
{
    public static function tableName()
    {
        return "publishers";
    }

    public static function createTable()
    {
        // TODO: Implement createTable() method.
    }

    public static function getModelFileds()
    {
        return [
            'id' => "id",
            'name'=> "name",
            'address'=> "address",
            'phone'=> "phone"
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
}