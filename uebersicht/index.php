<?php

session_start();

require "../database/database.php";

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

    if (isset($_SESSION['statement']) && $resultset = $databaseconnection->query($_SESSION['statement'])) {
      while ($row = $resultset->fetch_assoc()) {
        print_r($row);
        echo'<fieldset class="box mb-4 col-8 mx-auto">
              <div class="row mx-0 px-0 my-3">
                <legend style="padding: 0px 0px 0px 17px">'.$row['Titel'].'</legend>
                <div class="col-6">
                  <img class="col-12" style="padding-left: 0px; height: 180px; width: 320px" src="../const/loadPic.php?id='.$row['Bild_ID'].'" alt="">
                </div>
              </div>
            </fieldset>';
      }
    }

    ?>


  </body>
</html>

<?php closeConnection($databaseconnection); ?>
