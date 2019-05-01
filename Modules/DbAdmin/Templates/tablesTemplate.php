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
    //alert($(this).data('tablename'));
  }

  function init()
  {
    $('.tablelist__row').click(tablelistRowClick);
  }

  $(init);
  
</script>

<section class="container">

    <div class="toolbar">
      <div id="new" class="button">New</div>
      <div id="schema" class="button">Schema</div>
      <div class="clear"></div>
    </div>

    <div class="tablelist">
    <?php foreach($tables as $tableName => $table) { ?>
    <a href="/admin/dbadmin/table/<?php $this->put($tableName); ?>">
    <div class="tablelist__row" data-tablename="<?php $this->put($tableName); ?>">
      <?php $this->put($tableName); ?>
    </div>
  </a>
  <?php }; ?>
  </div>
</section>

<?php

$this->blockEnd("body");

$this->extend("layout");