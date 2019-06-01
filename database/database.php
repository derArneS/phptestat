<?php

function createConnection() {
  //Zugangsdaten zur Datenbank
  $databaseconnection = new mysqli("mysql.jamawie.ovh", "phpArne", "FzTyknk0Xot8PSNX", "phpArne");

  //Wenn ein Fehler eingetreten ist
  if ($databaseconnection->connect_errno) {
    printf('Verbindung fehlgeschlagen: %s\n', $databaseconnection->connect_error);
  }

  //Sonst wird die Datenbankverbindung zurückgegeben
  return $databaseconnection;
}

//Schließt die Verbindung
function closeConnection($databaseconnection) {
  $databaseconnection->close();
}

?>
