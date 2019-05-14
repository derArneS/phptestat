<?php

session_start();

require "../database/database.php";
require "../const/cookie.php";

$databaseconnection = createConnection();


?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="uebersicht.css">
    <?php require "../const/head.php" ?>
  </head>
  <body>
    <?php
    require "../const/navbar.php";

    ?>
    <div class="container">
      <div class="my-3 mx-auto">
        <a href="../suche/index.php">Suche verändern</a>
      </div>

    <?php

    if (isset($_SESSION['statement']) && $resultset = $databaseconnection->query($_SESSION['statement'])) {
      if ($resultset->num_rows == 0) {
        $_SESSION['errorErgebnis'] = true;
        header("Location: ../suche");
        die();
      }

      while ($row = $resultset->fetch_assoc()) {
        echo'
        <a href="angebot.php?id='.$row['Angebot_ID'].'">
          <fieldset class="box mb-4 mx-auto">
            <div class="row mx-0 px-0 mb-3">
              <legend style="padding: 0px 0px 0px 17px">'.$row['Titel'].'</legend>
              <div class="col-3">
                <img class="" style="padding-left: 0px; height: 135px; width: 240px" src="../const/loadPic.php?id='.$row['Bild_ID'].'" alt="">
              </div>
              <div style=" border-left: 1px solid grey;  height: 135px;" class="col-7">
                <p class="m-0" style="font-size: 20px">Baujahr: '.$row['Baujahr'].', Kilometerstand: '.$row['Kilometerstand'].', Leistung: '.$row['Leistung'].'
                  </br>Kraftstoff: '; if($row['Kraftstoff'] == 1) echo "Benzin"; if($row['Kraftstoff'] == 2) echo "Diesel"; if($row['Kraftstoff'] == 3) echo "Elektro"; if($row['Kraftstoff'] == 4) echo "Wasserstoff"; echo ', Getriebe: ';
                  if($row['Getriebe'] == 1) echo "Manuell"; if($row['Getriebe'] == 2) echo "Automatik"; echo '
                </p>
              </div>
              <div style=" border-left: 1px solid grey;  height: 135px;" class="col-2">
                <h4 style="height: 50%">Preis:</h4>
                <h2>'.$row['Preis'].' €</h2>
              </div>
            </div>
          </fieldset>
        </a>
        ';
      }
    }

    ?>

  </div>


    <?php require "../const/footer.php" ?>



  </body>
</html>

<?php closeConnection($databaseconnection); ?>
