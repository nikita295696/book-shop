<?php


namespace controller;


use models\db\DbRepository;
use models\db\mysql\tables\Category;
use mvc\controller\BaseController;

class ProductsController extends SiteController
{

    public function index(){
        $this->render("index");
    }

    public function view($bookId = 1){
        $this->render("view", ["id" => $bookId]);
    }

    public function category($categoryId = 1){
        $db = DbRepository::getDb($categoryId);
        $books = $db->findBooksByCategoryId($categoryId);
        $books = $books === null ? [] : $books;
        $this->render("index", ['books' => $books]);
    }
}