<?php
/**
 * Created by PhpStorm.
 * User: ПК
 * Date: 23.06.2019
 * Time: 15:17
 */

namespace controller;


use models\db\DbRepository;
use mvc\controller\BaseController;

class SiteController extends BaseController
{
    public function __construct($controllerName = "Default", $moduleName = "")
    {
        parent::__construct($controllerName, $moduleName);
        $this->models["categories"] = DbRepository::getDb()->findCategories();
    }
}