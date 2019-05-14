<?php
session_start();
require "../database/database.php";
require "../const/cookie.php";

if (isset($_SESSION['cache']['insert'])) {
  unset($_SESSION['cache']['insert']);
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title></title>
  <?php require "../const/head.php" ?>
  <link rel="stylesheet" href="suche.css">
</head>
<body onload="ajax()" style="padding-bottom: 80px">
  <?php require "../const/navbar.php"; ?>

  <script type="text/javascript">
  function ajax(){
      var marke = $('#marke').val();
        <?php echo ("var modell = ".(isset($_SESSION['cache']['suche']['modell']) && $_SESSION['cache']['suche']['modell'] != ""?$_SESSION['cache']['suche']['modell'].";":"0;")) ?>
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
  $databaseconnection = createConnection();

  if (($statement = $databaseconnection->prepare("SELECT * FROM Marken ORDER BY Name ASC"))
  && ($statement->execute())
  && ($resultset = $statement->get_result())) {
    $rowCount = $resultset->num_rows;
  }

  ?>
  <form action="action.php" method="post">
  <div class="container mt-4">
    <div class="row mx-0 px-0">
      <div class="container col-12 mx-0 px-0">
        <div class="mb-3 mx-auto">

          <a href="reset.php">Suche zurücksetzen</a>
        </div>
        <?php if (isset($_SESSION['errorErgebnis']) && $_SESSION['errorErgebnis']) { ?> <div class="alert alert-danger alert-round" role="alert">Leider keine Inserate gefunden...</div> <?php } ?>

        <fieldset class="box mb-4">
          <div class="row mx-0 px-0">
            <legend style="padding: 0px 0px 0px 17px">Modell</legend>
            <div class="col-6 form-label-group">
              <select class="form-control" id="marke" name="marke" onchange="ajax()">
                <option value="">Beliebig</option>
                <?php
                if($rowCount > 0){
                  while($row = $resultset->fetch_assoc()){
                    echo '<option '.((isset($_SESSION['cache']['suche']['marke']) && $_SESSION['cache']['suche']['marke'] == $row['ID'])?'selected="selected"':' ').'value="'.$row['ID'].'">'.$row['Name'].'</option>';
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
            <legend style="padding: 0px 0px 0px 17px">Daten</legend>
            <div class="col-12">
              <div class="row">
                <div class="col-4 form-label-group">
                  <input type="text" name="inputPreisMin" id="inputPreisMin" class="form-control" placeholder="Preis (min)" value="<?= (isset($_SESSION['cache']['suche']['inputPreisMin'])?$_SESSION['cache']['suche']['inputPreisMin']:null); ?>">
                  <label for="inputPreisMin">Preis (min)</label>
                </div>
                <div class="col-4 form-label-group">
                  <input type="text" name="inputPreisMax" id="inputPreisMax" class="form-control" placeholder="Preis (max)" value="<?= (isset($_SESSION['cache']['suche']['inputPreisMax'])?$_SESSION['cache']['suche']['inputPreisMax']:null); ?>">
                  <label for="inputPreisMax">Preis (max)</label>
                </div>
              </div>
            </div>

            <div class="col-12">
              <div class="row">
                <div class="col-4 form-label-group">
                  <input type="text" name="inputBaujahrMin" id="inputBaujahrMin" class="form-control" placeholder="Baujahr (min)" value="<?= (isset($_SESSION['cache']['suche']['inputBaujahrMin'])?$_SESSION['cache']['suche']['inputBaujahrMin']:null); ?>">
                  <label for="inputBaujahrMin">Baujahr (min)</label>
                </div>
                <div class="col-4 form-label-group">
                  <input type="text" name="inputBaujahrMax" id="inputBaujahrMax" class="form-control" placeholder="Baujahr (max)" value="<?= (isset($_SESSION['cache']['suche']['inputBaujahrMax'])?$_SESSION['cache']['suche']['inputBaujahrMax']:null); ?>">
                  <label for="inputBaujahrMax">Baujahr (max)</label>
                </div>
              </div>
            </div>

            <div class="col-12">
              <div class="row">
                <div class="col-4 form-label-group">
                  <input type="text" name="inputKmMin" id="inputKmMin" class="form-control" placeholder="Kilometerstand (min)" value="<?= (isset($_SESSION['cache']['suche']['inputKmMin'])?$_SESSION['cache']['suche']['inputKmMin']:null); ?>">
                  <label for="inputKmMin">Kilometerstand (min)</label>
                </div>
                <div class="col-4 form-label-group">
                  <input type="text" name="inputKmMax" id="inputKmMax" class="form-control" placeholder="Kilometerstand (max)" value="<?= (isset($_SESSION['cache']['suche']['inputKmMax'])?$_SESSION['cache']['suche']['inputKmMax']:null); ?>">
                  <label for="inputKmMax">Kilometerstand (max)</label>
                </div>
              </div>
            </div>

            <div class="col-12">
              <div class="row">
                <div class="col-4 form-label-group">
                  <input type="text" name="inputLeistungMin" id="inputLeistungMin" class="form-control" placeholder="Leistung (min)" value="<?= (isset($_SESSION['cache']['suche']['inputLeistungMin'])?$_SESSION['cache']['suche']['inputLeistungMin']:null); ?>">
                  <label for="inputLeistungMin">Leistung (min)</label>
                </div>
                <div class="col-4 form-label-group">
                  <input type="text" name="inputLeistungMax" id="inputLeistungMax" class="form-control" placeholder="Leistung (max)" value="<?= (isset($_SESSION['cache']['suche']['inputLeistungMax'])?$_SESSION['cache']['suche']['inputLeistungMax']:null); ?>">
                  <label for="inputLeistungMax">Leistung (max)</label>
                </div>
              </div>
            </div>

            <div class="col-12">
              <div class="row">
                <div class="col-4 form-label-group">
                  <select class="form-control" id="kraftstoff" name="kraftstoff">
                    <option value="">Kraftstoffart</option>
                    <option value="1" <?php if(isset($_SESSION['cache']['suche']['kraftstoff']) && $_SESSION['cache']['suche']['kraftstoff'] == "1") echo "selected"; ?>>Benzin</option>
                    <option value="2" <?php if(isset($_SESSION['cache']['suche']['kraftstoff']) && $_SESSION['cache']['suche']['kraftstoff'] == "2") echo "selected"; ?>>Diesel</option>
                    <option value="3" <?php if(isset($_SESSION['cache']['suche']['kraftstoff']) && $_SESSION['cache']['suche']['kraftstoff'] == "3") echo "selected"; ?>>Elektro</option>
                    <option value="4" <?php if(isset($_SESSION['cache']['suche']['kraftstoff']) && $_SESSION['cache']['suche']['kraftstoff'] == "4") echo "selected"; ?>>Wasserstoff</option>
                  </select>
                </div>
                <div class="col-4 form-label-group">
                  <select class="form-control" id="getriebe" name="getriebe">
                    <option value="">Getriebe</option>
                    <option value="1" <?php if(isset($_SESSION['cache']['suche']['getriebe']) && $_SESSION['cache']['suche']['getriebe'] == "1") echo "selected"; ?>>Manuell</option>
                    <option value="2" <?php if(isset($_SESSION['cache']['suche']['getriebe']) && $_SESSION['cache']['suche']['getriebe'] == "2") echo "selected"; ?>>Automatik</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </fieldset>

        <fieldset class="box my-4">
          <div class="row mx-0 px-0 mb-3">
            <legend style="padding: 0px 0px 0px 17px">Ausstattung</legend>

            <div class="col-4" style="padding-left: 17px">
              <div class="custom-control custom-checkbox mt-3">
                <input type="checkbox" name="alarmanlage" class="custom-control-input" id="alarmanlage" value="true" <?php if (isset($_SESSION['cache']['suche']['alarmanlage']) && $_SESSION['cache']['suche']['alarmanlage'] == "true") echo "checked='checked'"; ?>>
                <label class="custom-control-label" for="alarmanlage">Alarmanlage</label>
              </div>
            </div>

            <div class="col-4" style="padding-left: 17px">
              <div class="custom-control custom-checkbox mt-3">
                <input type="checkbox" name="anhaengerkupplung" class="custom-control-input" id="anhaengerkupplung" value="true" <?php if (isset($_SESSION['cache']['suche']['anhaengerkupplung']) && $_SESSION['cache']['suche']['anhaengerkupplung'] == "true") echo "checked='checked'"; ?>>
                <label class="custom-control-label" for="anhaengerkupplung">Anhaengerkupplung</label>
              </div>
            </div>

            <div class=" col-4" style="padding-left: 17px">
              <div class="custom-control custom-checkbox mt-3">
                <input type="checkbox" name="bluetooth" class="custom-control-input" id="bluetooth" value="true" <?php if (isset($_SESSION['cache']['suche']['bluetooth']) && $_SESSION['cache']['suche']['bluetooth'] == "true") echo "checked='checked'"; ?>>
                <label class="custom-control-label" for="bluetooth">Bluetooth</label>
              </div>
            </div>

            <div class=" col-4" style="padding-left: 17px">
              <div class="custom-control custom-checkbox mt-3">
                <input type="checkbox" name="bordcomputer" class="custom-control-input" id="bordcomputer" value="true" <?php if (isset($_SESSION['cache']['suche']['bordcomputer']) && $_SESSION['cache']['suche']['bordcomputer'] == "true") echo "checked='checked'"; ?>>
                <label class="custom-control-label" for="bordcomputer">Bordcomputer</label>
              </div>
            </div>

            <div class=" col-4" style="padding-left: 17px">
              <div class="custom-control custom-checkbox mt-3">
                <input type="checkbox" name="head" class="custom-control-input" id="head" value="true" <?php if (isset($_SESSION['cache']['suche']['head']) && $_SESSION['cache']['suche']['head'] == "true") echo "checked='checked'"; ?>>
                <label class="custom-control-label" for="head">Head-Up Display</label>
              </div>
            </div>

            <div class=" col-4" style="padding-left: 17px">
              <div class="custom-control custom-checkbox mt-3">
                <input type="checkbox" name="multifunktionslenkrad" class="custom-control-input" id="multifunktionslenkrad" value="true" <?php if (isset($_SESSION['cache']['suche']['multifunktionslenkrad']) && $_SESSION['cache']['suche']['multifunktionslenkrad'] == "true") echo "checked='checked'"; ?>>
                <label class="custom-control-label" for="multifunktionslenkrad">Multifunktionslenkrad</label>
              </div>
            </div>

            <div class=" col-4" style="padding-left: 17px">
              <div class="custom-control custom-checkbox mt-3">
                <input type="checkbox" name="navigationssystem" class="custom-control-input" id="navigationssystem" value="true" <?php if (isset($_SESSION['cache']['suche']['navigationssystem']) && $_SESSION['cache']['suche']['navigationssystem'] == "true") echo "checked='checked'"; ?>>
                <label class="custom-control-label" for="navigationssystem">Navigationssystem</label>
              </div>
            </div>

            <div class=" col-4" style="padding-left: 17px">
              <div class="custom-control custom-checkbox mt-3">
                <input type="checkbox" name="regensensor" class="custom-control-input" id="regensensor" value="true" <?php if (isset($_SESSION['cache']['suche']['regensensor']) && $_SESSION['cache']['suche']['regensensor'] == "true") echo "checked='checked'"; ?>>
                <label class="custom-control-label" for="regensensor">Regensensor</label>
              </div>
            </div>

            <div class=" col-4" style="padding-left: 17px">
              <div class="custom-control custom-checkbox mt-3">
                <input type="checkbox" name="sitzheizung" class="custom-control-input" id="sitzheizung" value="true" <?php if (isset($_SESSION['cache']['suche']['sitzheizung']) && $_SESSION['cache']['suche']['sitzheizung'] == "true") echo "checked='checked'"; ?>>
                <label class="custom-control-label" for="sitzheizung">Sitzheizung</label>
              </div>
            </div>

            <div class=" col-4" style="padding-left: 17px">
              <div class="custom-control custom-checkbox mt-3">
                <input type="checkbox" name="soundsystem" class="custom-control-input" id="soundsystem" value="true" <?php if (isset($_SESSION['cache']['suche']['soundsystem']) && $_SESSION['cache']['suche']['soundsystem'] == "true") echo "checked='checked'"; ?>>
                <label class="custom-control-label" for="soundsystem">Soundsystem</label>
              </div>
            </div>

            <div class=" col-4" style="padding-left: 17px">
              <div class="custom-control custom-checkbox mt-3">
                <input type="checkbox" name="standheizung" class="custom-control-input" id="standheizung" value="true" <?php if (isset($_SESSION['cache']['suche']['standheizung']) && $_SESSION['cache']['suche']['standheizung'] == "true") echo "checked='checked'"; ?>>
                <label class="custom-control-label" for="standheizung">Standheizung</label>
              </div>
            </div>

            <div class=" col-4" style="padding-left: 17px">
              <div class="custom-control custom-checkbox mt-3">
                <input type="checkbox" name="startStopp" class="custom-control-input" id="startStopp" value="true" <?php if (isset($_SESSION['cache']['suche']['startStopp']) && $_SESSION['cache']['suche']['startStopp'] == "true") echo "checked='checked'"; ?>>
                <label class="custom-control-label" for="startStopp">Start/Stopp-Automatik</label>
              </div>
            </div>

          </div>
        </fieldset>
      </div>
    </div>
  </div>

  <?php closeConnection($databaseconnection);?>
  <?php unset($_SESSION['errorErgebnis']) ?>

  <footer class="bg-dark fixed-bottom align-center">
    <div class="container text-center my-3 col-6">
      <button class="btn btn-primary btn-block btn-lg btn-login" type="submit" name="button" value="suche">Suchen</button>
    </div>
  </footer>
  </form>
</body>
</html>
