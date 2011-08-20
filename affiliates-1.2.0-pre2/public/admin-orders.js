function validator() {
    var required = $("#details_id, #details_affiliate, #details_total, " +
        "#details_commission");

    if(required.is('*[value=""]'))
        return false;

    return true;
}

$(function() {
    var pager = new Pager("data-admin-orders.php");
    var details = new Details("data-admin-orders.php", 2, validator);
    pager.editable(details);
});
