<?php
$this->blockStart("body");
?>

<link rel="stylesheet" href="/assets/dbadmin/css/components/document.css">
<link rel="stylesheet" href="/assets/dbadmin/css/components/tablelist.css">
<link rel="stylesheet" href="/assets/dbadmin/css/components/toolbar.css">
<link rel="stylesheet" href="/assets/dbadmin/css/components/button.css">

<script>

  function tablelistRowClick()
  {
    var table = $(this).data('tablename');
    window.location.href = '/admin/dbadmin/table/'+table;
  }
  
  function build()
  {
    window.location.href = '/admin/db/builder';
  }
  
  function schema()
  {
    window.location.href = '/admin/dbadmin/schema';
  }
  
  function init()
  {
    $('#build').click(build);
    $('#schema').click(schema);
    $('.tablelist__row').click(tablelistRowClick);
  }

  $(init);
  
</script>

<section class="container">

    <div class="toolbar">
      <div id="build" class="button">Build</div>
      <div id="schema" class="button">Schema</div>
      <div class="clear"></div>
    </div>

    <div class="tablelist">
    <?php foreach($tables as $tableName => $table) { ?>
      
      <div class="tablelist__row" data-tablename="<?php $this->put($tableName); ?>">
        <?php $this->put($tableName); ?>
      </div>

    <?php }; ?>
  </div>
</section>

<?php

$this->blockEnd("body");

$this->extend("layout");