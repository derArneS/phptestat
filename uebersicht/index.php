<?php

session_start();

require "../database/database.php";
//Es wird die Cookie-Methode benutzt, die schaut, ob Cookies gesetzt sind, die einen einloggen können
require "../const/cookie.php";

//Datenbankconnection wird geöffnet
$databaseconnection = createConnection();

//Wenn kein Statment für die Suche in der Session steht, wird die Standardssuche als Statement in die Session geschrieben. Hierbei wird nicht gefiltert, sondern alle Autos angezeigt
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
        <!-- Link zurück zur Suchen-Seite -->
        <a href="../suche/index.php">Suche verändern</a>
      </div>

    <?php

    //Es wird das Statement aus der Session ausgeführt, also entweder die definierte Suche oder die eben in die Session geschriebene Standardssuche
    if ($resultset = $databaseconnection->query($_SESSION['statement'])) {
      //Wenn keine Angebote zu dem Statement passen, es also kein Suchergebnis gibt, wird man zurück zur Such-Seite geleitet, damit man die Suche überarbeiten kann
      if ($resultset->num_rows == 0) {
        $_SESSION['error']['ergebnis'] = true;
        header("Location: ../suche");
        die();
      }

      //Es werden solange Anzeigeelemente erschaffen, wie es Autos in dem Suchergebnis gibt
      while ($row = $resultset->fetch_assoc()) {
      echo'
      <div class="container">
        <fieldset class="mt-4 mx-auto box" >
        <div class="row">
          <div class="col-10">
            <a href="../uebersicht/angebot.php?id='.$row['Angebot_ID'].'"><h3 style="padding: 0px 0px 0px 17px">'.$row['Titel'].'</h3></a>
          </div>';
          //Wenn der eingeloggte User nicht der Urheber ist, kann er das Angebot zu seinen Favoviten hinzufügen
          //Wenn man hier drauf klickt, und nicht angemeldet ist, wird man zum Login weitergeleitet, da dieser Bereich privat ist
          if ($row['Benutzer_ID'] != $_SESSION['id']) {

            echo '
            <div class="col-2 pr-4 mb-3" style="padding: 0!important">';

            //Wenn man dieses Angebot schon favorisiert hat, wird einem der Favoritenbutton nicht mehr angezeigt
            if (!(isset($_SESSION['id']))
            || !($statement2 = $databaseconnection->prepare("SELECT * FROM Favoriten WHERE Benutzer_ID=? AND Angebot_ID=?"))
            || !($statement2->bind_param("ii", $_SESSION['id'], $row['Angebot_ID']))
            || !($statement2->execute())
            || !($resultset2 = $statement2->get_result())
            || !($resultset2->fetch_assoc())) {
              echo '<a href="../profil/favoritenAction.php?id='.$row['Angebot_ID'].'" class="btn btn-primary">Favorit</a>';
            }
            //Wenn man nicht eingeloggt ist, wird einem zwar der Kontakt-Button angezeigt, es wird aber ein Modal angezeigt, welches einen zum einloggen auffordert
            //Wenn man akzeptiert, wird man zum Login weitergeleitet. Dies findet mit dem redirect-Link zur der FavoritenAction statt. Wenn man sich nun einloggt, wird das vorher ausgewählte Auto favorisiert
            if(!isset($_SESSION['id'])) {
              echo '
                <button type="button" class="btn btn-primary" style="float: right" data-toggle="modal" data-target="#ModalKontaktNoLogin'.$row['Angebot_ID'].'">Kontakt</button>
                <div class="modal fade" id="ModalKontaktNoLogin'.$row['Angebot_ID'].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Abbrechen</button>
                        <a href="../login/index.php?red=/uebersicht/angebot.php?id='.$row['Angebot_ID'].'" class="btn btn-primary">Login</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
                    ';
            //Wenn man eingeloggt ist, aber nicht der Urheber ist, kann man den Urheber kontaktieren. Es öffnet sich ein Modal, in welches man eine Nachricht eingeben kann. Mit dem drücken auf Senden wird man zu der action.php
            //vom Chat weitergeleitet. Hier wird die Nachricht verarbeitet und gesendet
            } else if ($row['Benutzer_ID'] != $_SESSION['id']) {
              echo '
                <button type="button" class="btn btn-primary" style="float: right" data-toggle="modal" data-target="#ModalKontakt'.$row['Angebot_ID'].'">Kontakt</button>
                <div class="modal fade" id="ModalKontakt'.$row['Angebot_ID'].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Kontakt</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form class="" action="../chat/action.php" method="post">
                        <div class="modal-body">
                          <textarea name="text" class="form-control" rows="3" cols="80" required></textarea>
                          <input type="hidden" name="empfaenger" value="'.$row['Benutzer_ID'].'">
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Abbrechen</button>
                          <input type="submit" class="btn btn-primary" name="" value="Senden">
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
                  ';
            }
          }
          //Die eigentliche Darstellung des Angebots in der Suchübersicht. Hier werden die Daten aus der aktuellen $row genommen. Das Bild wird über $row['Bild_ID'] mit der Funktion loadPic geladen
          echo '
        </div>
          <div class="row mx-0 px-0 mb-3">
            <a class="col-12 p-0" href="../uebersicht/angebot.php?id='.$row['Angebot_ID'].'">
              <div class="row m-0 p-0">
                <div class="mr-2">
                  <img class="" style="padding-left: 0px; height: 135px; width: 240px" src="../const/loadPic.php?id='.$row['Bild_ID'].'" alt="">
                </div>
                <div style=" border-left: 1px solid grey;  height: 135px;" class="col-7">
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
<!-- Die Datenbankconnection wird wieder geschlossen -->
<?php closeConnection($databaseconnection); ?>
