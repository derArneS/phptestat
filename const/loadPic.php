<?php
session_start();

require '../database/database.php';

$databaseconnection = createConnection();

if (isset($_GET['id'])) {
  if (($statement = $databaseconnection->prepare("SELECT * FROM Bilder WHERE ID=?"))
  && ($statement->bind_param('i', $_GET['id']))
  && ($statement->execute())
  && ($resultset = $statement->get_result())
  && ($row = $resultset->fetch_assoc())) {
    header('Content-type: ' . $row['Typ']);
    echo $row['Bild'];
  } else {
    header("Location: ../pics/404.PNG");
  }
} else {
  header("Location: ../pics/404.PNG");
}

closeConnection($databaseconnection);
?>
