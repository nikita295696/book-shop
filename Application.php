<?php
/**
 * Created by PhpStorm.
 * User: shaptala
 * Date: 20.06.2018
 * Time: 17:19
 */

spl_autoload_register(function($cls) {
    //if(file_exists($cls)) {
        require_once "$cls.php";
    //}
});

class Application
{
    private $controllerName = 'Default';
    private $controller = "Default";
    private $actionName = 'index';
    private $id = null;

    private $moduleName;

    function __construct($moduleName = "")
    {
        $this->moduleName = $moduleName;

        if(isset($_GET['controller'])) {
            $this->controllerName = $_GET['controller'];
            $this->controller = $_GET['controller'];
        }
        if(empty($this->controllerName)) {
            $this->controllerName = "Default";
            $this->controller = "Default";
        }
        if(stristr($this->controllerName, "controller") === FALSE) {
            $this->controllerName .= "Controller";
        }

        if(isset($_GET['action'])) {
            $this->actionName = strtolower($_GET['action']);
        }
        if(empty($this->actionName)) {
            $this->actionName = "index";
        }

        if(isset($_GET['id'])) {
            $this->id = $_GET['id'];
        }
    }

    public static function getUrl($controller, $action = null, $id = null,  $queryParams = null){
        $url = BASE_URL . "$controller";
        $url .= isset($action) && !empty($action) ? "/$action/" : "";
        $url .= isset($id) && !empty($id) ? "$id" : "";
        if(isset($queryParams) && !empty($queryParams) &&  is_array($queryParams) && count($queryParams) > 0){
            $isFirst = false;
            foreach ($queryParams as $key => $value){
                $url .= !$isFirst ? "?$key=$value" : "&$key=$value";
                $isFirst = true;
            }

        }
        return $url;
    }

    function run() {

        $this->controllerName = "controller\\$this->controllerName";
        if(class_exists($this->controllerName)) {
            if($this->moduleName != "") {
                $this->controllerName = $this->moduleName != "" ? $this->moduleName . '\\' : "" . $this->controllerName;
            }
            $controller = new $this->controllerName($this->controller, $this->moduleName);
            if (in_array($this->actionName, get_class_methods($this->controllerName))) {
                $controller->{$this->actionName}($this->id);
            }
        }
    }
}