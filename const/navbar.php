<?php
require "root.php";
?>

<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href=<?= root?>>Auto25</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href=<?= root . "/suche/index.php"?>>Suche</a>
      </li>
    </ul>

    <?php if(isset($_SESSION['benutzername'])) { ?>
      <ul class="navbar-nav mr-0 my-lg-0">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php echo $_SESSION['benutzername']; ?>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href=<?= root . "/inserieren"?>>Inserieren</a>
            <a class="dropdown-item" href=<?= root . "/profil"?>>Profil</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href=<?= root . "/login/logout.php"?>>Logout</a>
          </div>
        </li>
      </ul>
    <?php } else {?>
    <ul class="navbar-nav mr-0 my-lg-0">
      <li class="nav-item">
        <a class="nav-link" href=<?= root . "/register"?>>Registrieren</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href=<?= root . "/login"?>>Login</a>
      </li>
    </ul>
  <?php } ?>
  </div>
</nav>

<?php


if (isset($_SESSION['benutzername']) && (!isset($_SESSION['vorname']) || !isset($_SESSION['nachname']) || !isset($_SESSION['strasse']) || !isset($_SESSION['postleitzahl']) || !isset($_SESSION['stadt']))) {
  echo '
    <div class="alert alert-warning alert-dismissible fade show m-0" role="alert">
      Scheinbar ist dein Profil noch nicht fertig! <a href="'.root.'/profil/index.php?tab=3" class="alert-link">Hier vervollständigen.</a>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  ';
}

?>
