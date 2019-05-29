
<?php
/*
   In dieser Datei ist der PHP-Code für die Änderung von den Profildaten.
   Dabei wird bei jedem Änderungswunsch geprüft ob die entsprechend benötigten Felder ausgefüllt sind.
*/
session_start();
require "../database/database.php";
require "../const/deletecache.php";

$databaseconnection = createConnection();


// PHP-Code Benutzername prüfen
if (isset($_POST['benutzername-neu']) && isset($_POST['benutzername-bestätigen']) && $_POST['benutzername-bestätigen'] == $_POST['benutzername-neu']) {
  //Abfrage der Datenbank, ob der Benutzername in der Tabelle steht
  if (!($statement = $databaseconnection->prepare("SELECT Benutzername FROM Benutzer WHERE Benutzername=?"))
  || !($statement->bind_param('s', $_POST['benutzername-neu']))
  || !($statement->execute())) {
    $_SESSION['errorBenutzer'] = true;
    goto err;
    //Überprüfung ob das Resultset nicht leer ist
  } else if (!($resultset = $statement->get_result()) || !($resultset->num_rows === 0)) {
    if ($row = $resultset->fetch_assoc()) {
      $_SESSION['errorBenutzername'] = true;
      goto err;
    }
  }
  //Falls der Benutzername noch nicht vergeben wurde, wird dieser in der Tabelle Benutzer geupdatet
  if (($statement = $databaseconnection->prepare("UPDATE Benutzer SET Benutzername=? WHERE ID=?"))
  && ($statement->bind_param('si', $_POST['benutzername-neu'], $_SESSION['id']))
  && ($statement->execute())){
    //Der neue Benutzername wird ausßerdem in der Session überschrieben
    $_SESSION['benutzername'] = $_POST['benutzername-neu'];
    //Das Profil wird wieder angezeigt mit dem aktiven Tab Persönliche Daten, danach wird die Datenbankconnection geschlossen
    header('Location: index.php?tab=3');
    closeConnection($databaseconnection);
    die();
  }
}

//PHP-Code Vorname einfügen/ändern
if(isset($_POST['vorname-neu']) && isset($_POST['vorname-bestätigen']) && $_POST['vorname-bestätigen'] == $_POST['vorname-neu']){
  //Der Vorname wird in der Tabelle Benutzer geupdatet
  if (($statement = $databaseconnection->prepare("UPDATE Benutzer SET Vorname=? WHERE ID=?"))
  && ($statement->bind_param('si', $_POST['vorname-neu'], $_SESSION['id']))
  && ($statement->execute())){
    //Der Vorname wird in die Session eingefügt/überschrieben
    $_SESSION['vorname'] = $_POST['vorname-neu'];
    //Das Profil wird wieder angezeigt mit dem aktiven Tab Persönliche Daten, danach wird die Datenbankconnection geschlossen
    header('Location: index.php?tab=3');
    closeConnection($databaseconnection);
    die();
  }
}

//PHP-Code Nachname einfügen/ändern
if(isset($_POST['nachname-neu']) && isset($_POST['nachname-bestätigen']) && $_POST['nachname-bestätigen'] == $_POST['nachname-neu']){
  //Der Nachname wird in der Tabelle Benutzer geupdatet
  if (($statement = $databaseconnection->prepare("UPDATE Benutzer SET Nachname=? WHERE ID=?"))
  && ($statement->bind_param('si', $_POST['nachname-neu'], $_SESSION['id']))
  && ($statement->execute())){
    //Der Nachname wird in die Session eingefügt/überschrieben
    $_SESSION['nachname'] = $_POST['nachname-neu'];
    //Das Profil wird wieder angezeigt mit dem aktiven Tab Persönliche Daten, danach wird die Datenbankconnection geschlossen
    header('Location: index.php?tab=3');
    closeConnection($databaseconnection);
    die();
  }
}

