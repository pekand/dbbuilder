<?php $this->blockStart("body"); ?>

<style type="text/css">
	
</style>

<script type="text/javascript">
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
</script>

<section>
	<form id="dbconsole__form">
		<textarea id="dbconsole__query"></textarea>
		<input type="submit" valu="submit">
	</form>
</section><section id="dbconsole__result"></section>

<?php 
$this->blockEnd("body"); 
$this->extend("layout");