var passGood = false, wizard = false;

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

function agree() {
    $("#tabs > ul").tabs("enable", 1).tabs("select", 1).tabs("disable", 0);
    return false;
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
            function() {
                if(wizard) {
                    $("#tabs > ul").tabs("enable", 2).tabs("select", 2).
                        tabs("disable", 1);
                } else {
                    show("#generalset");
                }
            });
    }

    return false;
}

function setPassword() {
    if(passGood) {
        $.getJSON("json-setpassword.php",
            { "password": $("#chosenpassword").val() },
                function() { show("#pwdset") });
    } else {
        show("#failedtosetpwd");
    }

    return false;
}

function setPaypal() {
    $.getJSON("json-setpaypal.php",
        { "paypal": $("#paypalid").val() },
        function() {
            if(wizard) {
                show("#endofwizard", function() {
                    window.location = window.location.href.replace(/[^/]*$/, "")
                        + "overview.php";
                });
            } else {
                show("#paypalset");
            }
        });

    return false;
}

$(function() {
    $("#tabs > ul").tabs();
    $("#chosenpassword").change(passChange);
    $("#chosenpassword").keyup(passChange);
    $("#confirmpassword").change(passChange);
    $("#confirmpassword").keyup(passChange);
    $("#general > form").submit(setGeneral);
    $("#password > form").submit(setPassword);
    $("#paypal > form").submit(setPaypal);

    if($("#legal form").length > 0) {
        $("#legal form").submit(agree);
        $("#tabs > ul").tabs("disable", 1).tabs("disable", 2).tabs("remove", 3);
        $("#general :submit").val("Next");
        $("#paypal :submit").val("Finish");
        wizard = true;
    } else {
        $("#tabs > ul").tabs("select", 1);
    }
});
