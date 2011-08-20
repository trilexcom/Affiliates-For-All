var chosenbanner;

function update() {
    var linkHtml = $("#baseurl").text() + $("#linktarget").val();
    linkHtml += "?" + $("#refparam").text();
    if($("#campaignid").val() != "")
      linkHtml += "&" + $("#dataparam").text() + "=" + $("#campaignid").val();
    linkHtml = '<a href="' + linkHtml + '">';

    var imgHtml =
        '<img style="border: 0px" src="' +
        $("#bannerscript").text() + chosenbanner + '">';

    var code = linkHtml + imgHtml + "</img></a>";
    $("#code").val(code);
}

function setbanner(name, linkTarget) {
    chosenbanner = name;
    $("#chosenbanner").attr("src", "servebanner.php?name=" + name);
    $("#linktarget").val(linkTarget);
    update();
}

function changebanner() {
    $("#tabs > ul").tabs("select", 1);
    return false;
}

$(function() {
    var defaultBanner = $("#defaultbanner").text();
    setbanner($("#name_" + defaultBanner).text(),
        $("#target_" + defaultBanner).text());

    $("#tabs > ul").tabs();
    $("#chosenbanner, #changebanner").click(changebanner);

    $(".banner").map(function() {
        var id = $(this).attr("id").replace(/^banner_/, "");
        var bannerName = $("#name_" + id).text();
        var linkTarget = $("#target_" + id).text();
        $(this).click(function() {
            setbanner(bannerName, linkTarget);
            $("#tabs > ul").tabs("select", 0);
        });
    });

    $("#campaignid, #linktarget").change(update).keyup(update);

    update();
});
