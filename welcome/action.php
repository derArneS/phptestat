<?php

session_start();

if (isset($_GET['marke'])) {
  $_SESSION['cache']['suche'] = $_GET;
}

if (isset($_GET['marke']) && $_GET['marke'] == "1") {
  $_SESSION['statement'] = "SELECT Angebote.ID AS Angebot_ID, Benutzer_ID, Titel, Marken_ID, Modell_ID, Preis, Baujahr,
                            Kilometerstand, Leistung, Kraftstoff, Getriebe, Alarmanlage, Anhaengerkupplung,
                            Bluetooth, Bordcomputer, HeadUP, Multilenk, Navi, Regensensor, Sitzheizung, Sound,
                            Standheiz, StartStopp, Bilder.ID AS Bild_ID FROM Angebote, Bilder WHERE Bilder.Angebot_ID = Angebote.ID AND Marken_ID = " . $_GET['marke'] . " ORDER BY Angebote.ID DESC";
  header("Location: ../uebersicht");
  die();
} else if (isset($_GET['marke']) && $_GET['marke'] == "2") {
  $_SESSION['statement'] = "SELECT Angebote.ID AS Angebot_ID, Benutzer_ID, Titel, Marken_ID, Modell_ID, Preis, Baujahr,
                            Kilometerstand, Leistung, Kraftstoff, Getriebe, Alarmanlage, Anhaengerkupplung,
                            Bluetooth, Bordcomputer, HeadUP, Multilenk, Navi, Regensensor, Sitzheizung, Sound,
                            Standheiz, StartStopp, Bilder.ID AS Bild_ID FROM Angebote, Bilder WHERE Bilder.Angebot_ID = Angebote.ID AND Marken_ID = " . $_GET['marke'] . " ORDER BY Angebote.ID DESC";
  header("Location: ../uebersicht");
  die();
} else if (isset($_GET['marke']) && $_GET['marke'] == "7") {
  $_SESSION['statement'] = "SELECT Angebote.ID AS Angebot_ID, Benutzer_ID, Titel, Marken_ID, Modell_ID, Preis, Baujahr,
                            Kilometerstand, Leistung, Kraftstoff, Getriebe, Alarmanlage, Anhaengerkupplung,
                            Bluetooth, Bordcomputer, HeadUP, Multilenk, Navi, Regensensor, Sitzheizung, Sound,
                            Standheiz, StartStopp, Bilder.ID AS Bild_ID FROM Angebote, Bilder WHERE Bilder.Angebot_ID = Angebote.ID AND Marken_ID = " . $_GET['marke'] . " ORDER BY Angebote.ID DESC";
  header("Location: ../uebersicht");
  die();
}

if (isset($_GET['id'])) {
  $_SESSION['statement'] = "SELECT Angebote.ID AS Angebot_ID, Benutzer_ID, Titel, Marken_ID, Modell_ID, Preis, Baujahr,
                            Kilometerstand, Leistung, Kraftstoff, Getriebe, Alarmanlage, Anhaengerkupplung,
                            Bluetooth, Bordcomputer, HeadUP, Multilenk, Navi, Regensensor, Sitzheizung, Sound,
                            Standheiz, StartStopp, Bilder.ID AS Bild_ID FROM Angebote, Bilder WHERE Bilder.Angebot_ID = Angebote.ID ORDER BY Angebote.ID DESC";
  header("Location: ../uebersicht/angebot.php?id=" . $_GET['id']);
  die();
}

if (isset($_POST['marke']) && isset($_POST['modell'])) {
  $_SESSION['cache']['suche'] = $_POST;
  if ($_POST['marke'] != '' && $_POST['modell'] == '') {
    $_SESSION['statement'] = "SELECT Angebote.ID AS Angebot_ID, Benutzer_ID, Titel, Marken_ID, Modell_ID, Preis, Baujahr,
                              Kilometerstand, Leistung, Kraftstoff, Getriebe, Alarmanlage, Anhaengerkupplung,
                              Bluetooth, Bordcomputer, HeadUP, Multilenk, Navi, Regensensor, Sitzheizung, Sound,
                              Standheiz, StartStopp, Bilder.ID AS Bild_ID FROM Angebote, Bilder WHERE Bilder.Angebot_ID = Angebote.ID AND Marken_ID = " . $_POST['marke'] . " ORDER BY Angebote.ID DESC";
    header("Location: ../uebersicht");
    die();
  } else if ($_POST['marke'] != '' && $_POST['modell'] != '') {
    $_SESSION['statement'] = "SELECT Angebote.ID AS Angebot_ID, Benutzer_ID, Titel, Marken_ID, Modell_ID, Preis, Baujahr,
                              Kilometerstand, Leistung, Kraftstoff, Getriebe, Alarmanlage, Anhaengerkupplung,
                              Bluetooth, Bordcomputer, HeadUP, Multilenk, Navi, Regensensor, Sitzheizung, Sound,
                              Standheiz, StartStopp, Bilder.ID AS Bild_ID FROM Angebote, Bilder WHERE Bilder.Angebot_ID = Angebote.ID AND Marken_ID = " . $_POST['marke'] . " AND Modell_ID = " . $_POST['modell'] . " ORDER BY Angebote.ID DESC";
    header("Location: ../uebersicht");
    die();
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
