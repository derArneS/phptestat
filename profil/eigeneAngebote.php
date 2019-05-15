<div class="tab-pane show active fade pt-3" id="nav-angebote" role="tabpanel" aria-labelledby="nav-home-tab">
  <?php

  if ($resultset3->num_rows == 0) {
    echo "Du hast scheinbar noch keine Angebote...";
  }

  while ($angebotrow = $resultset3->fetch_assoc()) {
    echo'
      <div class="container">
      <fieldset class="mb-4 mx-auto" style="box-shadow: 0 1px 2px 0 rgba(0,0,0,.5); border-radius: 4px; padding: 13px 17px 0px 17px;">
        <div>
          <a href="deleteAngebot.php?id='.$angebotrow['Angebot_ID'].'" class="btn btn-primary" style="position: absolute; right: 200px;">Löschen</a>
        </div>
      <a href="../uebersicht/angebot.php?id='.$angebotrow['Angebot_ID'].'">
        <div class="row mx-0 px-0 mb-3">
          <legend style="padding: 0px 0px 0px 17px">'.$angebotrow['Titel'].'</legend>
          <div class="col-3">
            <img class="" style="padding-left: 0px; height: 135px; width: 240px" src="../const/loadPic.php?id='.$angebotrow['Bild_ID'].'" alt="">
          </div>
          <div style=" border-left: 1px solid grey;  height: 135px;" class="col-7">
            <p class="m-0" style="font-size: 20px">Baujahr: '.$angebotrow['Baujahr'].', Kilometerstand: '.$angebotrow['Kilometerstand'].', Leistung: '.$angebotrow['Leistung'].'
              </br>Kraftstoff: '; if($angebotrow['Kraftstoff'] == 1) echo "Benzin"; if($angebotrow['Kraftstoff'] == 2) echo "Diesel"; if($angebotrow['Kraftstoff'] == 3) echo "Elektro"; if($angebotrow['Kraftstoff'] == 4) echo "Wasserstoff"; echo ', Getriebe: ';
              if($angebotrow['Getriebe'] == 1) echo "Manuell"; if($angebotrow['Getriebe'] == 2) echo "Automatik"; echo '
            </p>
          </div>
          <div style=" border-left: 1px solid grey;  height: 135px;" class="col-2">
            <h4 style="height: 50%">Preis:</h4>
            <h2>'.$angebotrow['Preis'].' €</h2>
          </div>
        </div>
        </a>
      </fieldset>
      </div>
    ';
  }

   ?>
</div>
