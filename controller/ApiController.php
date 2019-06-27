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
use models\db\mysql\tables\Book;
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
                        $bookToAuthor = ["idBook"=>$_REQUEST['id'], "idAuthor"=>$_REQUEST['idAuthor']];
                        $res = DbRepository::getDb()->addAuthorToBook($bookToAuthor);
                        $result = $res > 0 ? true : false;
                    }
                    else{
                        $res = DbRepository::getDb()->addBook($_REQUEST);
                        $result = $res > 0 ? true : false;
                    }
                }
                break;
            case "DELETE":
                break;
            default:
                if (!empty($id)) {
                    $result = DbRepository::getDb()->findAuthorById($id);
                }
                break;
        }
        $this->json($result);
    }

    public function bookphoto($id){
        $path = $this->saveFile($_FILES['file']);
        $bookPhoto = ['idBook' => $id, "path" => $path];
        $result = DbRepository::getDb()->addPhotoToBook($bookPhoto) > 0 ? true : false;
        $this->json($result);
    }

    private function saveFile($file){
        $uploaddir = DbConfig::$config['file']['upload_dir'];
        $uploadfile = $uploaddir . basename($file['name']);

        echo '<pre>';
        if (move_uploaded_file($file['tmp_name'], $uploadfile)) {
            return $uploadfile;
        } else {
            return null;
        }
    }
}