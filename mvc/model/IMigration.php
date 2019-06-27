<?php
/**
 * Created by PhpStorm.
 * User: ПК
 * Date: 27.06.2019
 * Time: 22:06
 */

namespace mvc\model;


interface IMigration
{
    public function up();
    public function down();
    public function executeQuery($query);

}