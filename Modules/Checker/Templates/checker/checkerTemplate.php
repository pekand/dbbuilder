<?php $this->blockStart("body"); ?>

<style type="text/css">
	
</style>

<script type="text/javascript">
	
	function init() {
		bindEvents();
	}

	function bindEvents() {
		$( "#checker__form" ).submit(submit);
	}
	
	function submit(event) {
		event.preventDefault();
		var query = $("#checker__query").val();
		checkerRunQuery(query);
	}

	function checkerRunQuery(query) {
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
	            $('#checker__result').html(data.result);
	        },
	        error: function (jqXHR, textStatus, errorThrown)
	        {

	        }
	    });
	}

	$(init);
</script>


<main role="main" class="container">
      <h1 class="mt-5">Checker</h1>
      <section>
		<form id="checker__form" method="POST" action="/admin/checker/query">
		  
		  <div class="form-group">
		    <label for="checker__type">Type</label>
		    
		    <select class="form-control" id="checker__type">
		    	<option>GET</option>
		    	<option>POST</option>
		    	<option>PUT</option>
		    	<option>DELETE</option>
		    	<option>SOAP</option>
		    </select>
		    
		  </div>
		  
		  <div class="form-group">
		    <label for="exampleFormControlTextarea1">Url</label>
		    <input type="text" class="form-control" id="checker__url" value="<?php echo htmlspecialchars($url); ?>" >
		  </div>
		  
		  <div class="form-group">
		    <input type="submit" class="form-control" value="submit" >
		  </div>
		  
		</form>
	</section>
	<section><pre id="checker__result" ><?php  echo htmlspecialchars($result); ?></pre></section>
</main>
    


<?php 
$this->blockEnd("body"); 
$this->extend("layout");