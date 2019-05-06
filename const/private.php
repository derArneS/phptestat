<?php
function isPrivate($private){
  if ($private && !isset($_SESSION['benutzername'])) {
    $_SESSION['errorPrivate'] = true;
    $_SESSION['redirect'] = "/inserieren";
    header('Location: ../login');
    die();
  }
}
 ?>
