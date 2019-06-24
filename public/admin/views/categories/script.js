const typeFormCreate = "create";
const typeFormUpdate = "update";

function updateTable(thisLi, dataId, dataName){
    var url = `${URL_API}/categories/childs`;

        if (dataId != "null") {
            url += "/" + dataId;
        }
        $.ajax({
            method: "GET",
            url: url,
            success: function (json) {
                thisLi.nextAll().remove();
                thisLi.remove();
                generateTable(json, dataId, dataName);
            },
            error: function (err) {

            }
        });
}

function generateTable(json, dataId, dataName) {
    $("#current-category").text(dataName);
    $("#current-category").parent().attr("data-id", dataId);
    $("#current-category").parent().attr("data-name", dataName);
    $("#category-body").html("");
    if (json && json.length > 0) {
        for (var category of json) {
            var id = category.id;
            var tr = $("<tr>");
            //data-id=category.id, data-name=category.name, data-id-parent=category.idParentCategory
            console.log(category);
            tr.attr("data-id", category.id).attr("data-name", category.name).attr("data-id-parent", category["id_parent_category"]);
            tr.append($("<td>").text(id));
            tr.append($("<td>").text(category.name));
            var tdOptions = $("<td>");
            tdOptions.append($("<a>").attr("href", `#`).addClass("update").text("Update"));
            tdOptions.append($("<span>").text(" | "));
            tdOptions.append($("<a>").attr("href", `#`).attr("data-id", id).attr("data-name", category.name).addClass("childs").text("Childs"));
            tr.append(tdOptions);
            $("#category-body").append(tr);
        }
    } else {
        $("#category-body").append($("<tr>").attr("colspan", "3").append($("<td>").text("Not found")));
    }

    /**
     * li.breadcrumb-item.active(aria-current='page')
     */

    $("li.breadcrumb-item.active").removeClass("active");
    var lists = $("li.breadcrumb-item");
    $("#broadcast").html("");
    for (var li of lists) {
        $("#broadcast").append($("<li>").attr("data-id", li.getAttribute("data-id")).attr("data-name", li.getAttribute("data-name")).addClass("breadcrumb-item").addClass("active").append($("<a>").attr("href", "#").text(li.innerText)));
    }
    $("#broadcast").append($("<li>").attr("data-id", dataId).attr("data-name", dataName).addClass("breadcrumb-item").addClass("active").attr("aria-current", "page").text(dataName));

    addEventHandlers();
}

function addEventHandlers() {
    $("a.childs").click(function (e) {
        const dataId = $(this).attr("data-id");
        const dataName = $(this).attr("data-name");
        $.ajax({
            method: "GET",
            url: `${URL_API}/categories/childs/${dataId}`,
            success: function (json) {
                generateTable(json, dataId, dataName);
            },
            error: function (err) {

            }
        });
    });

    $("li.breadcrumb-item a").click(function (e) {
        var thisLi = $(this).parent();
        const dataId = $(this).parent().attr("data-id");
        const dataName = $(this).parent().attr("data-name");
        updateTable(thisLi, dataId, dataName);
    });

    $("a.update").click(function (e) {
        const tr = $(this).parent().parent();
        $("#form-cat-id").val(tr.attr("data-id"));
        $("#form-cat-name").val(tr.attr("data-name"));
        $("#form-cat-parent").val(tr.attr("data-id-parent"));
        $("#form-type").val(typeFormUpdate);

        $("#formCategoryLabel").text("Update. Parent: " + tr.attr("data-name"));
        $("#openModalDialogBtn").click();
    });

    $("a#create").click(function (e) {
        $("#form-cat-id").val("");
        $("#form-cat-name").val("");
        $("#form-cat-parent").val($("#create").attr("data-id"));
        $("#form-type").val(typeFormCreate);

        $("#formCategoryLabel").text("Create. Parent: " + $("#create").attr("data-name"));
        $("#openModalDialogBtn").click();
    });
    
}

addEventHandlers();



$("#btnSend").click(function (e) {
    const type = $("#form-type").val();
    var url = `${URL_API}/categories/`;
    var method = "";
    switch (type) {
        case typeFormCreate:
            method = "POST";
            break;
        case typeFormUpdate:
            url += `/${$("#form-cat-id").val()}`;
            method = "PUT";
            break;
    }

    $.ajax({
        url: url,
        method: method,
        data: $("#category-form").serialize(),
        success: function(json){
            console.log(json);
            if(json){
                var thisLi = $("li.breadcrumb-item.active:last");
                const dataId = thisLi.attr("data-id");
                const dataName = thisLi.attr("data-name");
                updateTable(thisLi, dataId, dataName);
                //$(".close").click();
            }else{
                console.log("failed");
            }
        },
        error: function(err){

        }
    });
});