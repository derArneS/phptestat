<?php
session_start();

require '../database/database.php';

$databaseconnection = createConnection();

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <?php require "../const/head.php" ?>
    <link rel="stylesheet" href="login.css">

    <meta charset="utf-8">
    <title>Passwort zurücksetzen</title>
  </head>
  <body>
    <?php require "../const/navbar.php" ?>
    <div class="login d-flex align-items-center py-5">
      <div class="container">
        <div class="row">
          <div class="col-md-9 col-lg-8 mx-auto">
            <h3 class="login-heading mb-4">Geben Sie ihr neues Passwort ein</h3>
            <form method="post" action="vergessenAction.php">

              <div class="form-label-group">
                <input type="password" name="inputPassword"  id="inputPassword" class="form-control" placeholder="Passwort" required>
                <label for="inputPassword">Passwort</label>
              </div>

              <div class="form-label-group">
                <input type="password" name="inputPassword2"  id="inputPassword2" class="form-control" placeholder="Passwort wiederholen" required>
                <label for="inputPassword2">Passwort wiederholen</label>
              </div>

              <input type="hidden" name="email" value="<?= $_GET['email'] ?>">
              <input type="hidden" name="pwd" value="<?= $_GET['link'] ?>">

              <button class="btn btn-lg btn-primary btn-block btn-login text-uppercase font-weight-bold mb-2" type="submit">Anmelden</button>

              <?php
              closeConnection($databaseconnection);
              ?>
            </div>
          </form>
        </div>
      </div>
    </div>
    <?php require "../const/footer.php" ?>
  </body>
</html>
