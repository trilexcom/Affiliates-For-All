var timer = null, userGood = false, passGood = false;

function userChange(e) {
    if(timer != null)
        window.clearTimeout(timer);

    timer = setTimeout(checkUser, 500);
}

function checkUser() {
    getJSON("json-availuser.php", { "user": $("#chosenusername").val() },
        function(json) {
            userGood = json[0];
            $("#message").html(json[1]);
        });
}

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

function completeLogon(json) {
    if(json) {
        window.location.href =
            window.location.href.replace(/[^/]*$/, "") + json;
    } else {
        show("#failedtologon");
    }
}


function logon() {
    getJSON("json-logon.php", {
        "user": $("#username").val(),
        "password": $("#password").val() }, completeLogon);

    return false;
}

function navigate(json) {
    if(json)
        window.location.href =
            window.location.href.replace(/[^/]*$/, "") + json;
}

function signup() {
    if(userGood && passGood) {
        getJSON("json-signup.php", {
            "user": $("#chosenusername").val(),
            "password": $("#chosenpassword").val() }, navigate);
    } else {
        show("#failedtosignup");
    }

    return false;
}

$(function() {
    $("#tabs > ul").tabs();
    $("#chosenusername").change(userChange);
    $("#chosenusername").keyup(userChange);
    $("#chosenpassword").change(passChange);
    $("#chosenpassword").keyup(passChange);
    $("#confirmpassword").change(passChange);
    $("#confirmpassword").keyup(passChange);
    $("#logon > form").submit(logon);
    $("#signup > form").submit(signup);
});
