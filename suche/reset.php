<?php

session_start();

if (isset($_SESSION['cache']['suche'])) {
  unset($_SESSION['cache']['suche']);
}

header("Location: index.php");

 ?>
