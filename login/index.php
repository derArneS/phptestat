<?php
  session_start();

require '../database/database.php';

$databaseconnection = createConnection();

  //Wenn der Benutzer in der Session gesetzt ist, wird die Login-Seite nicht mehr angezeigt
  if (isset($_SESSION['benutzername'])) {
    header("Location: ../welcome");
    die();
  }

  //Wird der Link über die Get-Methode über ein Redirect-Link aufgerufen wird dieser in die Session geschrieben
  if (isset($_GET['red'])) {
    $_SESSION['redirect'] = $_GET['red'];
  }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Login</title>
  <?php require "../const/head.php" ?>
  <link rel="stylesheet" href="login.css">
</head>
<body>
  <?php require "../const/navbar.php" ?>

  <div class="container-fluid">
    <div class="row no-gutter">
      <div class="d-none d-lg-flex col-6 bg-image"></div>
      <div class="col-12 col-lg-6">
        <div class="login d-flex align-items-center py-5">
          <div class="container">
            <div class="row row-stretch">
              <div class="col-md-9 col-lg-9 col-xl-8 mx-auto">
                <h3 class="login-heading mb-4">Willkommen zurück!</h3>
                <!--Form die auf action.php verweist -->
                <form method="post" action='action.php'>
                  <?php if (isset($_SESSION['errorPrivate']) && $_SESSION['errorPrivate']) { ?> <div class="alert alert-danger alert-round" role="alert">Bitte erst anmelden!</div> <?php } ?>
                  <?php if (isset($_SESSION['errorEmailBenutzer']) && $_SESSION['errorEmailBenutzer']) { ?> <div class="alert alert-danger alert-round" role="alert">Benutzername oder Email nicht bekannt!</div> <?php } ?>
                  <div class="form-label-group">
                    <!--Inputfeld für die Eingabe des Benutzernamens oder der E-Mail -->
                    <input type="text" name="inputEmailBenutzer" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
                    <label for="inputEmail">Email oder Benutzername</label>
                  </div>

                  <?php if (isset($_SESSION['errorPasswort']) && $_SESSION['errorPasswort']) { ?> <div class="alert alert-danger  alert-round" role="alert">Passwort falsch!</div> <?php } ?>
                  <div class="form-label-group">
                    <!--Inputfeld für die Eingabe des Passworts -->
                    <input type="password" name="inputPassword" id="inputPassword" class="form-control" placeholder="Password" required>
                    <label for="inputPassword">Passwort</label>
                  </div>

                  <div class="custom-control custom-checkbox mb-3">
                    <!--Checkbox für die Speicherung des Passwort -->
                    <input type="checkbox" name="inputRememberPassword" class="custom-control-input" id="customCheck1" value="cookie">
                    <label class="custom-control-label" for="customCheck1">Passwort speichern</label>
                  </div>

                  <!--Button zum einloggen, Inhalte der Form werden an action.php übergeben -->
                  <button class="btn btn-lg btn-primary btn-block btn-login text-uppercase font-weight-bold mb-2" type="submit" value="Submit">Login</button>

                  <div class="row">
                    <div class="col-6 text-center">
                        <a class="small" href="#vergessen" data-toggle="modal" data-target="#vergessen">Passwort vergessen?</a>
                    </div>
                    <div class="col-6 text-center">
                        <a class="small" href="../register">Noch kein Konto?</a>
                    </div>
                  </div>
                  </form>

                  <div class="modal fade" id="vergessen" tabindex="-1" role="dialog" aria-labelledby="vergessenTitel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="vergessenTitel">Passwort vergessen?</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form class="" action="passwortvergessen.php" method="post">
                          <div class="modal-body">
                            <input type="text" name="inputEmailvergessen" id="inputEmailvergessen" class="form-control" placeholder="Email" required>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Abbrechen</button>
                            <button class="btn btn-primary" type="submit" name="vergessenbtn" value="vergessen">Senden</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>


                  <?php
                  unset($_SESSION['errorEmailBenutzer']);
                  unset($_SESSION['errorPasswort']);
                  unset($_SESSION['errorPrivate']);
                  closeConnection($databaseconnection);
                  ?>
                </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php require "../const/footer.php" ?>
  </body>
  </html>
