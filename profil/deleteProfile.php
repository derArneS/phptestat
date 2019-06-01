<?php

session_start();

require "../database/database.php";

//Nur durchführen, wenn auch über die Form aufgerufen wurde.
if ($_POST['deleteBtn'] == "delete") {
  $databaseconnection = createConnection();

  //Alle Angebote selektieren, die von dem Profil erstellt wurden
  if (($statement = $databaseconnection->prepare("SELECT Angebote.ID AS angebot_id FROM Benutzer, Angebote WHERE Benutzer.ID = Angebote.Benutzer_ID AND Benutzer.ID = ?"))
  && ($statement->bind_param('i', $_SESSION['id']))
  && ($statement->execute())
  && ($resultset = $statement->get_result())) {

    //Durch alle Angebote, die von diesem Profil erstellt wurden durchiterieren
    while ($row = $resultset->fetch_assoc()) {
      //Das Bild des Angebots löschen
      if (($statement = $databaseconnection->prepare("DELETE FROM Bilder WHERE Angebot_ID=?"))
      && ($statement->bind_param('i', $row['angebot_id']))
      && ($statement->execute())) {

      }

      //Das Angebot löschen
      if (($statement = $databaseconnection->prepare("DELETE FROM Angebote WHERE ID=?"))
      && ($statement->bind_param('i', $row['angebot_id']))
      && ($statement->execute())) {

      }

      //Die Favoriten, die zu diesem Angebot gehören, löschen
      if (($statement = $databaseconnection->prepare("DELETE FROM Favoriten WHERE Angebot_ID=?"))
      && ($statement->bind_param('i', $row['angebot_id']))
      && ($statement->execute())) {

      }
    }

  }

  //Den Benutzer zu diesem Profil auswählen
  if (($statement = $databaseconnection->prepare("SELECT * FROM Benutzer WHERE Benutzer.ID = ?"))
  && ($statement->bind_param('i', $_SESSION['id']))
  && ($statement->execute())
  && ($resultset = $statement->get_result())
  && ($row = $resultset->fetch_assoc())) {
    print_r($row);
    echo $row['Adress_ID'];
    //Die Adresse dieses Benutzers löschen
    if ($statement = $databaseconnection->prepare("DELETE FROM Adressen WHERE ID=?")
    && ($statement->bind_param('i', $row['Adress_ID']))
    && ($statement->execute())) {
      echo "string";
    }
  }

  //Alle Favoriten dieses Benutzers löschen
  if (($statement = $databaseconnection->prepare("DELETE FROM Favoriten WHERE Benutzer_ID=?"))
  && ($statement->bind_param('i', $_SESSION['id']))
  && ($statement->execute())) {

  }

  //Alle Nachrichten, die an diesen Nutzer gingen, oder die von diesem Nutzer gesendet wurden löschen
  if (($statement = $databaseconnection->prepare("DELETE FROM Nachrichten WHERE Sender=? OR Empfaenger=?"))
  && ($statement->bind_param('ii', $_SESSION['id'], $_SESSION['id']))
  && ($statement->execute())) {

  }

  //Diesen Benutzer aus der DB entfernen
  if (($statement = $databaseconnection->prepare("DELETE FROM Benutzer WHERE ID=?"))
  && ($statement->bind_param('i', $_SESSION['id']))
  && ($statement->execute())) {

  }

  //Den Benutzer ausloggen
  header("Location: ../login/logout.php");

}

 ?>
