<?php
  function isPrivate($private){
    if ($private && !isset($_SESSION['benutzername'])) {
      return false;
    }
    return true;
  }
 ?>
