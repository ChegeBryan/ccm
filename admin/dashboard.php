<?php


session_start();

if (isset($_SESSION["admin_logged_In"]) || $_SESSION["admin_logged_in"] !== true) {
  header("location: login.php");
  exit;
}

require_once '../includes/config.php';

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <title>Admin Dashboard</title>
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
        <h1 class="h3 mb-0 text-secondary">Dashboard</h1>
      </div>

      <?php include 'summary.php'; ?>

      <div class="row">

        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-7">
          <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary">Land Distribution</h6>
            </div>

            <div class="card-body">
              <div class="d-flex justify-content-around">

                <?php include 'grain_distribution.php'; ?>

                <span class="badge badge-pill badge-primary p-4 rounded-circle"><?php echo $maize; ?> Acres</span>
                <span class="badge badge-pill badge-secondary p-4 rounded-circle"><?php echo $wheat; ?> Acres</span>
                <span class="badge badge-pill badge-success p-4 rounded-circle"><?php echo $millet; ?> Acres</span>
                <span class="badge badge-pill badge-warning p-4 rounded-circle"><?php echo $sorghum; ?> Acres</span>
                <span class="badge badge-pill badge-info p-4 rounded-circle"><?php echo $beans; ?> Acres</span>
                <span class="badge badge-pill badge-dark p-4 rounded-circle"><?php echo $rice; ?> Acres</span>
              </div>

              <div class="mt-4 text-center small">
                <span class="mr-2">
                  <i class="fa fa-circle text-primary"></i> Maize
                </span>
                <span class="mr-2">
                  <i class="fa fa-circle text-secondary"></i> Wheat
                </span>
                <span class="mr-2">
                  <i class="fa fa-circle text-success"></i> Millet
                </span>
                <span class="mr-2">
                  <i class="fa fa-circle text-warning"></i> Sorghums
                </span>
                <span class="mr-2">
                  <i class="fa fa-circle text-info"></i> Beans
                </span>
                <span class="mr-2">
                  <i class="fa fa-circle text-dark"></i> Rice
                </span>
              </div>

            </div>
          </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
          <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary">Approved CCM Users</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">

              <div class="d-flex justify-content-around">
                <span class="badge badge-pill badge-primary p-4 rounded-circle"><?php echo $_SESSION['approved_advisors']; ?></span>
                <span class="badge badge-pill badge-secondary p-4 rounded-circle">
                  <?php
                  $sql = "SELECT COUNT(id) FROM ccm_staff WHERE approved = ?";

                  if ($stmt = $conn->prepare($sql)) {
                    $stmt->bind_param("i", $param_approved);

                    $param_approved = 1;

                    if ($stmt->execute()) {
                      $result = $stmt->get_result();

                      $count = $result->fetch_row()[0];

                      echo $count;
                    }
                    $result->free();
                  }
                  $stmt->close();
                  ?>
                </span>
                <span class="badge badge-pill badge-success p-4 rounded-circle"><?php echo $_SESSION['approved_farmers']; ?></span>
              </div>

              <div class="mt-4 text-center small">
                <span class="mr-2">
                  <i class="fa fa-circle text-primary"></i> Advisors
                </span>
                <span class="mr-2">
                  <i class="fa fa-circle text-secondary"></i> Staff
                </span>
                <span class="mr-2">
                  <i class="fa fa-circle text-success"></i> Farmers
                </span>
              </div>
            </div>
          </div>
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