//PHP-Code E-Mail Adresse ändern
if (isset($_POST['email-neu']) && isset($_POST['email-bestätigen']) && $_POST['email-bestätigen'] == $_POST['email-neu']) {
  //Überprüfung ob die E-Mail bereits von einem anderen User registriert ist
  if (!($statement = $databaseconnection->prepare("SELECT Email FROM Benutzer WHERE Email=?"))
  || !($statement->bind_param('s', $_POST['email-neu']))
  || !($statement->execute())) {
    $_SESSION['errorEmail'] = true;
    goto err;
    //Überprüfung ob das Resultset nicht leer ist
  } else if (!($resultset = $statement->get_result()) || !($resultset->num_rows === 0)) {
    if ($row = $resultset->fetch_assoc()) {
      $_SESSION['errorEmail'] = true;
      goto err;
    }
  }
  //Falls die E-Mail noch nicht von einem anderen Benutzer registriert ist, wird die E-Mail in der Tabelle Benutzer geupdatet
  if (($statement = $databaseconnection->prepare("UPDATE Benutzer SET Email=? WHERE ID=?"))
  && ($statement->bind_param('si', $_POST['email-neu'], $_SESSION['id']))
  && ($statement->execute())){
    //Das Profil wird wieder angezeigt mit dem aktiven Tab Persönliche Daten, danach wird die Datenbankconnection geschlossen
    header('Location: index.php?tab=3');
    closeConnection($databaseconnection);
    die();
  }
}

//PHP-Code Adresse hinzufügen/ändern
if (isset($_POST['strasse-neu']) && isset($_POST['strasse-bestätigen']) && $_POST['strasse-bestätigen'] == $_POST['strasse-neu']) {
  //Die Adress-ID des Benutzers wird selektiert
  if (!($statement = $databaseconnection->prepare("SELECT Adress_ID FROM Benutzer WHERE Benutzername=?"))
  || !($statement->bind_param('s', $_SESSION['benutzername']))
  || !($statement->execute())) {
    $_SESSION['errorBenutzer'] = true;
    goto err;
    //Das Ergebnis aus der Abfrage wird in die $row geschrieben
  } else if (($resultset = $statement->get_result()) && !($resultset->num_rows == 0) && ($row = $resultset->fetch_assoc())) {
    //Die Strasse wird in der Tabelle Benutzer geupdatet
    //Es wird auf die Tabelle Adressen zugegriffen die die AdressID vom vorher selektierten Benutzer hat
    if (($statement = $databaseconnection->prepare("UPDATE Adressen SET Strasse=? WHERE ID=?"))
    && ($statement->bind_param('si', $_POST['strasse-neu'], $row['Adress_ID']))
    && ($statement->execute())){
      //Die Strasse wird in die Session eingefügt/überschrieben
      $_SESSION['strasse'] = $_POST['strasse-neu'];
      //Das Profil wird wieder angezeigt mit dem aktiven Tab Persönliche Daten, danach wird die Datenbankconnection geschlossen
      header('Location: index.php?tab=3');
      closeConnection($databaseconnection);
      die();
    } else {
      $_SESSION['test'] = true;
    }
  }
}

//PHP-Code Postleitzahl hinzufügen/ändern
if (isset($_POST['plz-neu']) && isset($_POST['plz-bestätigen']) && $_POST['plz-bestätigen'] == $_POST['plz-neu'] && is_numeric($_POST['plz-neu'])) {
  //Die Adress-ID des Benutzers wird selektiert
  if (!($statement = $databaseconnection->prepare("SELECT Adress_ID FROM Benutzer WHERE Benutzername=?"))
  || !($statement->bind_param('s', $_SESSION['benutzername']))
  || !($statement->execute())) {
    $_SESSION['errorBenutzer'] = true;
    goto err;
    //Das Ergebnis aus der Abfrage wird in die $row geschrieben
  } else if (($resultset = $statement->get_result()) && !($resultset->num_rows == 0) && ($row = $resultset->fetch_assoc())) {
    //Die Postleitzahl wird in der Tabelle Benutzer geupdatet
    //Es wird auf die Tabelle Adressen zugegriffen die die AdressID vom vorher selektierten Benutzer hat
    if (($statement = $databaseconnection->prepare("UPDATE Adressen SET Postleitzahl=? WHERE ID=?"))
    && ($statement->bind_param('si', $_POST['plz-neu'], $row['Adress_ID']))
    && ($statement->execute())){
      //Die Postleitzahl wird in die Session eingefügt/überschrieben
      $_SESSION['postleitzahl'] = $_POST['plz-neu'];
      //Das Profil wird wieder angezeigt mit dem aktiven Tab Persönliche Daten, danach wird die Datenbankconnection geschlossen
      header('Location: index.php?tab=3');
      closeConnection($databaseconnection);
      die();
    } else {
      $_SESSION['test'] = true;
    }
  }
}


