<?php

session_start();

require '../database/database.php';
require "../const/private.php"; isPrivate(true, "/profil");

$test = 1;

if (isset($_GET['id'])) {
  $databaseconnection = createConnection();

  echo $_GET['id'];
  echo $_SESSION['id'];

  if (($statement = $databaseconnection->prepare("SELECT * FROM Benutzer, Angebote WHERE Benutzer.ID = Angebote.Benutzer_ID AND Benutzer.ID = ? AND Angebote.ID = ?"))
  && ($statement->bind_param('ii', $_SESSION['id'], $_GET['id']))
  && ($statement->execute())
  && ($resultset = $statement->get_result())) {

    if ($resultset->num_rows != 0 && $row = $resultset->fetch_assoc()) {
      if (($statement = $databaseconnection->prepare("DELETE FROM Bilder WHERE Angebot_ID=?"))
      && ($statement->bind_param('i', $_GET['id']))
      && ($statement->execute())) {

      }

      if (($statement = $databaseconnection->prepare("DELETE FROM Angebote WHERE ID=? AND Benutzer_ID=?"))
      && ($statement->bind_param('ii', $_GET['id'], $_SESSION['id']))
      && ($statement->execute())) {
        
      }
    }


  }

  closeConnection($databaseconnection);
  header('Location: index.php');
}

 ?>
