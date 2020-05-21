<?php


session_start();

if (isset($_SESSION["staff_logged_In"]) || $_SESSION["staff_logged_in"] !== true) {
  header("location: login.php");
  exit;
}

if (isset($_SESSION["staff_approved_status"]) && $_SESSION["staff_approved_status"] == 0) {
  header("location: not_approved.php?staff=" . $_SESSION['staff_id']);
  exit;
}

require_once '../includes/config.php';

?>


<!DOCTYPE html>
<html lang="en">

  <head>
    <title>Scheduled Bookings</title>
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
          <h1 class="h3 mb-0 text-secondary">Scheduled Bookings'</h1>
        </div>

        <?php include 'summary.php'; ?>

        <div class="row">

          <!-- Area Chart -->
          <div class="col-lg-9">
            <div class="card shadow mb-4">
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-dark">Scheduled Farmers' Bookings</h6>
              </div>

              <div class="card-body">
                <?php
              $sql = "SELECT quantity_to_deliver, date_booked, delivery_date, approved_on, ccm_farmers.id, fullname, username, ccm_cereals.grain  \n"

                . "FROM ccm_bookings \n"

                . "JOIN ccm_farmers\n"

                . "ON ccm_bookings.booked_by = ccm_farmers.id\n"

                . "JOIN ccm_cereals\n"

                . "ON ccm_bookings.product_to_deliver = ccm_cereals.id\n"

                . "WHERE ccm_bookings.approved = ?";

              if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("i", $param_approved);

                $param_approved = 1;

                if ($stmt->execute()) {
                  $result = $stmt->get_result();

                  if ($result->num_rows > 0) {
                    echo "<div class='table-responsive'>";
                    echo "<table class='table table-bordered table-sm'>";
                    echo "<thead class='text-secondary'>";
                    echo "<tr>";
                    echo "<th scope='col'>#</th>
                          <th scope='col'>Full Name</th>
                          <th scope='col'>User name</th>
                          <th scope='col'>Delivering</th>
                          <th scope='col'>Quantity (Kgs)</th>
                          <th scope='col'>Approved on</th>
                          <th scope='col'>To Deliver on</th>
                          ";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";

                    $n = 1;

                    while ($row = $result->fetch_array()) {
                      echo "<tr>";
                      echo "<td>" . $n . "</td>";
                      echo "<td>" . $row['fullname'] . "</td>";
                      echo "<td>" . $row['username'] . "</td>";
                      echo "<td>" . $row['grain'] . "</td>";
                      echo "<td>" . $row['quantity_to_deliver'] . "</td>";
                      echo "<td>" . date('M-d-Y', strtotime($row['approved_on'])) . "</td>";
                      echo "<td>" . date('M-d-Y', strtotime($row['delivery_date'])) . "</td>";

                      echo "</tr>";

                      $n++;
                    }
                    echo "</tbody></table>";
                    echo "</div>";
                  } else {
                    echo "<p class='card-text'>No Scheduled Bookings yet.</p>";
                  }
                }
              }
              $stmt->close();
              ?>
              </div>
            </div>
          </div>

          <!-- Pie Chart -->
          <div class="col-lg-3">
            <div class="card shadow mb-4">
              <!-- Card Header - Dropdown -->
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-dark">Bookings' Stats</h6>
              </div>
              <!-- Card Body -->
              <div class="card-body">
                <div class="d-flex justify-content-around">
                  <span class="badge badge-pill badge-success p-4 rounded-circle">
                    <?php
                  $sql = "SELECT COUNT(id) FROM ccm_bookings WHERE approved = ?";

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
                  $sql = "SELECT COUNT(id) FROM ccm_bookings WHERE approved = ?";

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
                    <i class="fa fa-circle text-success"></i> Scheduled Deliveries
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
