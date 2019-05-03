
<?php session_start() ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php print_r($_FILES); ?>
    <br>
    <?php print_r($_POST); ?>
    <br>
    <?php $_SESSION['cache']['insert'] = $_POST; ?>
    <?php print_r($_SESSION); ?>
    <br>

    <?php

    if (isset($_POST['file'])) {

    } else {
      echo "nicht hallo";
    }

    ?>

    <form class="" action="index.php" method="post">
      <button type="submit" name="button">Hier klicken</button>
    </form>
  </body>
</html>
