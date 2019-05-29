<?php

session_start();

//Es wird die Logik des Preises untersucht
//Wenn beide gesetzt sind, wird geschaut, ob min > max oder ob eines der beiden kleiner als 0 ist
if ($_POST['inputPreisMin'] != '' && $_POST['inputPreisMax'] != '') {
  if ($_POST['inputPreisMin'] > $_POST['inputPreisMax'] || $_POST['inputPreisMin'] < 0 || $_POST['inputPreisMax'] < 0) {
    //Wenn dem so ist, wird sich ein Fehler gemerkt und man wird zuürck zur Suche geleitet.
    $_SESSION['error']['preis'] = true;
    header("Location: index.php");
    die();
  }
//Wenn nur eins von beiden gesetzt ist, wird das jeweilige auf < 0 untersucht
} else {
  if ($_POST['inputPreisMin'] != '' && $_POST['inputPreisMin'] < 0) {
    //Wenn dem so ist, wird sich ein Fehler gemerkt und man wird zuürck zur Suche geleitet.
    $_SESSION['error']['preis'] = true;
    header("Location: index.php");
    die();
  } else if ($_POST['inputPreisMax'] != '' && $_POST['inputPreisMax'] < 0) {
    //Wenn dem so ist, wird sich ein Fehler gemerkt und man wird zuürck zur Suche geleitet.
    $_SESSION['error']['preis'] = true;
    header("Location: index.php");
    die();
  }
}

//Es wird die Logik des Baujahrs untersucht
//Wenn beide gesetzt sind, wird geschaut, ob min > max oder ob das Baujahr vor 1900 oder in der Zukunft liegt
if ($_POST['inputBaujahrMin'] != '' && $_POST['inputBaujahrMax'] != '') {
  if ($_POST['inputBaujahrMin'] > $_POST['inputBaujahrMax'] || $_POST['inputBaujahrMin'] < 1900 || $_POST['inputBaujahrMax'] > date("Y") + 0) {
    //Wenn dem so ist, wird sich ein Fehler gemerkt und man wird zuürck zur Suche geleitet.
    $_SESSION['error']['baujahr'] = true;
    header("Location: index.php");
    die();
  }
//Wenn nur eins von beiden gesetzt ist, wird das jeweilige auf < 0 untersucht
} else {
  if ($_POST['inputBaujahrMin'] != '' && $_POST['inputBaujahrMin'] < 1900) {
    //Wenn dem so ist, wird sich ein Fehler gemerkt und man wird zuürck zur Suche geleitet.
    $_SESSION['error']['baujahr'] = true;
    header("Location: index.php");
    die();
  } else if ($_POST['inputBaujahrMax'] != '' && $_POST['inputBaujahrMax'] > date("Y") + 0) {
    //Wenn dem so ist, wird sich ein Fehler gemerkt und man wird zuürck zur Suche geleitet.
    $_SESSION['error']['baujahr'] = true;
    header("Location: index.php");
    die();
  }
}

//Es wird die Logik des Kilometerstandes untersucht
//Wenn beide gesetzt sind, wird geschaut, ob min > max oder ob eines der beiden kleiner als 0 ist
if ($_POST['inputKmMin'] != '' && $_POST['inputKmMax'] != '') {
  if ($_POST['inputKmMin'] > $_POST['inputKmMax'] || $_POST['inputKmMin'] < 0 || $_POST['inputKmMax'] < 0) {
    //Wenn dem so ist, wird sich ein Fehler gemerkt und man wird zuürck zur Suche geleitet.
    $_SESSION['error']['km'] = true;
    header("Location: index.php");
    die();
  }
//Wenn nur eins von beiden gesetzt ist, wird das jeweilige auf < 0 untersucht
} else {
  if ($_POST['inputKmMin'] != '' && $_POST['inputKmMin'] < 0) {
    //Wenn dem so ist, wird sich ein Fehler gemerkt und man wird zuürck zur Suche geleitet.
    $_SESSION['error']['km'] = true;
    header("Location: index.php");
    die();
  } else if ($_POST['inputKmMax'] != '' && $_POST['inputKmMax'] < 0) {
    //Wenn dem so ist, wird sich ein Fehler gemerkt und man wird zuürck zur Suche geleitet.
    $_SESSION['error']['km'] = true;
    header("Location: index.php");
    die();
  }
}

//Es wird die Logik der Leistung untersucht
//Wenn beide gesetzt sind, wird geschaut, ob min > max oder ob eines der beiden kleiner als 0 ist
if ($_POST['inputLeistungMin'] != '' && $_POST['inputLeistungMax'] != '') {
  if ($_POST['inputLeistungMin'] > $_POST['inputLeistungMax'] || $_POST['inputLeistungMin'] < 0 || $_POST['inputLeistungMax'] < 0) {
    //Wenn dem so ist, wird sich ein Fehler gemerkt und man wird zuürck zur Suche geleitet.
    $_SESSION['error']['leistung'] = true;
    header("Location: index.php");
    die();
  }
//Wenn nur eins von beiden gesetzt ist, wird das jeweilige auf < 0 untersucht
} else {
  if ($_POST['inputLeistungMin'] != '' && $_POST['inputLeistungMin'] < 0) {
    //Wenn dem so ist, wird sich ein Fehler gemerkt und man wird zuürck zur Suche geleitet.
    $_SESSION['error']['leistung'] = true;
    header("Location: index.php");
    die();
  } else if ($_POST['inputLeistungMax'] != '' && $_POST['inputLeistungMax'] < 0) {
    //Wenn dem so ist, wird sich ein Fehler gemerkt und man wird zuürck zur Suche geleitet.
    $_SESSION['error']['leistung'] = true;
    header("Location: index.php");
    die();
  }
}

//Wenn es keine Fehler in der Suche gab, werden die eingegeben Parameter in der Session gespeichert, damit bei erneutem Aufruf der Such-Seite diese Parameter schon eingetragen sind
$_SESSION['cache']['suche'] = $_POST;

//Es wird ein passendes Statement erstellt, welches nach den Parametern der Suche filtert. Es wird für jeden Parameter mit dem Elvis-Operator geschaut, ob der Parameter gesetzt ist. Wenn ja wird das Statement um diesen Part ergänzt
//Wenn bei der Ausstattung ein Wert nicht selektiert wurde, werden die Autos, die diese Ausstattung haben, trotzdem angezeigt
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

//Das Statement wird in die Session geschrieben, da es erst auf der Übersichtsseite ausgeführt wird
$_SESSION['statement'] = $statement;

header("Location: ../uebersicht");
 ?>
