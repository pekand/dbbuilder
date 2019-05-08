<?php $this->blockStart("body"); ?>

<style type="text/css">
	
</style>

<script type="text/javascript">
	
	function init() {
		bindEvents();
	}

	function bindEvents() {
		$( "#dbconsole__form" ).submit(submit);
	}
	
	function submit(event) {
		event.preventDefault();
		var query = $("#dbconsole__query").val();
		dbconsoleRunQuery(query);
	}

	function dbconsoleRunQuery(query) {
	    var formData = {
	    	query:query
	    };
	    
		history.pushState({},"",'?query='+query);
		
	    $.ajax({
	        url : "/admin/dbadmin/console",
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

	$(init);
</script>


<main role="main" class="container">
      <h1 class="mt-5">DbConsole</h1>
      <section>
		<form id="dbconsole__form" method="POST" action="/admin/dbconsole/query">
		  
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