//PHP-Code Stadt hinzufügen/ändern
if (isset($_POST['stadt-neu']) && isset($_POST['stadt-bestätigen']) && $_POST['stadt-bestätigen'] == $_POST['stadt-neu']) {
  //Die Adress-ID des Benutzers wird selektiert
  if (!($statement = $databaseconnection->prepare("SELECT Adress_ID FROM Benutzer WHERE Benutzername=?"))
  || !($statement->bind_param('s', $_SESSION['benutzername']))
  || !($statement->execute())) {
    $_SESSION['errorBenutzer'] = true;
    goto err;
    //Das Ergebnis aus der Abfrage wird in die $row geschrieben
  } else if (($resultset = $statement->get_result()) && !($resultset->num_rows == 0) && ($row = $resultset->fetch_assoc())) {
    //Die Stadt wird in der Tabelle Benutzer geupdatet
    //Es wird auf die Tabelle Adressen zugegriffen die die AdressID vom vorher selektierten Benutzer hat
    if (($statement = $databaseconnection->prepare("UPDATE Adressen SET Ort=? WHERE ID=?"))
    && ($statement->bind_param('si', $_POST['stadt-neu'], $row['Adress_ID']))
    && ($statement->execute())){
      //Die Stadt wird in die Session eingefügt/überschrieben
      $_SESSION['stadt'] = $_POST['stadt-neu'];
      //Das Profil wird wieder angezeigt mit dem aktiven Tab Persönliche Daten, danach wird die Datenbankconnection geschlossen
      header('Location: index.php?tab=3');
      closeConnection($databaseconnection);
      die();
    } else {
      $_SESSION['test'] = true;
    }
  }
}

//PHP-Code Passwort ändern
if(isset($_POST['passwort-alt']) && isset($_POST['passwort-neu']) && isset($_POST['passwort-bestätigen']) && $_POST['passwort-bestätigen'] == $_POST['passwort-neu']){
  //Der aktuelle Passwort-Hash wird selektiert und in die $row geschrieben
  if (($statement = $databaseconnection->prepare("SELECT Passwort FROM Benutzer WHERE ID=?"))
  && ($statement->bind_param('i', $_SESSION['id']))
  && ($statement->execute())){
    $resultset = $statement->get_result();
    $row = $resultset->fetch_assoc();
    //Überprüfung ob das Passwort "Altes Passwort" mit dem aktuellen Passwort in der Datenbank übereinstimmt
    if(password_verify($_POST['passwort-alt'], $row['Passwort'])){
      //Das neue Passwort wird gehasht
      $passwordHash = password_hash($_POST['passwort-neu'], PASSWORD_BCRYPT);
      //Das gehashte Passwort wird in die Datenbank eingefügt
      if (($statement = $databaseconnection->prepare("UPDATE Benutzer SET Passwort=? WHERE ID=?"))
      && ($statement->bind_param('si', $passwordHash, $_SESSION['id']))
      && ($statement->execute())){
        header('Location: index.php?tab=3');
        //Das Profil wird wieder angezeigt mit dem aktiven Tab Persönliche Daten, danach wird die Datenbankconnection geschlossen
        closeConnection($databaseconnection);
        die();
      }
    } else {
      $_SESSION['passwort'] = true;
    }
  }

}

//Wenn ein Fehler auftritt, wird die profil/index.php Datei wieder eingeblendet und die Datenbankconnection geschlossen
err:
header("Location: index.php?tab=3");
closeConnection($databaseconnection);
die();

?>
