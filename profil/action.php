
<?php
session_start();
require "../database/database.php";

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

  if (($statement = $databaseconnection->prepare("UPDATE Benutzer set benutzername=? where id=?"))
  && ($statement->bind_param('si', $_POST['benutzername-neu'], $_SESSION['id']))
  && ($statement->execute())){
    $_SESSION['benutzername'] = $_POST['benutzername-neu'];
    header('Location: index.php');
    closeConnection($databaseconnection);
    die();
  }
}

//PHP-Code Vorname einfügen/ändern
if(isset($_POST['vorname-neu']) && isset($_POST['vorname-bestätigen']) && $_POST['vorname-bestätigen'] == $_POST['vorname-neu']){
  if (($statement = $databaseconnection->prepare("UPDATE Benutzer set vorname=? where id=?"))
  && ($statement->bind_param('si', $_POST['vorname-neu'], $_SESSION['id']))
  && ($statement->execute())){
    header('Location: index.php');
    closeConnection($databaseconnection);
    die();
  }
}

//PHP-Code Nachname einfügen/ändern
if(isset($_POST['nachname-neu']) && isset($_POST['nachname-bestätigen']) && $_POST['nachname-bestätigen'] == $_POST['nachname-neu']){
  if (($statement = $databaseconnection->prepare("UPDATE Benutzer set nachname=? where id=?"))
  && ($statement->bind_param('si', $_POST['nachname-neu'], $_SESSION['id']))
  && ($statement->execute())){
    header('Location: index.php');
    closeConnection($databaseconnection);
    die();
  }
}

err:
header("Location: index.php");
closeConnection($databaseconnection);
die();

?>
