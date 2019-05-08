<?php
$this->blockStart("body");
?>

<link rel="stylesheet" href="/assets/dbadmin/css/components/document.css">
<link rel="stylesheet" href="/assets/dbadmin/css/components/table.css">

<script>

  function init()
  {
    
  }

  $(init);
  
</script>

<section class="container">

  <pre><table class='table'>
  <?php
  
  echo "<tr><th>table</th><th>cid</th><th>name</th><th>type</th><th>notnull</th><th>dflt_value</th><th>pk</th></tr>";
  foreach ($schema as $tableName => $table) {
    
    foreach ($table as $key => $columns) {
      echo "<tr><td>".$tableName."</td>";
      foreach ($columns as $key => $value) {

        echo "<td title='$key' >".htmlspecialchars($value)."</td>";
        
      }
      echo "</tr>";
    }
    
  }
  ?>
 </table><pre>

</section>

<?php

$this->blockEnd("body");

$this->extend("layout");