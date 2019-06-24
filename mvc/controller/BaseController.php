<?php

namespace mvc\controller;

class BaseController
{
    private $controllerName;
    private $directoryViews = 'views';
    private $layoutFile = "layouts\\main.php";
    protected $models = [];

    /**
     * BaseController constructor.
     * @param $controllerName
     */
    public function __construct($controllerName = "Default", $moduleName = "")
    {
        if($moduleName != "") {
            $this->directoryViews = "$moduleName\\" . $this->directoryViews;
            $this->layoutFile = "$moduleName\\" . $this->layoutFile;
        }
        $this->controllerName = $controllerName;
    }

    public function render($action, $models = null, $isLayout = true){
        $view = "";
        $content = "";
        if($isLayout) {
            $view = "$this->directoryViews\\$this->layoutFile";
            $content = "$this->directoryViews\\" . strtolower($this->controllerName) . "\\$action.php";
        }
        else{
            $view = "$this->directoryViews\\" . strtolower($this->controllerName) . "\\$action.php";
        }

        if(!empty($models)){
            $this->models = array_merge($models, $this->models);
        }

        if(!empty($this->models)){
            extract($this->models);
        }

        if(file_exists($view)) {
            require $view;
        }
    }

}