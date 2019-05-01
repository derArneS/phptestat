<?php

function createConnection() {
  $databaseconnection = new mysqli("mysql.jamawie.ovh", "phpArne", "FzTyknk0Xot8PSNX", "phpArne");

  if ($databaseconnection->connect_errno) {
    printf('Verbindung fehlgeschlagen: %s\n', $databaseconnection->connect_error);
  }

  return $databaseconnection;
}

function closeConnection($databaseconnection) {
  $databaseconnection->close();
}

?>
