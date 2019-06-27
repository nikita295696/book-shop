<?php
/**
 * Created by PhpStorm.
 * User: ПК
 * Date: 27.06.2019
 * Time: 22:08
 */

namespace migrations;


use mvc\model\BaseMigration;
use mvc\model\IMigration;

class m270619_190134_CreateTablesMigration extends BaseMigration
{
    public function up()
    {
        $this->executeQuery("CREATE TABLE publishers(
	id int PRIMARY KEY AUTO_INCREMENT,
    name nvarchar(50) not null,
    address nvarchar(150) not null,
    phone varchar(15) not null
);");
        $this->executeQuery("CREATE TABLE categories(
	id int PRIMARY KEY AUTO_INCREMENT,
    name nvarchar(50) not null,
    id_parent_category int null,
    FOREIGN KEY(id_parent_category) REFERENCES categories(id) ON DELETE CASCADE
);");

        $this->executeQuery("CREATE TABLE books(
	id int PRIMARY KEY AUTO_INCREMENT,
    name nvarchar(50) not null,
    yearPublisher int not null,
    id_publisher int not null,
    id_category int not null,
    FOREIGN KEY(id_publisher) REFERENCES publishers(id) ON DELETE CASCADE,
    FOREIGN KEY(id_category) REFERENCES categories(id) ON DELETE CASCADE
);");

        $this->executeQuery("CREATE TABLE books_photos(
	id_book int not null,
    path varchar(50) not null,
    FOREIGN KEY(id_book) REFERENCES books(id) ON DELETE CASCADE
);");

        $this->executeQuery("CREATE TABLE `authors`(
    id int PRIMARY KEY AUTO_INCREMENT,
    name varchar(100) not null
);");

        $this->executeQuery("CREATE TABLE books_authors(
	id_book int not null,
    id_author int not null,
    FOREIGN KEY(id_book) REFERENCES books(id) ON DELETE CASCADE,
    FOREIGN KEY(id_author) REFERENCES authors(id) ON DELETE CASCADE
);");

        $this->executeQuery("CREATE TABLE users(
	id int PRIMARY KEY AUTO_INCREMENT,
    displayName nvarchar(150) not null,
    email varchar(100) not null,
    `password` varchar(100) not null,
    role nvarchar(50) not null
);");

        echo "End migration m270619_190134_CreateTablesMigration <br/>";
    }

    public function down()
    {
        $this->executeQuery("DROP TABLE IF EXISTS `users`");
        $this->executeQuery("DROP TABLE IF EXISTS `books_authors`");
        $this->executeQuery("DROP TABLE IF EXISTS `authors`");
        $this->executeQuery("DROP TABLE IF EXISTS `books_photos`");
        $this->executeQuery("DROP TABLE IF EXISTS `books`");
        $this->executeQuery("DROP TABLE IF EXISTS `categories`");
        $this->executeQuery("DROP TABLE IF EXISTS `publishers`");
    }
}