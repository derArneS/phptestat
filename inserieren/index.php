<?php
session_start();
require "../database/database.php";
require "../const/cookie.php";
require "../const/private.php"; isPrivate(true, "/inserieren");

if (isset($_SESSION['cache']['suche'])) {
  unset($_SESSION['cache']['suche']);
}


if (isset($_SESSION['cache'])) {
  $titel = (isset($_SESSION['cache']['insert']['titel'])) ? $_SESSION['cache']['insert']['titel'] : null;
  $marke = (isset($_SESSION['cache']['insert']['marke'])) ? $_SESSION['cache']['insert']['marke'] : null;
  $modell = (isset($_SESSION['cache']['insert']['modell'])) ? $_SESSION['cache']['insert']['modell'] : null;
  $img_id = (isset($_SESSION['cache']['insert']['img_id'])) ? $_SESSION['cache']['insert']['img_id'] : null;
  $preis = (isset($_SESSION['cache']['insert']['inputPreis'])) ? $_SESSION['cache']['insert']['inputPreis'] : null;
  $bj = (isset($_SESSION['cache']['insert']['inputBJ'])) ? $_SESSION['cache']['insert']['inputBJ'] : null;
  $km = (isset($_SESSION['cache']['insert']['inputKM'])) ? $_SESSION['cache']['insert']['inputKM'] : null;
  $leistung = (isset($_SESSION['cache']['insert']['inputLeistung'])) ? $_SESSION['cache']['insert']['inputLeistung'] : null;
  $kraftstoff = (isset($_SESSION['cache']['insert']['kraftstoff'])) ? $_SESSION['cache']['insert']['kraftstoff'] : null;
  $getriebe = (isset($_SESSION['cache']['insert']['getriebe'])) ? $_SESSION['cache']['insert']['getriebe'] : null;
  $alarmanlage = (isset($_SESSION['cache']['insert']['alarmanlage'])) ? 'true' : 'false';
  $anhaengerkupplung = (isset($_SESSION['cache']['insert']['anhaengerkupplung'])) ? 'true' : 'false';
  $bluetooth = (isset($_SESSION['cache']['insert']['bluetooth'])) ? 'true' : 'false';
  $bordcomputer = (isset($_SESSION['cache']['insert']['bordcomputer'])) ? 'true' : 'false';
  $head = (isset($_SESSION['cache']['insert']['head'])) ? 'true' : 'false';
  $multifunktionslenkrad = (isset($_SESSION['cache']['insert']['multifunktionslenkrad'])) ? 'true' : 'false';
  $navigationssystem = (isset($_SESSION['cache']['insert']['navigationssystem'])) ? 'true' : 'false';
  $regensensor = (isset($_SESSION['cache']['insert']['regensensor'])) ? 'true' : 'false';
  $sitzheizung = (isset($_SESSION['cache']['insert']['sitzheizung'])) ? 'true' : 'false';
  $soundsystem = (isset($_SESSION['cache']['insert']['soundsystem'])) ? 'true' : 'false';
  $standheizung = (isset($_SESSION['cache']['insert']['standheizung'])) ? 'true' : 'false';
  $startStopp = (isset($_SESSION['cache']['insert']['startStopp'])) ? 'true' : 'false';
}


?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Inserieren</title>
  <?php require "../const/head.php" ?>
  <link rel="stylesheet" href="insert.css">
