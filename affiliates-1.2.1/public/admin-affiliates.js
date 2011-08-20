function validator() {
    var required = $("#details_local_username, #details_local_password");

    if(required.is('*[value=""]'))
        return false;

    return true;
}

function AffiliateDetails() {
    this.super_class = Details;
    this.super_class("json-admin-affiliates.php", 1, validator);
}

AffiliateDetails.prototype = new Details();
AffiliateDetails.prototype.super_resultsListChanged =
    AffiliateDetails.prototype.resultsListChanged;

AffiliateDetails.prototype.resultsListChanged = function() {
    var result = this.super_resultsListChanged();
    $("#delete_1").remove();
    return result;
}

AffiliateDetails.prototype.super_initialiseFields =
    AffiliateDetails.prototype.initialiseFields;
AffiliateDetails.prototype.initialiseFields = function(json) {
    var result = this.super_initialiseFields(json);
    defaultCommission();
}

AffiliateDetails.prototype.super_edit = AffiliateDetails.prototype.edit;
AffiliateDetails.prototype.edit = function(id) {
    var result = this.super_edit(id);
    $("#details_administrator").attr("disabled", id == 1);
}

function defaultCommission() {
    if($("#details_default_commission").is("[checked]")) {
        $("#details_commission_percent").attr("value",
            $("#commission_percent").text());
        $("#details_commission_fixed").attr("value",
            $("#commission_fixed").text());

        $("#details_commission_percent, #details_commission_fixed").
            attr("disabled", true);
    } else {
        $("#details_commission_percent, #details_commission_fixed").
            attr("disabled", false);
    }
}

$(function() {
    var pager = new Pager("json-admin-affiliates.php", true);
    var details = new AffiliateDetails();
    pager.editable(details);
    details.autoincrementId();
    $("#details_default_commission").click(defaultCommission);
});
