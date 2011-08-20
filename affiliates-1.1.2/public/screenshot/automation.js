var afa = top.frames[1];
var continuations = [];

function run(code) {
    continuations.push(code);
}

function cont() {
    if(continuations.length > 0) {
        var code = continuations.shift();
        code();
        top.document.title = afa.document.title;
    }
}

function runlogin(user, pass) {
    run(function() {
        afa.$("#username").val(user);
        afa.$("#password").val(pass);
        afa.$("#logon form").submit();
        setTimeout(cont, 1000);
    });
}

function login() {
    runlogin("Pete", "Pete");
}

function admin() {
    runlogin("Admin", "Admin");
}
