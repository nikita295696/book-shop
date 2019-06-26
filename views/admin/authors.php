<div class="col-md-12"><button class="btn btn-primary hidden" id="openModalDialogBtn" type="button" data-toggle="modal" data-target="#formAuthor" data-whatever="@mdo">Open</button>
    <div class="modal fade" id="formAuthor" tabindex="-1" role="dialog" aria-labelledby="formAuthorLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="formAuthorLabel">Add Author</h4><button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
                <div class="modal-body">
                    <form id="author-form">
                        <div class="form-group"><label class="form-control-label" for="recipient-name">Name:</label><input class="form-control" id="form-auth-name" type="text" name="name" /></div><input id="form-auth-id" type="hidden" name="id" /><input id="form-type" type="hidden"
                        /></form>
                </div>
                <div class="modal-footer"><button class="btn btn-secondary" id="btnClose" type="button" data-dismiss="modal">Close</button><button class="btn btn-primary" id="btnSend" type="button">Send</button></div>
            </div>
        </div>
    </div>
    <h1>Index Author</h1><br/>
    <div><a class="btn btn-primary btn-fw" id="create" href="#" data-id="null" data-name="All">Add author</a></div>
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
            <?php if(isset($authors) && count($authors) > 0){
                foreach($authors as $author) { ?>
                    <tr data-id="<?=$author['id']?>" data-name="<?=$author['name']?>">
                        <td><?=$author['id']?></td>
                        <td><?=$author['name']?></td>
                        <td><a class="update" href="#">Update </a><span>| </span><a class="delete" href="#">Delete</a></td>
                    </tr>
                <?php }
            }else{ ?>
                <tr>Not found authors</tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<script src="<?=PUBLIC_URL?>admin/views/authors/script.js"></script>