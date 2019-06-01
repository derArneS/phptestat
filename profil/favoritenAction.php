<?php
session_start();
require "../database/database.php";
require "../const/deletecache.php";
require "../const/private.php"; isPrivate(true, "/profil/favoritenAction.php?id=".$_GET['id']);

$databaseconnection = createConnection();

//Wenn im Suchergebnis der Knopf "Favorit" gedrückt wird, wird dieser Code ausgeführt
if(isset($_GET['id'])){
  if (($statement = $databaseconnection->prepare("SELECT Benutzer_ID FROM Angebote WHERE ID = ?"))
  && ($statement->bind_param('i', $_GET['id']))
  && ($statement->execute())
  && ($resultset = $statement->get_result())
  && ($row = $resultset->fetch_assoc())){
    //Überprüfung ob das Angebot, das als Favorit hinzugefügt werden soll nicht ein eigenes eingestelltes Angebot ist
    if ($_SESSION['id'] != $row['Benutzer_ID']) {
      //Überprüfung ob der Benutzer das Angebot bereits als Favorit hinzugefügt hat
      if (!($statement = $databaseconnection->prepare("SELECT * FROM Favoriten WHERE Benutzer_ID = ? AND Angebot_ID = ?"))
      || !($statement->bind_param('ii', $_SESSION['id'], $_GET['id']))
      || !($statement->execute())) {
        goto err;
      } else if (!($resultset = $statement->get_result()) || !($resultset->num_rows === 0)) {
        if ($row = $resultset->fetch_assoc()) {
          goto err;
        }
      }

      //Hinzufügen des ausgewählten Angebots zu den Favoriten
      $angebotsid = htmlspecialchars(stripslashes($_GET['id']));
      if (($statement = $databaseconnection->prepare("INSERT INTO Favoriten (Benutzer_ID, Angebot_ID) VALUES (?,?)"))
      && ($statement->bind_param('ii', $_SESSION['id'], $angebotsid))
      && ($statement->execute())){
        //Entweder zurück zur Übersicht oder zum Angebot
        if (isset($_GET['re'])) {
          header("Location: " . $_GET['re']);
        } else {
          header("Location: ../uebersicht/index.php");
        }
        closeConnection($databaseconnection);
        die();
      }
    }
  }
}

//Entweder zurück zur Übersicht oder zum Angebot
err:
if (isset($_GET['re'])) {
  header("Location: " . $_GET['re']);
} else {
  header("Location: ../uebersicht/index.php");
}
closeConnection($databaseconnection);
die();

?>
