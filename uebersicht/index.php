<?php

session_start();

require "../database/database.php";
require "../const/cookie.php";

$databaseconnection = createConnection();

if (!isset($_SESSION['statement'])) {
  $_SESSION['statement'] = "SELECT Angebote.ID AS Angebot_ID, Benutzer_ID, Titel, Marken_ID, Modell_ID, Preis, Baujahr,
                            Kilometerstand, Leistung, Kraftstoff, Getriebe, Alarmanlage, Anhaengerkupplung,
                            Bluetooth, Bordcomputer, HeadUP, Multilenk, Navi, Regensensor, Sitzheizung, Sound,
                            Standheiz, StartStopp, Bilder.ID AS Bild_ID FROM Angebote, Bilder WHERE Bilder.Angebot_ID = Angebote.ID ORDER BY Angebote.ID DESC";
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Übersicht</title>
    <link rel="stylesheet" href="uebersicht.css">
    <?php require "../const/head.php" ?>
  </head>
  <body>
    <?php
    require "../const/navbar.php";

    ?>
    <div class="container">
      <div class="my-3 pl-3">
        <a href="../suche/index.php">Suche verändern</a>
      </div>

    <?php

    if ($resultset = $databaseconnection->query($_SESSION['statement'])) {
      if ($resultset->num_rows == 0) {
        $_SESSION['errorErgebnis'] = true;
        header("Location: ../suche");
        die();
      }

      while ($row = $resultset->fetch_assoc()) {
      echo'
      <div class="container">
        <fieldset class="mt-4 mx-auto box" >
          <div class="row mx-0 px-0 mb-3">
            <a class="col-10 p-0" href="../uebersicht/angebot.php?id='.$row['Angebot_ID'].'">
              <div class="row m-0 p-0">
                <legend style="padding: 0px 0px 0px 17px">'.$row['Titel'].'</legend>
                <div class="mr-2">
                  <img class="" style="padding-left: 0px; height: 135px; width: 240px" src="../const/loadPic.php?id='.$row['Bild_ID'].'" alt="">
                </div>
                <div style=" border-left: 1px solid grey;  height: 135px;" class="col-6">
                  <p class="m-0" style="font-size: 20px">
                    Baujahr: '.$row['Baujahr'].', Kilometerstand: '.$row['Kilometerstand'].', Leistung: '.$row['Leistung'].'PS
                  </br>Kraftstoff: '; if($row['Kraftstoff'] == 1) echo "Benzin"; if($row['Kraftstoff'] == 2) echo "Diesel";
                  if($row['Kraftstoff'] == 3) echo "Elektro"; if($row['Kraftstoff'] == 4) echo "Wasserstoff"; echo ', Getriebe: ';
                  if($row['Getriebe'] == 1) echo "Manuell"; if($row['Getriebe'] == 2) echo "Automatik"; echo '
                </p>
              </div>
              <div style=" border-left: 1px solid grey;  height: 135px;" class="col pr-0">
                <h4 style="height: 50%">Preis:</h4>
                <h2>'.$row['Preis'].' €</h2>
              </div>
              </div>
            </a>
            <div class="col-2 pr-4" style="padding: 0!important">
              <a href="../profil/favoritenAction.php?id='.$row['Angebot_ID'].'" class="btn btn-primary" style="float: right">Favorit</a>
            </div>
          </div>
        </fieldset>
      </div>
      ';
      }
    }

    ?>

  </div>

  <div class="mb-3">
    <br>
  </div>


    <?php require "../const/footer.php" ?>



  </body>
</html>

<?php closeConnection($databaseconnection); ?>
