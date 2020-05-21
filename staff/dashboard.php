<?php


session_start();

if (isset($_SESSION["staff_logged_In"]) || $_SESSION["staff_logged_in"] !== true) {
  header("location: login.php");
  exit;
}

if (!isset($_SESSION["staff_approved_status"]) || $_SESSION["staff_approved_status"] == 0) {
  header("location: not_approved.php?staff=" . $_SESSION['staff_id']);
  exit;
}

require_once '../includes/config.php';

?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <title>Staff Dashboard</title>
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


          <div class="col-lg-8 mb-4">
            <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-dark">Farmers' Requesting Approval</h6>
              </div>
              <div class="card-body">

                <?php
              $sql = "SELECT id, fullname, mobile_number, national_id FROM ccm_farmers WHERE approved = ?";

              if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("i", $param_approved);

                $param_approved = 0;

                if ($stmt->execute()) {
                  $result = $stmt->get_result();

                  if ($result->num_rows > 0) {
                    echo "<table class='table table-bordered table-sm'>";
                    echo "<thead class='text-muted'>";
                    echo "<tr>";
                    echo "<th scope='col'>#</th>
                          <th scope='col'>Full Name</th>
                          <th scope='col'>National Id</th>
                          <th scope='col'>Mobile Number</th>
                          <th scope='col'>Action</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";

                    $n = 1;

                    while ($row = $result->fetch_array()) {
                      echo "<tr>";
                      echo "<td>" . $n . "</td>";
                      echo "<td>" . $row['fullname'] . "</td>";
                      echo "<td>" . $row['national_id'] . "</td>";
                      echo "<td>" . $row['mobile_number'] . "</td>";
                      echo "<td><a class='btn btn-secondary text-white btn-sm' href='approve_user.php?farmer=" . $row['id'] . "'>Approve</a></td>";
                      echo "</tr>";

                      $n++;
                    }
                    echo "</tbody></table>";
                  } else {
                    echo "<p class='card-text'>No new farmers registered.</p>";
                  }
                }
              }
              $stmt->close();
              ?>
              </div>
            </div>

          </div>

          <div class="col-lg-4 mb-4">

            <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-dark">Farmers' Stats</h6>
              </div>
              <div class="card-body overflow-auto" style="max-height: 20.75rem">
                <div class="d-flex justify-content-around">
                  <span class="badge badge-pill badge-success p-4 rounded-circle">
                    <?php
                  $sql = "SELECT COUNT(id) FROM ccm_farmers WHERE approved = ?";

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
                  <span class="badge badge-pill badge-warning p-4 rounded-circle">
                    <?php
                  $sql = "SELECT COUNT(id) FROM ccm_farmers WHERE approved = ?";

                  if ($stmt = $conn->prepare($sql)) {
                    $stmt->bind_param("i", $param_approved);

                    $param_approved = 0;

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
                </div>

                <div class="mt-4 text-center small">
                  <span class="mr-2">
                    <i class="fa fa-circle text-success"></i> Approved Farmers
                  </span>
                  <span class="mr-2">
                    <i class="fa fa-circle text-warning"></i> Waiting Approval
                  </span>
                </div>
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
