<?php


namespace controller;


use mvc\controller\BaseController;

class AdminController extends BaseController
{
    public function login(){
        $this->render("login", [], false);
    }

    public function index(){
        header('Location: '. BASE_URL . 'admin/login');
    }
}