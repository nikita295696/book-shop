<?php


namespace controller;


use models\db\DbRepository;
use mvc\controller\BaseController;

class AdminController extends BaseController
{
    public function __construct($controllerName = "Default", $moduleName = "")
    {
        parent::__construct($controllerName, $moduleName);
        $this->layoutFile = "layouts\\admin_main.php";
    }

    public function login(){
        if(!empty($_REQUEST)){
            $user = DbRepository::getDb()->loginUser($_REQUEST['username'], $_REQUEST["password"]);
            if(isset($user) && !empty($user)){
                $_SESSION['user'] = $user->toArray();
                header('Location: ' . BASE_URL . 'admin/index');
            }
        }
        $this->render("login", [], false);
    }

    public function index(){
        if(!isset($_SESSION['user']) || empty($_SESSION['user'])) {
            header('Location: ' . BASE_URL . 'admin/login');
        }
        else{
            $this->render('index');
        }

    }
}