<?php
session_start();
require "../database/database.php";
require "../const/cookie.php"; cookie();
require "../const/private.php";

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
<body>
  <?php require "../const/navbar.php"; ?>

  <script type="text/javascript">
  $(document).ready(function(){
    $('.marke').on('change',function(){
      var markeID = $(this).val();
      if(markeID){
        $.ajax({
          type:'POST',
          url:'ajaxData.php',
          data:'markeID='+markeID,
          success:function(html){
            $('#modell').html(html);
          }
        });
      }else{
        $('#modell').html('<option value="">test</option>');
      }
    });
  });


  </script>

  <?php
  $databaseconnection = createConnection();

  if (($statement = $databaseconnection->prepare("SELECT * FROM Marken ORDER BY Marke ASC"))
  && ($statement->execute())
  && ($resultset = $statement->get_result())) {
    $rowCount = $resultset->num_rows;
  }

  ?>

  <div class="container col-8 mt-5">
    <div class="row row-stretch mx-0 px-0 pt-5">
      <form class="col-12 mx-0 px-0" action="#" method="post">
        <fieldset class="box">
          <div class="row mx-0 px-0">
            <legend style="padding: 0px 0px 0px 17px">Informationen</legend>
            <div class="col-4 form-label-group">
              <select class="form-control" id="marke" name="marke">
                <option value="">Beliebig</option>
                <?php
                if($rowCount > 0){
                  while($row = $resultset->fetch_assoc()){
                    echo '<option value="'.$row['ID'].'">'.$row['Marke'].'</option>';
                  }
                }else{
                  echo '<option value="">Country not available</option>';
                }
                ?>
              </select>
            </div>
            <div class="col-4 form-label-group">
              <select class="form-control" id="modell" name="modell">
                <option value="">Modell</option>
              </select>
            </div>
            <div class="col-4 form-label-group">
              <input type="text" name="inputKM" id="inputKM" class="form-control" placeholder="Kilometerstand" required>
              <label for="inputKM">Kilometerstand</label>
            </div>
          </div>
        </fieldset>
      </form>
    </div>
  </div>


  <footer class="bg-dark fixed-bottom align-center">
    <div class="container text-center my-3 col-6">
      <button class="btn btn-primary btn-block btn-lg btn-login" type="submit" name="button">Inserieren</button>
    </div>
  </footer>
</body>
</html>
