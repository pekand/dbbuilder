<!DOCTYPE html>
<html lang="en">
  <head>

    <meta charset="utf-8">
    <title><?php $this->blockInsert("title", "DbBuilder")?></title>
    <link rel='shortcut icon' type='image/x-icon' href='/assets/img/favicon.ico' />

    <link rel="stylesheet" href="/assets/styles.css">
	<script src="/assets/js/jquery.js"></script>
	    
    <?php $this->blockInsert("style")?>

  </head>
  <body>
      
      <?php $this->blockInsert("body")?>

      <script src="/assets/js/script.js"></script>

    <?php $this->blockInsert("scripts")?>

  </body>
</html>