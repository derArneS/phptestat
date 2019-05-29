<?php
session_start();

//Wenn für die Suche was im Cache gespeichert ist, werden diese Einträge gelöscht. Dadurch werden dann bei erneutem Aufrufen der Suche-Seite alle Felder leer angezeigt
if (isset($_SESSION['cache']['suche'])) {
  unset($_SESSION['cache']['suche']);
}

//zurück zur Suche
header("Location: index.php");

 ?>
