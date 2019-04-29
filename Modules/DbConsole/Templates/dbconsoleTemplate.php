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
			dbconsoleRunQuery(
				$("#dbconsole__database").val(),
				$("#dbconsole__query").val()
			);
		});
	}

	function dbconsoleRunQuery(database, query) {
	    var formData = {
	    	database:database,
	    	query:query
	    };
	    
		history.pushState({},"",'?database='+database+'&query='+query);
		
	    $.ajax({
	        url : "/admin/dbconsole/query",
	        type: "POST",
	        data : formData,
	        success: function(data, textStatus, jqXHR)
	        {
	            $('#dbconsole__result').html(data.result);
	        },
	        error: function (jqXHR, textStatus, errorThrown)
	        {

	        }
	    });
	}

	$(function() {init();});
</script>


<main role="main" class="container">
      <h1 class="mt-5">DbConsole</h1>
      <section>
		<form id="dbconsole__form" method="POST" action="/admin/dbconsole/query">
			
		  <div class="form-group">
		    <label for="exampleFormControlInput1">Database</label>
		    <input type="text" class="form-control" id="dbconsole__database" value="<?php echo htmlspecialchars($database); ?>" >
		  </div>
		  
		  <div class="form-group">
		    <label for="exampleFormControlTextarea1">Query</label>
		    <textarea class="form-control" id="dbconsole__query" rows="3"><?php echo htmlspecialchars($query); ?></textarea>
		  </div>
		  
		  <div class="form-group">
		    <input type="submit" class="form-control" value="submit" >
		  </div>
		  
		</form>
	</section>
	<section><pre id="dbconsole__result" ><?php  echo htmlspecialchars($result); ?></pre></section>
</main>
    


<?php 
$this->blockEnd("body"); 
$this->extend("layout");