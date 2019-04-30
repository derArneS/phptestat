<?php

  session_start();

  require "../database/database.php";

  $databaseconnection = createConnection();

  if (($statement = $databaseconnection->prepare("SELECT Passwort FROM Benutzer WHERE Email =?"))
  || ($statement->bind_param('s', $_POST['inputEmail']))
  || ($statement->execute())) {
    $resultset = $statement->get_result();

    if ($resultset->num_rows == 0 || !($row = $resultset->fetch_assoc()) || !password_verify($_POST['inputPassword'], $row['Passwort'])) {
      $_SESSION['error'] = true;
      header('Location: ../welcome');
    } else {
      header('Location: ../welcome/register.php');
    }
  } else {
    $_SESSION['error'];
    header('Location: index.php');
  }

  closeConnection($databaseconnection);
?>
