<?php require "root.php" ?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href=<?= root?>>
    <img src="../pics/h.png" class="d-inline-block align-top" width="30" height="30" alt="H">
    Hotel25
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href=<?= root?>>Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Dropdown
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
    </ul>

    <ul class="navbar-nav mr-0 my-lg-0">
      <li class="nav-item">
        <a class="nav-link" href=<?= root . "/welcome/register.php"?>>Registrieren</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href=<?= root . "/welcome/login.php"?>>Login</a>
      </li>
    </ul>
    <!--
    <ul class="navbar-nav mr-0 my-lg-0">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          User
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="../welcome/login.php">Login</a>
        </div>
      </li>
    </ul>
  -->
  </div>
</nav>
