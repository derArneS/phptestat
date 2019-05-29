<?php
  session_start();

  require '../database/database.php';

  $databaseconnection = createConnection();

  //Falls ein Benutzer in der Session gespeichert ist, wird der Benutzer direkt auf die Startseite verwiesen
  if (isset($_SESSION['benutzername'])) {
    header("Location: ../welcome");
    die();
  }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Registrieren</title>
  <?php require "../const/head.php" ?>
  <link rel="stylesheet" href="../login/login.css">
</head>
<body>
  <?php require "../const/navbar.php" ?>
  <?php if (isset($_SESSION['errorRegister']) && $_SESSION['errorRegister']) { ?> <div class="alert alert-danger  alert-round" role="alert">errorRegister</div> <?php } ?>
  <?php if (isset($_SESSION['errorBenutzer']) && $_SESSION['errorBenutzer']) { ?> <div class="alert alert-danger  alert-round" role="alert">errorBenutzer</div> <?php } ?>
  <div class="login d-flex align-items-center py-5">
    <div class="container">
      <div class="row">
        <div class="col-md-9 col-lg-8 mx-auto">
          <h3 class="login-heading mb-4">Willkommen!</h3>
          <!--Form, die die eingegeben Daten bei der Regristrierung an die register/action.php sendet -->
          <form method="post" action="action.php">
            <!--Einblendung der Fehlermeldung wenn der Benutzername schon vergeben ist -->
            <?php if (isset($_SESSION['errorBenutzername']) && $_SESSION['errorBenutzername']) { ?> <div class="alert alert-danger alert-round" role="alert">Benutzername schon vergeben: Bitte einen anderen auswählen oder einloggen.</div> <?php } ?>
            <div class="form-label-group">
              <!--Inputfeld für den Benutzernamen -->
              <input type="text" name="inputBenutzername" id="inputBenutzername" class="form-control" placeholder="Benutzername" required autofocus>
              <label for="inputBenutzername">Benutzername</label>
            </div>
            <!--Einblendung der Fehlermeldung wenn die E-Mail schon vergeben ist -->
            <?php if (isset($_SESSION['errorEmail']) && $_SESSION['errorEmail']) { ?> <div class="alert alert-danger  alert-round" role="alert">Email wurde schon benutzt: Bitte eine andere auswählen oder einloggen.</div> <?php } ?>
            <div class="form-label-group">
              <!--Inputfeld für die E-Mail Adresse -->
              <input type="email" name="inputEmail"  id="inputEmail" class="form-control" placeholder="E-mail Adresse" required>
              <label for="inputEmail">E-mail Addresse</label>
            </div>

            <?php if (isset($_SESSION['errorPasswort']) && $_SESSION['errorPasswort']) { ?> <div class="alert alert-danger  alert-round" role="alert">Passwörter stimmen nicht über ein.</div> <?php } ?>
            <div class="form-label-group">
              <!--Inputfeld für das Passwort -->
              <input type="password" name="inputPassword"  id="inputPassword" class="form-control" placeholder="Passwort" required>
              <label for="inputPassword">Passwort</label>
            </div>

            <div class="form-label-group">
              <!--Inputfeld für die Wiederholung des Passwortes -->
              <input type="password" name="inputPassword2"  id="inputPassword2" class="form-control" placeholder="Passwort wiederholen" required>
              <label for="inputPassword2">Passwort wiederholen</label>
            </div>

            <div class="custom-control custom-checkbox mb-3">
              <!--Checkbox für das Abonnieren des Newsletters -->
              <input type="checkbox" name="customCheck1"  class="custom-control-input" id="customCheck1">
              <label class="custom-control-label" for="customCheck1">Newsletter abonnieren</label>
            </div>

            <!--Button für das Abschicken der Daten an die action.php-->
            <button class="btn btn-lg btn-primary btn-block btn-login text-uppercase font-weight-bold mb-2" type="submit">Anmelden</button>

            <?php
            //Unset der Fehlermeldungen die entstehen können, durch z.B. schon Verfügbaren Benutzernamen, etc.
            unset($_SESSION['errorEmail']);
            unset($_SESSION['errorBenutzername']);
            unset($_SESSION['errorPasswort']);
            unset($_SESSION['errorBenutzer']);
            unset($_SESSION['errorRegister']);

            closeConnection($databaseconnection);
            ?>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
