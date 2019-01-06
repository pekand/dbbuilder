<!DOCTYPE html>
<html lang="en">
  <head>

    <meta charset="utf-8">
    <title><?php $this->blockInsert("title", "DbBuilder")?></title>
    <link rel='shortcut icon' type='image/x-icon' href='/assets/img/favicon.ico' />

    <link rel="stylesheet" href="/resources/css/lib/bootstrap.min.css">
    <link rel="stylesheet" href="/resources/css/style.css">

    <?php $this->blockInsert("style")?>

  </head>
  <body>
      
      <?php $this->blockInsert("body")?>

      <script src="/resources/js/lib/jquery-3.3.1.min.js"></script>
      <script src="/resources/js/lib/bootstrap.min.js"></script>
    <script src="/resources/js/script.js"></script>

    <?php $this->blockInsert("scripts")?>

  </body>
</html>