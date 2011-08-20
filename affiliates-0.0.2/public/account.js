var passGood = false;

function passChange() {
    var msg, cssClass;

    if($("#chosenpassword").val() == "") {
        msg = "Please choose a password.";
        cssClass = "no";
        passGood = false;
    } else if($("#chosenpassword").val() == $("#confirmpassword").val()) {
        msg = "Passwords match.";
        cssClass = "yes";
        passGood = true;
    } else {
        msg = "Passwords don’t match.";
        cssClass = "no";
        passGood = false;
    }

    $("#passmessage").text(msg).removeClass("yes").removeClass("no")
        .addClass(cssClass);
}

function show(id) {
    $(id).show().dialog({
        buttons: { "Close": function() { $(id).dialog("close"); } }
        });
}

function setGeneral() {
    var required = $(
        "#title, #firstname, #lastname, #email, #address1, #address2, " +
        "#postcode, #phone");

    if(required.is('*[value=""]')) {
        show("#requiredfields");
    } else {
        $.getJSON("json-setgeneral.php",
            { "details": $("#general :input").serialize() },
            function() { show("#generalset") });
    }

    return false;
}

function setPassword() {
    if(passGood) {
        $.getJSON("json-setpassword.php",
            { "password": $("#chosenpassword").val() },
                function() { show("#pwdset") });
    } else {
        $("#failedtosetpwd").show().dialog({
            buttons: {
                "Close": function() { $("#failedtosetpwd").dialog("close"); }
            }
            });
    }

    return false;
}

function setPaypal() {
    $.getJSON("json-setpaypal.php",
        { "paypal": $("#paypalid").val() }, function() { show("#paypalset") });

    return false;
}

$(function() {
    $("#tabs > ul").tabs();
    $("#chosenpassword").bind("change", passChange);
    $("#chosenpassword").bind("keyup", passChange);
    $("#confirmpassword").bind("change", passChange);
    $("#confirmpassword").bind("keyup", passChange);
    $("#general > form").bind("submit", setGeneral);
    $("#password > form").bind("submit", setPassword);
    $("#paypal > form").bind("submit", setPaypal);
});
