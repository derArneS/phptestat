<?php
session_start();
require "../database/database.php";
require "../const/deletecache.php";
$databaseconnection = createConnection();

if(isset($_GET['id'])){
  if (($statement = $databaseconnection->prepare("DELETE FROM Favoriten WHERE Benutzer_ID = ? AND Angebot_ID = ?"))
  && ($statement->bind_param('ii', $_SESSION['id'], $_GET['id']))
  && ($statement->execute())){
    header("Location: index.php");
    closeConnection($databaseconnection);
    die();
  }
}
err:
header("Location: index.php");
closeConnection($databaseconnection);
die();

?>
