const typeFormCreate = "create";
const typeFormUpdate = "update";

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
    $(".current-category").text(dataName);
    $(".current-category").parent().attr("data-id", dataId);
    $(".current-category").parent().attr("data-name", dataName);
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
            tr.append(tdOptions);
            $("#category-body").append(tr);
        }
    } else {
        $("#category-body").append($("<tr>").attr("colspan", "3").append($("<td>").text("Not found")));
    }

    $("#book-body").html("");

    if (json && json["books"].length > 0) {
        for (var book of json["books"]) {
            var id = book.id;
            var tr = $("<tr>");
            //data-id=category.id, data-name=category.name, data-id-parent=category.idParentCategory
            console.log(book);
            tr.attr("data-id", book.id).attr("data-title", book.name).attr("data-year", book.yearPublisher).attr("data-id-cat", book.id_category).attr("data-id-pub", book.id_publisher);
            tr.append($("<td>").text(id));
            tr.append($("<td>").text(book.name));
            tr.append($("<td>").text(book.yearPublisher));
            tr.append($("<td>").text(book.publisherName));
            tr.append($("<td>").text(book.categoryName));
            var tdOptions = $("<td>");
            tdOptions.append($("<a>").attr("href", `#`).attr("data-id", id).attr("data-title", book.title).addClass("update").text("Update"));
            tdOptions.append($("<span>").text(" | "));
            tdOptions.append($("<a>").attr("href", `${BASE_URL}/admin/booksview/${id}`).attr("data-title", book.title).text("View"));
            tr.append(tdOptions);
            $("#book-body").append(tr);
        }
    } else {
        $("#book-body").append($("<tr>").attr("colspan", "4").append($("<td>").text("Not found")));
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

    $("a.update").click(function (e) {
        const tr = $(this).parent().parent();
        $("#form-book-id").val(tr.attr("data-id"));
        $("#form-book-title").val(tr.attr("data-title"));
        $("#form-book-id-cat").val(tr.attr("data-id-cat"));
        $("#form-book-year").val(tr.attr("data-year"));
        $("#form-book-id-pub").val(tr.attr("data-id-pub"));
        $("#form-type").val(typeFormUpdate);

        $("#formCategoryLabel").text("Update. Book " + tr.attr("data-title"));
        $("#openModalDialogBtn").click();
    });

    $("a#create").click(function (e) {
        $("#form-book-id").val("");
        $("#form-book-title").val("");
        $("#form-book-id-cat").val($("#create").attr("data-id"));
        $("#form-book-year").val("");
        //$("#form-book-id-pub").val();
        $("#form-type").val(typeFormCreate);

        $("#formCategoryLabel").text("Create Book");
        $("#openModalDialogBtn").click();
    });

}

addEventHandlers();



$("#btnSend").click(function (e) {
    const type = $("#form-type").val();
    var url = `${URL_API}/books/`;
    var method = "";
    var additionalParams = "";
    switch (type) {
        case typeFormCreate:
            method = "POST";
            break;
        case typeFormUpdate:
            url += `/${$("#form-book-id").val()}`; 
            method = "POST";
            additionalParams += "&method=put";
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
            data: $("#category-form").serialize() + additionalParams,
            success: function (json) {
                console.log(json);
                if (json) {
                    var thisLi = $("li.breadcrumb-item.active:last");
                    const dataId = thisLi.attr("data-id");
                    const dataName = thisLi.attr("data-name");
                    updateTable(thisLi, dataId, dataName);
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