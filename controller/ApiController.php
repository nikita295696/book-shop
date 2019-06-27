<?php
/**
 * Created by PhpStorm.
 * User: ПК
 * Date: 26.06.2019
 * Time: 6:36
 */

namespace controller;


use config\DbConfig;
use models\db\DbRepository;
use models\db\mysql\tables\Author;
use models\db\mysql\tables\Book;
use models\db\mysql\tables\BooksAuthors;
use models\db\mysql\tables\BooksPhotos;
use models\db\mysql\tables\Category;
use models\db\mysql\tables\Publisher;
use mvc\controller\BaseController;

class ApiController extends \mvc\controller\ApiController
{
    public function categoriesindex($id)
    {
        $result = [];
        switch ($_SERVER['REQUEST_METHOD']) {
            case "POST":
                if(isset($_REQUEST['method'])) {
                    if(empty($_REQUEST['id_parent_category'])){
                        $_REQUEST['id_parent_category'] = null;
                    }
                    $result = DbRepository::getDb()->updateCategory($_REQUEST);
                }else {
                    if($_REQUEST['id_parent_category'] == 'null'){
                        $_REQUEST['id_parent_category'] = "";
                    }
                    $res = DbRepository::getDb()->addCategory($_REQUEST);
                    $result = $res > 0 ? true : false;
                }
                break;
            case "DELETE":
                $category = Category::findByPk($id);
                if(!empty($category)) {
                    $categoryFileds = Category::getModelFileds();
                    Category::deleteBy($categoryFileds['id'] . " = :id",[':id' =>(int)$category->id]);
                    $result = true;
                }else{
                    $result = false;
                }


                break;
            default:
                if (empty($id)) {
                    $result = DbRepository::getDb()->findCategories();
                } else {
                    $result = DbRepository::getDb()->findCategoryById($id);
                }
                break;
        }
        $this->json($result);
    }

    public function categorieschilds($id){
        $result = DbRepository::getDb()->findChildsByParentId($id);
        $json = [];
        if(!empty($result)){
            foreach ($result as $child){
                $json[] = $child->toArray();
            }
        }
        $this->json($json);
    }

    public function authors($id)
    {
        $result = [];
        switch ($_SERVER['REQUEST_METHOD']) {
            case "POST":
                if(isset($_REQUEST['method'])) {
                    $result = DbRepository::getDb()->updateAuthor($_REQUEST);
                }else {
                    $res = DbRepository::getDb()->addAuthor($_REQUEST);
                    $result = $res > 0 ? true : false;
                }
                break;
            case "DELETE":
                $author = Author::findByPk($id);
                if(!empty($author)) {
                    $authorFields = Author::getModelFileds();
                    Author::deleteBy($authorFields['id'] . " = :id",[':id' =>(int)$author->id]);
                    $result = true;
                }else{
                    $result = false;
                }
                break;
            default:
                if (empty($id)) {
                    $authors = DbRepository::getDb()->findAuthors();
                    $result = [];
                    if(!empty($authors)){
                        foreach ($authors as $author) {
                            $result[] = $author->toArray();
                        }
                    }
                } else {
                    $result = DbRepository::getDb()->findAuthorById($id);
                }
                break;
        }
        $this->json($result);
    }

    public function publishers($id)
    {
        $result = [];
        switch ($_SERVER['REQUEST_METHOD']) {
            case "POST":
                if(isset($_REQUEST['method'])) {
                    $result = DbRepository::getDb()->updatePublisher($_REQUEST);
                }else {
                    $res = DbRepository::getDb()->addPublisher($_REQUEST);
                    $result = $res > 0 ? true : false;
                }
                break;
            case "DELETE":
                $publisher = Publisher::findByPk($id);
                if(!empty($publisher)) {
                    $publisherFields = Publisher::getModelFileds();
                    Publisher::deleteBy($publisherFields['id'] . " = :id",[':id' =>(int)$publisher->id]);
                    $result = true;
                }else{
                    $result = false;
                }
                break;
            default:
                if (empty($id)) {
                    $publishers = DbRepository::getDb()->findPublishers();
                    $result = [];
                    if(!empty($publishers)){
                        foreach ($publishers as $publisher) {
                            $result[] = $publisher->toArray();
                        }
                    }
                } else {
                    $result = DbRepository::getDb()->findPublisherById($id);
                }
                break;
        }
        $this->json($result);
    }

