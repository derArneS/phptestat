<?php
session_start();
require "../const/cookie.php"; cookie();
require "../const/private.php";
require "../database/database.php";

if (!isPrivate(true)) {
  $_SESSION['errorPrivate'] = true;
  $_SESSION['redirect'] = "/profil";
  header('Location: ../login');
  die();
}
?>

<?php
$databaseconnection = createConnection();
if (!($statement = $databaseconnection->prepare("SELECT * FROM Benutzer WHERE Benutzername = ?"))
|| !($statement->bind_param('s', $_SESSION['benutzername']))
|| !($statement->execute())
|| !($resultset = $statement->get_result())) {

}
closeConnection($databaseconnection);
$row = $resultset->fetch_assoc();

?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <?php require "../const/head.php" ?>
    <link rel="stylesheet" href="profil.css">
  </head>
  <body>
    <?php require '../const/navbar.php'; ?>

<div class="container col-11 mt-5 box">
    <nav>
    <div class="nav nav-tabs nav-justified" id="nav-tab" role="tablist" fill>
      <a class="nav-item nav-link" id="nav-angebote-tab" data-toggle="tab" href="#nav-angebote" role="tab" aria-controls="nav-home" aria-selected="true">Eigene Angebote</a>
      <a class="nav-item nav-link" id="nav-favoriten-tab" data-toggle="tab" href="#nav-favoriten" role="tab" aria-controls="nav-profile" aria-selected="false">Favoriten</a>
      <a class="nav-item nav-link active" id="nav-daten-tab" data-toggle="tab" href="#nav-daten" role="tab" aria-controls="nav-contact" aria-selected="false">Persönliche Daten</a>
    </div>
  </nav>
  <div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade " id="nav-angebote" role="tabpanel" aria-labelledby="nav-home-tab">
      Hallo :-)
    </div>
    <div class="tab-pane fade" id="nav-favoriten" role="tabpanel" aria-labelledby="nav-profile-tab">
      ...
    </div>
    <div class="tab-pane fade show active" id="nav-daten" role="tabpanel" aria-labelledby="nav-contact-tab">
      <div class="row">
        <div class="form-label-group col-6">
          <input disabled class="col-12 form-control" type="text" id="benutzername" name="benutzername" value="<?=$row['Benutzername'] ?>">
          <label for="benutzername">Benutzername</label>
        </div>
        <div class="form-label-group col-6 text-center">
          <button class="btn btn-primary btn-login col-4" type="submit" name="insert">Ändern</button>
        </div>
      </div>
    </div>
  </div>
</div>

  </body>
</html>
