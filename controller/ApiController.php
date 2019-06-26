<?php
/**
 * Created by PhpStorm.
 * User: ПК
 * Date: 26.06.2019
 * Time: 6:36
 */

namespace controller;


use models\db\DbRepository;
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
}