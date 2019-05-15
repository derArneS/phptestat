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
                <h3 class="login-heading mb-4">Welcome back!</h3>
                <form method="post" action='action.php'>
                  <?php if (isset($_SESSION['errorPrivate']) && $_SESSION['errorPrivate']) { ?> <div class="alert alert-danger alert-round" role="alert">Bitte erst anmelden!</div> <?php } ?>
                  <?php if (isset($_SESSION['errorEmailBenutzer']) && $_SESSION['errorEmailBenutzer']) { ?> <div class="alert alert-danger alert-round" role="alert">Benutzername oder Email nicht bekannt!</div> <?php } ?>
                  <div class="form-label-group">
                    <input type="text" name="inputEmailBenutzer" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
                    <label for="inputEmail">Email address</label>
                  </div>

                  <?php if (isset($_SESSION['errorPasswort']) && $_SESSION['errorPasswort']) { ?> <div class="alert alert-danger  alert-round" role="alert">Passwort falsch!</div> <?php } ?>
                  <div class="form-label-group">
                    <input type="password" name="inputPassword" id="inputPassword" class="form-control" placeholder="Password" required>
                    <label for="inputPassword">Password</label>
                  </div>

                  <div class="custom-control custom-checkbox mb-3">
                    <input type="checkbox" name="inputRememberPassword" class="custom-control-input" id="customCheck1" value="cookie">
                    <label class="custom-control-label" for="customCheck1">Remember password</label>
                  </div>

                  <button class="btn btn-lg btn-primary btn-block btn-login text-uppercase font-weight-bold mb-2" type="submit" value="Submit">Sign in</button>

                  <!--
                    <div class="text-center">
                      <a class="small" href="forgotpassword.php">Forgot password?</a>
                    </div>
                  -->
                  </form>

                  <?php //print_r($_COOKIE); ?>
                  <?php //print_r($_SESSION); ?>

                  <?php
                  unset($_SESSION['errorEmailBenutzer']);
                  unset($_SESSION['errorPasswort']);
                  unset($_SESSION['errorPrivate']);
                  ?>
                </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
  </html>
