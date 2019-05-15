<?php
  session_start();

  require "../database/database.php";
  require "../const/root.php";

  $databaseconnection = createConnection();

  if (!($statement = $databaseconnection->prepare("SELECT * FROM Benutzer WHERE Email = ? OR Benutzername = ?"))
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


  if (!($statement2 = $databaseconnection->prepare("SELECT * FROM Adressen WHERE ID=?"))
  || !($statement2->bind_param('i', $row['Adress_ID']))
  || !($statement2->execute())
  || !($resultset2 = $statement2->get_result())) {

  } else if ($row2 = $resultset2->fetch_assoc()) {
    $_SESSION['strasse'] = $row2['Strasse'];
    $_SESSION['postleitzahl'] = $row2['Postleitzahl'];
    $_SESSION['stadt'] = $row2['Ort'];
  }


  $_SESSION['benutzername'] = $row['Benutzername'];
  $_SESSION['id'] = $row['ID'];

  if ($row['Vorname'] != '') {
      $_SESSION['vorname'] = $row['Vorname'];
  }

  if ($row['Nachname'] != '') {
      $_SESSION['nachname'] = $row['Nachname'];
  }

  print_r($_SESSION);
  print_r($row);
  print_r($row2);

  goto noerr;

  err:
  header("Location: index.php");
  closeConnection($databaseconnection);
  die();

  noerr:
  if (isset($_POST['inputRememberPassword']) && $_POST["inputRememberPassword"] == "cookie") {
    setcookie("benutzername", $row['Benutzername'], time() + 60 * 60 * 24, "/");
    setcookie("passwort", $row['Passwort'], time() + 60 * 60 * 24, "/");
  }

  if (isset($_SESSION['redirect'])) {
    header("Location: " . root . $_SESSION['redirect']);
    unset($_SESSION['redirect']);
  } else {
    header("Location: ../welcome");
  }
  closeConnection($databaseconnection);
?>
