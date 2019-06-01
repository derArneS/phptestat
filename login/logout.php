<?php
  session_start();
  //Die session wird mit einem neuen, leeren Array überschrieben
  $_SESSION = array();
  //Beim Logout wird der Benutzername und das Passwort aus den Cookies gelöscht.
  setcookie("benutzername", "", time() - 1, "/");
  setcookie("passwort", "", time() - 1, "/");
  header("Location: ../welcome");
 ?>
