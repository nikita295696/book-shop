<?php


namespace models\db\mysql\tables;


use mvc\model\ActiveRecord;
use mvc\model\IMigration;

class BooksAuthors extends ActiveRecord implements IMigration
{
    public static function tableName()
    {
        return "books_authors";
    }

    public static function createTable()
    {
        // TODO: Implement createTable() method.
    }

    public static function getModelFileds()
    {
        return [
            'idBook' => "id_book",
            'idAuthor' => "id_author"
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

    public static function findAuthorsFromBook($idBook, $idAuthor = null){
        $bookTable = static::tableName();
        $thisFields = BooksAuthors::getModelFileds();
        $query = `select a.`.$thisFields['idBook'].`, a.`.$thisFields['idAuthor'].` from `.$bookTable.` as b, `.Author::tableName().` as a where b.`.$thisFields['idBook'].` = :idBook `;
        $params = [':idBook'=>$idBook];
        if(isset($idAuthor) && !empty($idAuthor)){
            $query .= `and `. $thisFields['idAuthor'] .` = :idAuthor`;
            $params[':idAuthor'] = $idAuthor;
        }
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