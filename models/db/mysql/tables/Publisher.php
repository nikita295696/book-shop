<?php


namespace models\db\mysql\tables;


use mvc\model\ActiveRecord;
use mvc\model\IModelFields;

class Publisher extends ActiveRecord implements IModelFields
{
    public static function tableName()
    {
        return "publishers";
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