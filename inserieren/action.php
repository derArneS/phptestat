<?php session_start(); require "../database/database.php";

$_SESSION['cache']['insert'] = $_POST;

if ($_POST['button'] == "pic") {
  $databaseconnection = createConnection();

  if ($_FILES['datei']['error'] == 0 && is_uploaded_file($_FILES['datei']['tmp_name'])) {
    $img = addslashes(file_get_contents($_FILES['datei']['tmp_name']));
    $img_type = getimagesize($_FILES['datei']['tmp_name']);

    $file_type = $_FILES['datei']['type']; //returns the mimetype

    $allowed = array("image/jpeg", "image/png");
    if(!in_array($file_type, $allowed)) {
      $_SESSION['errorEingabe'] = true;
      header("Location: index.php");
      closeConnection($databaseconnection);
      die();
    }

    $statement = "INSERT INTO Bilder (Bild, Typ) VALUES ('{$img}', '{$img_type['mime']}')";
    $databaseconnection->query($statement);

    $_SESSION['cache']['insert']['img_id'] = $databaseconnection->insert_id;
  } else {
    $_SESSION['errorEingabe'] = true;
  }

  header("Location: index.php");
  closeConnection($databaseconnection);
} else if ($_POST['button'] =="insert") {
  $databaseconnection = createConnection();

  $img_id = isset($_POST['img_id']) ? $_POST['img_id'] : 0;

  if ($_FILES['datei']['error'] == 0 && is_uploaded_file($_FILES['datei']['tmp_name'])) {
    $img = addslashes(file_get_contents($_FILES['datei']['tmp_name']));
    $img_type = getimagesize($_FILES['datei']['tmp_name']);

    $file_type = $_FILES['datei']['type']; //returns the mimetype

    $allowed = array("image/jpeg", "image/png");
    if(!in_array($file_type, $allowed)) {
      $_SESSION['errorEingabe'] = true;
      header("Location: index.php");
      closeConnection($databaseconnection);
      die();
    }

    $statement = "INSERT INTO Bilder (Bild, Typ) VALUES ('{$img}', '{$img_type['mime']}')";
    $databaseconnection->query($statement);

    $_SESSION['cache']['insert']['img_id'] = $databaseconnection->insert_id;
    $img_id = $databaseconnection->insert_id;
  }

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

  if (!($statement = $databaseconnection->prepare("INSERT INTO Angebote (Benutzer_ID, Titel, Marken_ID, Modell_ID, Preis, Baujahr, Kilometerstand, Leistung, kraftstoff, Getriebe, Alarmanlage, Anhaengerkupplung, Bluetooth, Bordcomputer, HeadUP, Multilenk, Navi, Regensensor, Sitzheizung, Sound, Standheiz, StartStopp) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"))
  || !($statement->bind_param('isiiiiiiiiiiiiiiiiiiii',$_SESSION['id'], $_POST['titel'], $_POST['marke'], $_POST['modell'], $_POST['inputPreis'], $_POST['inputBJ'], $_POST['inputKM'],
                                                       $_POST['inputLeistung'], $_POST['kraftstoff'], $_POST['getriebe'],
                                                       $alarmanlage, $anhaengerkupplung, $bluetooth, $bordcomputer, $head, $multifunktionslenkrad, $navigationssystem,
                                                       $regensensor, $sitzheizung, $soundsystem, $standheizung, $startStopp))
  || !($statement->execute())) {
    header("Location: index.php");
    closeConnection($databaseconnection);
    die();
  }

  $auto_id = $databaseconnection->insert_id;

  if (!($statement = $databaseconnection->prepare("UPDATE Bilder SET Angebot_ID = ? WHERE ID = ?"))
  || !($statement->bind_param('ii', $auto_id, $img_id))
  || !($statement->execute())) {
    header("Location: index.php");
    closeConnection($databaseconnection);
    die();
  }

  if (isset($_SESSION['cache'])) unset($_SESSION['cache']);
  closeConnection($databaseconnection);
  header("Location: ../uebersicht/angebot.php?id=$auto_id");
}
?>
