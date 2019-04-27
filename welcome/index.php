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
  <section>
  <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" style="width: 100%; height: 100%">
    <ol class="carousel-indicators">
      <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
      <div class="carousel-item active" style="width: 100%; max-height: 400px">
        <a href="../welcome/search.php">
          <img class="d-block w-100"src="../pics/car1.jpg" alt="First slide">
        </a>
      </div>
      <div class="carousel-item" style="width: 100%; max-height: 400px">
        <a href="../welcome/search.php">
          <img class="d-block w-100" src="../pics/car2.jpg" alt="Second slide">
        </a>
      </div>
      <div class="carousel-item" style="width: 100%; max-height: 400px">
        <a href="../welcome/search.php">
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
  </section>

<!--
  <section class="search-sec">
    <div class="container">
      <form action="#" method="post" novalidate="novalidate">
        <div class="row">
          <div class="col-lg-12">
            <div class="row">
              <div class="col-lg-3 col-md-3 col-sm-12 p-0">
                <input type="text" class="form-control search-slt" placeholder="Reiseort">
              </div>
              <div class="col-lg-3 col-md-3 col-sm-12 p-0">
                <input type="text" class="form-control search-slt" placeholder="Reiseort">
              </div>
              <div class="col-lg-3 col-md-3 col-sm-12 p-0">
                <button type="button" class="btn btn-danger wrn-btn">Suche</button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </section>
-->
</body>
</html>