</head>
<body onload="ajax()" style="padding-bottom: 80px">
  <?php $databaseconnection = createConnection(); ?>
  <?php require "../const/navbar.php"; ?>

  <script type="text/javascript">
  function ajax(){
      var marke = $('#marke').val();
        <?php echo ("var modell = ".(isset($modell) && $modell != ""?$modell.";":"0;")) ?>
      var ajaxString = 'marke='+ encodeURIComponent(marke) + '&modell='+ encodeURIComponent(modell);
      if(marke){
        $.ajax({
          type:'POST',
          url:'ajaxData.php',
          data: ajaxString,
          success:function(html){
            $('#modell').html(html);
          }
        });
      }else{
        $('#modell').html('<option value="">Modell</option>');
      }
    };

    document.onload = ajax();
  </script>

  <?php


  if (($statement = $databaseconnection->prepare("SELECT * FROM Marken ORDER BY Name ASC"))
  && ($statement->execute())
  && ($resultset = $statement->get_result())) {
    $rowCount = $resultset->num_rows;
  }

  ?>
  <form action="action.php" method="post" enctype="multipart/form-data">
  <div class="container mt-4">
    <div class="row mx-0 px-0">
      <div class="container col-12 mx-0 px-0">
        <?php if (isset($_SESSION['errorEingabe']) && $_SESSION['errorEingabe']) { ?> <div class="alert alert-danger alert-round" role="alert">Fehlerhafte Eingaben!</div> <?php } ?>

        <fieldset class="box mb-4">
          <div class="row mx-0 px-0 mb-3">
            <legend style="padding: 0px 0px 0px 17px">Titel</legend>
            <div class="col-4 form-label-group">
              <input type="text" name="titel" id="titel" class="form-control" placeholder="Titel" value="<?= (isset($titel)?$titel:null); ?>">
              <label for="titel">Titel</label>
            </div>
          </div>
        </fieldset>

        <fieldset class="box mb-4">
          <div class="row mx-0 px-0">
            <legend style="padding: 0px 0px 0px 17px">Modell</legend>
            <div class="col-6 form-label-group">
              <select class="form-control" id="marke" name="marke" onchange="ajax()">
                <option value="">Beliebig</option>
                <?php
                if($rowCount > 0){
                  while($row = $resultset->fetch_assoc()){
                    echo '<option '.((isset($marke) && $marke == $row['ID'])?'selected="selected"':' ').'value="'.$row['ID'].'">'.$row['Name'].'</option>';
                  }
                }else{
                  echo '<option value="">Keine Marken</option>';
                }
                ?>
              </select>
            </div>
            <div class="col-6 form-label-group">
              <select class="form-control" id="modell" name="modell">
                <option value="">Modell</option>
              </select>
            </div>
          </div>
        </fieldset>

        <fieldset class="box my-4">
          <div class="row mx-0 px-0 mb-3">
            <legend style="padding: 0px 0px 0px 17px">Bild</legend>
            <div class="col-6">
              <img class="col-12" style="padding-left: 0px" src="../const/loadPic.php?id=<?php if(isset($img_id)) echo $img_id ?>" alt="">
            </div>
            <div class="col-6 form-label-group">
              <div class="row" class="align-items-end" style="height: 50%;">
                <input name="datei" type="file" class="mx-auto mt-auto mb-2">
              </div>
              <div class="row align-center">
                <button class="btn btn-primary btn-login col-8 mx-auto mt-2" type="submit" name="button" value="pic">Bild hochladen</button>
              </div>
            </div>
          </div>
        </fieldset>

        <input type="hidden" name="img_id" value="<?= isset($img_id) ? $img_id : 0 ?>">

        <fieldset class="box my-4">
          <div class="row mx-0 px-0 mb-3">
            <legend style="padding: 0px 0px 0px 17px">Daten</legend>
            <div class="col-4 form-label-group">
              <input type="text" name="inputPreis" id="inputPreis" class="form-control" placeholder="Preis" value="<?= (isset($preis)?$preis:null); ?>">
              <label for="inputPreis">Preis</label>
            </div>
            <div class="col-4 form-label-group">
              <input type="text" name="inputBJ" id="inputBJ" class="form-control" placeholder="Baujahr" value="<?= (isset($bj)?$bj:null); ?>">
              <label for="inputBJ">Baujahr</label>
            </div>
            <div class="col-4 form-label-group">
              <input type="text" name="inputKM" id="inputKM" class="form-control" placeholder="Kilometerstand" value="<?= (isset($km)?$km:null); ?>">
              <label for="inputKM">Kilometerstand</label>
            </div>
            <div class="col-4 form-label-group">
              <input type="text" name="inputLeistung" id="inputLeistung" class="form-control" placeholder="Leistung" value="<?= (isset($leistung)?$leistung:null); ?>">
              <label for="inputLeistung">Leistung (PS)</label>
            </div>
            <div class="col-4 form-label-group">
              <select class="form-control" id="kraftstoff" name="kraftstoff">
                <option value="">Kraftstoffart</option>
                <option value="1" <?php if(isset($kraftstoff) && $kraftstoff == "1") echo "selected"; ?>>Benzin</option>
                <option value="2" <?php if(isset($kraftstoff) && $kraftstoff == "2") echo "selected"; ?>>Diesel</option>
                <option value="3" <?php if(isset($kraftstoff) && $kraftstoff == "3") echo "selected"; ?>>Elektro</option>
                <option value="4" <?php if(isset($kraftstoff) && $kraftstoff == "4") echo "selected"; ?>>Wasserstoff</option>
              </select>
            </div>
            <div class="col-4 form-label-group">
              <select class="form-control" id="getriebe" name="getriebe">
                <option value="">Getriebe</option>
                <option value="1" <?php if(isset($getriebe) && $getriebe == "1") echo "selected"; ?>>Manuell</option>
                <option value="2" <?php if(isset($getriebe) && $getriebe == "2") echo "selected"; ?>>Automatik</option>
              </select>
            </div>
          </div>
        </fieldset>

        <fieldset class="box my-4">
          <div class="row mx-0 px-0 mb-3">
            <legend style="padding: 0px 0px 0px 17px">Ausstattung</legend>

            <div class="col-4" style="padding-left: 17px">
              <div class="custom-control custom-checkbox mt-3">
                <input type="checkbox" name="alarmanlage" class="custom-control-input" id="alarmanlage" value="true" <?php if (isset($alarmanlage) && $alarmanlage == "true") echo "checked='checked'"; ?>>
                <label class="custom-control-label" for="alarmanlage">Alarmanlage</label>
              </div>
            </div>

            <div class="col-4" style="padding-left: 17px">
              <div class="custom-control custom-checkbox mt-3">
                <input type="checkbox" name="anhaengerkupplung" class="custom-control-input" id="anhaengerkupplung" value="true" <?php if (isset($anhaengerkupplung) && $anhaengerkupplung == "true") echo "checked='checked'"; ?>>
                <label class="custom-control-label" for="anhaengerkupplung">Anhaengerkupplung</label>
              </div>
            </div>

            <div class=" col-4" style="padding-left: 17px">
              <div class="custom-control custom-checkbox mt-3">
                <input type="checkbox" name="bluetooth" class="custom-control-input" id="bluetooth" value="true" <?php if (isset($bluetooth) && $bluetooth == "true") echo "checked='checked'"; ?>>
                <label class="custom-control-label" for="bluetooth">Bluetooth</label>
              </div>
            </div>

            <div class=" col-4" style="padding-left: 17px">
              <div class="custom-control custom-checkbox mt-3">
                <input type="checkbox" name="bordcomputer" class="custom-control-input" id="bordcomputer" value="true" <?php if (isset($bordcomputer) && $bordcomputer == "true") echo "checked='checked'"; ?>>
                <label class="custom-control-label" for="bordcomputer">Bordcomputer</label>
              </div>
            </div>

            <div class=" col-4" style="padding-left: 17px">
              <div class="custom-control custom-checkbox mt-3">
                <input type="checkbox" name="head" class="custom-control-input" id="head" value="true" <?php if (isset($head) && $head == "true") echo "checked='checked'"; ?>>
                <label class="custom-control-label" for="head">Head-Up Display</label>
              </div>
            </div>

            <div class=" col-4" style="padding-left: 17px">
              <div class="custom-control custom-checkbox mt-3">
                <input type="checkbox" name="multifunktionslenkrad" class="custom-control-input" id="multifunktionslenkrad" value="true" <?php if (isset($multifunktionslenkrad) && $multifunktionslenkrad == "true") echo "checked='checked'"; ?>>
                <label class="custom-control-label" for="multifunktionslenkrad">Multifunktionslenkrad</label>
              </div>
            </div>

            <div class=" col-4" style="padding-left: 17px">
              <div class="custom-control custom-checkbox mt-3">
                <input type="checkbox" name="navigationssystem" class="custom-control-input" id="navigationssystem" value="true" <?php if (isset($navigationssystem) && $navigationssystem == "true") echo "checked='checked'"; ?>>
                <label class="custom-control-label" for="navigationssystem">Navigationssystem</label>
              </div>
            </div>

            <div class=" col-4" style="padding-left: 17px">
              <div class="custom-control custom-checkbox mt-3">
                <input type="checkbox" name="regensensor" class="custom-control-input" id="regensensor" value="true" <?php if (isset($regensensor) && $regensensor == "true") echo "checked='checked'"; ?>>
                <label class="custom-control-label" for="regensensor">Regensensor</label>
              </div>
            </div>

            <div class=" col-4" style="padding-left: 17px">
              <div class="custom-control custom-checkbox mt-3">
                <input type="checkbox" name="sitzheizung" class="custom-control-input" id="sitzheizung" value="true" <?php if (isset($sitzheizung) && $sitzheizung == "true") echo "checked='checked'"; ?>>
                <label class="custom-control-label" for="sitzheizung">Sitzheizung</label>
              </div>
            </div>

            <div class=" col-4" style="padding-left: 17px">
              <div class="custom-control custom-checkbox mt-3">
                <input type="checkbox" name="soundsystem" class="custom-control-input" id="soundsystem" value="true" <?php if (isset($soundsystem) && $soundsystem == "true") echo "checked='checked'"; ?>>
                <label class="custom-control-label" for="soundsystem">Soundsystem</label>
              </div>
            </div>

            <div class=" col-4" style="padding-left: 17px">
              <div class="custom-control custom-checkbox mt-3">
                <input type="checkbox" name="standheizung" class="custom-control-input" id="standheizung" value="true" <?php if (isset($standheizung) && $standheizung == "true") echo "checked='checked'"; ?>>
                <label class="custom-control-label" for="standheizung">Standheizung</label>
              </div>
            </div>

            <div class=" col-4" style="padding-left: 17px">
              <div class="custom-control custom-checkbox mt-3">
                <input type="checkbox" name="startStopp" class="custom-control-input" id="startStopp" value="true" <?php if (isset($startStopp) && $startStopp == "true") echo "checked='checked'"; ?>>
                <label class="custom-control-label" for="startStopp">Start/Stopp-Automatik</label>
              </div>
            </div>

          </div>
        </fieldset>
      </div>
    </div>
  </div>

  <?php closeConnection($databaseconnection);?>
  <?php unset($_SESSION['errorEingabe']) ?>

  <footer class="bg-dark fixed-bottom align-center">
    <div class="container text-center my-3 col-6">
      <button class="btn btn-primary btn-block btn-lg btn-login" type="submit" name="button" value="insert">Inserieren</button>
    </div>
  </footer>
</form>
</body>
</html>
