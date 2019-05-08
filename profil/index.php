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

<!-- Tableiste mit drei Tabs -->
    <nav>
      <div class="nav nav-tabs nav-justified" id="nav-tab" role="tablist" fill>
        <a class="nav-item nav-link" id="nav-angebote-tab" data-toggle="tab" href="#nav-angebote" role="tab" aria-controls="nav-home" aria-selected="true">Eigene Angebote</a>
        <a class="nav-item nav-link" id="nav-favoriten-tab" data-toggle="tab" href="#nav-favoriten" role="tab" aria-controls="nav-profile" aria-selected="false">Favoriten</a>
        <a class="nav-item nav-link active" id="nav-daten-tab" data-toggle="tab" href="#nav-daten" role="tab" aria-controls="nav-contact" aria-selected="false">Persönliche Daten</a>
      </div>
    </nav>


    <div class="tab-content" id="nav-tabContent">

<!-- Tab - Eigene Angebote -->
      <div class="tab-pane fade " id="nav-angebote" role="tabpanel" aria-labelledby="nav-home-tab">
        Hallo :-)
      </div>

<!-- Tab - Favoriten -->
      <div class="tab-pane fade" id="nav-favoriten" role="tabpanel" aria-labelledby="nav-profile-tab">
        Test
      </div>


<!-- Tab - Persönliche Daten -->
      <div class="tab-pane fade show active col-12 mt-5 box" id="nav-daten" role="tabpanel" aria-labelledby="nav-contact-tab">
        <div class="container col-12 mt-5 box">
          <div class="row">


            <!-- Profil - Benutzername -->
            <div class="input-group mb-3 ml-auto col-6">
              <div class="input-group-prepend">
                <span class="input-group-addon" id="inputGroup-sizing-default">Benutzername</span>
              </div>
              <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default name="benutzername" id="benutzername" value="<?=$row['Benutzername'] ?>"">
            </div>

            <div class="text-center mr-auto">
              <button type="buttom" class="btn btn-primary mb-2" data-toggle="modal" data-target="#exampleModal">Ändern</button>
            </div>

            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Geben Sie Ihren neuen Benutzernamen ein</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form method="post">
                      <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Neuer Benutzername</label>
                        <input type="text" class="form-control" id="benutzername-neu">
                      </div>
                      <div class="form-group">
                        <label for="message-text" class="col-form-label">Benutzername bestätigen</label>
                        <input type="text" class="form-control" id="benutzername-bestätigen">
                      </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Abbrechen</button>
                    <button type="submit" name="button" class="btn btn-primary" value="insert" data-dismiss="modal">Bestätigen</button>
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
              <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" name="vorname" id="vorname">
            </div>

            <div class="text-center mr-auto">
              <button type="submit" class="btn btn-primary mb-2">Ändern</button>
            </div>


            <!-- Profil - Nachname -->
            <div class="input-group mb-3 ml-auto col-6">
              <div class="input-group-prepend">
                <span class="input-group-addon" id="inputGroup-sizing-default">Nachname</span>
              </div>
              <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" name="nachname" id="nachname">
            </div>

            <div class="text-center mr-auto">
              <button type="submit" class="btn btn-primary mb-2">Ändern</button>
            </div>


            <!-- Profil - E-Mail -->
            <div class="input-group mb-3 ml-auto col-6">
              <div class="input-group-prepend">
                <span class="input-group-addon" id="inputGroup-sizing-default">E-Mail</span>
              </div>
              <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" name="email" id="email" value="<?=$row['Email'] ?>">
            </div>

            <div class="text-center mr-auto">
              <button type="submit" class="btn btn-primary mb-2">Ändern</button>
            </div>


            <!-- Profil - Straße -->
            <div class="input-group mb-3 ml-auto col-6">
              <div class="input-group-prepend">
                <span class="input-group-addon" id="inputGroup-sizing-default">Straße</span>
              </div>
              <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" name="strasse" id="strasse">
            </div>

            <div class="text-center mr-auto">
              <button type="submit" class="btn btn-primary mb-2">Ändern</button>
            </div>


            <!-- Profil - Postleitzahl -->
            <div class="input-group mb-3 ml-auto col-6">
              <div class="input-group-prepend">
                <span class="input-group-addon" id="inputGroup-sizing-default">Postleitzahl</span>
              </div>
              <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" name="postleitzahl" id="postleitzahl">
            </div>

            <div class="text-center mr-auto">
              <button type="submit" class="btn btn-primary mb-2">Ändern</button>
            </div>


            <!-- Profil - Stadt -->
            <div class="input-group mb-3 ml-auto col-6">
              <div class="input-group-prepend">
                <span class="input-group-addon" id="inputGroup-sizing-default">Stadt</span>
              </div>
              <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" name="stadt" id="stadt">
            </div>

            <div class="text-center mr-auto">
              <button type="submit" class="btn btn-primary mb-2">Ändern</button>
            </div>


            <!-- Profil - Passwort -->
            <div class="input-group mb-3 ml-auto col-6">
              <div class="input-group-prepend">
                <span class="input-group-addon" id="inputGroup-sizing-default">Passwort</span>
              </div>
              <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" name="passwort" id="passwort" value="<?=$row['Passwort'] ?>">
            </div>

            <div class="text-center mr-auto">
              <button type="submit" class="btn btn-primary mb-2">Ändern</button>
            </div>

          </div>
        </div>
      </div>
    </div>


  </div>

</body>
</html>
