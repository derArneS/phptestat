<?php

session_start();

if (isset($_GET['marke'])) {
  //Speichern der Suchparameter in die Session, damit bei erneutem Aufruf der Such-Funktion die Parameter wieder eingetragen werden
  $_SESSION['cache']['suche'] = $_GET;
}

//vordefinierte SQL-Statements die nach Auswahl eines Bildes auf der Startseite in der Session abgelegt werden
//wenn diese Action mit marke = 1 (BMW) aufgerufen wird, wird das passende Statement in die Session geschrieben, um alle BMWs aus der Datenbank zu holen
if (isset($_GET['marke']) && $_GET['marke'] == "1") {
  $_SESSION['statement'] = "SELECT Angebote.ID AS Angebot_ID, Benutzer_ID, Titel, Marken_ID, Modell_ID, Preis, Baujahr,
                            Kilometerstand, Leistung, Kraftstoff, Getriebe, Alarmanlage, Anhaengerkupplung,
                            Bluetooth, Bordcomputer, HeadUP, Multilenk, Navi, Regensensor, Sitzheizung, Sound,
                            Standheiz, StartStopp, Bilder.ID AS Bild_ID FROM Angebote, Bilder WHERE Bilder.Angebot_ID = Angebote.ID AND Marken_ID = " . $_GET['marke'] . " ORDER BY Angebote.ID DESC";
  header("Location: ../uebersicht");
  die();
  //wenn diese Action mit marke = 2 (AUDI) aufgerufen wird, wird das passende Statement in die Session geschrieben, um alle Audis aus der Datenbank zu holen
} else if (isset($_GET['marke']) && $_GET['marke'] == "2") {
  $_SESSION['statement'] = "SELECT Angebote.ID AS Angebot_ID, Benutzer_ID, Titel, Marken_ID, Modell_ID, Preis, Baujahr,
                            Kilometerstand, Leistung, Kraftstoff, Getriebe, Alarmanlage, Anhaengerkupplung,
                            Bluetooth, Bordcomputer, HeadUP, Multilenk, Navi, Regensensor, Sitzheizung, Sound,
                            Standheiz, StartStopp, Bilder.ID AS Bild_ID FROM Angebote, Bilder WHERE Bilder.Angebot_ID = Angebote.ID AND Marken_ID = " . $_GET['marke'] . " ORDER BY Angebote.ID DESC";
  header("Location: ../uebersicht");
  die();
  //wenn diese Action mit marke = 7 (PORSCHE) aufgerufen wird, wird das passende Statement in die Session geschrieben, um alle Porsches aus der Datenbank zu holen
} else if (isset($_GET['marke']) && $_GET['marke'] == "7") {
  $_SESSION['statement'] = "SELECT Angebote.ID AS Angebot_ID, Benutzer_ID, Titel, Marken_ID, Modell_ID, Preis, Baujahr,
                            Kilometerstand, Leistung, Kraftstoff, Getriebe, Alarmanlage, Anhaengerkupplung,
                            Bluetooth, Bordcomputer, HeadUP, Multilenk, Navi, Regensensor, Sitzheizung, Sound,
                            Standheiz, StartStopp, Bilder.ID AS Bild_ID FROM Angebote, Bilder WHERE Bilder.Angebot_ID = Angebote.ID AND Marken_ID = " . $_GET['marke'] . " ORDER BY Angebote.ID DESC";
  header("Location: ../uebersicht");
  die();
}

//wenn diese Action mit der ID zu einem Angebot aufgerufen wird, wird das passende Statement in die Session geschrieben, um die Daten zu dem Angebot aus der Datenbank zu laden
if (isset($_GET['id'])) {
  $_SESSION['statement'] = "SELECT Angebote.ID AS Angebot_ID, Benutzer_ID, Titel, Marken_ID, Modell_ID, Preis, Baujahr,
                            Kilometerstand, Leistung, Kraftstoff, Getriebe, Alarmanlage, Anhaengerkupplung,
                            Bluetooth, Bordcomputer, HeadUP, Multilenk, Navi, Regensensor, Sitzheizung, Sound,
                            Standheiz, StartStopp, Bilder.ID AS Bild_ID FROM Angebote, Bilder WHERE Bilder.Angebot_ID = Angebote.ID ORDER BY Angebote.ID DESC";
  header("Location: ../uebersicht/angebot.php?id=" . $_GET['id']);
  die();
}

//Für die Marke/Modell-Suche auf der Welcome-Seite
//Wenn diese Action mit einer Marke (und einem Modell) aufgerufen wird, wird das passende Statement, um alle Angebote zu der Marke (und dem Modell) aus der Datenbank zu holen
if (isset($_POST['marke']) && isset($_POST['modell'])) {
  //Speichern der Suchparameter in die Session, damit bei erneutem Aufruf der Such-Funktion die Parameter wieder eingetragen werden
  $_SESSION['cache']['suche'] = $_POST;
  //Wenn nur die Marke gesetzt wurde
  if ($_POST['marke'] != '' && $_POST['modell'] == '') {
    $_SESSION['statement'] = "SELECT Angebote.ID AS Angebot_ID, Benutzer_ID, Titel, Marken_ID, Modell_ID, Preis, Baujahr,
                              Kilometerstand, Leistung, Kraftstoff, Getriebe, Alarmanlage, Anhaengerkupplung,
                              Bluetooth, Bordcomputer, HeadUP, Multilenk, Navi, Regensensor, Sitzheizung, Sound,
                              Standheiz, StartStopp, Bilder.ID AS Bild_ID FROM Angebote, Bilder WHERE Bilder.Angebot_ID = Angebote.ID AND Marken_ID = " . $_POST['marke'] . " ORDER BY Angebote.ID DESC";
    header("Location: ../uebersicht");
    die();
    //Wenn Marke und Modell gesetzt sind
  } else if ($_POST['marke'] != '' && $_POST['modell'] != '') {
    $_SESSION['statement'] = "SELECT Angebote.ID AS Angebot_ID, Benutzer_ID, Titel, Marken_ID, Modell_ID, Preis, Baujahr,
                              Kilometerstand, Leistung, Kraftstoff, Getriebe, Alarmanlage, Anhaengerkupplung,
                              Bluetooth, Bordcomputer, HeadUP, Multilenk, Navi, Regensensor, Sitzheizung, Sound,
                              Standheiz, StartStopp, Bilder.ID AS Bild_ID FROM Angebote, Bilder WHERE Bilder.Angebot_ID = Angebote.ID AND Marken_ID = " . $_POST['marke'] . " AND Modell_ID = " . $_POST['modell'] . " ORDER BY Angebote.ID DESC";
    header("Location: ../uebersicht");
    die();
    //Wenn weder Marke noch Modell gesetzt sind, werden alle Angebote gesucht
    //Muss gemacht werden, da bei POST die Variablen gesetzt sind, auch wenn sie leer sind
  } else {
    $_SESSION['statement'] = "SELECT Angebote.ID AS Angebot_ID, Benutzer_ID, Titel, Marken_ID, Modell_ID, Preis, Baujahr,
                              Kilometerstand, Leistung, Kraftstoff, Getriebe, Alarmanlage, Anhaengerkupplung,
                              Bluetooth, Bordcomputer, HeadUP, Multilenk, Navi, Regensensor, Sitzheizung, Sound,
                              Standheiz, StartStopp, Bilder.ID AS Bild_ID FROM Angebote, Bilder WHERE Bilder.Angebot_ID = Angebote.ID ORDER BY Angebote.ID DESC";
    header("Location: ../uebersicht");
    die();
  }
}

 ?>
