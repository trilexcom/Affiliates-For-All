function getJSON(url, params, callback) {
    params["csrfkey"] = $("#key").text();
    return $.getJSON(url, params, callback);
}

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

function pad(digits, string) {
    // Make sure it really is a string:
    string = "" + string;
    while(string.length < digits)
        string = "0" + string;

    return string;
}

function formatDate(date) {
    return "" + date.getFullYear() + pad(2, date.getMonth() + 1) +
        pad(2, date.getDate());
}

function formatDateTime(date) {
    var result = formatDate(date);
    result += pad(2, date.getHours());
    result += pad(2, date.getMinutes());
    result += pad(2, date.getSeconds());
    return result;
}

function parseDate(date) {
    var components = date.match(/(\d+)-(\d+)-(\d+) (\d+):(\d+):(\d+)/);

    if(components == null)
        return new Date();

    return new Date(components[1], components[2] - 1, components[3],
        components[4], components[5], components[6]);
}

function Pager(script, disableSearch) {
    var obj = this;
    this.script = script;
    this.disableSearch = disableSearch;
    this.editor = null;

    $("#tabs > ul").tabs();

    $("#from, #to").datepicker({
        showOn: "button",
        buttonImage: "images/calendar.gif",
        buttonImageOnly: true,
        dateFormat: "M d yy",
        duration: ""
    });

    $("#from, #to").datepicker("setDate", new Date());
    $("#display").click(this.wrapper("display"));
    $("#download").click(this.wrapper("download"));

    $("#previous").click(function() {
        if(obj.currentPage > 1) {
            obj.showPage(obj.currentPage - 1);
        } else {
            show("#offstart");
        }
    });

    $("#next").click(function() {
        if(obj.currentPage < obj.maxPages) {
            obj.showPage(obj.currentPage + 1);
        } else {
            show("#offend");
        }
    });

    if(disableSearch) {
        this.showPage(1);
    } else {
        $("#tabs > ul").tabs("disable", 1);
    }
}

Pager.prototype.wrapper = function(method) {
    var obj = this;
    return function() { return obj[method]() }
}

Pager.prototype.showPage = function(page) {
    this.currentPage = page;
    var obj = this;

    var restrictions = {
        "format": "json",
        "page": this.currentPage - 1
    };

    if(!this.disableSearch) {
        restrictions.start = formatDate($("#from").datepicker("getDate"));
        restrictions.end = formatDate($("#to").datepicker("getDate"));
    }

    getJSON(this.script, restrictions, function(json) {
        $("#restable").html(json.html);
        obj.maxPages = json.pages;
        $("#currentpage").text(page);
        $("#maxpages").text(obj.maxPages);

        var i, html = "";
        for(i = 1; i <= obj.maxPages; i++) {
            html += '<a id="page'+i+'" href="#">'+i+'</a> ';
        }

        $("#pagelist").html(html);
        for(i = 1; i <= obj.maxPages; i++) {
            $("#page"+i).click(function(page) {
                return function() { obj.showPage(page) };
            } (i));
        }

        if(obj.editor != null)
            obj.editor.resultsListChanged();
    });
}

Pager.prototype.display = function() {
    $("#tabs > ul").tabs("enable", 1).tabs("select", 1);
    this.showPage(1);

    return false;
}

Pager.prototype.download = function() {
    var query = this.script + "?format=download";
    query += "&start=" + formatDate($("#from").datepicker("getDate"));
    query += "&end=" + formatDate($("#to").datepicker("getDate"));

    window.location.href = window.location.href.replace(/[^/]*$/, "") + query;

    return false;
}

Pager.prototype.editable = function(editor) {
    this.editor = editor;
    editor.notifyOnChange(this);
}

Pager.prototype.changeNotification = function() {
    this.showPage(this.currentPage);
}

function Details(script, tab, validator) {
    var obj = this;
    this.script = script;
    this.tab = tab;
    this.validator = validator;
    this.notify = null;
    this.editId = true;

    $("#tabs > ul").tabs("disable", tab);

    $(".detailsdate :first-child").datepicker({
        showOn: "button",
        buttonImage: "images/calendar.gif",
        buttonImageOnly: true,
        dateFormat: "M d yy",
        duration: ""
    });

    $("#details_save").click(function() {
        obj.save();
    });

    $("#details_cancel").click(function() {
        $("#tabs > ul").tabs("select", obj.tab - 1).tabs("disable", obj.tab);
    });

    $("#addnew a").click(function() {
        obj.addNew();
    });
}

