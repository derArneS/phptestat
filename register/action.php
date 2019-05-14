<?php

  session_start();

  require "../database/database.php";
  require '../const/deletecache.php';

  if (isset($_SESSION['benutzername'])) {
    goto err;
  }

  $databaseconnection = createConnection();

  if ($_POST['inputPassword'] !== $_POST['inputPassword2']) {
    $_SESSION['errorPasswort'] = true;
    goto err;
  }

  if (!($statement = $databaseconnection->prepare("SELECT Benutzername, Email FROM Benutzer WHERE Benutzername=? OR Email=?"))
  || !($statement->bind_param('ss', $_POST['inputBenutzername'], $_POST['inputEmail']))
  || !($statement->execute())) {
    $_SESSION['errorBenutzer'] = true;
    goto err;
  } else if (!($resultset = $statement->get_result()) || !($resultset->num_rows === 0)) {
    if ($row = $resultset->fetch_assoc()) {
      if ($_POST['inputEmail'] == $row['Email']) {
        $_SESSION['errorEmail'] = true;
        goto err;
      } else if ($_POST['inputBenutzername'] == $row['Benutzername']) {
        $_SESSION['errorBenutzername'] = true;
        goto err;
      }
    }
  }

  $passwordHash = password_hash($_POST['inputPassword'], PASSWORD_BCRYPT);

  if (!($statement = $databaseconnection->prepare("INSERT INTO Adressen (Ort) VALUES (null)"))
  || !($statement->execute())) {
    $_SESSION['errorRegister'] = true;
    goto err;
  } else {
    $adressid = $databaseconnection->insert_id;
    if (!($statement = $databaseconnection->prepare("INSERT INTO Benutzer (Benutzername, Email, Passwort, Adress_ID) VALUES (?, ?, ?, ?)"))
    || !($statement->bind_param('sssi', $_POST['inputBenutzername'], $_POST['inputEmail'], $passwordHash, $adressid))
    || !($statement->execute())) {
      $_SESSION['errorRegister'] = true;
      goto err;
    }
  }


  $_SESSION['benutzername'] = $_POST['inputBenutzername'];
  $_SESSION['id'] = $databaseconnection->insert_id;

  goto noerr;

  err:
  header("Location: index.php");
  closeConnection($databaseconnection);
  die();

  noerr:
  $_SESSION['errorRegister'] = false;
  header("Location: ../welcome");
  closeConnection($databaseconnection);

?>
