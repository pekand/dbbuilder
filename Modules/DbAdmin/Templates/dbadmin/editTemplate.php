<?php
$this->blockStart("body");
?>

<link rel="stylesheet" href="/assets/dbadmin/css/components/document.css">
<link rel="stylesheet" href="/assets/dbadmin/css/components/toolbar.css">
<link rel="stylesheet" href="/assets/dbadmin/css/components/button.css">
<link rel="stylesheet" href="/assets/dbadmin/css/components/editform.css">

<style>

</style>

<script>

  var table = '<?php $this->put($table); ?>';
  var uid = '<?php $this->put($uid); ?>';

  function save()
  {
    var formData = {};

    $(".item").each(function( index, value ) {
      var area = $(this);
      formData[area.data('name')] = area.val();
    });

    console.log(formData);

    var url = "/admin/dbadmin/table/"+table+"/new";
    if (uid !== "") {
      url = "/admin/dbadmin/table/"+table+"/update/"+uid;
    }        
    
    $.post({
        url : url,
        data : formData,
        success: function(data, textStatus, jqXHR)
        {
          if (uid === '') {
            uid = data['uid'];
            window.history.replaceState({},"Edit", '/admin/dbadmin/table/'+table+'/edit/'+uid);
          }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            console.log('error');
        }
    });
    
  }

  function remove()
  {
    $.get({
      url:"/admin/dbadmin/table/"+table+"/remove/"+uid,
      success: function(data, textStatus, jqXHR)
      {
        window.location.href = '/admin/dbadmin/table/' + table;
      }
    });
  }

  function init()
  {
    $('#save').click(save);
    $('#remove').click(remove);
  }

  $(init);
  
</script>

<section class="container">

    <div class="toolbar">
      <div id="save" class="button">Save</div>
      <div id="remove" class="button button--remove">Remove</div>
      <div class="clear"></div>
    </div>

    <div class="editform">
        <?php foreach($data as $name => $value) { ?>
          <div class="editform__item">
          
            <div class="editform__item__label">
              <?php $this->put($name); ?>
            </div>

            <div class="editform__item__input" title="<?php $this->put($name); ?>" >
              <textarea class="item" data-name="<?php $this->put($name); ?>" ><?php $this->put($value); ?></textarea>
            </div>

            <div class="clear"></div>

          </div>
        <?php }; ?>
    </div>

</section>

<?php

$this->blockEnd("body");

$this->extend("layout");