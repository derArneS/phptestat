<?php
  session_start();
  $_SESSION = array();
  setcookie("benutzername", "", time() - 1, "/");
  setcookie("passwort", "", time() - 1, "/");
  //unset($_COOKIE['benutzername']);
  //unset($_COOKIE['passwort']);
  header("Location: ../welcome");
 ?>
