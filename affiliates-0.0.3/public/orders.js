var currentPage, maxPages;

function pad(digits, string) {
    // Make sure it really is a string:
    string = "" + string;
    while(string.length < digits)
        string = "0" + string;

    return string;
}

function formatDate(date) {
    return "" + date.getFullYear() + pad(2, date.getMonth() + 1) +
        pad(2, date.getDate());
}

function showPage(page) {
    currentPage = page;
    $.getJSON("data-orders.php", {
            "format": "json",
            "start": formatDate($("#from").datepicker("getDate")),
            "end": formatDate($("#to").datepicker("getDate")),
            "page": currentPage - 1
        }, function(json) {
            $("#restable").html(json.html);
            maxPages = json.pages;
            $("#currentpage").text(page);
            $("#maxpages").text(maxPages);

            var i, html = "";
            for(i = 1; i <= maxPages; i++) {
                html += '<a id="page'+i+'" href="#">'+i+'</a> ';
            }

            $("#pagelist").html(html);
            for(i = 1; i <= maxPages; i++) {
                $("#page"+i).click(function(page) {
                    return function() { showPage(page) };
                } (i));
            }
        });
}

function display() {
    $("#tabs > ul").tabs("enable", 1).tabs("select", 1);
    showPage(1);

    return false;
}

function download() {
    var query = "data-orders.php?format=download";
    query += "&start=" + formatDate($("#from").datepicker("getDate"));
    query += "&end=" + formatDate($("#to").datepicker("getDate"));

    window.location.href = window.location.href.replace(/[^/]*$/, "") + query;

    return false;
}

$(function() {
    $("#tabs > ul").tabs();
    $("#tabs > ul").tabs("disable", 1);

    $("#from, #to").datepicker({
        showOn: "button",
        buttonImage: "calendar.gif",
        buttonImageOnly: true,
        dateFormat: "M d yy",
        duration: ""
    });

    $("#from, #to").datepicker("setDate", new Date());

    $("#display").click(display);
    $("#download").click(download);

    $("#previous").click(function() {
        if(currentPage > 1) {
            showPage(currentPage - 1);
        } else {
            show("#offstart");
        }
    });

    $("#next").click(function() {
        if(currentPage < maxPages) {
            showPage(currentPage + 1);
        } else {
            show("#offend");
        }
    });
});
