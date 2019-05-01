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
    $_SESSION['errorEmailBenutzer'] = true;
    goto err;
  } elseif (!password_verify($_POST['inputPassword'], $row['Passwort'])) {
    $_SESSION['errorPasswort'] = true;
    goto err;
  }

  $_SESSION['benutzername'] = $row['Benutzername'];
  setcookie("benutzername", $row['Benutzername'], time() + 60 * 60 * 24, "/");
  setcookie("passwort", $row['Passwort'], time() + 60 * 60 * 24, "/");

  goto noerr;

  err:
  header("Location: index.php");
  closeConnection($databaseconnection);
  die();

  noerr:
  if ($_POST["inputRememberPassword"] == "cookie") {
    header("Location: ../const/cookie.php");
  } else  {
    header("Location: ../welcome");
  }
  closeConnection($databaseconnection);
?>
