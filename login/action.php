<?php
  session_start();

  require "../database/database.php";
  require "../const/root.php";

  $databaseconnection = createConnection();

  //SQL-Statement holt sich die Daten des Benutzers welcher sich über die Inputfelder E-Mail und Passwort einloggt
  if (!($statement = $databaseconnection->prepare("SELECT * FROM Benutzer WHERE Email = ? OR Benutzername = ?"))
  || !($statement->bind_param('ss', $_POST['inputEmailBenutzer'], $_POST['inputEmailBenutzer']))
  || !($statement->execute())
  //Ergebniss wird ins Resultset geschrieben
  || !($resultset = $statement->get_result())) {
    goto err;
  }
  //Wenn kein Benutzer mit der eingegeben E-Mail gefunden wurde, wird auf der Login-Seite eine Fehlermeldung angezeigt
  if ($resultset->num_rows == 0
  || !($row = $resultset->fetch_assoc())) {
    $_SESSION['errorEmailBenutzer'] = true;
    goto err;
    //Wenn das Passwort nicht mit dem hinterlegten Passwort in der Datenbank übereinstimmt, wird auf der Login-Seite eine Fehlermeldung angezeigt
  } elseif (!password_verify($_POST['inputPassword'], $row['Passwort'])) {
    $_SESSION['errorPasswort'] = true;
    goto err;
  }

  //SQL-Statement für die Adressdaten des eingeloggten Benutzers
  if (!($statement2 = $databaseconnection->prepare("SELECT * FROM Adressen WHERE ID=?"))
  || !($statement2->bind_param('i', $row['Adress_ID']))
  || !($statement2->execute())
    //Ergebnisse werden ins $resultset2 geschrieben
  || !($resultset2 = $statement2->get_result())) {
    //Adressdaten werden in die Session geschrieben
  } else if ($row2 = $resultset2->fetch_assoc()) {
    $_SESSION['strasse'] = $row2['Strasse'];
    $_SESSION['postleitzahl'] = $row2['Postleitzahl'];
    $_SESSION['stadt'] = $row2['Ort'];
  }

  //Benutzerdaten werden in die Session geschrieben
  $_SESSION['benutzername'] = $row['Benutzername'];
  $_SESSION['id'] = $row['ID'];

  //Wenn der Benutzer bereits einen Vornamen im Profil hinterlegt hat, wird dieser auch in die Session geschrieben
  if ($row['Vorname'] != '') {
      $_SESSION['vorname'] = $row['Vorname'];
  }

  //Wenn der Benutzer bereits einen Nachnamen im Profil hinterlegt hat, wird dieser auch in die Session geschrieben
  if ($row['Nachname'] != '') {
      $_SESSION['nachname'] = $row['Nachname'];
  }

  goto noerr;

  err:
  header("Location: index.php");
  closeConnection($databaseconnection);
  die();

  noerr:
  //Wenn die Checkbox "Passwort speichern" aktiviert wurde wird der Benutzername und das Passwort als Hash in Cookies abgelegt
  if (isset($_POST['inputRememberPassword']) && $_POST["inputRememberPassword"] == "cookie") {
    setcookie("benutzername", $row['Benutzername'], time() + 60 * 60 * 24, "/");
    setcookie("passwort", $row['Passwort'], time() + 60 * 60 * 24, "/");
  }
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
