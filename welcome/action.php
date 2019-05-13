<?php

session_start();

$_SESSION['cache']['suche'] = $_GET;

if (isset($_GET['marke']) && $_GET['marke'] == "1") {
  $_SESSION['statement'] = "SELECT Angebote.ID AS Angebot_ID, Benutzer_ID, Titel, Marken_ID, Modell_ID, Preis, Baujahr,
                            Kilometerstand, Leistung, Kraftstoff, Getriebe, Alarmanlage, Anhaengerkupplung,
                            Bluetooth, Bordcomputer, HeadUP, Multilenk, Navi, Regensensor, Sitzheizung, Sound,
                            Standheiz, StartStopp, Bilder.ID AS Bild_ID FROM Angebote, Bilder WHERE Bilder.Angebot_ID = Angebote.ID AND Marken_ID = " . $_GET['marke'];
  header("Location: ../uebersicht");
} else if (isset($_GET['marke']) && $_GET['marke'] == "2") {
  $_SESSION['statement'] = "SELECT Angebote.ID AS Angebot_ID, Benutzer_ID, Titel, Marken_ID, Modell_ID, Preis, Baujahr,
                            Kilometerstand, Leistung, Kraftstoff, Getriebe, Alarmanlage, Anhaengerkupplung,
                            Bluetooth, Bordcomputer, HeadUP, Multilenk, Navi, Regensensor, Sitzheizung, Sound,
                            Standheiz, StartStopp, Bilder.ID AS Bild_ID FROM Angebote, Bilder WHERE Bilder.Angebot_ID = Angebote.ID AND Marken_ID = " . $_GET['marke'];
  header("Location: ../uebersicht");
} else if (isset($_GET['marke']) && $_GET['marke'] == "7") {
  $_SESSION['statement'] = "SELECT Angebote.ID AS Angebot_ID, Benutzer_ID, Titel, Marken_ID, Modell_ID, Preis, Baujahr,
                            Kilometerstand, Leistung, Kraftstoff, Getriebe, Alarmanlage, Anhaengerkupplung,
                            Bluetooth, Bordcomputer, HeadUP, Multilenk, Navi, Regensensor, Sitzheizung, Sound,
                            Standheiz, StartStopp, Bilder.ID AS Bild_ID FROM Angebote, Bilder WHERE Bilder.Angebot_ID = Angebote.ID AND Marken_ID = " . $_GET['marke'];
  header("Location: ../uebersicht");
}

 ?>
