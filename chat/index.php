<?php

session_start();

require '../database/database.php';
$databaseconnection = createConnection();
require "../const/cookie.php";
require '../const/deletecache.php';
require "../const/private.php"; isPrivate(true, "/chat");


//Holen aller Nachrichten inklusive der Sender und Empfänger, bei denen der eingeloggte Nutzer entweder Empfänger oder Sender ist
if (($statement = $databaseconnection->prepare("SELECT Sender, Empfaenger, Sender.Benutzername AS Sendername, Empfaenger.Benutzername AS Empfaengername
                                                FROM Nachrichten, Benutzer AS Sender, Benutzer AS Empfaenger
                                                WHERE (Sender = ? OR Empfaenger = ?) AND Nachrichten.Sender = Sender.ID AND Nachrichten.Empfaenger = Empfaenger.ID
                                                GROUP BY Empfaenger, Sender"))
&& ($statement->bind_param('ii', $_SESSION['id'], $_SESSION['id']))
&& ($statement->execute())
&& ($resultset = $statement->get_result())) {
  //Auswertden der Nachrichten, zwischenspeichern aller Personen, mit denen kommuniziert wurde
  while ($row = $resultset->fetch_assoc()) {
    if ($row['Empfaenger'] == $_SESSION['id']) {
      $empfaenger[$row['Sender']] = $row['Sender'];
    } else {
      $empfaenger[$row['Empfaenger']] = $row['Empfaenger'];    }
  }
}

//ReultSet wieder an den Anfang bringen
$resultset->data_seek(0);

//Alle Nachrichten, bei denen der eingeloggte Nutzer Empfänger ist, werden auf gelesen gesetzt
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

    <!-- Wenn Nachrichten gefunden wurden, bei denen der eingeloggte Nutzer entweder Sender oder Empfänger ist, wird die Nachrichten-Übersicht angezeigt -->
    <?php if ($resultset->num_rows != 0) { ?>
    <div class="container mt-3 mb-5">
      <div class="row" id="test">
        <div class="col-4">
          <div class="list-group" id="list-tab" role="tablist">
            <!-- für jeden Empänger wird ein eigener Tab erstellt -->
            <?php foreach ($empfaenger as $empf) {
              //Die Nachrichten, die in diesem Tab angezeigt werden sollen, werden aus der DB geladen
              if (($statement4 = $databaseconnection->prepare("SELECT Benutzername FROM Benutzer WHERE ID = ?"))
              && ($statement4->bind_param('i', $empf))
              && ($statement4->execute())
              && ($resultset4 = $statement4->get_result())
              && ($row4 = $resultset4->fetch_assoc())) {

              }

              ?>
              <!-- Wenn diese Seite mit einem $_GET['tab'] aufgerufen wird, wird der dazu passende Tab als aktiv dargestellt -->
              <a class="list-group-item list-group-item-action text-center <?php if (isset($_GET['tab']) && $_GET['tab'] == $empf ) echo "active"; ?>"
                id="list-<?= $empf ?>-list" data-toggle="list" href="#list-<?= $empf ?>" role="tab" aria-controls="<?= $empf ?>"><?= $row4['Benutzername'] ?></a>
            <?php } $resultset->data_seek(0);?>
          </div>
        </div>
        <div class="col-8">
          <div class="tab-content" id="nav-tabContent">
            <!-- Für jeden Empfänger werden auch Seiten erstellt, die angezeigt werden, wenn der dazu passende Tab angeklickt wird -->
            <?php foreach ($empfaenger as $empf) { ?>
            <!-- Wenn diese Seite mit einem $_GET['tab'] aufgerufen wird, wird der dazu passende Tab als aktiv dargestellt. Hier wird dann der Inhalt dazu als aktiv angezeigt -->
            <div class="tab-pane fade <?php if (isset($_GET['tab']) && $_GET['tab'] == $empf ) echo "show active"; ?>" id="list-<?= $empf ?>" role="tabpanel" aria-labelledby="list-<?= $empf ?>-list">
              <div class="container mb-3" style="height: 80vh; overflow-y: auto;">
                <div class="row">
                  <?php
                  //Alle Nachrichten zwischen dem eingeloggten Nutzer und dem chatpartner
                  if (($statement2 = $databaseconnection->prepare("SELECT * FROM Nachrichten, Benutzer AS Sender, Benutzer AS Empfaenger WHERE ((Sender.ID = ? AND Empfaenger.ID = ?) OR (Sender.ID = ? AND Empfaenger.ID = ?))  AND Nachrichten.Sender = Sender.ID AND Nachrichten.Empfaenger = Empfaenger.ID"))
                  && ($statement2->bind_param('iiii', $_SESSION['id'], $empf, $empf, $_SESSION['id']))
                  && ($statement2->execute())
                  && ($resultset2 = $statement2->get_result())) {
                    while ($row2 = $resultset2->fetch_assoc()) { ?>
                      <div class="container">
                        <div class="row">
                          <div class="col-6">
                            <!-- Wenn der eingeloggte Nutzer Empfänger ist, wird die Nachricht links angezeigt -->
                            <?php if ($row2['Sender'] != $_SESSION['id']): ?>
                              <p class="box py-2 text-center"><?= $row2['Text'] ?></p>
                            <?php endif; ?>
                          </div>
                          <div class="col-6">
                            <!-- Wenn der eingeloggte Nutzer Sender ist, wird die Nachricht rechts angezeigt -->
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
              <!-- Form zum senden von neuen Nachrichten -->
              <form class="" action="action.php" method="post">
               <div class="container">
                 <div class="row">
                   <div class="col-10">
                      <input type="text" class="form-control" name="text" value="" required>
                      <input type="hidden" name="empfaenger" value="<?= $empf ?>">
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

  <!-- Wenn man keine Chatpartner hat -->
  <?php } else {
    echo "Du musst erst jemanden anschreiben, bevor hier Nachrichten angezeigt werden können.";
  } ?>


    <?php require "../const/footer.php" ?>
  </body>
</html>

<?php closeConnection($databaseconnection); ?>
