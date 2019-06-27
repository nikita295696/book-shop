<?php

namespace config;

class DbConfig{
    public static $config = [
        'dsn' => 'mysql:host=localhost;port=3306;dbname=book_shop_bykova_db',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
        "table_prefix" => "",
        'file' => [
            'upload_dir' => "/book-shop/public/images/"
        ]
    ];
}