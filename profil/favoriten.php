<div class="tab-pane fade <?php if(isset($_GET['tab']) && $_GET['tab'] == 2) echo "show active";?>" id="nav-favoriten" role="tabpanel" aria-labelledby="nav-profile-tab">

<?php
$databaseconnection = createConnection();

//SQL-Statement, welches für den angemeldeteten Benutzer die Favoriten ausgibt
$sql = "SELECT Angebote.ID AS Angebot_ID, Favoriten.Benutzer_ID, Titel, Marken_ID, Modell_ID, Preis, Baujahr, Kilometerstand, Leistung, Kraftstoff,
Getriebe, Alarmanlage, Anhaengerkupplung, Bluetooth, Bordcomputer, HeadUP, Multilenk, Navi, Regensensor, Sitzheizung, Sound, Standheiz, StartStopp,
Bilder.ID AS Bild_ID FROM Angebote INNER JOIN Bilder ON Angebote.ID=Bilder.Angebot_ID INNER JOIN Favoriten ON Angebote.ID=Favoriten.Angebot_ID AND Favoriten.Benutzer_ID = ?";
if (!($statement = $databaseconnection->prepare($sql)) || !($statement->bind_param('i', $_SESSION['id'])) || !($statement->execute())) {

} else if (($resultset4 = $statement->get_result()) && ($resultset4->num_rows > 0)) {
  //Die Favoriten werden nacheinander ausgegeben
  while($row2 = $resultset4->fetch_assoc()){
    echo'
    <div class="container">
      <fieldset class="mt-4 mx-auto box" >
        <div class="row mx-0 px-0 mb-3">
          <a class="col-10 p-0" href="../uebersicht/angebot.php?id='.$row2['Angebot_ID'].'">
            <div class="row m-0 p-0">
              <legend style="padding: 0px 0px 0px 17px">'.$row2['Titel'].'</legend>
              <div class="mr-2">
                <img class="" style="padding-left: 0px; height: 135px; width: 240px" src="../const/loadPic.php?id='.$row2['Bild_ID'].'" alt="">
              </div>
              <div style=" border-left: 1px solid grey;  height: 135px;" class="col-6">
                <p class="m-0" style="font-size: 20px">
                  Baujahr: '.$row2['Baujahr'].', Kilometerstand: '.$row2['Kilometerstand'].', Leistung: '.$row2['Leistung'].'PS
                </br>Kraftstoff: '; if($row2['Kraftstoff'] == 1) echo "Benzin"; if($row2['Kraftstoff'] == 2) echo "Diesel";
                if($row2['Kraftstoff'] == 3) echo "Elektro"; if($row2['Kraftstoff'] == 4) echo "Wasserstoff"; echo ', Getriebe: ';
                if($row2['Getriebe'] == 1) echo "Manuell"; if($row2['Getriebe'] == 2) echo "Automatik"; echo '
              </p>
            </div>
            <div style=" border-left: 1px solid grey;  height: 135px;" class="col pr-0">
              <h4 style="height: 50%">Preis:</h4>
              <h2>'.$row2['Preis'].' €</h2>
            </div>
            </div>
          </a>
          <div class="col-2 pr-4" style="padding: 0!important">
            <a href="deleteFavorit.php?id='.$row2['Angebot_ID'].'" class="btn btn-primary" style="float: right">Entfernen</a>
          </div>
        </div>
      </fieldset>
    </div>
    ';
  }
} else {
  echo 'Du hast noch keine Favoriten hinzugefügt.';
}
?>




</div>
