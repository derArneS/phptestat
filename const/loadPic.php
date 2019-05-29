<?php
session_start();

require '../database/database.php';
//Erstellt eine Datenbankverbindung
$databaseconnection = createConnection();
//Überprüft, ob ein zu ladendes Bild in der Datenbank hinterlegt ist.
if (isset($_GET['id'])) {
//Wenn ja, wird das Bild aus der DB geladen.
  if (($statement = $databaseconnection->prepare("SELECT * FROM Bilder WHERE ID=?"))
  && ($statement->bind_param('i', $_GET['id']))
  && ($statement->execute())
  && ($resultset = $statement->get_result())
  && ($row = $resultset->fetch_assoc())) {
    header('Content-type: ' . $row['Typ']);
    echo $row['Bild'];
//Wenn das Bild ohne ID geladen wird, wird mit einem Platzhalterbild gearbeitet, das in 404.png hinterlegt ist.
  } else {
    header("Location: ../pics/404.PNG");
  }
//Wenn die ID nicht in der DB hinterlegt ist, wird mit einem Platzhalterbild gearbeitet, das in 404.png hinterlegt ist.
} else {
  header("Location: ../pics/404.PNG");
}
//Schließt die Datenbankverbindung
closeConnection($databaseconnection);
?>
