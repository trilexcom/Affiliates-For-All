function show(id, continuation) {
    if(continuation == undefined)
        continuation = function() { };

    $(id).show().dialog({
        buttons: { "Close": function() {
                    $(id).dialog("close");
                    continuation();
                }
            }
        });
}
