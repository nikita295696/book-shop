<?php


namespace models\db\mysql\tables;


use mvc\model\ActiveRecord;
use mvc\model\IModelFields;

class Category extends ActiveRecord implements IModelFields
{

    public static function tableName()
    {
        return "categories";
    }

    public static function findByParent($id){
        if(empty($id)|| !isset($id)) {
            return self::findAll(self::getModelFileds()['idParentCategory'] . " is :id ", [":id"=>null]);
        }
        else{
            return self::findAll(self::getModelFileds()['idParentCategory'] . " = :id ", [':id'=>$id]);
        }
    }

    public static function getModelFileds()
    {
        return [
            'id'=> "id",
            'name'=> "name",
            'idParentCategory'=> "id_parent_category"
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