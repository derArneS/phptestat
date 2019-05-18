<?php
session_start();
require "../database/database.php";
require "../const/cookie.php";
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title></title>
  <?php require "../const/head.php" ?>
  <link rel="stylesheet" href="uebersicht.css">
</head>
<body style="padding-bottom: 80px">
  <?php require "../const/navbar.php"; ?>

  <?php
  $databaseconnection = createConnection();

  if (!($statement = $databaseconnection->prepare("SELECT Angebote.ID AS Angebot_ID, Benutzer_ID, Titel, Angebote.Marken_ID AS Angebot_Marke_ID, Angebote.Modell_ID AS Angebote_Modell_ID, Preis, Baujahr, Kilometerstand, Leistung, Kraftstoff, Getriebe,
                                                          Alarmanlage, Anhaengerkupplung, Bluetooth, Bordcomputer, HeadUP, Multilenk, Navi, Regensensor, Sitzheizung,
                                                          Sound, Standheiz, StartStopp, Bilder.Angebot_ID AS Bilder_Angebot_ID, Bilder.ID AS Bild_ID, Marken.ID AS Marke_ID, Marken.Name AS Marke_Marke, Modelle.Marken_ID AS Modell_Marke_ID,
                                                          Modelle.Name AS Modell_Name
                                                          FROM Angebote, Bilder, Marken, Modelle WHERE Angebote.ID = ? AND Angebote.ID = Bilder.Angebot_ID AND Angebote.Marken_ID = Marken.ID AND Angebote.Modell_ID = Modelle.ID"))
  || !($statement->bind_param('i', $_GET['id']))
  || !($statement->execute())
  || !($resultset = $statement->get_result())
  || !($row = $resultset->fetch_assoc())) {
    die();
  }

  ?>
  <div class="container col-7 mt-4">
    <div class="row mx-0 px-0">
      <div class="container col-12 mx-0 px-0">

        <div class="mb-3 mx-auto">
          <?php

          if (isset($_GET['loc'])) {
            echo '<a href="../profil/index.php?tab='.$_GET['loc'].'">Zurück zum Profil</a>';
          } else {
            echo '<a href="index.php">Zurück zu den Ergebnissen</a>';
          }

          ?>
        </div>

        <fieldset class="box mb-4">
          <div class="row mx-0 px-0 my-3">
            <legend style="padding: 0px 0px 0px 17px"><?= $row['Titel'] ?></legend>
            <div class="col-12">
              <img class="col-12" style="padding-left: 0px" src="../const/loadPic.php?id=<?= $row['Bild_ID'] ?>" alt="">
            </div>
          </div>
        </fieldset>

        <fieldset class="box mb-4">
          <div class="row mx-0 px-0">
            <legend style="padding: 0px 0px 0px 17px">Modell</legend>
            <div class="col-6 form-label-group">
              <input disabled type="text" name="marke" id="marke" class="form-control" placeholder="Marke" value="<?= $row['Marke_Marke'] ?>">
              <label for="marke">Marke</label>
            </div>
            <div class="col-6 form-label-group">
              <input disabled type="text" name="modell" id="modell" class="form-control" placeholder="Modell" value="<?= $row['Modell_Name'] ?>">
              <label for="modell">Modell</label>
            </div>
          </div>
        </fieldset>

        <fieldset class="box my-4">
          <div class="row mx-0 px-0 my-3">
            <legend style="padding: 0px 0px 0px 17px">Daten</legend>
            <div class="col-4 form-label-group">
              <input disabled type="text" name="preis" id="preis" class="form-control" placeholder="Preis" value="<?= $row['Preis'] . '€' ?>">
              <label for="preis">Preis</label>
            </div>
            <div class="col-4 form-label-group">
              <input disabled type="text" name="baujahr" id="baujahr" class="form-control" placeholder="Baujahr" value="<?= $row['Baujahr'] ?>">
              <label for="baujahr">Baujahr</label>
            </div>
            <div class="col-4 form-label-group">
              <input disabled type="text" name="kilometer" id="kilometer" class="form-control" placeholder="Kilometerstand" value="<?= $row['Kilometerstand'] ?>">
              <label for="kilometer">Kilometerstand</label>
            </div>
            <div class="col-4 form-label-group">
              <input disabled type="text" name="leistung" id="leistung" class="form-control" placeholder="Leistung" value="<?= $row['Leistung'] ?>">
              <label for="leistung">Leistung (PS)</label>
            </div>
            <div class="col-4 form-label-group">
              <input disabled type="text" name="kraftstoff" id="kraftstoff" class="form-control" placeholder="Kraftstoff" value="<?php if($row['Kraftstoff'] == 1) echo "Benzin";
              if($row['Kraftstoff'] == 2) echo "Diesel"; if($row['Kraftstoff'] == 3) echo "Elektro"; if($row['Kraftstoff'] == 4) echo "Wasserstoff";?>">
              <label for="kraftstoff">Kraftstoff</label>
            </div>
            <div class="col-4 form-label-group">
              <input disabled type="text" name="getriebe" id="getriebe" class="form-control" placeholder="Getriebe" value="<?php if($row['Getriebe'] == 1) echo "Manuell"; if($row['Getriebe'] == 2) echo "Automatik";?>">
              <label for="getriebe">Getriebe</label>
            </div>
          </div>
        </fieldset>

        <fieldset class="box my-4">
          <div class="row mx-0 px-0 my-3">
            <legend style="padding: 0px 0px 0px 17px">Ausstattung</legend>

            <?php if($row['Alarmanlage'] == 1) echo'
            <div class="col-4" style="padding-left: 17px">
              <div class="custom-control custom-checkbox mt-3">
                <input type="checkbox" checked disabled name="alarmanlage" class="custom-control-input" id="alarmanlage" value="true">
                <label class="custom-control-label" for="alarmanlage">Alarmanlage</label>
              </div>
            </div>
            ' ?>

            <?php if($row['Anhaengerkupplung'] == 1) echo'
            <div class="col-4" style="padding-left: 17px">
              <div class="custom-control custom-checkbox mt-3">
                <input type="checkbox" checked disabled name="anhaengerkupplung" class="custom-control-input" id="anhaengerkupplung" value="true">
                <label class="custom-control-label" for="anhaengerkupplung">Anhaengerkupplung</label>
              </div>
            </div>
            ' ?>

            <?php if($row['Bluetooth'] == 1) echo'
            <div class=" col-4" style="padding-left: 17px">
              <div class="custom-control custom-checkbox mt-3">
                <input type="checkbox" checked disabled name="bluetooth" class="custom-control-input" id="bluetooth" value="true">
                <label class="custom-control-label" for="bluetooth">Bluetooth</label>
              </div>
            </div>
            ' ?>

            <?php if($row['Bordcomputer'] == 1) echo'
            <div class=" col-4" style="padding-left: 17px">
              <div class="custom-control custom-checkbox mt-3">
                <input type="checkbox" checked disabled name="bordcomputer" class="custom-control-input" id="bordcomputer" value="true">
                <label class="custom-control-label" for="bordcomputer">Bordcomputer</label>
              </div>
            </div>
            ' ?>

            <?php if($row['HeadUP'] == 1) echo'
            <div class=" col-4" style="padding-left: 17px">
              <div class="custom-control custom-checkbox mt-3">
                <input type="checkbox" checked disabled name="head" class="custom-control-input" id="head" value="true">
                <label class="custom-control-label" for="head">Head-Up Display</label>
              </div>
            </div>
            ' ?>

            <?php if($row['Multilenk'] == 1) echo'
            <div class=" col-4" style="padding-left: 17px">
              <div class="custom-control custom-checkbox mt-3">
                <input type="checkbox" checked disabled name="multifunktionslenkrad" class="custom-control-input" id="multifunktionslenkrad" value="true">
                <label class="custom-control-label" for="multifunktionslenkrad">Multifunktionslenkrad</label>
              </div>
            </div>
            ' ?>

            <?php if($row['Navi'] == 1) echo'
            <div class=" col-4" style="padding-left: 17px">
              <div class="custom-control custom-checkbox mt-3">
                <input type="checkbox" checked disabled name="navigationssystem" class="custom-control-input" id="navigationssystem" value="true">
                <label class="custom-control-label" for="navigationssystem">Navigationssystem</label>
              </div>
            </div>
            ' ?>

            <?php if($row['Regensensor'] == 1) echo'
            <div class=" col-4" style="padding-left: 17px">
              <div class="custom-control custom-checkbox mt-3">
                <input type="checkbox" checked disabled name="regensensor" class="custom-control-input" id="regensensor" value="true">
                <label class="custom-control-label" for="regensensor">Regensensor</label>
              </div>
            </div>
            ' ?>

            <?php if($row['Sitzheizung'] == 1) echo'
            <div class=" col-4" style="padding-left: 17px">
              <div class="custom-control custom-checkbox mt-3">
                <input type="checkbox" checked disabled name="sitzheizung" class="custom-control-input" id="sitzheizung" value="true">
                <label class="custom-control-label" for="sitzheizung">Sitzheizung</label>
              </div>
            </div>
            ' ?>

            <?php if($row['Sound'] == 1) echo'
            <div class=" col-4" style="padding-left: 17px">
              <div class="custom-control custom-checkbox mt-3">
                <input type="checkbox" checked disabled name="soundsystem" class="custom-control-input" id="soundsystem" value="true">
                <label class="custom-control-label" for="soundsystem">Soundsystem</label>
              </div>
            </div>
            ' ?>

            <?php if($row['Standheiz'] == 1) echo'
            <div class=" col-4" style="padding-left: 17px">
              <div class="custom-control custom-checkbox mt-3">
                <input type="checkbox" checked disabled name="standheizung" class="custom-control-input" id="standheizung" value="true">
                <label class="custom-control-label" for="standheizung">Standheizung</label>
              </div>
            </div>
            ' ?>

            <?php if($row['StartStopp'] == 1) echo'
            <div class=" col-4" style="padding-left: 17px">
              <div class="custom-control custom-checkbox mt-3">
                <input type="checkbox" checked disabled name="startStopp" class="custom-control-input" id="startStopp" value="true">
                <label class="custom-control-label" for="startStopp">Start/Stopp-Automatik</label>
              </div>
            </div>
            ' ?>

          </div>
        </fieldset>
      </div>
    </div>
  </div>

  <?php closeConnection($databaseconnection);?>
  <?php require "../const/footer.php" ?>
</body>
</html>
