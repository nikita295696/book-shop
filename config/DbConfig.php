<?php

namespace config;

class DbConfig{
    public static $config = [
        'dsn' => 'mysql:host=localhost;port=3306;dbname=book_shop_bykova_db;charset=utf8;',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
        "table_prefix" => "",
        'file' => [
            'upload_dir' => "/book-shop/public/images/"
        ],
        'public_url' => "/book-shop/public/",
        "base_url" => "/book-shop/",
        'migrationsUp' => [
            'm270619_190134_CreateTablesMigration',
            'm270619_190521_Insert',
        ],
        'migrationsDown' => [
            'm270619_190134_CreateTablesMigration',
        ],
    ];
}