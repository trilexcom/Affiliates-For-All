function download() {
    var query = "data-admin-payments.php?format=download";
    query += "&end=" + formatDate($("#to").datepicker("getDate"));
    window.location.href = window.location.href.replace(/[^/]*$/, "") + query;
    return false;
}

$(function() {
    $("#tabs > ul").tabs();

    $("#to").datepicker({
        showOn: "button",
        buttonImage: "images/calendar.gif",
        buttonImageOnly: true,
        dateFormat: "M d yy",
        duration: ""
    });

    $("#to").datepicker("setDate", new Date());
    $("#download").click(download);

    show("#message");
});
