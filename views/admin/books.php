<div class="col-md-12">
    <button class="btn btn-primary hidden" id="openModalDialogBtn" type="button" data-toggle="modal"
            data-target="#formCategory" data-whatever="@mdo">Open
    </button>
    <div class="modal fade" id="formCategory" tabindex="-1" role="dialog" aria-labelledby="formCategoryLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="formCategoryLabel">Add category</h4>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <form id="category-form">
                        <div class="form-group">
                            <label class="form-control-label" for="recipient-name">Title: </label>
                            <input class="form-control" id="form-book-title" type="text" name="name"/></div>
                        <div class="form-group"><label class="form-control-label" for="recipient-name">Year
                                Publisher:</label><input class="form-control" id="form-book-year" type="text"
                                                         name="yearPublisher"/></div>
                        <div class="form-group"><label class="form-control-label"
                                                       for="recipient-name">Publisher:</label><select
                                    class="form-control" id="form-book-id-pub" type="text" name="idPublisher">
                                <?php foreach ($publishers as $publisher) { ?>
                                    <option value='<?= $publisher['id'] ?>'><?= $publisher['name'] ?></option>
                                <?php } ?>
                            </select></div>
                        <input id="form-book-id"
                               type="hidden" name="id"/><input id="form-book-id-cat" type="hidden"
                                                               name="idCategory"/><input id="form-type" type="hidden"/>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" id="btnClose" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" id="btnSend" type="button">Send</button>
                </div>
            </div>
        </div>
    </div>
    <h1>Index Categories</h1><br/>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" id="broadcast">
            <li class="breadcrumb-item active" aria-current="page" data-id="null" data-name="All">All</li>
        </ol>
    </nav>
    <div><a class="btn btn-primary btn-fw" id="create" href="#" data-id="null" data-name="All">Add book to <span
                    class="current-category" id="current-category">All</span></a></div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th></th>
            </tr>
            </thead>
            <tbody id="category-body">
            <?php if (isset($categories) && count($categories) > 0) {
                foreach ($categories as $category) { ?>
                    <tr data-id="<?= $category['id'] ?>" data-name="<?= $category['name'] ?>"
                        data-id-parent="<?= $category['idParentCategory'] ?>">
                        <td><?= $category['id'] ?></td>
                        <td><?= $category['name'] ?></td>
                        <td><a class="childs" href="#" data-id="<?= $category['id'] ?>"
                               data-name="<?= $category['name'] ?>">Childs</a></td>
                    </tr>
                <?php }
            } else { ?>
                <tr>Not found categories</tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="table-responsive">
        <h2>Books to category <span class="current-category">All</span></h2>
        <table class="table table-hover">
            <thead>
            <tr>
                <th>Id</th>
                <th>Title</th>
                <th>Year Publisher</th>
                <th>Publisher</th>
                <th>Category</th>
                <th></th>
            </tr>
            </thead>
            <tbody id="book-body"></tbody>
        </table>
    </div>
</div>
<script src="<?= PUBLIC_URL ?>admin/views/books/script.js"></script>
