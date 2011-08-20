function validator() {
    var required = $("#details_affiliate, #details_amount");

    if(required.is('*[value=""]'))
        return false;

    return true;
}

$(function() {
    var pager = new Pager("json-admin-payments.php");
    var details = new Details("json-admin-payments.php", 2, validator);
    pager.editable(details);
    details.autoincrementId();
});
