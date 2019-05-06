<?php session_start() ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <?php require "../const/head.php" ?>
  <meta charset="utf-8">
  <title></title>
</head>
<body style="padding-bottom: 80px">

  <?php require '../const/navbar.php'; ?>

  <!-- Page Content -->
  <div class="container">

    <!-- Page Heading -->
    <h1 class="my-4">Detaillierte Suche
      <small>Für Ihr neues Traumauto</small>
    </h1>

    <script type="text/javascript">
      function anzeigen(a){
        if(a.value !== 'bel'){
          Modell.disabled = false;
        } else {
          Modell.disabled = true;
        }
      }
    </script>

    <form>
      <div class="form-row">
        <div class="col-md-2,5">
          <label for="Marke">Marke</label>
          <select id="Marke" class="form-control" onchange="anzeigen(this)">
            <option value="bel" selected>Beliebig</option>
            <option>Audi</option>
            <option>BMW</option>
            <option>Mercedes</option>
            <option>Opel</option>
            <option>Volkswagen</option>
          </select>
        </div>
        <div class="col-md-2,5">
          <label for="Modell">Modell</label>
          <select disabled id="Modell" class="form-control">
            <option selected>Keine Auswahl</option>
          </select>
        </div>
        <div class="col-md-2,5">
          <label for="Erstzulassung">Erstzulassung ab</label>
          <select id="Erstzulassung" class="form-control">
            <option selected>Keine Auswahl</option>
            <option>2019</option>
            <option>2018</option>
            <option>2017</option>
            <option>2016</option>
            <option>2015</option>
          </select>
        </div>
        <div class="col-md-2,5">
          <label for="Preis">Preis</label>
          <select id="Preis" class="form-control">
            <option selected>Preis bis</option>
            <option>5.000€</option>
            <option>10.000€</option>
            <option>20.000€</option>
            <option>30.000€</option>
            <option>40.000€</option>
          </select>
        </div>
        <div class="col-md-2,5">
          <label for="Kilometerstand">Kilometerstand</label>
          <select id="Kilometerstand" class="form-control">
            <option selected>Kilometerstand bis</option>
            <option>10.000km</option>
            <option>25.000km</option>
            <option>50.000km</option>
            <option>75.000km</option>
            <option>100.000km</option>
          </select>
        </div>
        <div class="col-md-2,5">
          <label for="Stadt">Stadt</label>
          <input type="text" class="form-control" id="Stadt" placeholder="Münster">
        </div>
      </div>

    </br>
    <div class="form-row">
      <div class="col-md-2,5">
        <button type="submit" class="btn btn-primary" onclick="anzeigen()">Suchen</button>
      </div>
    </div>
    </br>
    </br>
  </form>



  <div class="row">
    <div class="col-lg-6 mb-4">
      <div class="card h-100">
        <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
        <div class="card-body">
          <h4 class="card-title">
            <a href="#">Project One</a>
          </h4>
          <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra euismod odio, gravida pellentesque urna varius vitae.</p>
        </div>
      </div>
    </div>
    <div class="col-lg-6 mb-4">
      <div class="card h-100">
        <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
        <div class="card-body">
          <h4 class="card-title">
            <a href="#">Project Two</a>
          </h4>
          <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugit aliquam aperiam nulla perferendis dolor nobis numquam, rem expedita, aliquid optio, alias illum eaque. Non magni, voluptates quae, necessitatibus unde temporibus.</p>
        </div>
      </div>
    </div>
    <div class="col-lg-6 mb-4">
      <div class="card h-100">
        <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
        <div class="card-body">
          <h4 class="card-title">
            <a href="#">Project Three</a>
          </h4>
          <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra euismod odio, gravida pellentesque urna varius vitae.</p>
        </div>
      </div>
    </div>
    <div class="col-lg-6 mb-4">
      <div class="card h-100">
        <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
        <div class="card-body">
          <h4 class="card-title">
            <a href="#">Project Four</a>
          </h4>
          <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugit aliquam aperiam nulla perferendis dolor nobis numquam, rem expedita, aliquid optio, alias illum eaque. Non magni, voluptates quae, necessitatibus unde temporibus.</p>
        </div>
      </div>
    </div>
    <div class="col-lg-6 mb-4">
      <div class="card h-100">
        <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
        <div class="card-body">
          <h4 class="card-title">
            <a href="#">Project Five</a>
          </h4>
          <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra euismod odio, gravida pellentesque urna varius vitae.</p>
        </div>
      </div>
    </div>
    <div class="col-lg-6 mb-4">
      <div class="card h-100">
        <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
        <div class="card-body">
          <h4 class="card-title">
            <a href="#">Project Six</a>
          </h4>
          <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugit aliquam aperiam nulla perferendis dolor nobis numquam, rem expedita, aliquid optio, alias illum eaque. Non magni, voluptates quae, necessitatibus unde temporibus.</p>
        </div>
      </div>
    </div>
  </div>
  <!-- /.row -->

  <!-- Pagination -->
  <ul class="pagination justify-content-center">
    <li class="page-item">
      <a class="page-link" href="#" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
        <span class="sr-only">Previous</span>
      </a>
    </li>
    <li class="page-item">
      <a class="page-link" href="#">1</a>
    </li>
    <li class="page-item">
      <a class="page-link" href="#">2</a>
    </li>
    <li class="page-item">
      <a class="page-link" href="#">3</a>
    </li>
    <li class="page-item">
      <a class="page-link" href="#" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
        <span class="sr-only">Next</span>
      </a>
    </li>
  </ul>

</div>

  <?php require "../const/footer.php" ?>

</body>
</html>
