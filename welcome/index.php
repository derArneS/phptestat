<?php

session_start();
require '../database/database.php';
require "../const/cookie.php";
require '../const/deletecache.php';

$databaseconnection = createConnection();

//Alle Marken aus der Datenbank lesen
if (($statement = $databaseconnection->prepare("SELECT * FROM Marken ORDER BY Name ASC"))
&& ($statement->execute())
&& ($resultset = $statement->get_result())) {
  $rowCount = $resultset->num_rows;
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Auto25</title>
  <?php require "../const/head.php" ?>
  <link rel="stylesheet" href="welcome.css">
  <link rel="stylesheet" href="../css/carousel.css">
</head>
<body>
  <script type="text/javascript">
  //Ajax Zugriff auf ajaxData.php zum Laden der Modelle zu der ausgewählten Marke
  function ajax(){
      //ausgewählte Marke
      var marke = $('#marke').val();
      //Wenn in der Session schon das Modell hinterlegt ist, wird das Modell eingetragen
        <?php echo ("var modell = ".(isset($_SESSION['cache']['suche']['modell']) && $_SESSION['cache']['suche']['modell'] != ""?$_SESSION['cache']['suche']['modell'].";":"0;")) ?>
      var ajaxString = 'marke='+ encodeURIComponent(marke) + '&modell='+ encodeURIComponent(modell);
      if(marke){
        $.ajax({
          type:'POST',
          url:'../suche/ajaxData.php',
          data: ajaxString,
          success:function(html){
            //bei Success wird die Rückgabe von ajaxData.php in das Dropdown eingetragen
            $('#modell').html(html);
          }
        });
      }else{
        //Wenn keine Marke ausgewählt wurde, gibt es nur die Auswahl Modell als Platzhalter
        $('#modell').html('<option value="">Modell</option>');
      }
    };

    //wenn das Document fertig geladen ist, wird das AJAX einmal ausgeführt, damit, falls über die Session schon Such-Suchparameter
    //bereitgestellt wurde, die Modelle eingetragen
    document.onload = ajax();
  </script>
  <?php require '../const/navbar.php'; ?>
  <!--Slider mit drei Bildern, welche bei Auswahl auf eine vordefinierte Suche verweisen -->
  <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <!-- Das erste Element des Carousels verlinkt auf die Action.php mit einer gesetzten Marke (1), damit werden alle BMWs aus der
      Datenbank geladen  -->
        <a href="../welcome/action.php?marke=1">
          <img class="d-block w-100"src="../pics/car1.jpg" alt="First slide">
        </a>
        <div class="carousel-caption d-none d-md-block">
          <h1>BMW</h1>
        </div>
      </div>
      <div class="carousel-item">
        <!-- Das zweite Element des Carousels verlinkt auf die Action.php mit einer gesetzten Marke (2), damit werden alle Audis aus der
      Datenbank geladen -->
        <a href="../welcome/action.php?marke=2">
          <img class="d-block w-100" src="../pics/car2.jpg" alt="Second slide">
        </a>
        <div class="carousel-caption d-none d-md-block">
          <h1>Audi</h1>
        </div>
      </div>
      <div class="carousel-item">
        <!-- Das dritte Element des Carousels verlinkt auf die Action.php mit einer gesetzten Marke (7), damit werden alle Porsches aus der
      Datenbank geladen -->
        <a href="../welcome/action.php?marke=7">
          <img class="d-block w-100" src="../pics/car3.jpg" alt="Third slide">
        </a>
        <div class="carousel-caption d-none d-md-block">
          <h1>Porsche</h1>
        </div>
      </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>

  <!-- Schnellsuche, nur Marken und Modelle
       Form die auf action.php verweist-->
  <form action="action.php" method="post">
    <div class="container mt-4">
      <div class="row mx-0 px-0">
        <div class="container col-12 mx-0 px-0">
          <div class="mb-3 mx-auto">
            <fieldset class="box mb-4">
              <div class="row mx-0 px-0">
                <legend style="padding: 0px 0px 0px 17px">Schnellsuche</legend>
                <div class="col-5 form-label-group">
                  <!-- Wenn sich die Auswahl im Dropdown verändert wird, wird der Ajax-Aufruf benutzt, um die
                       Modelle aus der Datenbank zu laden-->
                  <select class="form-control" id="marke" name="marke" onchange="ajax()">
                    <option value="">Beliebig</option>
                    <?php
                    //Die Schleife wird nur ausgeführt, wenn es Marken in der Datenbank gibt
                    if($rowCount > 0){
                      //Die Schleife wird so oft ausgeführt, wie es Marken in der Datenbank gibt
                      while($row = $resultset->fetch_assoc()){
                        //Auswahlmöglichkeiten für das Marken-Dropdown; wenn die Marke mit der Marke aus dem Cache in der Session übereinstimmt, wird diese Auswahl selektiert
                        echo '<option '.((isset($_SESSION['cache']['suche']['marke']) && $_SESSION['cache']['suche']['marke'] == $row['ID'])?'selected="selected"':' ').'value="'.$row['ID'].'">'.$row['Name'].'</option>';
                      }
                      //sonst wird Keine Marken als Platzhalter angezeigt
                    }else{
                      echo '<option value="">Keine Marken</option>';
                    }
                    ?>
                  </select>
                </div>
                <div class="col-5 form-label-group">
                  <select class="form-control" id="modell" name="modell">
                    <option value="">Modell</option>
                  </select>
                </div>
                <div class="col-2">
                  <button class="btn btn-primary btn-block btn-lg btn-login" type="submit" name="button" value="suche">Suchen</button>
                </div>
              </div>
            </fieldset>
          </div>
        </div>
      </div>
    </div>
  </form>



  <div class="container mt-4 mb-5">
    <div class="row mx-0 px-0">
      <div class="container col-12 mx-0 px-0">
        <div class="mb-3 mx-auto">
          <fieldset class="box mb-4">
            <div class="row mx-0 px-0 mb-3">
              <legend style="padding: 0px 0px 0px 17px">Die neusten Angebote: </legend>
              <div class="container">
                <div class="row">

  <?php

  //Alle Angebote aus der Datenbank holen, nach ID absteigend (also jüngste Angebote zuerst) sortieren und nur die 3 obersten selektieren
  //So werden die 3 neusten Angebote auf der Übersichtsseite gezeigt
  if (($statement = $databaseconnection->prepare("SELECT Angebote.ID AS Angebot_ID, Benutzer_ID, Titel, Angebote.Marken_ID AS Angebot_Marke_ID, Angebote.Modell_ID AS Angebote_Modell_ID, Preis, Baujahr, Kilometerstand, Leistung, Kraftstoff, Getriebe,
                                                          Alarmanlage, Anhaengerkupplung, Bluetooth, Bordcomputer, HeadUP, Multilenk, Navi, Regensensor, Sitzheizung,
                                                          Sound, Standheiz, StartStopp, Bilder.Angebot_ID AS Bilder_Angebot_ID, Bilder.ID AS Bild_ID, Marken.ID AS Marke_ID, Marken.Name AS Marke_Marke, Modelle.Marken_ID AS Modell_Marke_ID,
                                                          Modelle.Name AS Modell_Name
                                                          FROM Angebote, Bilder, Marken, Modelle WHERE Angebote.ID = Bilder.Angebot_ID AND Angebote.Marken_ID = Marken.ID AND Angebote.Modell_ID = Modelle.ID ORDER BY Angebote.ID DESC LIMIT 3"))
  && ($statement->execute())
  && ($resultset = $statement->get_result())) {
    //wenn nicht kein Angebot gefunden wird, wird dieses angezeigt
    if ($resultset->num_rows != 0) {
      //kleine Übersicht, die zu der normalen Übersicht des Angebots verlinkt
      if ($row = $resultset->fetch_assoc()) {
        echo '
          <div class="col-4">
            <a href="action.php?id='.$row['Angebot_ID'].'">
              <div class="card">
                <img src="../const/loadPic.php?id='.$row['Bild_ID'].'" class="card-img-top" alt="..." style="height: 230px;">
                <div class="card-body">
                  <h2 class="card-text">'.$row['Titel'].'</h2>
                  <h4 class="card-text">'.$row['Preis'].' €</h4>
                </div>
              </div>
            </a>
          </div>
        ';
      }
      //wenn 2 Angebote gefunden wurden, wieder eine kleine Übersicht, die zu der normalen Übersicht des Angebots verlinkt
      if ($row = $resultset->fetch_assoc()) {
        echo '
          <div class="col-4">
            <a href="action.php?id='.$row['Angebot_ID'].'">
              <div class="card">
                <img src="../const/loadPic.php?id='.$row['Bild_ID'].'" class="card-img-top" alt="..." style="height: 230px;">
                <div class="card-body">
                  <h2 class="card-text">'.$row['Titel'].'</h2>
                  <h4 class="card-text">'.$row['Preis'].' €</h4>
                </div>
              </div>
            </a>
          </div>
        ';
      }
      //wenn ein drittes Angebot gefunden wurde, wieder eine kleine Übersicht, die zu der normalen Übersicht des Angebots verlinkt
      if ($row = $resultset->fetch_assoc()) {
        echo '
          <div class="col-4">
            <a href="action.php?id='.$row['Angebot_ID'].'">
              <div class="card">
                <img src="../const/loadPic.php?id='.$row['Bild_ID'].'" class="card-img-top" alt="..." style="height: 230px;">
                <div class="card-body">
                  <h2 class="card-text">'.$row['Titel'].'</h2>
                  <h4 class="card-text">'.$row['Preis'].' €</h4>
                </div>
              </div>
            </a>
          </div>
        ';
      }
    }
  }
  ?>
                </div>
              </div>
            </div>
          </fieldset>
        </div>
      </div>
    </div>
  </div>

  <?php require "../const/footer.php" ?>
</body>
</html>
