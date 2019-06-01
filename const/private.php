<?php
function isPrivate($private, $redirect){
  //Überprüfung, ob man angemeldet ist
  if ($private && !isset($_SESSION['benutzername'])) {
    //Wenn man nicht eingeloggt ist, die Seite aber private ist, muss man sich erst einloggen
    $_SESSION['errorPrivate'] = true;
    //über redirect wird man wieder zu der Seite geleitet, zu der man eigentlich wollte
    $_SESSION['redirect'] = $redirect;
    header('Location: ../login');
    die();
  }
}
 ?>
