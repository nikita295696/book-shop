<?php
/**
 * Created by PhpStorm.
 * User: ПК
 * Date: 19.06.2019
 * Time: 22:35
 */

namespace models\db\mysql;


use config\DbConfig;
use models\db\mysql\tables\Author;
use models\db\mysql\tables\Book;
use models\db\mysql\tables\BooksAuthors;
use models\db\mysql\tables\BooksPhotos;
use models\db\mysql\tables\Category;
use models\db\mysql\tables\Publisher;
use models\db\mysql\tables\User;

class MySqlDb implements IDb
{
    public function __construct()
    {

    }

    private function _findChildsByParentId($id = null) {

            try {
                $res = Category::findByParent($id);
            $json = [];
            if (isset($res) && is_array($res) && count($res) > 0) {
                /** @var Category $category */
                foreach ($res as $category) {
                    $catJson = $category->toArray();
                    $catJson['childs'] = [];

                    $catJson['childs'] = $this->_findChildsByParentId($catJson['id']);

                    $json[] = $catJson;
                    //if(catJson.idParentCategory)
                }
            }
            return $json;
        } catch (\Exception $err) {
                return null;
            }
    }

    private function _getParentCategory($id){

            $res = [];
            try {
                if(isset($id) && !empty($id)){
                    $category = Category::findByPk($id);
                    $categoryArr = $category->toArray();
                if(isset($categoryArr) && is_array($categoryArr) && count($categoryArr) > 0){
                    $parentCategory = $this->_getParentCategory($categoryArr['idParentCategory']);
                    $parentCategory[] = $categoryArr;
                    $res = $parentCategory;
                }
            }
                return $res;
            } catch (\Exception $err) {
                return [];
            }

    }

    public function findCategories()
    {
        return $this->_findChildsByParentId();
    }

    function findChildsByParentId($id)
    {
        try {
            return Category::findByParent($id);

            } catch (\Exception $err) {
            return null;
        }
    }

    function findCategoryById($id)
    {
        try {
            return Category::findByPk($id);
            } catch (\Exception $err) {
            return null;
        }
    }

    function addCategory($category)
    {
        $dbCategory = new Category();
        foreach ($category as $key => $value){
            $dbCategory->$key = $value;
        }
        return $dbCategory->save();
    }

    function updateCategory($category)
    {
        $dbCategory = Category::findByPk($category[Category::getModelFileds()['id']]);
        if(isset($dbCategory) && !empty($book)) {
            foreach ($category as $key => $value) {
                $dbCategory->$key = $value;
            }
            return $dbCategory->save();
        }
        return 0;
    }

    function deleteCategory($id)
    {
        /*$dbCategory = Category::findByPk($id);
        if(isset($dbCategory)){
            $dbCategory->delete();
        }*/
    }

    function findPublishers()
    {
        return Publisher::findAll(null, null);
    }

    function findPublisherById($id)
    {
        return Publisher::findByPk($id);
    }

    function addPublisher($publisher)
    {
        $dbPublisher = new Publisher();
        foreach ($publisher as $key => $value){
            $dbPublisher->$key = $value;
        }
        return $dbPublisher->save();
    }

    function updatePublisher($publisher)
    {
        $dbPublisher = Publisher::findByPk($publisher[Publisher::getModelFileds()['id']]);
        if(isset($dbPublisher) && !empty($book)) {
            foreach ($publisher as $key => $value) {
                $dbPublisher->$key = $value;
            }
            return $dbPublisher->save();
        }
        return 0;
    }

    function deletePublisher($id)
    {
        // TODO: Implement deletePublisher() method.
    }

    function findAuthors()
    {
        return Author::findAll(null, null);
    }

    function findAuthorById($id)
    {
        return Author::findByPk($id);
    }

    function addAuthor($author)
    {
        $dbAuthor = new Author();
        foreach ($author as $key => $value){
            $dbAuthor->$key = $value;
        }
        return $dbAuthor->save();
    }

    function updateAuthor($author)
    {
        $dbAuthor = Author::findByPk($author[Author::getModelFileds()['id']]);
        if(isset($dbAuthor) && !empty($book)) {
            foreach ($author as $key => $value) {
                $dbAuthor->$key = $value;
            }
            return $dbAuthor->save();
        }
        return 0;
    }

    function deleteAuthor($id)
    {
        // TODO: Implement deleteAuthor() method.
    }

    function findBookById($id)
    {
        $resBook = null;
        $book = Book::findByPkAndPublisherName($id);
        if(isset($book) && !empty($book)){
            $resBook = [];
            $resBook["data"] = $book[0];
            $resBook["authors"] = BooksAuthors::findAuthorsFromBook($resBook['data']['id']);
            $resBook["photos"] = BooksPhotos::findByIdBook($resBook['data']['id']);
            $resBook["breadcrump"] = $this->_getParentCategory($resBook['data']['idCategory']);
        }
        return $resBook;
    }

    function findBooksByCategoryId($id)
    {
        return Book::findByCategoryId($id);
    }

    function addBook($book)
    {
        $dbBook = new Book();
        foreach ($book as $key => $value){
            $dbBook->$key = $value;
        }
        return $dbBook->save();
    }

    function updateBook($book)
    {
        $dbBook = Book::findByPk($book[Book::getModelFileds()['id']]);
        if(isset($dbBook) && !empty($book)) {
            foreach ($book as $key => $value) {
                $dbBook->$key = $value;
            }
            return $dbBook->save();
        }
        return 0;
    }

    function addAuthorToBook($booksAuthors)
    {
        $dbBookAuthors = new BooksAuthors();
        foreach ($booksAuthors as $key => $value){
            $dbBookAuthors->$key = $value;
        }
        return $dbBookAuthors->save();
    }

    function addPhotoToBook($booksPhotos)
    {
        $dbBookPhotos = new BooksPhotos();
        foreach ($booksPhotos as $key => $value){
            $dbBookPhotos->$key = $value;
        }
        return $dbBookPhotos->save();
    }

    function deleteBook($id)
    {
        // TODO: Implement deleteBook() method.
    }

    function findById($id, $callback)
    {
        return User::findByPk($id);
    }

    function findByName($name, $callback)
    {
        $condition = User::getModelFileds()['displayName'] . " like ':name'";
        $params = [':name'=>$name];
        return User::find($condition, $params);
    }

    function getBreadcramp($baseCategoryId)
    {
        return $this->_getParentCategory($baseCategoryId);
    }
}