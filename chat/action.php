<?php

session_start();

require '../database/database.php';
$databaseconnection = createConnection();
require "../const/cookie.php";
require '../const/deletecache.php';


//nur ausführen, wenn sowohl Text als auch Sender und Empfänger bekannt sind
if (isset($_POST['text']) && isset($_SESSION['id']) && isset($_POST['empfaenger'])) {
  $text = htmlspecialchars(stripslashes($_POST['text']));
  $empfaenger = htmlspecialchars(stripslashes($_POST['empfaenger']));
  //Nachrichten in die Nachrichten-Tabelle eintragen
  if (($statement = $databaseconnection->prepare("INSERT INTO Nachrichten (Text, Sender, Empfaenger) VALUES (?,?,?)"))
  && ($statement->bind_param('sii', $text, $_SESSION['id'], $empfaenger))
  && ($statement->execute())) {

  }
} else {
  header("Location: index.php");
  closeConnection($databaseconnection);
  die();
}

//Weiterleiten zum Chat, mit dem richtigen Tab ausgewählt
header("Location: index.php?tab=".$_POST['empfaenger']);
closeConnection($databaseconnection);

?>
