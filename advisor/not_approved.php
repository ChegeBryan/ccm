<?php


session_start();

if (isset($_SESSION["advisor_logged_In"]) || $_SESSION["advisor_logged_in"] !== true) {
  header("location: login.php");
  exit;
}

require_once '../includes/config.php';

?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <title>Advisor Not logged in page</title>
    <?php include '../head.php'; ?>
    <link rel="stylesheet" href="../css/dashboard.css">
  </head>

  <body>

    <div class="d-flex">

      <?php include 'menu.php'; ?>

      <!-- Begin Page Content -->
      <div class="container-fluid pt-9">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center mb-4">
          <h1 class="h3 mb-0 text-secondary">You are not yet approved by the site administrator. Once Approved you will
            able to view this page.</h1>
        </div>
      </div>
      <!-- /.container-fluid -->

    </div>

    <?php include '../logout_modal.php'; ?>
    <script src="../assets/js/jquery.min.js"></script>

    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/bootstrap-4.4.1-dist/js/bootstrap.min.js"></script>
  </body>

</html>
