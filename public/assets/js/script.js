
function init() {
	bindEvents();
}

function bindEvents() {
	$( "#dbconsole__form" ).submit(function( event ) {
		event.preventDefault();
		dbconsoleRunQuery($("#dbconsole__query").val());
	});
}

function dbconsoleRunQuery(query) {
    var formData = {query:query};

    $.ajax({
        url : "/admin/db/console/query",
        type: "POST",
        data : formData,
        success: function(data, textStatus, jqXHR)
        {
            $('#dbconsole__result').html(data.test);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {

        }
    });
}

$(function() {init();});