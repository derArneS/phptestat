<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <?php require "../const/head.php" ?>
    <link rel="stylesheet" href="../css/login.css">
  </head>
  <body>
    <?php require "../const/navbar.php" ?>
          <div class="login d-flex align-items-center py-5">
            <div class="container">
              <div class="row">
                <div class="col-md-9 col-lg-8 mx-auto">
                  <h3 class="login-heading mb-4">Welcome back!</h3>
                  <form>
                    <div class="form-label-group">
                      <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
                      <label for="inputEmail">Email address</label>
                    </div>

                    <div class="form-label-group">
                      <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
                      <label for="inputPassword">Password</label>
                    </div>

                    <div class="custom-control custom-checkbox mb-3">
                      <input type="checkbox" class="custom-control-input" id="customCheck1">
                      <label class="custom-control-label" for="customCheck1">Remember password</label>
                    </div>

                    <button class="btn btn-lg btn-primary btn-block btn-login text-uppercase font-weight-bold mb-2" type="submit">Sign in</button>

                      <div class="text-center">
                        <a class="small" href="#">Forgot password?</a>
                      </div>

                    </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </body>
</html>
