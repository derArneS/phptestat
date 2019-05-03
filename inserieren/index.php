<?php
session_start();
require "../database/database.php";
require "../const/cookie.php"; cookie();
require "../const/private.php";

if (isset($_SESSION['cache'])) {
  $marke = $_SESSION['cache']['insert']['marke'];
  $modell = $_SESSION['cache']['insert']['modell'];
  $km = $_SESSION['cache']['insert']['inputKM'];

  unset($_SESSION['cache']);
}

if (!isPrivate(true)) {
  $_SESSION['errorPrivate'] = true;
  $_SESSION['redirect'] = "/inserieren";
  header('Location: ../login');
  die();
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title></title>
  <?php require "../const/head.php" ?>
  <link rel="stylesheet" href="insert.css">
</head>
<body onload="ajax()">
  <?php require "../const/navbar.php"; ?>

  <?php echo ("var modellID = ".(isset($modell)?$modell.";":"0;")) ?>

  <script type="text/javascript">
  function ajax(){
      var marke = $('#marke').val();
        <?php echo ("var modell = ".(isset($modell)?$modell.";":"0;")) ?>
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

  if (($statement = $databaseconnection->prepare("SELECT * FROM Marken ORDER BY Marke ASC"))
  && ($statement->execute())
  && ($resultset = $statement->get_result())) {
    $rowCount = $resultset->num_rows;
  }

  ?>
  <form action="action.php" method="post" enctype="multipart/form-data">
  <div class="container col-8 mt-5">
    <div class="row mx-0 px-0 pt-5">
      <div class="container col-12 mx-0 px-0">
        <fieldset class="box mb-4">
          <div class="row mx-0 px-0">
            <legend style="padding: 0px 0px 0px 17px">Modell</legend>
            <div class="col-6 form-label-group">
              <select class="form-control" id="marke" name="marke" onchange="ajax()">
                <option value="">Beliebig</option>
                <?php
                if($rowCount > 0){
                  while($row = $resultset->fetch_assoc()){
                    echo '<option '.((isset($marke) && $marke == $row['ID'])?'selected="selected"':' ').'value="'.$row['ID'].'">'.$row['Marke'].'</option>';
                  }
                }else{
                  echo '<option value="">Keine Marken</option>';
                }
                ?>
              </select>
            </div>
            <div class="col-6 form-label-group">
              <select class="form-control" id="modell" name="modell">
                <option value="0">Modell</option>
              </select>
            </div>
          </div>
        </fieldset>

        <fieldset class="box my-4">
          <div class="row mx-0 px-0 my-3">
            <legend style="padding: 0px 0px 0px 17px">Bild</legend>
            <div class="col-6">
              <?php print_r($_FILES); ?>
            </div>
            <div class="col-6 form-label-group">
                <input name="datei" type="file">
                <input type="submit" class="btn btn-lg btn-primary" name="file" value="file" />
            </div>
          </div>
        </fieldset>

        <fieldset class="box my-4">
          <div class="row mx-0 px-0 my-3">
            <legend style="padding: 0px 0px 0px 17px">Daten</legend>
            <div class="col-4 form-label-group">
              <input type="text" name="inputKM" id="inputKM" class="form-control" placeholder="Kilometerstand" value="<?= (isset($km)?$km:null); ?>" required>
              <label for="inputKM">Kilometerstand</label>
            </div>
            <div class="col-4 form-label-group">
              <input type="text" name="inputtest" id="inputtest" class="form-control" placeholder="test" value="test" required>
              <label for="inputtest">test</label>
            </div>
          </div>
        </fieldset>
      </div>
    </div>
  </div>

  <br>
  <?php print_r($_SESSION) ?>

  <footer class="bg-dark fixed-bottom align-center">
    <div class="container text-center my-3 col-6">
      <button class="btn btn-primary btn-block btn-lg btn-login" type="submit" name="insert">Inserieren</button>
    </div>
  </footer>
</form>
</body>
</html>
