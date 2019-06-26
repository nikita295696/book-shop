const typeFormCreate = "create";
const typeFormUpdate = "update";

function updateTable(){
    var url = `${URL_API}/publishers/`;
    
        $.ajax({
            method: "GET",
            url: url,
            success: function (json) {
                generateTable(json);
            },
            error: function (err) {

            }
        });
}

function generateTable(json) {
    var bodyTable = "#publisher-body";
    $(bodyTable).html("");
    if (json && json.length > 0) {
        for (var publisher of json) {
            var id = publisher.id;
            var tr = $("<tr>");
            //data-id=category.id, data-name=category.name, data-address=publisher.address, data-phone=publisher.phone
            console.log(publisher);
            tr.attr("data-id", publisher.id).attr("data-name", publisher.name).attr("data-address", publisher.address).attr("data-phone", publisher.phone);
            tr.append($("<td>").text(id));
            tr.append($("<td>").text(publisher.name));
            tr.append($("<td>").text(publisher.address));
            tr.append($("<td>").text(publisher.phone));
            var tdOptions = $("<td>");
            tdOptions.append($("<a>").attr("href", `#`).addClass("update").text("Update"));
            tdOptions.append($("<span>").text(" | "));
            tdOptions.append($("<a>").attr("href", `#`).addClass("delete").text("Delete"));
            tr.append(tdOptions);
            $(bodyTable).append(tr);
        }
    } else {
        $(bodyTable).append($("<tr>").attr("colspan", "5").append($("<td>").text("Not found")));
    }
    addEventHandlers();
}

function addEventHandlers() {
    
    $("a.update").click(function (e) {
        const tr = $(this).parent().parent();
        $("#form-pub-id").val(tr.attr("data-id"));
        $("#form-pub-name").val(tr.attr("data-name"));
        $("#form-pub-address").val(tr.attr("data-address"));
        $("#form-pub-phone").val(tr.attr("data-phone"));
        
        $("#form-type").val(typeFormUpdate);

        $("#formPublisherLabel").text("Update publisher");
        $("#openModalDialogBtn").click();
    });

    $("a#create").click(function (e) {
        $("#form-pub-id").val("");
        $("#form-pub-name").val("");
        $("#form-pub-address").val("");
        $("#form-pub-phone").val("");
        
        $("#form-type").val(typeFormCreate);

        $("#formPublisherLabel").text("Create publisher");
        $("#openModalDialogBtn").click();
    });
    
}

addEventHandlers();



$("#btnSend").click(function (e) {
    const type = $("#form-type").val();
    var url = `${URL_API}/publishers/`;
    var additionalParams = "";
    var method = "";
    switch (type) {
        case typeFormCreate:
            method = "POST";
            break;
        case typeFormUpdate:
            url += `/${$("#form-pub-id").val()}`;
            method = "POST";
            additionalParams += "&method=put";
            break;
    }

    $.ajax({
        url: url,
        method: method,
        data: $("#publisher-form").serialize() + additionalParams,
        success: function(json){
            console.log(json);
            if(json){
                updateTable();
                //$(".close").click();
            }else{
                console.log("failed");
            }
        },
        error: function(err){

        }
    });
});