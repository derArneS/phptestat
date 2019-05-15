<?php

session_start();

if ($_POST['inputPreisMin'] > $_POST['inputPreisMax'] || $_POST['inputPreisMin'] < 0) {
  $_SESSION['error']['preis'] = true;
  header("Location: index.php");
  die();
}

if ($_POST['inputBaujahrMin'] > $_POST['inputBaujahrMax'] || $_POST['inputBaujahrMin'] != "") {
  if ($_POST['inputBaujahrMin'] < 1900 || $_POST['inputBaujahrMax'] > date("Y") + 0) {
    $_SESSION['error']['baujahr'] = true;
    header("Location: index.php");
    die();
  }
}

if ($_POST['inputKmMin'] > $_POST['inputKmMax'] || $_POST['inputKmMin'] < 0) {
  $_SESSION['error']['km'] = true;
  header("Location: index.php");
  die();
}

if ($_POST['inputLeistungMin'] > $_POST['inputLeistungMax'] || $_POST['inputLeistungMin'] < 0) {
  $_SESSION['error']['leistung'] = true;
  header("Location: index.php");
  die();
}

$_SESSION['cache']['suche'] = $_POST;

$statement = "SELECT Angebote.ID AS Angebot_ID, Benutzer_ID, Titel, Marken_ID, Modell_ID, Preis, Baujahr, Kilometerstand, Leistung, Kraftstoff, Getriebe, Alarmanlage, Anhaengerkupplung, Bluetooth, Bordcomputer, HeadUP, Multilenk, Navi, Regensensor, Sitzheizung, Sound, Standheiz, StartStopp, Bilder.ID AS Bild_ID FROM Angebote, Bilder WHERE Bilder.Angebot_ID = Angebote.ID"
               . ($_POST['marke'] > 0 ? " AND Marken_ID = ".$_POST['marke'] : "") . ($_POST['modell'] > 0 ? " AND Modell_ID = ".$_POST['modell'] : "")
               . ($_POST['inputPreisMin'] !== "" ? " AND Preis >= ".$_POST['inputPreisMin'] : "") . ($_POST['inputPreisMax'] !== "" ? " AND Preis <= ".$_POST['inputPreisMax'] : "")
               . ($_POST['inputBaujahrMin'] !== "" ? " AND Baujahr >= ".$_POST['inputBaujahrMin'] : "") . ($_POST['inputBaujahrMax'] !== "" ? " AND Baujahr <= ".$_POST['inputBaujahrMax'] : "")
               . ($_POST['inputKmMin'] !== "" ? " AND Kilometerstand >= ".$_POST['inputKmMin'] : "") . ($_POST['inputKmMax'] !== "" ? " AND Kilometerstand <= ".$_POST['inputKmMax'] : "")
               . ($_POST['inputLeistungMin'] !== "" ? " AND Leistung >= ".$_POST['inputLeistungMin'] : "") . ($_POST['inputLeistungMax'] !== "" ? " AND Leistung <= ".$_POST['inputLeistungMax'] : "")
               . ($_POST['getriebe'] !== "" ? " AND Getriebe = ".$_POST['getriebe'] : "")
               . ($_POST['kraftstoff'] !== "" ? " AND Kraftstoff = ".$_POST['kraftstoff'] : "")
               . (isset($_POST['alarmanlage']) ? " AND Alarmanlage = 1" : " AND Alarmanlage >= 0")
               . (isset($_POST['anhaengerkupplung']) ? " AND Anhaengerkupplung = 1" : " AND Anhaengerkupplung >= 0")
               . (isset($_POST['bluetooth']) ? " AND Bluetooth = 1" : " AND Bluetooth >= 0")
               . (isset($_POST['bordcomputer']) ? " AND Bordcomputer = 1" : " AND Bordcomputer >= 0")
               . (isset($_POST['head']) ? " AND HeadUP = 1" : " AND HeadUP >= 0")
               . (isset($_POST['multifunktionslenkrad']) ? " AND Multilenk = 1" : " AND Multilenk >= 0")
               . (isset($_POST['navigationssystem']) ? " AND Navi = 1" : " AND Navi >= 0")
               . (isset($_POST['regensensor']) ? " AND Regensensor = 1" : " AND Regensensor >= 0")
               . (isset($_POST['sitzheizung']) ? " AND Sitzheizung = 1" : " AND Sitzheizung >= 0")
               . (isset($_POST['sound']) ? " AND Sound = 1" : " AND Sound >= 0")
               . (isset($_POST['standheizung']) ? " AND Standheiz = 1" : " AND Standheiz >= 0")
               . (isset($_POST['startStopp']) ? " AND StartStopp = 1" : " AND StartStopp >= 0")
               . " ORDER BY Angebote.ID DESC";

$_SESSION['statement'] = $statement;

header("Location: ../uebersicht");
 ?>
