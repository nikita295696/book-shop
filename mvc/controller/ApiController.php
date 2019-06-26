<?php
/**
 * Created by PhpStorm.
 * User: ПК
 * Date: 26.06.2019
 * Time: 6:37
 */

namespace mvc\controller;


class ApiController
{
    private $controllerName;
    private $directoryViews = 'views';
    protected $models = [];

    public function __construct($controllerName = "Default", $moduleName = "")
    {
        if($moduleName != "") {
            $this->directoryViews = "$moduleName\\" . $this->directoryViews;
        }
        $this->controllerName = $controllerName;
    }

    public function json($models){
        header('Content-type: application/json');
        echo json_encode($models);
    }
}