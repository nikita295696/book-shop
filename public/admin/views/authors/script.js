const typeFormCreate = "create";
const typeFormUpdate = "update";

function updateTable(){
    var url = `${URL_API}/authors/`;
    
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
    var bodyTable = "#author-body";
    $(bodyTable).html("");
    if (json && json.length > 0) {
        for (var author of json) {
            var id = author.id;
            var tr = $("<tr>");
            console.log(author);
            tr.attr("data-id", author.id).attr("data-name", author.name);
            tr.append($("<td>").text(id));
            tr.append($("<td>").text(author.name));
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
        $("#form-auth-id").val(tr.attr("data-id"));
        $("#form-auth-name").val(tr.attr("data-name"));
        
        $("#form-type").val(typeFormUpdate);

        $("#formAuthorLabel").text("Update author");
        $("#openModalDialogBtn").click();
    });

    $("a#create").click(function (e) {
        $("#form-auth-id").val("");
        $("#form-auth-name").val("");
        
        $("#form-type").val(typeFormCreate);

        $("#formAuthorLabel").text("Create author");
        $("#openModalDialogBtn").click();
    });
    
}

addEventHandlers();



$("#btnSend").click(function (e) {
    const type = $("#form-type").val();
    var url = `${URL_API}/authors/`;
    var method = "";
    var additionalParams = "";
    switch (type) {
        case typeFormCreate:
            method = "POST";
            break;
        case typeFormUpdate:
            url += `/${$("#form-auth-id").val()}`;
            method = "POST";
            additionalParams += "&method=put";
            break;
    }

    $.ajax({
        url: url,
        method: method,
        data: $("#author-form").serialize() + additionalParams,
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