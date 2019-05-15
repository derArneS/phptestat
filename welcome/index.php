<?php

session_start();
require '../database/database.php';
require "../const/cookie.php";
require '../const/deletecache.php';

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title></title>
  <?php require "../const/head.php" ?>
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/carousel.css">
</head>
<body>
  <?php require '../const/navbar.php'; ?>
  <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <a href="../welcome/action.php?marke=1">
          <img class="d-block w-100"src="../pics/car1.jpg" alt="First slide">
        </a>
        <div class="carousel-caption d-none d-md-block">
          <h1>BMW</h1>
        </div>
      </div>
      <div class="carousel-item">
        <a href="../welcome/action.php?marke=2">
          <img class="d-block w-100" src="../pics/car2.jpg" alt="Second slide">
        </a>
        <div class="carousel-caption d-none d-md-block">
          <h1>Audi</h1>
        </div>
      </div>
      <div class="carousel-item">
        <a href="../welcome/action.php?marke=7">
          <img class="d-block w-100" src="../pics/car3.jpg" alt="Third slide">
        </a>
        <div class="carousel-caption d-none d-md-block">
          <h1>Porsche</h1>
        </div>
      </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
  <?php require "../const/footer.php" ?>
</body>
</html>
