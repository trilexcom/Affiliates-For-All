function refresh_page() {
    window.location.href = window.location.href;
}

function checkName(proposedName) {
    if(proposedName.match(/[^0-9A-Za-z_.-]/)) {
        show("#illegalchar");
        return false;
    }

    return true;
}

function save(id) {
    if(!checkName($("#name_" + id).val()))
        return false;

    getJSON("json-alterbanner.php", {
            "id": id,
            "name": $("#name_" + id).val(),
            "linktarget": $("#linktarget_" + id).val(),
            "enabled": $("#enabled_" + id).is("[checked]") ? "1" : "0"
        }, function(result) {
            if(result == "duplicate") {
                show("#duplicate");
            } else {
                show("#banneraltered", refresh_page);
            }
        });

    return false;
}

function deleteBanner(id) {
    $("#confirmdelete").show().dialog({
        buttons: {
            "Yes": function() {
                $("#confirmdelete").dialog("close");
                getJSON("json-delbanner.php", { "id": id }, refresh_page);
            },

            "No": function() {
                $("#confirmdelete").dialog("close");
            }
        }
    });

    return false;
}

$(function() {
    $("#tabs > ul").tabs();

    var submitBoxes = $(".bannersubmit");
    if(submitBoxes.length == 0)
        $("#tabs > ul").tabs("select", 1).tabs("disable", 0);
    
    submitBoxes.map(function() {
        var id = $(this).find("input").attr("id").replace(/.*_/, "");

        $(this).find("input:first-child").click(function() {
            return save(id);
        });

        $(this).find("input:nth-child(2)").click(function() {
            return deleteBanner(id);
        });
    });

    $("#upload").click(function() {
        if(!checkName($("#new_name").val()))
            return false;

        return true;
    });

    var start = $("#start").text();
    if(start == "duplicate") {
        $("#tabs > ul").tabs("select", 1);
        show("#duplicate");
    } else if(start == "success") {
        show("#success");
    }
});
