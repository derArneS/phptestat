<?php
  session_start();

  require "../database/database.php";

  $databaseconnection = createConnection();

  if (!($statement = $databaseconnection->prepare("SELECT Passwort, Benutzername FROM Benutzer WHERE Email = ? OR Benutzername = ?"))
  || !($statement->bind_param('ss', $_POST['inputEmailBenutzer'], $_POST['inputEmailBenutzer']))
  || !($statement->execute())
  || !($resultset = $statement->get_result())) {
    goto err;
  }

  if ($resultset->num_rows == 0
  || !($row = $resultset->fetch_assoc())) {
    $_SESSION['errorEmailBenutzer'];
    goto err;
  } elseif (!password_verify($_POST['inputPassword'], $row['Passwort'])) {
    $_SESSION['errorPasswort'] = true;
    goto err;
  }

  $_SESSION['benutzername'] = $row['Benutzername'];

  goto noerr;

  err:
  header("Location: index.php");
  closeConnection($databaseconnection);
  die();

  noerr:
  header("Location: ../welcome");
  closeConnection($databaseconnection);
?>
