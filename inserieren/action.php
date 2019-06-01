<?php session_start(); require "../database/database.php";

//Die Daten aus $_POST werden gesichert, falls ein Fehler auftritt. Dann wird man wieder zur inserieren-Seite geleitet und die Daten sind dann wieder eingetragen
$_SESSION['cache']['insert'] = $_POST;

//Wenn der Button zum Hochladen gedrückt wurde, wird überprüft, ob eine Datei mit hochgeladen wurde
if ($_POST['button'] == "pic") {
  $databaseconnection = createConnection();

  //Wenn eine Datei hochgeladen wurde und kein Fehler dabei entstanden ist
  if ($_FILES['datei']['error'] == 0 && is_uploaded_file($_FILES['datei']['tmp_name'])) {
    //Das Bild als BLOB
    $img = addslashes(file_get_contents($_FILES['datei']['tmp_name']));
    $img_type = getimagesize($_FILES['datei']['tmp_name']);

    //mimetype der Datei
    $file_type = $_FILES['datei']['type'];

    //die erlaubten mimetypes
    $allowed = array("image/jpeg", "image/png");
    //Wenn eine Datei hochgeladen wurde, die nicht den erlaubten Dateitypen entspricht, wird ein Fehler geworfen und man wird wieder zu der Übersicht geleitet
    if(!in_array($file_type, $allowed)) {
      $_SESSION['errorEingabe'] = true;
      header("Location: index.php");
      closeConnection($databaseconnection);
      die();
    }

    //Bild in die Datenbank laden
    $statement = "INSERT INTO Bilder (Bild, Typ) VALUES ('{$img}', '{$img_type['mime']}')";
    $databaseconnection->query($statement);

    //Merken, welche ID das Bild in der Datenbank bekommen hat
    $_SESSION['cache']['insert']['img_id'] = $databaseconnection->insert_id;
  } else {
    $_SESSION['errorEingabe'] = true;
  }

  header("Location: index.php");
  closeConnection($databaseconnection);
//Wenn der Button zum inserieren gedrückt wurde
} else if ($_POST['button'] =="insert") {
  $databaseconnection = createConnection();

  //Es wird erstmal geschaut, ob ein Bild hochgeladen wurde, oder ob eins aus der Datenbank verwendet wird
  $img_id = isset($_POST['img_id']) ? $_POST['img_id'] : 0;

  //Es kann auch ein neues Bild über das Formular hochgeladen werden. Dann wird das, welches vorher über den Button hochladen geladen wurde überschrieben und nicht mehr benutzt
  if ($_FILES['datei']['error'] == 0 && is_uploaded_file($_FILES['datei']['tmp_name'])) {
    //Die Datei als BLOB
    $img = addslashes(file_get_contents($_FILES['datei']['tmp_name']));
    $img_type = getimagesize($_FILES['datei']['tmp_name']);

    //Mimetype der Datei
    $file_type = $_FILES['datei']['type'];

    //Siehe Zeile 21
    $allowed = array("image/jpeg", "image/png");
    if(!in_array($file_type, $allowed)) {
      $_SESSION['errorEingabe'] = true;
      header("Location: index.php");
      closeConnection($databaseconnection);
      die();
    }

    //Laden des Bildes in die Datenbank
    $statement = "INSERT INTO Bilder (Bild, Typ) VALUES ('{$img}', '{$img_type['mime']}')";
    $databaseconnection->query($statement);

    //merken der ID des neuen Bildes
    $_SESSION['cache']['insert']['img_id'] = $databaseconnection->insert_id;
    $img_id = $databaseconnection->insert_id;
  }

  //Hier werden einige logische Überprüfungen zu den eingaben des Nutzers gemacht. Z.B. darf der Preis nicht negativ sein oder das Baujahr größer als das aktuelle Jahr
  if ($_POST['titel'] == '' || strlen($_POST['titel']) > 25
  || $_POST['marke'] == ''
  || $_POST['modell'] == ''
  || $img_id == '0'
  || $_POST['inputPreis'] == '' || !is_numeric($_POST['inputPreis']) || $_POST['inputPreis'] + 0 < 0
  || $_POST['inputBJ'] == '' || !is_numeric($_POST['inputBJ']) || $_POST['inputBJ'] + 0 < 1900 || $_POST['inputBJ'] + 0 > date("Y") + 0
  || $_POST['inputKM'] == '' || !is_numeric($_POST['inputKM']) || $_POST['inputKM'] + 0 < 0
  || $_POST['inputLeistung'] == '' || !is_numeric($_POST['inputLeistung']) || $_POST['inputLeistung'] + 0 < 0
  || $_POST['kraftstoff'] == ''
  || $_POST['getriebe'] == '') {
    $_SESSION['errorEingabe'] = true;
    header("Location: index.php");
    die();
  }

  //Wenn der Haken der Sonderausstattung gesetzt ist, wird der Eintrag in der Datenbank auf 1 gesetzt, wenn sie nicht vorhanden ist, wird der Eintrag auf 0 gesetzt
  $alarmanlage = isset($_POST['alarmanlage']) && $_POST['alarmanlage'] == 'true' ? 1 : 0;
  $anhaengerkupplung = isset($_POST['anhaengerkupplung']) && $_POST['anhaengerkupplung'] == 'true' ? 1 : 0;
  $bluetooth = isset($_POST['bluetooth']) && $_POST['bluetooth'] == 'true' ? 1 : 0;
  $bordcomputer = isset($_POST['bordcomputer']) && $_POST['bordcomputer'] == 'true' ? 1 : 0;
  $head = isset($_POST['head']) && $_POST['head'] == 'true' ? 1 : 0;
  $multifunktionslenkrad = isset($_POST['multifunktionslenkrad']) && $_POST['multifunktionslenkrad'] == 'true' ? 1 : 0;
  $navigationssystem = isset($_POST['navigationssystem']) && $_POST['navigationssystem'] == 'true' ? 1 : 0;
  $regensensor = isset($_POST['regensensor']) && $_POST['regensensor'] == 'true' ? 1 : 0;
  $sitzheizung = isset($_POST['sitzheizung']) && $_POST['sitzheizung'] == 'true' ? 1 : 0;
  $soundsystem = isset($_POST['soundsystem']) && $_POST['soundsystem'] == 'true' ? 1 : 0;
  $standheizung = isset($_POST['standheizung']) && $_POST['standheizung'] == 'true' ? 1 : 0;
  $startStopp = isset($_POST['startStopp']) && $_POST['startStopp'] == 'true' ? 1 : 0;

  //vorbereiten der Nutzereingaben, um sie in die Datenbank zu speichern. Sicherheit geht vor!
  $titel = htmlspecialchars(stripslashes($_POST['titel']));
  $marke = htmlspecialchars(stripslashes($_POST['marke']));
  $modell = htmlspecialchars(stripslashes($_POST['modell']));
  $inputPreis = htmlspecialchars(stripslashes($_POST['inputPreis']));
  $inputBJ = htmlspecialchars(stripslashes($_POST['inputBJ']));
  $inputKM = htmlspecialchars(stripslashes($_POST['inputKM']));
  $inputLeistung = htmlspecialchars(stripslashes($_POST['inputLeistung']));
  $kraftstoff = htmlspecialchars(stripslashes($_POST['kraftstoff']));
  $getriebe = htmlspecialchars(stripslashes($_POST['getriebe']));

  //Prepared statement, um das Angebot in die Datenbank zu schreiben
  if (!($statement = $databaseconnection->prepare("INSERT INTO Angebote (Benutzer_ID, Titel, Marken_ID, Modell_ID, Preis, Baujahr, Kilometerstand, Leistung, kraftstoff, Getriebe, Alarmanlage, Anhaengerkupplung, Bluetooth, Bordcomputer, HeadUP, Multilenk, Navi, Regensensor, Sitzheizung, Sound, Standheiz, StartStopp) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"))
  || !($statement->bind_param('isiiiiiiiiiiiiiiiiiiii',$_SESSION['id'], $titel, $marke, $modell, $inputPreis, $inputBJ, $inputKM,
                                                       $inputLeistung, $kraftstoff, $getriebe,
                                                       $alarmanlage, $anhaengerkupplung, $bluetooth, $bordcomputer, $head, $multifunktionslenkrad, $navigationssystem,
                                                       $regensensor, $sitzheizung, $soundsystem, $standheizung, $startStopp))
  || !($statement->execute())) {
    header("Location: index.php");
    closeConnection($databaseconnection);
    die();
  }

  //die ID des eben erstellten Angebots zwischenspeichern
  $auto_id = $databaseconnection->insert_id;

  //Das Hochgeladene Bild wird um die ID des Angebots ergänzt
  if (!($statement = $databaseconnection->prepare("UPDATE Bilder SET Angebot_ID = ? WHERE ID = ?"))
  || !($statement->bind_param('ii', $auto_id, $img_id))
  || !($statement->execute())) {
    header("Location: index.php");
    closeConnection($databaseconnection);
    die();
  }

  //Der Zwischenspeicher der Nutzereingaben wird zurückgesetzt, weil das Inserat jetzt fertig ist
  if (isset($_SESSION['cache'])) unset($_SESSION['cache']);
  closeConnection($databaseconnection);
  header("Location: ../uebersicht/angebot.php?id=$auto_id");
}
?>
