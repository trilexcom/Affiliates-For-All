function validator() {
    var required = $("#details_local_username, #details_local_password");

    if(required.is('*[value=""]'))
        return false;

    return true;
}

$(function() {
    var pager = new Pager("json-admin-affiliates.php", true);
    var details = new Details("json-admin-affiliates.php", 1, validator);
    pager.editable(details);
    details.autoincrementId();
});
