<?php


namespace models\db\mysql\tables;


use mvc\model\ActiveRecord;
use mvc\model\IMigration;

class Book extends ActiveRecord implements IMigration
{
    public static function tableName()
    {
        return "books";
    }

    public static function createTable()
    {
        // TODO: Implement createTable() method.
    }

    public static function getModelFileds()
    {
        return [
            'id' => "id",
            'name' => "name",
            'yearPublisher' => "yearPublisher",
            'idPublisher' => "id_publisher",
            'idCategory' => "id_category"
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

    public static function findByPkAndPublisherName($id){
        $thisFields = Book::getModelFileds();
        $query = 'SELECT b.'.$thisFields['id'].' as `id`, b.'.$thisFields['name'].' as `name`, b.'.$thisFields['yearPublisher'].' as `yearPublisher`, b.'.$thisFields['idPublisher'].' as `idPublisher`, b.'.$thisFields['idCategory'].' as `idCategory`, p.'.Publisher::getModelFileds()['name'].' as `publisherName`, c.'.Category::getModelFileds()['name'].' as `categoryName` from '.static::tableName().' as b, '.Publisher::tableName().' as p, '.Category::tableName().' as c WHERE p.'.Publisher::getModelFileds()['id'].' = b.'.$thisFields['idPublisher'].' and c.'.Category::getModelFileds()['id'].' = b.'.$thisFields['idCategory'].' and b.'.$thisFields['id'].' = :id';
        $params = [":id" => $id];

        try{
            $db = self::getConnection();
            $stmt = $db->prepare($query);
            $stmt->execute($params);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }catch (\Exception $ex){
            echo $ex;
        }
    }

    public static function findByCategoryId($id){
        $thisFields = static::getModelFileds();
        $query = 'SELECT b.'.$thisFields['id'].', b.'.$thisFields['name'].', b.'. $thisFields['yearPublisher'] .', b.'.$thisFields['idPublisher'].', b.'.$thisFields['idCategory'].', p.'.Publisher::getModelFileds()['name'].' as `publisherName`, c.'.Category::getModelFileds()['name'].' as `categoryName` from '.static::tableName().' as b, '.Publisher::tableName().' as p, '.Category::tableName().' as c WHERE p.'.Publisher::getModelFileds()['id'].' = b.'.$thisFields['idPublisher'].' and c.'.Category::getModelFileds()['id'].' = b.'.$thisFields['idCategory'].' and b.'.$thisFields['idCategory'].' = :id';
        $params = [':id' => $id];
        try {
            $db = self::getConnection();
            $sth = $db->prepare($query);
            $sth->execute($params);
            $arr = $sth->fetchAll(\PDO::FETCH_ASSOC);
            return $arr;

        }catch (\Exception $ex){
            echo $ex;
            return null;
        }
    }

    public function deleteByCategoryId($categoryId){
        try{
            $thisFields = static::getModelFileds();

        }catch (\Exception $ex){
            echo $ex;
            return null;
        }

    }
}