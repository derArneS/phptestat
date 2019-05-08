<?php
function isPrivate($private, $redirect){
  if ($private && !isset($_SESSION['benutzername'])) {
    $_SESSION['errorPrivate'] = true;
    $_SESSION['redirect'] = $redirect;
    header('Location: ../login');
    die();
  }
}
 ?>
