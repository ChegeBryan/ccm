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
  <title>Staff Approval</title>
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
        <h1 class="h3 mb-0 text-secondary">Staff Approval</h1>
      </div>

      <?php include 'summary.php'; ?>

      <div class="row">

        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-7">
          <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary">Staff Requesting Approval</h6>
            </div>

            <div class="card-body">

              <?php
              $sql = "SELECT id, fullname, username FROM ccm_staff WHERE approved = ?";

              if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("i", $param_approved);

                $param_approved = 0;

                if ($stmt->execute()) {
                  $result = $stmt->get_result();

                  if ($result->num_rows > 0) {
                    echo "<table class='table table-bordered table-sm'>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th scope='col'>#</th>
                          <th scope='col'>Full Name</th>
                          <th scope='col'>Username</th>
                          <th scope='col'>Action</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";

                    $n = 1;

                    while ($row = $result->fetch_array()) {
                      echo "<tr>";
                      echo "<td>" . $n . "</td>";
                      echo "<td>" . $row['fullname'] . "</td>";
                      echo "<td>" . $row['username'] . "</td>";
                      echo "<td><a class='btn btn-primary btn-sm' href='approve_staff.php?staff=" . $row['id'] . "'>Approve</a></td>";
                      echo "</tr>";

                      $n++;
                    }
                    echo "</tbody></table>";
                  } else {
                    echo "<p class='card-text'>No new staff registered.</p>";
                  }
                }
              }
              $stmt->close();
              ?>
            </div>
          </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
          <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary">Pending User Approvals</h6>
            </div>

            <div class="card-body">
              <?php include 'pending_approvals.php'; ?>
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
