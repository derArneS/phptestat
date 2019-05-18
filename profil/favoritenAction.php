<?php
session_start();
require "../database/database.php";
require "../const/deletecache.php";
$databaseconnection = createConnection();

//Wenn im Suchergebnis der Knopf "Favorit" gedrückt wird, wird dieser Code ausgeführt
if(isset($_GET['id'])){
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

  //Hinzufügen ausgewählten Angebots zu den Favoriten
  if (($statement = $databaseconnection->prepare("INSERT INTO Favoriten (Benutzer_ID, Angebot_ID) VALUES (?,?)"))
  && ($statement->bind_param('ii', $_SESSION['id'], $_GET['id']))
  && ($statement->execute())){
    header("Location: ../uebersicht/index.php");
    closeConnection($databaseconnection);
    die();
  }
}

err:
header("Location: ../uebersicht/index.php");
closeConnection($databaseconnection);
die();

?>
