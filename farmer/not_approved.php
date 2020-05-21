<?php


session_start();

if (isset($_SESSION["farmer_logged_In"]) || $_SESSION["farmer_logged_in"] !== true) {
  header("location: login.php");
  exit;
}

require_once '../includes/config.php';

?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <title>Farmer Dashboard</title>
    <?php include '../head.php'; ?>
    <link rel="stylesheet" href="../css/dashboard.css">
  </head>

  <body>

    <div class="d-flex">

      <?php include 'menu.php'; ?>

      <!-- Begin Page Content -->
      <div class="container-fluid pt-9">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h1 class="h3 mb-0 text-secondary">You are not yet approved by the site administrator. Once Approved you will
            able to view this page.</h1>
        </div>

      </div>
      <!-- /.container-fluid -->

    </div>
    <!-- Logout Modal-->
    <?php include '../logout_modal.php'; ?>


    <script src="../assets/js/jquery.min.js"></script>

    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/bootstrap-4.4.1-dist/js/bootstrap.min.js"></script>
  </body>

</html>
