<?php
session_start();
require "../database/database.php";
require "../const/cookie.php";
require "../const/private.php"; isPrivate(true, "/profil");

?>

<?php
$databaseconnection = createConnection();
if (!($statement = $databaseconnection->prepare("SELECT * FROM Benutzer WHERE Benutzername = ?"))
|| !($statement->bind_param('s', $_SESSION['benutzername']))
|| !($statement->execute())
|| !($resultset = $statement->get_result())) {

}
$row = $resultset->fetch_assoc();

if (!($statement = $databaseconnection->prepare("SELECT * FROM Adressen WHERE ID=?"))
|| !($statement->bind_param('i', $row['Adress_ID']))
|| !($statement->execute())
|| !($resultset = $statement->get_result())) {

}
$adressrow = $resultset->fetch_assoc();

if (!($statement3 = $databaseconnection->prepare("SELECT Angebote.ID AS Angebot_ID, Benutzer_ID, Titel, Marken_ID, Modell_ID,
                                                 Preis, Baujahr, Kilometerstand, Leistung, Kraftstoff, Getriebe, Alarmanlage,
                                                 Anhaengerkupplung, Bluetooth, Bordcomputer, HeadUP, Multilenk, Navi, Regensensor,
                                                 Sitzheizung, Sound, Standheiz, StartStopp, Bilder.ID AS Bild_ID
                                                 FROM Angebote, Bilder WHERE Benutzer_ID = ? AND Bilder.Angebot_ID = Angebote.ID"))
|| !($statement3->bind_param('i', $row['ID']))
|| !($statement3->execute())
|| !($resultset3 = $statement3->get_result())) {

}

closeConnection($databaseconnection);
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title></title>
  <?php require "../const/head.php" ?>
  <link rel="stylesheet" href="profil.css">
</head>
<body>
  <?php require '../const/navbar.php'; ?>

  <?php print_r($_SESSION) ?>

  <div class="container col-11 mt-5 pb-3 box">

<!-- Tableiste mit drei Tabs -->
    <nav>
      <div class="nav nav-tabs nav-justified" id="nav-tab" role="tablist" fill>
        <a class="nav-item nav-link <?php if(isset($_GET['tab']) && $_GET['tab'] == 1) echo "active"; if(!isset($_GET['tab'])) echo "active";?>" id="nav-angebote-tab" data-toggle="tab" href="#nav-angebote" role="tab" aria-controls="nav-home" aria-selected="true">Eigene Angebote</a>
        <a class="nav-item nav-link <?php if(isset($_GET['tab']) && $_GET['tab'] == 2) echo "active";?>" id="nav-favoriten-tab" data-toggle="tab" href="#nav-favoriten" role="tab" aria-controls="nav-profile" aria-selected="false">Favoriten</a>
        <a class="nav-item nav-link <?php if(isset($_GET['tab']) && $_GET['tab'] == 3) echo "active";?>" id="nav-daten-tab" data-toggle="tab" href="#nav-daten" role="tab" aria-controls="nav-contact" aria-selected="false">Persönliche Daten</a>
      </div>
    </nav>


    <div class="tab-content" id="nav-tabContent">

<!-- Tab - Eigene Angebote -->
      <?php include "eigeneAngebote.php" ?>



<!-- Tab - Favoriten -->
      <div class="tab-pane fade <?php if(isset($_GET['tab']) && $_GET['tab'] == 2) echo "show active";?>" id="nav-favoriten" role="tabpanel" aria-labelledby="nav-profile-tab">
        Hallo :-)
      </div>


<!-- Tab - Persönliche Daten -->
      <?php include "persDaten.php" ?>

    </div>


  </div>

</body>
</html>
