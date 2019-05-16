
<?php
session_start();
require "../database/database.php";
require "../const/deletecache.php";

$databaseconnection = createConnection();


// PHP-Code Benutzername prüfen
if (isset($_POST['benutzername-neu']) && isset($_POST['benutzername-bestätigen']) && $_POST['benutzername-bestätigen'] == $_POST['benutzername-neu']) {
  if (!($statement = $databaseconnection->prepare("SELECT Benutzername FROM Benutzer WHERE Benutzername=?"))
  || !($statement->bind_param('s', $_POST['benutzername-neu']))
  || !($statement->execute())) {
    $_SESSION['errorBenutzer'] = true;
    goto err;
  } else if (!($resultset = $statement->get_result()) || !($resultset->num_rows === 0)) {
    if ($row = $resultset->fetch_assoc()) {
      $_SESSION['errorBenutzername'] = true;
      goto err;
    }
  }

  if (($statement = $databaseconnection->prepare("UPDATE Benutzer SET Benutzername=? WHERE ID=?"))
  && ($statement->bind_param('si', $_POST['benutzername-neu'], $_SESSION['id']))
  && ($statement->execute())){
    $_SESSION['benutzername'] = $_POST['benutzername-neu'];
    header('Location: index.php?tab=3');
    closeConnection($databaseconnection);
    die();
  }
}

//PHP-Code Vorname einfügen/ändern
if(isset($_POST['vorname-neu']) && isset($_POST['vorname-bestätigen']) && $_POST['vorname-bestätigen'] == $_POST['vorname-neu']){
  if (($statement = $databaseconnection->prepare("UPDATE Benutzer SET Vorname=? WHERE ID=?"))
  && ($statement->bind_param('si', $_POST['vorname-neu'], $_SESSION['id']))
  && ($statement->execute())){
    $_SESSION['vorname'] = $_POST['vorname-neu'];
    header('Location: index.php?tab=3');
    closeConnection($databaseconnection);
    die();
  }
}

//PHP-Code Nachname einfügen/ändern
if(isset($_POST['nachname-neu']) && isset($_POST['nachname-bestätigen']) && $_POST['nachname-bestätigen'] == $_POST['nachname-neu']){
  if (($statement = $databaseconnection->prepare("UPDATE Benutzer SET Nachname=? WHERE ID=?"))
  && ($statement->bind_param('si', $_POST['nachname-neu'], $_SESSION['id']))
  && ($statement->execute())){
    $_SESSION['nachname'] = $_POST['nachname-neu'];
    header('Location: index.php?tab=3');
    closeConnection($databaseconnection);
    die();
  }
}

//PHP-Code E-Mail Adresse ändern
if (isset($_POST['email-neu']) && isset($_POST['email-bestätigen']) && $_POST['email-bestätigen'] == $_POST['email-neu']) {
  if (!($statement = $databaseconnection->prepare("SELECT Email FROM Benutzer WHERE Email=?"))
  || !($statement->bind_param('s', $_POST['email-neu']))
  || !($statement->execute())) {
    $_SESSION['errorEmail'] = true;
    goto err;
  } else if (!($resultset = $statement->get_result()) || !($resultset->num_rows === 0)) {
    if ($row = $resultset->fetch_assoc()) {
      $_SESSION['errorEmail'] = true;
      goto err;
    }
  }

  if (($statement = $databaseconnection->prepare("UPDATE Benutzer SET Email=? WHERE ID=?"))
  && ($statement->bind_param('si', $_POST['email-neu'], $_SESSION['id']))
  && ($statement->execute())){
    header('Location: index.php?tab=3');
    closeConnection($databaseconnection);
    die();
  }
}

//PHP-Code Adresse hinzufügen/ändern
if (isset($_POST['strasse-neu']) && isset($_POST['strasse-bestätigen']) && $_POST['strasse-bestätigen'] == $_POST['strasse-neu']) {
  if (!($statement = $databaseconnection->prepare("SELECT Adress_ID FROM Benutzer WHERE Benutzername=?"))
  || !($statement->bind_param('s', $_SESSION['benutzername']))
  || !($statement->execute())) {
    $_SESSION['errorBenutzer'] = true;
    goto err;
  } else if (($resultset = $statement->get_result()) && !($resultset->num_rows == 0) && ($row = $resultset->fetch_assoc())) {
    if (($statement = $databaseconnection->prepare("UPDATE Adressen SET Strasse=? WHERE ID=?"))
    && ($statement->bind_param('si', $_POST['strasse-neu'], $row['Adress_ID']))
    && ($statement->execute())){
      $_SESSION['strasse'] = $_POST['strasse-neu'];
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
  if (!($statement = $databaseconnection->prepare("SELECT Adress_ID FROM Benutzer WHERE Benutzername=?"))
  || !($statement->bind_param('s', $_SESSION['benutzername']))
  || !($statement->execute())) {
    $_SESSION['errorBenutzer'] = true;
    goto err;
  } else if (($resultset = $statement->get_result()) && !($resultset->num_rows == 0) && ($row = $resultset->fetch_assoc())) {
    if (($statement = $databaseconnection->prepare("UPDATE Adressen SET Postleitzahl=? WHERE ID=?"))
    && ($statement->bind_param('si', $_POST['plz-neu'], $row['Adress_ID']))
    && ($statement->execute())){
      $_SESSION['postleitzahl'] = $_POST['plz-neu'];
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
  if (!($statement = $databaseconnection->prepare("SELECT Adress_ID FROM Benutzer WHERE Benutzername=?"))
  || !($statement->bind_param('s', $_SESSION['benutzername']))
  || !($statement->execute())) {
    $_SESSION['errorBenutzer'] = true;
    goto err;
  } else if (($resultset = $statement->get_result()) && !($resultset->num_rows == 0) && ($row = $resultset->fetch_assoc())) {
    if (($statement = $databaseconnection->prepare("UPDATE Adressen SET Ort=? WHERE ID=?"))
    && ($statement->bind_param('si', $_POST['stadt-neu'], $row['Adress_ID']))
    && ($statement->execute())){
      $_SESSION['stadt'] = $_POST['stadt-neu'];
      header('Location: index.php?tab=3');
      closeConnection($databaseconnection);
      die();
    } else {
      $_SESSION['test'] = true;
    }
  }
}

//PHP-Code Passwort ändern
if(isset($_POST['passwort-neu']) && isset($_POST['passwort-bestätigen']) && $_POST['passwort-bestätigen'] == $_POST['passwort-neu']){
  $passwordHash = password_hash($_POST['passwort-neu'], PASSWORD_BCRYPT);
  if (($statement = $databaseconnection->prepare("UPDATE Benutzer SET Passwort=? WHERE ID=?"))
  && ($statement->bind_param('si', $passwordHash, $_SESSION['id']))
  && ($statement->execute())){
    header('Location: index.php?tab=3');
    closeConnection($databaseconnection);
    die();
  }
}

print_r($_SESSION);
print_r($_POST);

err:
#header("Location: index.php?tab=1");
closeConnection($databaseconnection);
die();

?>
