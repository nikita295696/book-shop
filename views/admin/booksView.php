<?php
/** @var array $book */
/** @var array $publishers */
/** @var array $authors */
?>
<div class="col-md-12">
    <div class="modal fade" id="formUpdateCategory" tabindex="-1" role="dialog" aria-labelledby="formCategoryLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="formCategoryLabel">Update category</h4><button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
                <div class="modal-body"><span class="hidden" id="category" data-id="null" data-name="All"></span>
                    <?=  \models\widjets\BreadcrampWidjet::render($book['breadcrump'])?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody id="category-body"></tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer"><button class="btn btn-secondary" id="btnClose" type="button" data-dismiss="modal">Close</button></div>
            </div>
        </div>
    </div>
    <form id="book-form">
        <div class="form-group"><label class="form-control-label" for="recipient-name">Id:</label><input class="form-control" id="form-book-id" type="text" value="<?=$book['data']['id']?>" disabled="disabled" /></div>
        <div class="form-group"><label class="form-control-label" for="recipient-name">Title:</label><input class="form-control" id="form-book-title" type="text" value="<?=$book['data']['name']?>" disabled="disabled" /></div>
        <div class="form-group"><label class="form-control-label" for="recipient-name">Year Publisher:</label><input class="form-control" id="form-book-year" type="text" value="<?=$book['data']['yearPublisher']?>" disabled="disabled" /></div>
        <div class="form-group"><label class="form-control-label" for="recipient-name">Publisher:</label>
            <select class="form-control" id="form-book-id-pub" value="<?=$book['data']['idPublisher']?>" disabled="disabled">
                <?php foreach ($publishers as $publisher) { ?>
                    <option value='<?= $publisher['id'] ?>'><?= $publisher['name'] ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group"><label class="form-control-label"></label><input class="form-control" id="category-name" type="text" value="<?=$book['data']['categoryName']?>" disabled="disabled" /></div>
        <div class="form-group"><button class="btn btn-primary" id="openCategoryUpdateModel" type="button" data-toggle="modal" data-target="#formUpdateCategory" data-whatever="@mdo">Update category</button></div>

        <input id="form-book-id-cat" type="hidden" name="idCategory" />
        <input class="form-control" id="form-book-id" type="hidden" name="id" value="<?=$book['data']['id']?>" />
        <input class="form-control" type="hidden" name="name" value="<?=$book['data']['name']?>" />
        <input class="form-control" type="hidden" name="yearPublisher" value="<?=$book['data']['yearPublisher']?>"/>
        <input class="form-control" type="hidden" name="idPublisher" value="<?=$book['data']['idPublisher']?>" />
        <input id="form-type" type="hidden" />
        <button class="btn btn-primary hidden" id="btnSend" type="button">Send</button>
    </form>
    <h3>Authors book</h3>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th></th>
            </tr>
            </thead>
            <tbody id="author-body">
            <?php if(is_array($book['authors']) && count($book['authors']) > 0) {
                foreach ($book['authors'] as $author) { ?>
                    <tr data-id="<?=$book['data']['id']?>" data-name="<?=$author['name']?>" data-author-id="<?=$author['id']?>">
                        <td><?=$author['id']?></td>
                        <td><?=$author['name']?></td>
                        <td>
                            <a class="deleteAuthor" href="#" data-id="<?=$book['data']['id']?>" data-author-id="<?=$author['id']?>">Delete</a>
                        </td>
                    </tr>
                <?php } ?>

            <?php }else{?>
                <tr><td colspan="2">Not found authors</td></tr>
            <?php } ?>
            </tbody>
        </table>
    </div>

    <form id="add-author">
        <div class="form-group">
            <label class="form-control-label" for="recipient-name">Authors:</label>
            <select class="form-control" id="form-add-author-id">
                <?php foreach ($authors as $author) { ?>
                    <option value="<?=$author['id']?>"><?=$author['name']?></option>
                <?php } ?>
            </select>
        </div>
        <button class="btn btn-primary" id="btnAddAuthor" type="button">Add author</button>
    </form>

    <h3>Photos book</h3>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th></th>
            </tr>
            </thead>
            <tbody id="photo-body">
            <?php if(is_array($book['photos']) && count($book['photos']) > 0) {
                foreach ($book['photos'] as $photo) { ?>
                    <tr data-id="<?=$book['data']['id']?>" data-path="<?=$photo['path']?>">
                        <td><img src="<?=$photo['path']?>"></td>
                        <td><?=$photo['path']?></td>
                        <td><a class="deletePhoto" href="#" data-id="<?=$book['data']['id']?>">Delete</a></td>
                    </tr>
                <?php } ?>

            <?php }else{?>
                <tr><td colspan="2">Not found photos</td></tr>
            <?php } ?>
            </tbody>
        </table>
    </div>

    <form id="add-photo" enctype="multipart/form-data">
        <div class="form-group">
            <label class="form-control-label" for="image">
                Choose file
                <input class="form-control" type="file" id="uploadFile"/>
            </label>
        </div>
        <button class="btn btn-primary" id="btnAddPhoto" type="button">Add Photo</button>
    </form>

</div>
<script src="<?=PUBLIC_URL?>admin/views/books/view_script.js"></script>