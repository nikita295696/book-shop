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

        if(!isset($_SESSION['user']) || empty($_SESSION['user'])) {
            \Application::redirect("admin/login");
        }
        else{
            $this->render('index');
        }

    }

    public function categories(){
        $categories = DbRepository::getDb()->findCategories();
        $this->render("categories", ['categories'=>$categories]);
    }

    public function logout(){
        unset($_SESSION['user']);
        \Application::redirect("admin/login");
    }
}