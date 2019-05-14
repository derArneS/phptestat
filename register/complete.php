<?php

session_start();

require "../database/database.php";
require '../const/deletecache.php';

if (isset($_SESSION['benutzername'])) {
  goto err;
}

 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>

  </body>
</html>
