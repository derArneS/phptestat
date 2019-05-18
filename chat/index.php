<?php

session_start();

require '../database/database.php';
require "../const/cookie.php";
require '../const/deletecache.php';
require "../const/private.php"; isPrivate(true, "/chat");

$databaseconnection = createConnection();

if (($statement = $databaseconnection->prepare("SELECT Empfaenger, Benutzername FROM Nachrichten, Benutzer WHERE Sender = ? AND Nachrichten.Empfaenger = Benutzer.ID GROUP BY Empfaenger"))
&& ($statement->bind_param('i', $_SESSION['id']))
&& ($statement->execute())
&& ($resultset = $statement->get_result())) {

}

if (($statement3 = $databaseconnection->prepare("UPDATE Nachrichten SET Gelesen = 1 WHERE Empfaenger = ?"))
&& ($statement3->bind_param('i', $_SESSION['id']))
&& ($statement3->execute())) {

}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <?php require "../const/head.php" ?>
    <link rel="stylesheet" href="chat.css">
  </head>
  <body>
    <?php require '../const/navbar.php'; ?>

    <?php if ($resultset->num_rows != 0) { ?>
    <div class="container mt-3 mb-5">
      <div class="row" id="test">
        <div class="col-4">
          <div class="list-group" id="list-tab" role="tablist">
            <?php while ($row = $resultset->fetch_assoc()) { ?>
              <a class="list-group-item list-group-item-action text-center <?php if (isset($_GET['tab']) && $_GET['tab'] == $row['Empfaenger'] ) echo "active"; ?>" id="list-<?= $row['Benutzername'] ?>-list" data-toggle="list" href="#list-<?= $row['Benutzername'] ?>" role="tab" aria-controls="<?= $row['Benutzername'] ?>"><?= $row['Benutzername'] ?></a>
            <?php } $resultset->data_seek(0);?>
          </div>
        </div>
        <div class="col-8">
          <div class="tab-content" id="nav-tabContent">
            <?php while($row = $resultset->fetch_assoc()) { ?>
            <div class="tab-pane fade <?php if (isset($_GET['tab']) && $_GET['tab'] == $row['Empfaenger'] ) echo "show active"; ?>" id="list-<?= $row['Benutzername'] ?>" role="tabpanel" aria-labelledby="list-<?= $row['Benutzername'] ?>-list">
              <div class="container mb-3" style="height: 80vh; overflow-y: auto;">
                <div class="row">
                  <?php
                  if (($statement2 = $databaseconnection->prepare("SELECT * FROM Nachrichten, Benutzer AS Sender, Benutzer AS Empfaenger WHERE ((Sender.ID = ? AND Empfaenger.ID = ?) OR (Sender.ID = ? AND Empfaenger.ID = ?))  AND Nachrichten.Sender = Sender.ID AND Nachrichten.Empfaenger = Empfaenger.ID"))
                  && ($statement2->bind_param('iiii', $_SESSION['id'], $row['Empfaenger'], $row['Empfaenger'], $_SESSION['id']))
                  && ($statement2->execute())
                  && ($resultset2 = $statement2->get_result())) {
                    while ($row2 = $resultset2->fetch_assoc()) { ?>
                      <div class="container">
                        <div class="row">
                          <div class="col-6">
                            <?php if ($row2['Sender'] != $_SESSION['id']): ?>
                              <p class="box py-2 text-center"><?= $row2['Text'] ?></p>
                            <?php endif; ?>
                          </div>
                          <div class="col-6">
                            <?php if ($row2['Sender'] == $_SESSION['id']): ?>
                              <p class="box py-2 text-center"><?= $row2['Text'] ?></p>
                            <?php endif; ?>
                          </div>
                        </div>
                      </div>
                    <?php }
                  }
                  ?>
                </div>
              </div>
              <form class="" action="action.php" method="post">
               <div class="container">
                 <div class="row">
                   <div class="col-10">
                      <input type="text" class="form-control" name="text" value="" required>
                      <input type="hidden" name="empfaenger" value="<?= $row['Empfaenger'] ?>">
                   </div>
                   <div class="col-2">
                     <input type="submit" class="btn btn-primary" name="" value="Senden">
                   </div>
                 </div>
               </div>
             </form>
            </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>

  <?php } else {
    echo "Du musst erst jemanden anschreiben, bevor hier Nachrichten angezeigt werden können.";
  } ?>


    <?php require "../const/footer.php" ?>
  </body>
</html>

<?php closeConnection($databaseconnection); ?>