Details.prototype.autoincrementId = function() {
    this.editId = false;
    $("#details_id").attr("readonly", "readonly");
}

Details.prototype.notifyOnChange = function(receiver) {
    this.notify = receiver;
}

Details.prototype.getDateTime = function(node) {
    var date = node.find(".date").datepicker("getDate");
    date.setHours(node.find(".hours").val());
    date.setMinutes(node.find(".minutes").val());
    date.setSeconds(node.find(".seconds").val());
    return date;
}

Details.prototype.save = function() {
    var obj = this;
    var result = new Object();

    if(this.validator()) {
        $(".detailsfield").each(function() {
            var fieldName = this.id.replace(/^details_/, "");
            var fieldValue = $("input#" + this.id + "[type=text]").val();

            if(fieldValue == undefined)
                fieldValue = $("select#" + this.id + " option[selected]")
                    .eq(0).val();

            if(fieldValue == undefined) {
                var field = $("input#" + this.id + "[type=checkbox]");
                if(field.length > 0)
                    fieldValue = field.is("[checked]") ? 1 : 0;
            }

            if(fieldValue == undefined)
                fieldValue = formatDateTime(obj.getDateTime(
                    $(".detailsdate#" + this.id)));

            result[fieldName] = fieldValue;
        });

        result["format"] = "write";
        if(this.key)
            result["key"] = this.key;

        getJSON(this.script, result, function(json) {
            if(json === true) {
                var tab = obj.key ? obj.tab - 1 : 0;
                show("#saved", function() {
                    $("#tabs > ul")
                        .tabs("select", tab).tabs("disable", obj.tab);
                });

                if(obj.notify)
                    obj.notify.changeNotification();
            } else {
                $("#dberror").html(json);
                show("#dberror");
            }
        });
    } else {
        show("#requiredfields");
    }
}

Details.prototype.resultsListChanged = function() {
    var obj = this;
    $(".edit").each(function() {
        var element = this;
        $("#" + this.id).click(function() {
            obj.edit(element.id.replace(/^edit_/, ""));
        });
    });

    $(".delete").each(function() {
        var element = this;
        $("#" + this.id).click(function() {
            obj.deleteRecord(element.id.replace(/^delete_/, ""));
        });
    });
}

Details.prototype.initialiseFields = function(json) {
    $(".detailsfield").each(function() {
        var value = json[this.id.replace(/^details_/, "")];
        if(!value)
            value = "";

        $("input#" + this.id + "[type=text]").val(value);

        if(value == 1) {
            $("input#" + this.id + "[type=checkbox]")
                .attr("checked", "checked");
        } else {
            $("input#" + this.id + "[type=checkbox]").removeAttr("checked");
        }

        $("select#" + this.id + " option[value=" + value + "]")
            .attr("selected", "selected");

        var date = value instanceof Date ? value : parseDate(value);
        $(".detailsdate#" + this.id + " .date").datepicker(
            "setDate", date);
        $(".detailsdate#" + this.id + " .hours").val(
            date.getHours());
        $(".detailsdate#" + this.id + " .minutes").val(
            date.getMinutes());
        $(".detailsdate#" + this.id + " .seconds").val(
            date.getSeconds());
    });
}

Details.prototype.addNew = function() {
    this.key = null;
    $("#tabs > ul").tabs("enable", this.tab).tabs("select", this.tab);
    var fields = new Object();

    if(this.editId) {
        fields.id = new Date().getTime().toString();
    } else {
        fields.id = "";
    }

    fields.date_entered = new Date();
    this.initialiseFields(fields);
}

Details.prototype.edit = function(order) {
    var obj = this;
    this.key = order;
    $("#tabs > ul").tabs("enable", this.tab).tabs("select", this.tab);
    getJSON(this.script, {
        "format": "singlejson",
        "key": order
    }, function(json) {
        obj.initialiseFields(json);
    });
}

Details.prototype.deleteRecord = function(order) {
    var obj = this;
    $("#confirmdelete").show().dialog({
        buttons: {
            "Yes": function() {
                $("#confirmdelete").dialog("close");
                getJSON(obj.script, {
                    "format": "delete",
                    "key": order
                }, function(json) {
                    if(obj.notify)
                        obj.notify.changeNotification();
                });
            },

            "No": function() {
                $("#confirmdelete").dialog("close");
            }
        }
    });
}
