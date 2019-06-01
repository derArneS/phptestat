<?php
session_start();
require "../database/database.php";
//es wird überprüft, ob ein Cookie gesetzt ist, der einen einloggt
require "../const/cookie.php";

$databaseconnection = createConnection();

//es werden alle Daten und das Bild zu der mit GET-Methode übergebenen Angebots-ID aus der Datenbank geladen
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

//Es werden die Kontaktdaten des Erstellers aus der Datenbank geladen
if (!($statement2 = $databaseconnection->prepare("SELECT Vorname, Nachname, Email, Benutzername, Postleitzahl, Ort, Strasse FROM Benutzer, Adressen WHERE Adressen.ID = Benutzer.Adress_ID AND Benutzer.ID = ?"))
|| !($statement2->bind_param('i', $row['Benutzer_ID']))
|| !($statement2->execute())
|| !($resultset2 = $statement2->get_result())
|| !($row2 = $resultset2->fetch_assoc())) {
  die();
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <!-- Der Titel wird aus der $row gelesen und in den Titel für den Tab gesetzt -->
  <title><?= $row['Titel'] ?></title>
  <?php require "../const/head.php" ?>
  <link rel="stylesheet" href="uebersicht.css">
</head>
<body style="padding-bottom: 40px">
  <?php require "../const/navbar.php"; ?>

  <div class="container col-7 mt-4">
    <div class="row mx-0 px-0">
      <div class="container col-12 mx-0 px-0">

        <div class="mb-3 mx-auto">
          <div class="row">
            <div class="col-8">
              <?php
              //wenn über die GET-Methode auch die Location (loc) übergeben wird, leitet ein anderer Link einen zurück zum Profil
              //und zwar zu dem Tab, der in Loc gespeichert ist
              if (isset($_GET['loc'])) {
                echo '<a href="../profil/index.php?tab='.$_GET['loc'].'">Zurück zum Profil</a>';
              //sonst kommt man wieder zurück zur Übersichtsseite
              } else {
                echo '<a href="index.php">Zurück zu den Ergebnissen</a>';
              }

              ?>
            </div>
            <!-- wenn man nicht eingeloggt ist, werden Button zum favorisieren und kontaktieren angezeigt -->
          <?php if(!isset($_SESSION['id'])) { ?>
            <div class="col-4">
              <div class="pr-4" style="padding: 0!important">
                <!-- öffnet ein Modal, weil man sich erst anmelden muss, um einen anderen zu kontaktieren -->
                <button type="button" class="btn btn-primary" style="float: right" data-toggle="modal" data-target="#ModalKontaktNoLogin">Kontakt</button>
                <!-- leitet an die Action zum favorisieren weiter -->
                <a href="../profil/favoritenAction.php?id=<?php echo $row['Angebot_ID'] ?>&re=../uebersicht/angebot.php?id=<?php echo $row['Angebot_ID'] ?>" class="btn btn-primary mx-3" style="float: right">Favorit</a>
              </div>
            </div>
            <!-- Wenn man eingeloggt ist, und nicht Urheber des Angebots ist -->
          <?php } else if ($row['Benutzer_ID'] != $_SESSION['id']) { ?>
            <div class="col-4">
              <div class="pr-4" style="padding: 0!important">
                <!-- Button öffnet den Modal zum kontaktieren -->
                <button type="button" class="btn btn-primary" style="float: right" data-toggle="modal" data-target="#ModalKontakt">Kontakt</button>
                <!-- leitet an die Action zum favorisieren weiter -->

                <?php
                if (!($statement3 = $databaseconnection->prepare("SELECT * FROM Favoriten WHERE Benutzer_ID=? AND Angebot_ID=?"))
                || !($statement3->bind_param("ii", $_SESSION['id'], $row['Angebot_ID']))
                || !($statement3->execute())
                || !($resultset3 = $statement3->get_result())
                || !($resultset3->fetch_assoc())) {
                  echo '<a href="../profil/favoritenAction.php?id='.$row['Angebot_ID'].'&re=../uebersicht/angebot.php?id='.$row['Angebot_ID'].'" class="btn btn-primary mx-3" style="float: right">Favorit</a>';
                }
                ?>

              </div>
            </div>
            <!-- wenn man eingeloggt ist und Urheber des Angebots sind -->
          <?php } else { ?>
            <div class="col-4">
              <div class="pr-4" style="padding: 0!important">
                <!-- öffnet Modal zum löschen des Angebots -->
                <button type="button" class="btn btn-danger" style="float: right" data-toggle="modal" data-target="#ModalLöschen">Löschen</button>
              </div>
            </div>
          <?php } ?>
          </div>
        </div>

        <fieldset class="box mb-4">
          <div class="row mx-0 px-0 my-3">
            <legend style="padding: 0px 0px 0px 17px"><?= $row['Titel'] ?></legend>
            <div class="col-12">
              <!-- benutzt die loadPic.php um das Bild zu laden -->
              <img class="col-12" style="padding-left: 0px" src="../const/loadPic.php?id=<?= $row['Bild_ID'] ?>" alt="">
            </div>
          </div>
        </fieldset>

        <!-- Anzeigen der Daten zu dem Angebot -->
        <!-- Die Values werden aus der $row genommen -->
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

        <!-- Anzeigen der Daten zu dem Angebot -->
        <!-- Die Values werden aus der $row genommen -->
        <fieldset class="box my-4">
          <div class="row mx-0 px-0">
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

            <!-- Wenn das Feature in der Datenbank gesetzt ist, zeige den Punkt dazu -->
            <?php if($row['Alarmanlage'] == 1) echo'
            <div class="col-4" style="padding-left: 17px">
              <div class="custom-control custom-checkbox mt-3">
                <input type="checkbox" checked disabled name="alarmanlage" class="custom-control-input" id="alarmanlage" value="true">
                <label class="custom-control-label" for="alarmanlage">Alarmanlage</label>
              </div>
            </div>
            ' ?>

            <!-- Wenn das Feature in der Datenbank gesetzt ist, zeige den Punkt dazu -->
            <?php if($row['Anhaengerkupplung'] == 1) echo'
            <div class="col-4" style="padding-left: 17px">
              <div class="custom-control custom-checkbox mt-3">
                <input type="checkbox" checked disabled name="anhaengerkupplung" class="custom-control-input" id="anhaengerkupplung" value="true">
                <label class="custom-control-label" for="anhaengerkupplung">Anhaengerkupplung</label>
              </div>
            </div>
            ' ?>

            <!-- Wenn das Feature in der Datenbank gesetzt ist, zeige den Punkt dazu -->
            <?php if($row['Bluetooth'] == 1) echo'
            <div class=" col-4" style="padding-left: 17px">
              <div class="custom-control custom-checkbox mt-3">
                <input type="checkbox" checked disabled name="bluetooth" class="custom-control-input" id="bluetooth" value="true">
                <label class="custom-control-label" for="bluetooth">Bluetooth</label>
              </div>
            </div>
            ' ?>

            <!-- Wenn das Feature in der Datenbank gesetzt ist, zeige den Punkt dazu -->
            <?php if($row['Bordcomputer'] == 1) echo'
            <div class=" col-4" style="padding-left: 17px">
              <div class="custom-control custom-checkbox mt-3">
                <input type="checkbox" checked disabled name="bordcomputer" class="custom-control-input" id="bordcomputer" value="true">
                <label class="custom-control-label" for="bordcomputer">Bordcomputer</label>
              </div>
            </div>
            ' ?>

            <!-- Wenn das Feature in der Datenbank gesetzt ist, zeige den Punkt dazu -->
            <?php if($row['HeadUP'] == 1) echo'
            <div class=" col-4" style="padding-left: 17px">
              <div class="custom-control custom-checkbox mt-3">
                <input type="checkbox" checked disabled name="head" class="custom-control-input" id="head" value="true">
                <label class="custom-control-label" for="head">Head-Up Display</label>
              </div>
            </div>
            ' ?>

            <!-- Wenn das Feature in der Datenbank gesetzt ist, zeige den Punkt dazu -->
            <?php if($row['Multilenk'] == 1) echo'
            <div class=" col-4" style="padding-left: 17px">
              <div class="custom-control custom-checkbox mt-3">
                <input type="checkbox" checked disabled name="multifunktionslenkrad" class="custom-control-input" id="multifunktionslenkrad" value="true">
                <label class="custom-control-label" for="multifunktionslenkrad">Multifunktionslenkrad</label>
              </div>
            </div>
            ' ?>

            <!-- Wenn das Feature in der Datenbank gesetzt ist, zeige den Punkt dazu -->
            <?php if($row['Navi'] == 1) echo'
            <div class=" col-4" style="padding-left: 17px">
              <div class="custom-control custom-checkbox mt-3">
                <input type="checkbox" checked disabled name="navigationssystem" class="custom-control-input" id="navigationssystem" value="true">
                <label class="custom-control-label" for="navigationssystem">Navigationssystem</label>
              </div>
            </div>
            ' ?>

            <!-- Wenn das Feature in der Datenbank gesetzt ist, zeige den Punkt dazu -->
            <?php if($row['Regensensor'] == 1) echo'
            <div class=" col-4" style="padding-left: 17px">
              <div class="custom-control custom-checkbox mt-3">
                <input type="checkbox" checked disabled name="regensensor" class="custom-control-input" id="regensensor" value="true">
                <label class="custom-control-label" for="regensensor">Regensensor</label>
              </div>
            </div>
            ' ?>

            <!-- Wenn das Feature in der Datenbank gesetzt ist, zeige den Punkt dazu -->
            <?php if($row['Sitzheizung'] == 1) echo'
            <div class=" col-4" style="padding-left: 17px">
              <div class="custom-control custom-checkbox mt-3">
                <input type="checkbox" checked disabled name="sitzheizung" class="custom-control-input" id="sitzheizung" value="true">
                <label class="custom-control-label" for="sitzheizung">Sitzheizung</label>
              </div>
            </div>
            ' ?>

            <!-- Wenn das Feature in der Datenbank gesetzt ist, zeige den Punkt dazu -->
            <?php if($row['Sound'] == 1) echo'
            <div class=" col-4" style="padding-left: 17px">
              <div class="custom-control custom-checkbox mt-3">
                <input type="checkbox" checked disabled name="soundsystem" class="custom-control-input" id="soundsystem" value="true">
                <label class="custom-control-label" for="soundsystem">Soundsystem</label>
              </div>
            </div>
            ' ?>

            <!-- Wenn das Feature in der Datenbank gesetzt ist, zeige den Punkt dazu -->
            <?php if($row['Standheiz'] == 1) echo'
            <div class=" col-4" style="padding-left: 17px">
              <div class="custom-control custom-checkbox mt-3">
                <input type="checkbox" checked disabled name="standheizung" class="custom-control-input" id="standheizung" value="true">
                <label class="custom-control-label" for="standheizung">Standheizung</label>
              </div>
            </div>
            ' ?>

            <!-- Wenn das Feature in der Datenbank gesetzt ist, zeige den Punkt dazu -->
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

        <!-- Kontaktdatenübersicht -->
        <fieldset class="box my-4">
          <div class="row mx-0 px-0 my-3">
            <legend style="padding: 0px 0px 0px 17px">Standort</legend>
            <div class="col-6 mb-0 form-label-group">
              <h6><?php echo $row2['Vorname'] . " " . $row2['Nachname'] . " / " . $row2['Benutzername']; ?></h6>
              <p>Email: <?= $row2['Email'] ?></p>
            </div>
            <div class="col-6 mb-0 form-label-group">
              <p class="mb-0"><?php echo $row2['Strasse']; ?></p>
              <p class="mb-0"><?php echo $row2['Postleitzahl'] . " " . $row2['Ort']; ?></p>
            </div>
          </div>
        </fieldset>
      </div>
    </div>
  </div>

  <!-- Modal zum löschen des Angebots -->
  <div class="modal fade" id="ModalLöschen" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle">Löschen</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <h2>Achtung!</h2>
          <h4>Wollen Sie dieses Angebot wirklich löschen?</h4>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Abbrechen</button>
          <!-- aufrufen der delete-Funktion mit der zu löschenden Angebots-ID -->
          <a href="deleteAngebot.php?id=<?= $row['Angebot_ID'] ?>" class="btn btn-danger">Löschen</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal, um eine Nachricht an den Urheber zu senden -->
  <div class="modal fade" id="ModalKontakt" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle">Kontakt</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <!-- Weiterleitung an die action.php des Chats, in dieser wird die Nachricht dann verarbeitet und gesendet -->
        <form class="" action="../chat/action.php" method="post">
          <div class="modal-body">
            <textarea name="text" class="form-control" rows="3" cols="80" required></textarea>
            <input type="hidden" name="empfaenger" value="<?= $row['Benutzer_ID'] ?>">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Abbrechen</button>
            <input type="submit" class="btn btn-primary" name="" value="Senden">
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal, welches einen zum einloggen auffordert -->
  <div class="modal fade" id="ModalKontaktNoLogin" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle">Kontakt</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="text-center">
            <h3>Bitte erst einloggen</h3>
            <!-- Wenn man nicht eingeloggt ist, wird die URL des Angebots in die Session als redirect-Link geschrieben, damit man nach dem einloggen oder registrieren wieder zum Angebot gelangt -->
            <?php if (!isset($_SESSION['id'])) {
              $_SESSION['redirect'] = "/uebersicht/angebot.php?id=".$row['Angebot_ID'];
            } ?>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Abbrechen</button>
          <a href="../login" class="btn btn-primary">Login</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Die Datenbankconnection wird wieder geschlossen -->
  <?php closeConnection($databaseconnection);?>
  <?php require "../const/footer.php" ?>
</body>
</html>
