<?php

session_start();
require "../database/database.php";
print_r($_POST);

$databaseconnection = createConnection();

if(isset($_POST['email']) && isset($_POST['pwd']) && isset($_POST['inputPassword']) && isset($_POST['inputPassword2']) && $_POST['inputPassword'] == $_POST['inputPassword2']){
  //Der aktuelle Passwort-Hash wird selektiert und in die $row geschrieben
  if (($statement = $databaseconnection->prepare("SELECT * FROM Benutzer WHERE Email=?"))
  && ($statement->bind_param('s', $_POST['email']))
  && ($statement->execute())){
    $resultset = $statement->get_result();
    $row = $resultset->fetch_assoc();

    //Wenn der übermittelte und der ausgelesene Hash übereinstimmen
    if($row['Passwort'] == $_POST['pwd']) {
      //Das neue Passwort wird gehasht
      $passwordHash = password_hash($_POST['inputPassword2'], PASSWORD_BCRYPT);
      //Das gehashte Passwort wird in die Datenbank eingefügt
      if (($statement = $databaseconnection->prepare("UPDATE Benutzer SET Passwort=? WHERE Email=?"))
      && ($statement->bind_param('ss', $passwordHash, $_POST['email']))
      && ($statement->execute())){

        if (!($statement2 = $databaseconnection->prepare("SELECT * FROM Adressen WHERE ID=?"))
        || !($statement2->bind_param('i', $row['Adress_ID']))
        || !($statement2->execute())
        || !($resultset2 = $statement2->get_result())) {
        } else if ($row2 = $resultset2->fetch_assoc()) {
          //Adressdaten werden in die Session geschrieben
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
      }
    }
  }
}

header("Location: /");
closeConnection($databaseconnection);
 ?>
