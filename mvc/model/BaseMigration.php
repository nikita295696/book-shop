<?php
/**
 * Created by PhpStorm.
 * User: ПК
 * Date: 27.06.2019
 * Time: 22:12
 */

namespace mvc\model;


class BaseMigration implements IMigration
{
    public function up()
    {
        // TODO: Implement up() method.
    }

    public function down()
    {
        // TODO: Implement down() method.
    }

    public function executeQuery($query)
    {
        $return = true;
        try {
            $db = ActiveRecord::getConnection();
            $db->query($query);
        }catch (\Exception $ex){
            $return = false;
        }

        return $return;
    }
}