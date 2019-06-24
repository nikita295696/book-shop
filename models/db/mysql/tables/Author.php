<?php
/**
 * Created by PhpStorm.
 * User: ПК
 * Date: 20.06.2019
 * Time: 6:32
 */

namespace models\db\mysql\tables;

use mvc\model\ActiveRecord;
use mvc\model\IMigration;

class Author extends ActiveRecord implements IMigration
{
    public static function tableName()
    {
        return "authors";
    }

    public static function createTable()
    {
        // TODO: Implement createTable() method.
    }

    public static function getModelFileds()
    {
        return [
            'id' => "id",
            'name' => "name"
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