    public function bookschilds($id){
        $result = [];
        $categories = DbRepository::getDb()->findChildsByParentId($id);
        $result['categories'] = [];
        if(!empty($categories)){
            foreach ($categories as $child){
                $result['categories'][] = $child->toArray();
            }
        }
        $result['books'] = DbRepository::getDb()->findBooksByCategoryId($id);
        $this->json($result);
    }

    public function books($id){
        $result = [];
        switch ($_SERVER['REQUEST_METHOD']) {
            case "POST":
                $_REQUEST[Book::getModelFileds()['idPublisher']] = (int)$_REQUEST['idPublisher'];
                $_REQUEST[Book::getModelFileds()['idCategory']] = (int)$_REQUEST['idCategory'];
                $_REQUEST[Book::getModelFileds()['name']] = $_REQUEST['name'];

                if(isset($_REQUEST['method'])) {
                    $result = DbRepository::getDb()->updateBook($_REQUEST);
                }else {
                    if(isset($_REQUEST['id']) && isset($_REQUEST['idAuthor'])){
                        $find = BooksAuthors::find(BooksAuthors::getModelFileds()['idBook'] . " = :idBook and " . BooksAuthors::getModelFileds()['idAuthor'] . " = :idAuthor", [":idBook" => (int)$_REQUEST['id'], ":idAuthor"=>$_REQUEST['idAuthor']]);
                        $bookToAuthor = [BooksAuthors::getModelFileds()['idBook'] => (int)$_REQUEST['id'], BooksAuthors::getModelFileds()['idAuthor'] => (int)$_REQUEST['idAuthor']];
                        if(empty($find)) {

                            DbRepository::getDb()->addAuthorToBook($bookToAuthor);
                            $result = 1;
                        }
                        else{
                            $result = 0;
                        }
                    }
                    else{
                        $res = DbRepository::getDb()->addBook($_REQUEST);
                        $result = $res > 0 ? true : false;
                    }
                }
                break;
            case "DELETE":
                if(isset($_REQUEST['id']) && isset($_REQUEST['idAuthor'])){

                    $bookAuthorsFields = BooksAuthors::getModelFileds();
                    BooksAuthors::deleteBy(
                        $bookAuthorsFields['idBook'] . " = :idBook and " . $bookAuthorsFields['idAuthor'] . " = :idAuthor",
                        [':idBook' => (int)$_REQUEST['id'], ':idAuthor'=>(int)$_REQUEST['idAuthor']]);
                    $result = true;
                }else {
                    $book = Book::findByPk($id);
                    if (!empty($book)) {
                        $bookFields = Book::getModelFileds();
                        Book::deleteBy($bookFields['id'] . " = :id", [':id' => (int)$book->id]);
                        $result = true;
                    } else {
                        $result = false;
                    }
                }
                break;
            default:
                if (!empty($id)) {
                    $result = DbRepository::getDb()->findBookById($id);
                }
                break;
        }
        $this->json($result);
    }

    public function bookphoto($id){
        switch ($_SERVER['REQUEST_METHOD']) {
            case "POST":
                if(isset($_REQUEST["method"]) && $_REQUEST['method'] == 'delete'){
                    $booksPhotos = BooksPhotos::getModelFileds();
                    BooksPhotos::deleteBy($booksPhotos['idBook'] . " = :idBook and " . $booksPhotos['path'] . " = :path", [':idBook'=>$id, ":path"=>$_REQUEST['path']]);
                    $result = true;
                }
                else {
                    if (!empty(DbRepository::getDb()->findBookById($id))) {
                        $path = $this->saveFile($_FILES['file'], $id);
                        $bookPhoto = [BooksPhotos::getModelFileds()['idBook'] => (int)$id, BooksPhotos::getModelFileds()['path'] => $path];
                        DbRepository::getDb()->addPhotoToBook($bookPhoto);
                        $result = true;
                    } else {
                        $result = false;
                    }
                }
                break;
        }
        $this->json($result);
    }

    private function saveFile($file, $idBook){
        $uploaddir = DbConfig::$config['file']['upload_dir'];
        $pathUrl = $uploaddir . $idBook . "_" . basename($file['name']);
        $uploadfile = $_SERVER['DOCUMENT_ROOT'] . $pathUrl;
        if (move_uploaded_file($file['tmp_name'], $uploadfile)) {
            return $pathUrl;
        } else {
            return null;
        }
    }
}