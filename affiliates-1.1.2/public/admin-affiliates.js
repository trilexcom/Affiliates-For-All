function validator() {
    var required = $("#details_local_username, #details_local_password");

    if(required.is('*[value=""]'))
        return false;

    return true;
}

function AffiliateDetails() {
    this.super = Details;
    this.super("json-admin-affiliates.php", 1, validator);
}

AffiliateDetails.prototype = new Details();
AffiliateDetails.prototype.super_resultsListChanged =
    AffiliateDetails.prototype.resultsListChanged;

AffiliateDetails.prototype.resultsListChanged = function() {
    var result = this.super_resultsListChanged();
    $("#delete_1").remove();
    return result;
}

AffiliateDetails.prototype.super_edit = AffiliateDetails.prototype.edit;
AffiliateDetails.prototype.edit = function(id) {
    var result = this.super_edit(id);
    $("#details_administrator").attr("disabled", id == 1);
}

$(function() {
    var pager = new Pager("json-admin-affiliates.php", true);
    var details = new AffiliateDetails();
    pager.editable(details);
    details.autoincrementId();
});
