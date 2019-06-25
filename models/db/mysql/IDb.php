<?php
/**
 * Created by PhpStorm.
 * User: ПК
 * Date: 19.06.2019
 * Time: 22:38
 */

namespace models\db\mysql;


interface IDb
{
    public function findCategories();
    function findChildsByParentId($id);
    function findCategoryById($id);
    function addCategory($category);
    function updateCategory($category);
    function deleteCategory($id);

    function findPublishers();
    function findPublisherById($id);
    function addPublisher($publisher);
    function updatePublisher($publisher);
    function deletePublisher($id);

    function findAuthors();
    function findAuthorById($id);
    function addAuthor($author);
    function updateAuthor($author);
    function deleteAuthor($id);

    function findBookById($id);
    function findBooksByCategoryId($id);
    function addBook($book);
    function updateBook($book);
    function addAuthorToBook($booksAuthors);
    function addPhotoToBook($booksPhotos);
    function deleteBook($id);
    function findById($id, $callback);
    function findByName($name, $callback);

    function getBreadcramp($baseCategoryId);
    function loginUser($login, $pass);
}