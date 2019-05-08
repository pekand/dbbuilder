<?php
$this->blockStart("body");
?>

<link rel="stylesheet" href="/assets/dbadmin/css/components/document.css">
<link rel="stylesheet" href="/assets/dbadmin/css/components/table.css">
<link rel="stylesheet" href="/assets/dbadmin/css/components/toolbar.css">
<link rel="stylesheet" href="/assets/dbadmin/css/components/button.css">

<script>

  var table = '<?php $this->put($table); ?>';
  
  function tablelistRowClick()
  {
    var uid = $(this).data('uid');
    window.location.href = '/admin/dbadmin/table/'+table+'/edit/'+uid;
  }
  
  function tablelistNewClick()
  {
    window.location.href = '/admin/dbadmin/table/'+table+'/new';
  }
  
  function tablelistDropClick()
  {
    $.get({
      url:"/admin/dbadmin/table/"+table+"/drop",
      success: function(data, textStatus, jqXHR)
      {
        window.location.href = '/admin/dbadmin';
      }
    });
  }

  function init()
  {
    $('.table__row').click(tablelistRowClick);
    $('#new').click(tablelistNewClick);
    $('#drop').click(tablelistDropClick);
  }

  $(init);
  
</script>

<section class="container">

  <div class="toolbar">
    <div id="new" class="button">New</div>
    <div id="drop" class="button button--remove">Drop</div>
    <div class="clear"></div>
  </div>

  <div class="table">
    <?php foreach($data as $row) { ?>
    

      <div class="table__row" data-uid="<?php $this->put($row['uid']); ?>">
        <?php foreach($row as $name => $column) { ?>
          
            <div class="table__column" title="<?php $this->put($name); ?>" data-column="<?php $this->put($name); ?>">
              <?php $this->put($column); ?>
            </div>
          
        <?php }; ?>
       

        <div class="clear"></div>

      </div>
    
    <?php }; ?>
  </div>

</section>

<?php

$this->blockEnd("body");

$this->extend("layout");