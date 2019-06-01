<?php
//Schaut ob Cookies gesetzt sind
if (isset($_COOKIE['benutzername']) && isset($_COOKIE['passwort'])) {
  //Wenn man nicht eingeloggt ist, wird man eingeloggt
  if (!isset($_SESSION['benutzername'])) {
    $databaseconnection = createConnection();
    //Es wird der Passwort-Hash aus der DB geholt, von dem Benutzer, der die Cookies auf dem Rechner hat
    if (($statement = $databaseconnection->prepare("SELECT * FROM Benutzer WHERE Benutzername = ?"))
    && ($statement->bind_param('s', $_COOKIE['benutzername']))
    && ($statement->execute())
    && ($resultset = $statement->get_result())
    && !($resultset->num_rows == 0)
    && ($row = $resultset->fetch_assoc())) {
      //Wenn der Hash gleich dem gespeichertdem Hash ist, wird man eingeloggt, indem die relevanten Daten in die Session geschrieben werden
      if ($_COOKIE['passwort'] == $row['Passwort']) {

          //Die Adresse des Benutzers holen
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



?>
