<?php
session_start();
require "../database/database.php";
require "../const/deletecache.php";
$databaseconnection = createConnection();

if(isset($_GET['id'])){
  if (!($statement = $databaseconnection->prepare("SELECT * FROM Favoriten WHERE Benutzer_ID = ? AND Angebot_ID = ?"))
  || !($statement->bind_param('ii', $_SESSION['id'], $_GET['id']))
  || !($statement->execute())) {
    goto err;
  } else if (!($resultset = $statement->get_result()) || !($resultset->num_rows === 0)) {
    if ($row = $resultset->fetch_assoc()) {
      goto err;
    }
  }

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
