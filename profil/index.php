<?php
session_start();
require "../database/database.php";
require "../const/cookie.php";
require "../const/private.php"; isPrivate(true, "/profil");

?>

<?php
$databaseconnection = createConnection();
if (!($statement = $databaseconnection->prepare("SELECT * FROM Benutzer WHERE Benutzername = ?"))
|| !($statement->bind_param('s', $_SESSION['benutzername']))
|| !($statement->execute())
|| !($resultset = $statement->get_result())) {

}
$row = $resultset->fetch_assoc();

if (!($statement = $databaseconnection->prepare("SELECT * FROM Adressen WHERE ID=?"))
|| !($statement->bind_param('i', $row['Adress_ID']))
|| !($statement->execute())
|| !($resultset = $statement->get_result())) {

}
$adressrow = $resultset->fetch_assoc();

closeConnection($databaseconnection);
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

<!-- Tableiste mit drei Tabs -->
    <nav>
      <div class="nav nav-tabs nav-justified" id="nav-tab" role="tablist" fill>
        <a class="nav-item nav-link active" id="nav-angebote-tab" data-toggle="tab" href="#nav-angebote" role="tab" aria-controls="nav-home" aria-selected="true">Eigene Angebote</a>
        <a class="nav-item nav-link" id="nav-favoriten-tab" data-toggle="tab" href="#nav-favoriten" role="tab" aria-controls="nav-profile" aria-selected="false">Favoriten</a>
        <a class="nav-item nav-link" id="nav-daten-tab" data-toggle="tab" href="#nav-daten" role="tab" aria-controls="nav-contact" aria-selected="false">Persönliche Daten</a>
      </div>
    </nav>


    <div class="tab-content" id="nav-tabContent">

<!-- Tab - Eigene Angebote -->
      <div class="tab-pane fade show active col-12 mt-5 box" id="nav-angebote" role="tabpanel" aria-labelledby="nav-home-tab">

      </div>



<!-- Tab - Favoriten -->
      <div class="tab-pane fade" id="nav-favoriten" role="tabpanel" aria-labelledby="nav-profile-tab">
        Test
      </div>


