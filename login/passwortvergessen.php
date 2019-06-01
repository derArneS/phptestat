<?php
//Disclaimer: Diese Seite gibt es nur, da die Einbindung einer Mailfunktion zu umfangreich gewesen wäre...
//Normalerweise erhält der Nutzer den Link per Email.
//So wie es jetzt ist, bietet es keine Sicherheit.
session_start();

require "../database/database.php";

$databaseconnection = createConnection();

//Es wird der Hash des Passworts des Benutzers an die URL gehängt, um als Get-Parameter zu fungieren.
//Dieser ist fast unmöglich zu erraten und lässt keine Rückschlüsse zu dem alten Passwort zu
if (!($statement = $databaseconnection->prepare("SELECT Passwort FROM Benutzer WHERE Email = ?"))
|| !($statement->bind_param('s', $_POST['inputEmailvergessen']))
|| !($statement->execute())
|| !($resultset = $statement->get_result())
|| !($row = $resultset->fetch_assoc())) {
  die();
}

echo "Dieser Link wird eigentlich per Email versendet:";
?>
<br>
<?php

echo '<a href="/login/vergessen.php?email='.$_POST['inputEmailvergessen'].'&link='.$row['Passwort'].'">/login/vergessen.php?email='.$_POST['inputEmailvergessen'].'&link='.$row['Passwort'].'</a>';

 ?>
