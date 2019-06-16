<?php $this->blockStart("title"); ?>Short<?php $this->blockEnd("title"); ?>

<?php $this->blockStart("body"); ?>

<script type="text/javascript">
    function init() {
        bindEvents();
    }

    function bindEvents() {
        $( "#short__form" ).submit(function( event ) {
            event.preventDefault();
            shortUrl(
                $("#short__url").val(),
            );
        });
    }

    function shortUrl(url) {
        var formData = {
            url:url
        };
        
        //history.pushState({},"",'?url='+database+'&query='+query);
        
        $.ajax({
            url : "/short/add",
            type: "POST",
            data : formData,
            success: function(data, textStatus, jqXHR)
            {
                $('#short__result').html(window.location.hostname+'/short/'+data.name);
            },
            error: function (jqXHR, textStatus, errorThrown)
            {

            }
        });
    }

    $(init);
</script>


<main role="main" class="container">
      <h1 class="mt-5">Url shortener</h1>
      <section>
        <form id="short__form" method="POST" action="/short/add">
            
          <div class="form-group">
            <label for="short__url">Url</label>
            <input type="text" class="form-control" id="short__url" name="short__url" value="" >
          </div>
          
          <div class="form-group">
            <input type="submit" class="form-control" value="submit" >
          </div>
          
        </form>
    </section>
    <section><pre id="short__result" ></pre></section>
</main>
    


<?php 
$this->blockEnd("body"); 
$this->extend("layout");