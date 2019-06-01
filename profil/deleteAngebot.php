<?php

session_start();

require '../database/database.php';
require "../const/private.php"; isPrivate(true, "/profil");

if (isset($_GET['id'])) {
  $databaseconnection = createConnection();

  //Das eigene eingestellte Angebot wird selektiert und in das Resultset geschrieben
  if (($statement = $databaseconnection->prepare("SELECT * FROM Benutzer, Angebote WHERE Benutzer.ID = Angebote.Benutzer_ID AND Benutzer.ID = ? AND Angebote.ID = ?"))
  && ($statement->bind_param('ii', $_SESSION['id'], $_GET['id']))
  && ($statement->execute())
  && ($resultset = $statement->get_result())) {

    //Überprüfung ob das Resultset leer ist
    if ($resultset->num_rows != 0 && $row = $resultset->fetch_assoc()) {
      //Zuerst wird das Bild des Angebots entfernt
      if (($statement = $databaseconnection->prepare("DELETE FROM Bilder WHERE Angebot_ID=?"))
      && ($statement->bind_param('i', $_GET['id']))
      && ($statement->execute())) {

      }
      //Dann wird das Angebot aus der Tabelle Angebote entfernt
      if (($statement = $databaseconnection->prepare("DELETE FROM Angebote WHERE ID=? AND Benutzer_ID=?"))
      && ($statement->bind_param('ii', $_GET['id'], $_SESSION['id']))
      && ($statement->execute())) {

      }

      //Wenn ein Benutzer dieses Angebot favoritisiert hatte, wird der Eintrag auch gelöscht
      if (($statement = $databaseconnection->prepare("DELETE FROM Favoriten WHERE Angebot_ID=?"))
      && ($statement->bind_param('i', $_GET['id']))
      && ($statement->execute())) {

      }
    }
  }

  closeConnection($databaseconnection);
  header('Location: index.php');
}

 ?>
