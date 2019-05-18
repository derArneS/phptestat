<?php

session_start();

require '../database/database.php';
require "../const/cookie.php";
require '../const/deletecache.php';

$databaseconnection = createConnection();
if (isset($_POST['text']) && isset($_SESSION['id']) && isset($_POST['empfaenger'])) {
  if (($statement = $databaseconnection->prepare("INSERT INTO Nachrichten (Text, Sender, Empfaenger) VALUES (?,?,?)"))
  && ($statement->bind_param('sii',$_POST['text'], $_SESSION['id'], $_POST['empfaenger']))
  && ($statement->execute())) {

  }
} else {
  #hier fehlt noch eine Fehlermeldung
  header("Location: index.php");
  closeConnection($databaseconnection);
  die();
}

header("Location: index.php?tab=".$_POST['empfaenger']);
closeConnection($databaseconnection);

?>
