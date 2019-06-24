<?php


namespace models\db\mysql\tables;


use mvc\model\ActiveRecord;
use mvc\model\IMigration;

class BooksPhotos extends ActiveRecord implements IMigration
{
    public static function tableName()
    {
        return "books_photos";
    }

    public static function createTable()
    {
        // TODO: Implement createTable() method.
    }

    public static function getModelFileds()
    {
        return [
            'idBook' => "id_book",
            'path' => "path"
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

    public static function findByIdBook($idBook){
        $query = `select * from `.static::tableName().` where `.static::tableName().` = :idBook`;
        $params = [':idBook' => $idBook];
        try {
            $db = self::getConnection();
            $sth = $db->prepare($query);
            $sth->execute($params);
            return $sth->fetchAll(\PDO::FETCH_ASSOC);

        }catch (\Exception $ex){
            return null;
        }
    }
}