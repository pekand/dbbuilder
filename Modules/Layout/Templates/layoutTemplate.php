<!DOCTYPE html>
<html lang="en">
  <head>

    <meta charset="utf-8">
    <title><?php $this->blockInsert("title", "WebApplication")?></title>
    <link rel='shortcut icon' type='image/x-icon' href='/assets/img/favicon.ico' />

    <link rel="stylesheet" href="/assets/styles.css?<?php echo rand ( 1000000 , 9999999 );?>">
    <script src="/assets/js/jquery.js"></script>
        
    <?php $this->blockInsert("style")?>

  </head>
  <body>
      
      <?php $this->blockInsert("body")?>

      <script src="/assets/js/script.js?<?php echo rand ( 1000000 , 9999999 );?>"></script>

    <?php $this->blockInsert("scripts")?>

  </body>
</html>