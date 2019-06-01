<?php

  session_start();

  require "../database/database.php";
  require '../const/deletecache.php';
  require "../const/root.php";

  //Falls schon ein Benutzer in der Session ist, dann springe zu "err"
  if (isset($_SESSION['benutzername'])) {
    goto err;
  }

  $databaseconnection = createConnection();

  //Falls die beiden eingegeben Passwörter nicht übereinstimmen, dann wird die Fehlermeldung für das Passwort eingeblendet und zu "err" gesprungen
  if ($_POST['inputPassword'] !== $_POST['inputPassword2']) {
    $_SESSION['errorPasswort'] = true;
    goto err;
  }

  //SQL-Statement für den Benutzernamen und E-Mail von den eingegeben Daten
  if (!($statement = $databaseconnection->prepare("SELECT Benutzername, Email FROM Benutzer WHERE Benutzername=? OR Email=?"))
  || !($statement->bind_param('ss', $_POST['inputBenutzername'], $_POST['inputEmail']))
  || !($statement->execute())) {
    $_SESSION['errorBenutzer'] = true;
    goto err;
    //Das Ergebnis des Statements wird ins Resultset geschrieben und anschließend in die row
  } else if (!($resultset = $statement->get_result()) || !($resultset->num_rows === 0)) {
    if ($row = $resultset->fetch_assoc()) {
      //Wenn die eingebene E-Mail bei der Regristierung mit der aus der row übereistimmt, dann wird die E-Mail-Fehlermeldung eingeblendet
      if ($_POST['inputEmail'] == $row['Email']) {
        $_SESSION['errorEmail'] = true;
        goto err;
        //Wenn der eingebene Benutzername bei der Regristierung mit der aus der row übereistimmt, dann wird die Benutzername-Fehlermeldung eingeblendet
      } else if ($_POST['inputBenutzername'] == $row['Benutzername']) {
        $_SESSION['errorBenutzername'] = true;
        goto err;
      }
    }
  }

  //Das eingebene Passwort wird gehasht
  $passwordHash = password_hash($_POST['inputPassword'], PASSWORD_BCRYPT);

  //Bei der Regristrierung wird in der Tabelle für jeden Benutzer eine leere Adresszeile eingefügt
  if (!($statement = $databaseconnection->prepare("INSERT INTO Adressen (Ort) VALUES (null)"))
  || !($statement->execute())) {
    $_SESSION['errorRegister'] = true;
    goto err;
  } else {
    //Adress ID für den Benutzer
    $adressid = $databaseconnection->insert_id;
    //Der Benutzer wird angelegt indem in der Tabelle Benutzer der Benutzername, Email, Passwort und die AdressID für den Verweis auf die Tabelle Adressen
    $inputBenutzername = htmlspecialchars(stripslashes($_POST['inputBenutzername']));
    $inputEmail = htmlspecialchars(stripslashes($_POST['inputEmail']));
    if (!($statement = $databaseconnection->prepare("INSERT INTO Benutzer (Benutzername, Email, Passwort, Adress_ID) VALUES (?, ?, ?, ?)"))
    || !($statement->bind_param('sssi', $inputBenutzername, $inputEmail, $passwordHash, $adressid))
    || !($statement->execute())) {
      $_SESSION['errorRegister'] = true;
      goto err;
    }
  }

  //Der Benutzername und die ID des aktuellen Benutzers werden nach der Registrierung in die Session geschrieben
  $_SESSION['benutzername'] = $_POST['inputBenutzername'];
  //Inklusive Zuweisung einer ID
  $_SESSION['id'] = $databaseconnection->insert_id;

  goto noerr;

  err:
  header("Location: index.php");
  closeConnection($databaseconnection);
  die();

  noerr:
  $_SESSION['errorRegister'] = false;
  //Wenn ein link aufgerufen wurde und man noch nicht angemeldet ist, wird man auf die Login-Seite verwiesen.
  //Anschließend wird nach erfolgreichen Login auf die gewünschte Seite die durch den Link aufgerufen verwiesen.
  if (isset($_SESSION['redirect'])) {
    header("Location: " . root . $_SESSION['redirect']);
    unset($_SESSION['redirect']);
  } else {
    header("Location: ../welcome");
  }
  closeConnection($databaseconnection);

?>
