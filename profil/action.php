<?php
session_start();

require "../database/database.php";
require "../const/root.php";

$databaseconnection = createConnection();

if (!($statement = $databaseconnection->prepare("UPDATE Benutzer set benutzername=(?) where id=14"))
|| !($statement->bind_param('s', $_POST['benutzername-neu']))
|| !($statement->execute()))

closeConnection($databaseconnection);
?>
