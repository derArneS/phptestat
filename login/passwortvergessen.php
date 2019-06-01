<?php

session_start();

require "../database/database.php";

$databaseconnection = createConnection();

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
