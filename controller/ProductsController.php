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
        $book = DbRepository::getDb()->findBookById($bookId);
        $this->render("view", ["id" => $bookId, "book" => $book]);
    }

    public function category($categoryId = 1){
        $db = DbRepository::getDb();
        $books = $db->findBooksByCategoryId($categoryId);
        $books = $books === null ? [] : $books;
        $this->render("index", ['books' => $books]);
    }
}