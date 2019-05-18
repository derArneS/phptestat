<div class="tab-pane fade <?php if(isset($_GET['tab']) && $_GET['tab'] == 1) echo "show active"; if(!isset($_GET['tab'])) echo "show active";?>" id="nav-angebote" role="tabpanel" aria-labelledby="nav-home-tab">
  <?php

  if ($resultset3->num_rows == 0) {
    echo "Du hast scheinbar noch keine Angebote...";
  }

  //Die eigenen Angebote werden nacheinander ausgegeben. Inklusive der Option das eigene Angebot wieder zu entfernen.
  while ($angebotrow = $resultset3->fetch_assoc()) {
    echo'
    <div class="container">
      <fieldset class="mt-4 mx-auto box" >
        <div class="row mx-0 px-0 mb-3">
          <a class="col-11 p-0" href="../uebersicht/angebot.php?id='.$angebotrow['Angebot_ID'].'&loc=1">
            <div class="row m-0 p-0">
              <legend style="padding: 0px 0px 0px 17px">'.$angebotrow['Titel'].'</legend>
              <div class="mr-2">
                <img class="" style="padding-left: 0px; height: 135px; width: 240px" src="../const/loadPic.php?id='.$angebotrow['Bild_ID'].'" alt="">
              </div>
              <div style=" border-left: 1px solid grey;  height: 135px;" class="col-6">
                <p class="m-0" style="font-size: 20px">
                  Baujahr: '.$angebotrow['Baujahr'].', Kilometerstand: '.$angebotrow['Kilometerstand'].', Leistung: '.$angebotrow['Leistung'].'PS
                </br>Kraftstoff: '; if($angebotrow['Kraftstoff'] == 1) echo "Benzin"; if($angebotrow['Kraftstoff'] == 2) echo "Diesel";
                if($angebotrow['Kraftstoff'] == 3) echo "Elektro"; if($angebotrow['Kraftstoff'] == 4) echo "Wasserstoff"; echo ', Getriebe: ';
                if($angebotrow['Getriebe'] == 1) echo "Manuell"; if($angebotrow['Getriebe'] == 2) echo "Automatik"; echo '
              </p>
            </div>
            <div style=" border-left: 1px solid grey;  height: 135px;" class="col pr-0">
              <h4 style="height: 50%">Preis:</h4>
              <h2>'.$angebotrow['Preis'].' €</h2>
            </div>
            </div>
          </a>
          <div class="col-1 pl-0">
            <a href="deleteAngebot.php?id='.$angebotrow['Angebot_ID'].'" class="btn btn-primary">Löschen</a>
          </div>
        </div>
      </fieldset>
    </div>
    ';
  }

   ?>
</div>
