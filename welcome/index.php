<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title></title>
  <?php require "../const/head.php" ?>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
  <?php require '../const/navbar.php'; ?>

  <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" style="width: 100%; height: 100%">
    <ol class="carousel-indicators">
      <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
      <div class="carousel-item active" style="width: 100%; height: 500px">
        <a href="../welcome/hotelVorschlag1.php">
          <img class="d-block w-100"src="../pics/car1.jpg" alt="First slide">
        </a>
      </div>
      <div class="carousel-item" style="width: 100%; height: 500px">
        <a href="../welcome/hotelVorschlag2.php">
          <img class="d-block w-100" src="../pics/car2.jpg" alt="Second slide">
        </a>
      </div>
      <div class="carousel-item" style="width: 100%; height: 500px">
        <a href="../welcome/hotelVorschlag3.php">
          <img class="d-block w-100" src="../pics/car3.jpeg" alt="Third slide">
        </a>
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


  <?php require '../const/footer.php'; ?>

</body>
</html>