<!-- Tab - Persönliche Daten -->
      <div class="tab-pane fade col-12 mt-5 box" id="nav-daten" role="tabpanel" aria-labelledby="nav-contact-tab">
        <div class="container col-12 mt-5 box">
          <?php if (isset($_SESSION['errorBenutzername']) && $_SESSION['errorBenutzername']) { ?> <div class="alert alert-danger alert-round text-center" role="alert">Der angegebene Benutzername ist leider schon vorhanden. </div> <?php } ?>
          <?php if (isset($_SESSION['test']) && $_SESSION['test']) { ?> <div class="alert alert-danger alert-round text-center" role="alert">test</div> <?php } ?>
          <?php if (isset($_SESSION['errorPlz']) && $_SESSION['errorPlz']) { ?> <div class="alert alert-danger alert-round text-center" role="alert">Fehlerhafte Eingabe. Bitte die Postleitzahl erneut eingeben.</div> <?php } ?>


          <div class="row">

            <!-- Profil - Benutzername -->
            <div class="input-group mb-3 ml-auto col-6">
              <div class="input-group-prepend">
                <span class="input-group-addon" id="inputGroup-sizing-default">Benutzername</span>
              </div>
              <input disabled style="background-color:white" type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" name="benutzername" id="benutzername" value="<?=$row['Benutzername'] ?>">
            </div>

            <div class="text-center mr-auto">
              <button type="buttom" class="btn btn-primary mb-2" data-toggle="modal" data-target="#benutzernameModal">Ändern</button>
            </div>

            <div class="modal fade" id="benutzernameModal" tabindex="-1" role="dialog" aria-labelledby="benutzernameModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="benutzernameModalLabel">Geben Sie Ihren neuen Benutzernamen ein</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form method="post" action="action.php">
                      <div class="form-group">
                        <label for="benutzername-neu" class="col-form-label">Neuer Benutzername</label>
                        <input type="text" class="form-control" name="benutzername-neu" id="benutzername-neu">
                      </div>
                      <div class="form-group">
                        <label for="benutzername-bestätigen" class="col-form-label">Benutzername bestätigen</label>
                        <input type="text" class="form-control" name="benutzername-bestätigen" id="benutzername-bestätigen">
                      </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Abbrechen</button>
                    <button type="submit" name="button" class="btn btn-primary" value="insert">Bestätigen</button>
                  </div>
                  </form>
                </div>
              </div>
            </div>


            <!-- Profil - Vorname -->
            <div class="input-group mb-3 ml-auto col-6">
              <div class="input-group-prepend">
                <span class="input-group-addon" id="inputGroup-sizing-default">Vorname</span>
              </div>
              <input disabled style="background-color:white" type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" name="vorname" id="vorname" value="<?=$row['Vorname'] ?>">
            </div>

            <div class="text-center mr-auto">
              <button type="submit" class="btn btn-primary mb-2" data-toggle="modal" data-target="#vornameModal">Ändern</button>
            </div>

            <div class="modal fade" id="vornameModal" tabindex="-1" role="dialog" aria-labelledby="vornameModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="vornameModalLabel">Geben Sie Ihren Vornamen ein</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form method="post" action="action.php">
                      <div class="form-group">
                        <label for="vorname-neu" class="col-form-label">Vorname</label>
                        <input type="text" class="form-control" name="vorname-neu" id="vorname-neu">
                      </div>
                      <div class="form-group">
                        <label for="vorname-bestätigen" class="col-form-label">Vorname bestätigen</label>
                        <input type="text" class="form-control" name="vorname-bestätigen" id="vorname-bestätigen">
                      </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Abbrechen</button>
                    <button type="submit" name="button" class="btn btn-primary" value="insert">Bestätigen</button>
                  </div>
                  </form>
                </div>
              </div>
            </div>


            <!-- Profil - Nachname -->
            <div class="input-group mb-3 ml-auto col-6">
              <div class="input-group-prepend">
                <span class="input-group-addon" id="inputGroup-sizing-default">Nachname</span>
              </div>
              <input disabled style="background-color:white" type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" name="nachname" id="nachname" value="<?=$row['Nachname'] ?>">
            </div>

            <div class="text-center mr-auto">
              <button type="submit" class="btn btn-primary mb-2" data-toggle="modal" data-target="#nachnameModal">Ändern</button>
            </div>

            <div class="modal fade" id="nachnameModal" tabindex="-1" role="dialog" aria-labelledby="nachnameModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="nachnameModalLabel">Geben Sie Ihren Nachnamen ein</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form method="post" action="action.php">
                      <div class="form-group">
                        <label for="nachname-neu" class="col-form-label">Nachname</label>
                        <input type="text" class="form-control" name="nachname-neu" id="nachname-neu">
                      </div>
                      <div class="form-group">
                        <label for="nachname-bestätigen" class="col-form-label">Nachname bestätigen</label>
                        <input type="text" class="form-control" name="nachname-bestätigen" id="nachname-bestätigen">
                      </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Abbrechen</button>
                    <button type="submit" name="button" class="btn btn-primary" value="insert">Bestätigen</button>
                  </div>
                  </form>
                </div>
              </div>
            </div>


            <!-- Profil - E-Mail -->
            <div class="input-group mb-3 ml-auto col-6">
              <div class="input-group-prepend">
                <span class="input-group-addon" id="inputGroup-sizing-default">E-Mail</span>
              </div>
              <input disabled style="background-color:white" type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" name="email" id="email" value="<?=$row['Email'] ?>">
            </div>

            <div class="text-center mr-auto">
              <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#emailModal">Ändern</button>
            </div>

            <div class="modal fade" id="emailModal" tabindex="-1" role="dialog" aria-labelledby="emailModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="emailModalLabel">Geben Sie Ihre neue E-Mail Adresse ein</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form method="post" action="action.php">
                      <div class="form-group">
                        <label for="email-neu" class="col-form-label">Neue E-Mail Adresse</label>
                        <input type="text" class="form-control" name="email-neu" id="email-neu">
                      </div>
                      <div class="form-group">
                        <label for="email-bestätigen" class="col-form-label">E-Mail Adresse bestätigen</label>
                        <input type="text" class="form-control" name="email-bestätigen" id="email-bestätigen">
                      </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Abbrechen</button>
                    <button type="submit" name="button" class="btn btn-primary" value="insert">Bestätigen</button>
                  </div>
                  </form>
                </div>
              </div>
            </div>


            <!-- Profil - Straße -->
            <div class="input-group mb-3 ml-auto col-6">
              <div class="input-group-prepend">
                <span class="input-group-addon" id="inputGroup-sizing-default">Straße</span>
              </div>
              <input disabled style="background-color:white" type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" name="strasse" id="strasse" value="<?=$adressrow['Strasse'] ?>">
            </div>

            <div class="text-center mr-auto">
              <button type="submit" class="btn btn-primary mb-2" data-toggle="modal" data-target="#strasseModal">Ändern</button>
            </div>

            <div class="modal fade" id="strasseModal" tabindex="-1" role="dialog" aria-labelledby="strasseModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="strasseModalLabel">Geben Sie Ihre Adresse ein</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form method="post" action="action.php">
                      <div class="form-group">
                        <label for="strasse-neu" class="col-form-label">Straße</label>
                        <input type="text" class="form-control" name="strasse-neu" id="strasse-neu">
                      </div>
                      <div class="form-group">
                        <label for="strasse-bestätigen" class="col-form-label">Straße bestätigen</label>
                        <input type="text" class="form-control" name="strasse-bestätigen" id="strasse-bestätigen">
                      </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Abbrechen</button>
                    <button type="submit" name="button" class="btn btn-primary" value="insert">Bestätigen</button>
                  </div>
                  </form>
                </div>
              </div>
            </div>


            <!-- Profil - Postleitzahl -->
            <div class="input-group mb-3 ml-auto col-6">
              <div class="input-group-prepend">
                <span class="input-group-addon" id="inputGroup-sizing-default">Postleitzahl</span>
              </div>
              <input disabled style="background-color:white" type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" name="postleitzahl" id="postleitzahl" value="<?=$adressrow['Postleitzahl'] ?>">
            </div>

            <div class="text-center mr-auto">
              <button type="submit" class="btn btn-primary mb-2" data-toggle="modal" data-target="#plzModal">Ändern</button>
            </div>

            <div class="modal fade" id="plzModal" tabindex="-1" role="dialog" aria-labelledby="plzModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="plzModalLabel">Geben Sie Ihre Postleitzahl ein</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form method="post" action="action.php">
                      <div class="form-group">
                        <label for="plz-neu" class="col-form-label">Postleitzahl</label>
                        <input type="text" class="form-control" name="plz-neu" id="plz-neu">
                      </div>
                      <div class="form-group">
                        <label for="plz-bestätigen" class="col-form-label">Postleitzahl bestätigen</label>
                        <input type="text" class="form-control" name="plz-bestätigen" id="plz-bestätigen">
                      </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Abbrechen</button>
                    <button type="submit" name="button" class="btn btn-primary" value="insert">Bestätigen</button>
                  </div>
                  </form>
                </div>
              </div>
            </div>


            <!-- Profil - Stadt -->
            <div class="input-group mb-3 ml-auto col-6">
              <div class="input-group-prepend">
                <span class="input-group-addon" id="inputGroup-sizing-default">Stadt</span>
              </div>
              <input disabled style="background-color:white" type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" name="stadt" id="stadt" value="<?=$adressrow['Ort'] ?>">
            </div>

            <div class="text-center mr-auto">
              <button type="submit" class="btn btn-primary mb-2" data-toggle="modal" data-target="#stadtModal">Ändern</button>
            </div>

            <div class="modal fade" id="stadtModal" tabindex="-1" role="dialog" aria-labelledby="stadtModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="stadtModalLabel">Geben Sie Ihre Wohnort an</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form method="post" action="action.php">
                      <div class="form-group">
                        <label for="stadt-neu" class="col-form-label">Wohnort</label>
                        <input type="text" class="form-control" name="stadt-neu" id="stadt-neu">
                      </div>
                      <div class="form-group">
                        <label for="stadt-bestätigen" class="col-form-label">Wohnort bestätigen</label>
                        <input type="text" class="form-control" name="stadt-bestätigen" id="stadt-bestätigen">
                      </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Abbrechen</button>
                    <button type="submit" name="button" class="btn btn-primary" value="insert">Bestätigen</button>
                  </div>
                  </form>
                </div>
              </div>
            </div>


            <!-- Profil - Passwort -->
            <div class="input-group mb-3 ml-auto col-6">
              <div class="input-group-prepend">
                <span class="input-group-addon" id="inputGroup-sizing-default">Passwort</span>
              </div>
              <input disabled style="background-color:white" type="password" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" name="passwort" id="passwort" value="hahaha">
            </div>

            <div class="text-center mr-auto">
              <button type="submit" class="btn btn-primary mb-2" data-toggle="modal" data-target="#passwortModal">Ändern</button>
            </div>

            <div class="modal fade" id="passwortModal" tabindex="-1" role="dialog" aria-labelledby="passwortModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="passwortModalLabel">Geben Sie Ihr neues Passwort ein</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form method="post" action="action.php">
                      <div class="form-group">
                        <label for="passwort-neu" class="col-form-label">Neues Passwort</label>
                        <input type="password" class="form-control" name="passwort-neu" id="passwort-neu">
                      </div>
                      <div class="form-group">
                        <label for="passwort-bestätigen" class="col-form-label">Passwort bestätigen</label>
                        <input type="password" class="form-control" name="passwort-bestätigen" id="passwort-bestätigen">
                      </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Abbrechen</button>
                    <button type="submit" name="button" class="btn btn-primary" value="insert">Bestätigen</button>
                  </div>
                  </form>
                </div>
              </div>
            </div>

          </div>
          <?php
            unset($_SESSION['errorBenutzername']);
            unset($_SESSION['test']);
            unset($_SESSION['errorPlz']);
          ?>

        </div>
      </div>
    </div>


  </div>

</body>
</html>
