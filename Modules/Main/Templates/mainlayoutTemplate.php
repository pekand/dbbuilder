<!DOCTYPE html>
<html lang="en">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <title><?php $this->blockInsert("title", "WebApplication")?></title>
    <link rel='shortcut icon' type='image/x-icon' href='/assets/favicon.ico' />

    <link rel="stylesheet" href="/assets/css/lib/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    
    <script src="/assets/js/lib/jquery-3.3.1.min.js"></script>

    <?php $this->blockInsert("style")?>

  </head>
  <body>
      
      <?php $this->blockInsert("body")?>

      <script src="/assets/js/lib/bootstrap.min.js"></script>
      <script src="/assets/js/script.js"></script>

    <?php $this->blockInsert("scripts")?>

  </body>
</html>