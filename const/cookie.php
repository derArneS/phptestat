<?php
function cookie (){

  require "../database/database.php";

  if (isset($_COOKIE['benutzername']) && isset($_COOKIE['passwort'])) {
    if (!isset($_SESSION['benutzername'])) {
      $databaseconnection = createConnection();
      if (($statement = $databaseconnection->prepare("SELECT Passwort FROM Benutzer WHERE Benutzername = ?"))
      && ($statement->bind_param('s', $_COOKIE['benutzername']))
      && ($statement->execute())
      && ($resultset = $statement->get_result())
      && !($resultset->num_rows == 0)
      && ($row = $resultset->fetch_assoc())) {
        if ($_COOKIE['passwort'] == $row['Passwort']) {
          $_SESSION['benutzername'] = $_COOKIE['benutzername'];
        }
      }
      closeConnection($databaseconnection);
    }
  }
}

?>
