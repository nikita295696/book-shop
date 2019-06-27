const typeFormCreate = "create";
const typeFormUpdate = "update";

const bookId = $("#form-book-id").val();

function updateAuthors(){
    $.ajax({
        method: "GET",
        url: `${URL_API}/books/${bookId}`,
        success: function (json) {
            generateTableAuthors(json);
        },
        error: function (err) {

        }
    });
}

function updatePhotos(){
    $.ajax({
        method: "GET",
        url: `${URL_API}/books/${bookId}`,
        success: function (json) {
            generateTablePhotos(json);
        },
        error: function (err) {

        }
    });
}

function generateTableAuthors(json) {
    var bodyTable = "#author-body";
    $(bodyTable).html("");
    if (json['authors'] && json["authors"].length > 0) {
        for (var author of json["authors"]) {
            var id = author.id;
            var tr = $("<tr>");
            console.log(author);
            tr.attr("data-id", json['data'].id).attr("data-name", author.name).attr("data-author-id", author.id);
            tr.append($("<td>").text(id));
            tr.append($("<td>").text(author.name));
            //tr.append($("<td>").append());
            var tdOptions = $("<td>");
            tdOptions.append($("<a>").attr("href", "#").attr("data-id", json.data.id).attr("data-name", author.name).attr("data-author-id", author.id).addClass('deleteAuthor').text("Delete"));
            tr.append(tdOptions);
            $(bodyTable).append(tr);
        }
    } else {
        $(bodyTable).append($("<tr>").attr("colspan", "2").append($("<td>").text("Not found")));
    }
    addEventHandlers();
}

function generateTablePhotos(json) {
    var bodyTable = "#photo-body";
    $(bodyTable).html("");
    if (json['photos'] && json['photos'].length > 0) {
        for (var photo of json['photos']) {
            var id = photo.id;
            var tr = $("<tr>");
            console.log(photo);
            tr.attr("data-path", photo.name).attr("data-id", json.data.id);
            tr.append($("<td>").append($("<img>").attr("src", photo.path)));
            tr.append($("<td>").text(photo.path));
            var tdOptions = $("<td>");
            tdOptions.append($("<a>").attr("href", "#").attr("data-id", json.data.id).addClass('deletePhoto').text("Delete"));
            tr.append(tdOptions);
            $(bodyTable).append(tr);
        }
    } else {
        $(bodyTable).append($("<tr>").attr("colspan", "2").append($("<td>").text("Not found")));
    }
    addEventHandlers();
}

function updateTable(thisLi, dataId, dataName) {
    var url = `${URL_API}/bookschilds`;

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
    //$(".current-category").text(dataName);
    $("#category").attr("data-id", dataId);
    $("#category").attr("data-name", dataName);
    $("#category-body").html("");
    if (json && json["categories"].length > 0) {
        for (var category of json["categories"]) {
            var id = category.id;
            var tr = $("<tr>");
            //data-id=category.id, data-name=category.name, data-id-parent=category.idParentCategory
            console.log(category);
            tr.attr("data-id", category.id).attr("data-name", category.name).attr("data-id-parent", category["id_parent_category"]);
            tr.append($("<td>").text(id));
            tr.append($("<td>").text(category.name));
            var tdOptions = $("<td>");
            tdOptions.append($("<a>").attr("href", `#`).attr("data-id", id).attr("data-name", category.name).addClass("childs").text("Childs"));
            tdOptions.append($("<span>").text(" | "));
            tdOptions.append($("<a>").attr("href", `#`).attr("data-id", id).attr("data-name", category.name).addClass("select").text("Select this"));
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
            url: `${URL_API}/bookschilds/${dataId}`,
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

    $("a.select").click(function (e) {
        const tr = $(this).parent().parent();
        $("#form-book-id-cat").val(tr.attr("data-id"));
        $("#form-type").val(typeFormUpdate);

        $("#category").attr("data-id", tr.attr("data-id"));
        $("#category").attr("data-name", tr.attr("data-name"));

        $("#btnSend").click();
    });

    $("a.deleteAuthor").click(function (e) {
        const tr = $(this).parent().parent();

        var bookId = tr.attr("data-id");
        var authorId = tr.attr("data-author-id");
        var url = `${URL_API}/books/${bookId}/${authorId}`;

        $.ajax({
            url: url,
            method: "DELETE",
            success: function(json){
                console.log(json);
                if(json){
                    updateAuthors();
                }else{
                    console.log("failed");
                }
            },
            error: function(err){

            }
        });
    });

    $("a.deletePhoto").click(function (e) {
        const tr = $(this).parent().parent();

        var bookId = tr.attr("data-id");
        var path = tr.attr("data-path");
        var url = `${URL_API}/bookphoto/${bookId}`;

        $.ajax({
            url: url,
            method: "POST",
            data: `path=${path}&method=delete`,
            success: function(json){
                console.log(json);
                if(json){
                    updatePhotos();
                }else{
                    console.log("failed");
                }
            },
            error: function(err){

            }
        });
    });

}

addEventHandlers();

$("#btnSend").click(function (e) {
    const type = $("#form-type").val();
    var url = `${URL_API}/books/`;
    var method = "";
    switch (type) {
        case typeFormCreate:
            method = "POST";
            break;
        case typeFormUpdate:
            url += `${$("#form-book-id").val()}`;
            method = "PUT";
            break;
    }
    var idCat = $("#form-book-id-cat").val();
    if (idCat == "null" || idCat == "") {
        alert("Select a category");
    }
    else {

        $.ajax({
            url: url,
            method: method,
            data: $("#book-form").serialize(),
            success: function (json) {
                console.log(json);
                if (json) {
                    /*var thisLi = $("li.breadcrumb-item.active:last");
                    const dataId = thisLi.attr("data-id");
                    const dataName = thisLi.attr("data-name");
                    updateTable(thisLi, dataId, dataName);*/

                    $("#form-book-id-cat").val($("#category").attr("data-id"));
                    $("#category-name").val($("#category").attr("data-name"));
                    //$(".close").click();
                } else {
                    console.log("failed");
                }
            },
            error: function (err) {

            }
        });
    }
});

$("#btnAddAuthor").click(function (e) {
    var url = `${URL_API}/books/${bookId}/${$("#form-add-author-id").val()}`;

    $.ajax({
        url: url,
        method: "POST",
        data: $("#book-form").serialize(),
        success: function (json) {
            console.log(json);
            if (json) {
                updateAuthors();
            } else {
                console.log("failed");
            }
        },
        error: function (err) {

        }
    });

});

$("#btnAddPhoto").click(function (e) {
    var url = `${URL_API}/bookphoto/${bookId}`;
    var formData = new FormData;

    formData.append('file', $("#uploadFile").prop('files')[0]);
    $.ajax({
        url: url,
        method: "POST",
        contentType: false,
        processData: false,
        data: formData,
        success: function (json) {
            console.log(json);
            if (json) {
                updatePhotos();
            } else {
                console.log("failed");
            }
        },
        error: function (err) {

        }
    });

});