<!DOCTYPE html>
<html>

  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon.png">
    <link rel="stylesheet" href="./assets/bootstrap-4.4.1-dist/css/bootstrap.css">
    <link rel="stylesheet" href="./css/style.css">
    <title>Error Page</title>
    <style>
    html {
      height: 100%;
    }

    body {
      height: 100%;
      max-height: 100%;
    }

    .jumbotron {
      height: 100vh;
      margin-bottom: 0;
    }

    </style>
  </head>

  <body>

    <nav class="navbar navbar-expand-sm navbar-bg bg-dark fixed-top">

      <!-- Brand -->
      <a class="navbar-brand text-white" href="index.php">CCMS</a>

      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link text-white" href="<?php echo $_SERVER['HTTP_REFERER'] ?>">Back</a>
        </li>
      </ul>

    </nav>

    <div class="jumbotron jumbotron-fluid">
      <div class="container d-flex flex-column align-items-center">
        <h1>Oops!!</h1>
        <p>Could not complete request as requested. <a href="<?php echo $_SERVER['HTTP_REFERER'] ?>">Try Again</a></p>
      </div>
    </div>

    <!-- jQuery library -->
    <script src="js/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="js/popper.min.js"></script>
    <script src="./assets/bootstrap-4.4.1-dist/js/bootstrap.min.js"></script>

  </body>

</html>
