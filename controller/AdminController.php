<?php


namespace controller;


use models\db\DbRepository;
use models\db\mysql\tables\User;
use mvc\controller\BaseController;

class AdminController extends BaseController
{
    public function __construct($controllerName = "Default", $moduleName = "")
    {
        parent::__construct($controllerName, $moduleName);
        $this->layoutFile = "layouts\\admin_main.php";
        session_start();
        $this->models["user"] = isset($_SESSION['user']) && !empty($_SESSION['user']) ? $_SESSION["user"] : [];
    }

    public function authorizedActions()
    {
        $base = parent::authorizedActions();
        return array_merge($base, ['success'=>["login"]]);
    }

    public function successAuthorize()
    {
        return isset($_SESSION['user']) && !empty($_SESSION['user']);
    }

    public function login(){

        if(!empty($_REQUEST) && isset($_REQUEST['username']) && isset($_REQUEST["password"]) ){
            $user = DbRepository::getDb()->loginUser($_REQUEST['username'], User::getHashPassword($_REQUEST["password"]));
            if(isset($user) && !empty($user)){
                $_SESSION['user'] = $user->toArray();
                \Application::redirect("admin/index");
            }
        }
        $this->render("login", [], false);
    }

    public function index(){
        $this->render('index');
    }

    public function categories(){
        $categories = DbRepository::getDb()->findCategories();
        $this->render("categories", ['categories'=>$categories]);
    }

    public function logout(){
        unset($_SESSION['user']);
        \Application::redirect("admin/login");
    }

    public function authors(){
        $authors = DbRepository::getDb()->findAuthors();
        $resAuthors = [];
        if(!empty($authors)){
            foreach ($authors as $author) {
                $resAuthors[] = $author->toArray();
            }
        }
        $this->render("authors", ['authors'=>$resAuthors]);
    }

    public function publishers(){
        $publishers = DbRepository::getDb()->findPublishers();
        $resPublisher = [];
        if(!empty($publishers)){
            foreach ($publishers as $publisher) {
                $resPublisher[] = $publisher->toArray();
            }
        }
        $this->render("publishers", ['publishers'=>$resPublisher]);
    }

    public function books(){
        $categories = DbRepository::getDb()->findCategories();

        $dbPublishers = DbRepository::getDb()->findPublishers();
        $publishers = [];
        if(!empty($dbPublishers)){
            foreach ($dbPublishers as $publisher){
                $publishers[] = $publisher->toArray();
            }
        }
        $this->render("books", ['categories'=>$categories, 'publishers' => $publishers]);
    }

    public function booksview($id){
        $book = DbRepository::getDb()->findBookById($id);

        $categories = DbRepository::getDb()->findCategories();
        $dbPublishers = DbRepository::getDb()->findPublishers();
        $publishers = $this->toArrayActiveRecord($dbPublishers);

        $dbAuthors = DbRepository::getDb()->findAuthors();
        $authors = $this->toArrayActiveRecord($dbAuthors);
        $this->render("booksView", ['categories'=>$categories, 'publishers' => $publishers, 'authors'=>$authors, 'book' => $book]);
    }

    private function toArrayActiveRecord($activeRecord){
        $mss = [];
        if(!empty($activeRecord)){
            foreach ($activeRecord as $item){
                $mss[] = $item->toArray();
            }
        }
        return $mss;
    }
}