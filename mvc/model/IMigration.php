<?php
/**
 * Created by PhpStorm.
 * User: ПК
 * Date: 23.06.2019
 * Time: 0:16
 */

namespace mvc\model;


interface IMigration
{
    public static function createTable();
    public static function getModelFileds();
    public function toArray();
}