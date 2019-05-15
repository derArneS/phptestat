<?php
  session_start();

  if (isset($_SESSION['benutzername'])) {
    header("Location: ../welcome");
    die();
  }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title></title>
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
          <form method="post" action="action.php">
            <?php if (isset($_SESSION['errorBenutzername']) && $_SESSION['errorBenutzername']) { ?> <div class="alert alert-danger alert-round" role="alert">Benutzername schon vergeben: Bitte einen anderen auswählen oder einloggen.</div> <?php } ?>
            <div class="form-label-group">
              <input type="text" name="inputBenutzername" id="inputBenutzername" class="form-control" placeholder="Benutzername" required autofocus>
              <label for="inputBenutzername">Benutzername</label>
            </div>
            <?php if (isset($_SESSION['errorEmail']) && $_SESSION['errorEmail']) { ?> <div class="alert alert-danger  alert-round" role="alert">Email wurde schon benutzt: Bitte eine andere auswählen oder einloggen.</div> <?php } ?>
            <div class="form-label-group">
              <input type="email" name="inputEmail"  id="inputEmail" class="form-control" placeholder="E-mail Adresse" required>
              <label for="inputEmail">E-mail Addresse</label>
            </div>

            <?php if (isset($_SESSION['errorPasswort']) && $_SESSION['errorPasswort']) { ?> <div class="alert alert-danger  alert-round" role="alert">Passwörter stimmen nicht über ein.</div> <?php } ?>
            <div class="form-label-group">
              <input type="password" name="inputPassword"  id="inputPassword" class="form-control" placeholder="Passwort" required>
              <label for="inputPassword">Passwort</label>
            </div>

            <div class="form-label-group">
              <input type="password" name="inputPassword2"  id="inputPassword2" class="form-control" placeholder="Passwort wiederholen" required>
              <label for="inputPassword2">Passwort wiederholen</label>
            </div>

            <div class="custom-control custom-checkbox mb-3">
              <input type="checkbox" name="customCheck1"  class="custom-control-input" id="customCheck1">
              <label class="custom-control-label" for="customCheck1">Newsletter abonnieren</label>
            </div>

            <button class="btn btn-lg btn-primary btn-block btn-login text-uppercase font-weight-bold mb-2" type="submit">Anmelden</button>

            <?php
            unset($_SESSION['errorEmail']);
            unset($_SESSION['errorBenutzername']);
            unset($_SESSION['errorPasswort']);
            unset($_SESSION['errorBenutzer']);
            unset($_SESSION['errorRegister']);
            ?>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
