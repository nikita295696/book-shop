<div class="col-md-12"><button class="btn btn-primary hidden" id="openModalDialogBtn" type="button" data-toggle="modal" data-target="#formPublisher" data-whatever="@mdo">Open</button>
    <div class="modal fade" id="formPublisher" tabindex="-1" role="dialog" aria-labelledby="formPublisherLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="formPublisherLabel">Add Publisher</h4><button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button></div>
                <div class="modal-body">
                    <form id="publisher-form">
                        <div class="form-group"><label class="form-control-label" for="recipient-name">Name:</label><input class="form-control" id="form-pub-name" type="text" name="name" /></div>
                        <div class="form-group"><label class="form-control-label" for="recipient-name">Address:</label><input class="form-control" id="form-pub-address" type="text" name="address" /></div>
                        <div class="form-group"><label class="form-control-label" for="recipient-name">Phone:</label><input class="form-control" id="form-pub-phone" type="text" name="phone" /></div><input id="form-pub-id" type="hidden" name="id" /><input id="form-type" type="hidden"
                        /></form>
                </div>
                <div class="modal-footer"><button class="btn btn-secondary" id="btnClose" type="button" data-dismiss="modal">Close</button><button class="btn btn-primary" id="btnSend" type="button">Send</button></div>
            </div>
        </div>
    </div>
    <h1>Index Publisher</h1><br/>
    <div><a class="btn btn-primary btn-fw" id="create" href="#" data-id="null" data-name="All">Add publisher</a></div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Address</th>
                <th>Phone</th>
                <th></th>
            </tr>
            </thead>
            <tbody id="publisher-body">
            <?php if(isset($publishers) && count($publishers) > 0){
                foreach($publishers as $publisher) { ?>
                    <tr data-id="<?=$publisher['id']?>" data-name="<?=$publisher['name']?>" data-address="<?=$publisher['address']?>" data-phone="<?=$publisher['phone']?>">
                        <td><?=$publisher['id']?></td>
                        <td><?=$publisher['name']?></td>
                        <td><?=$publisher['address']?></td>
                        <td><?=$publisher['phone']?></td>
                        <td><a class="update" href="#">Update </a><span>| </span><a class="delete" href="#">Delete</a></td>
                    </tr>
                <?php }
            }else{ ?>
                <tr>Not found publishers</tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<script src="<?=PUBLIC_URL?>admin/views/publishers/script.js"></script>