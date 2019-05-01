<?php
$this->blockStart("body");
?>

<link rel="stylesheet" href="/assets/dbadmin/css/components/document.css">
<link rel="stylesheet" href="/assets/dbadmin/css/components/table.css">
<link rel="stylesheet" href="/assets/dbadmin/css/components/toolbar.css">
<link rel="stylesheet" href="/assets/dbadmin/css/components/button.css">

<script>

  function tablelistRowClick()
  {
    alert($(this).data('tablename'));
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
    <div class="clear"></div>
  </div>

  <div class="table">
    <?php foreach($data as $row) { ?>
    
      <a href="/admin/dbadmin/table/<?php $this->put($table); ?>/edit/<?php $this->put($row['uid']); ?>">
      <div class="table__row" data-tablename="<?php $this->put($table); ?>">
        <?php foreach($row as $name => $column) { ?>
          
            <div class="table__column" title="<?php $this->put($name); ?>" data-column="<?php $this->put($name); ?>">
              <?php $this->put($column); ?>
            </div>
          
        <?php }; ?>
       

        <div class="clear"></div>

      </div>
      </a>
    
    <?php }; ?>
  </div>

</section>

<?php

$this->blockEnd("body");

$this->extend("layout");