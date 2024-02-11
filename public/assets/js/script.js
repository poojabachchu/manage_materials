$(document).ready(function () {
    //     $(".nav-item").on("click", function (e) {
    //         $(this).siblings().removeClass("active");
    //         $(this).addClass("active");
    //     });

    $(".datatable").dataTable();
});

//Get the confirmation before deleting a record from the db
function confirmDelete(id, url) {
    if (confirm("Do you want to delete the selected category")) {
        $.ajax({
            url: url,
            data: {
                id: id,
            },
            success: function (result) {
                let data = JSON.parse(result);
                if (data.msg == "Success") {
                    $(".container").before(
                        '<div class="alert alert-success">Data deleted sucessfully!</div>'
                    );
                    reloadFrame();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            },
        });
    }
}

//Reload the page after 1 sec
function reloadFrame() {
    setTimeout(function () {
        location.reload();
    }, 1000);
}

//Get the list of materials based on selected category
function getMaterials(material_id = "") {
    let category_id = $("#category option:selected").attr("data-id");
    console.log(category_id);
    $.ajax({
        url: "/getMaterials",
        data: {
            category_id: category_id,
        },
        dataType: "json",
        success: function (result) {
            if (result.msg == "Success") {
                let html = "<option value=''>Select</option>";
                let selected = "";
                for (let i = 0; i < result["materials"].length; i++) {
                    selected =
                        material_id == result["materials"][i]["material_id"]
                            ? "selected"
                            : "";
                    html += `<option value="${result["materials"][i]["material_id"]}" ${selected}>${result["materials"][i]["material_name"]}</option>`;
                }

                $("#material_name").html(html);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
        },
    });
}
