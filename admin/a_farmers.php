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
    <title>Approved Farmers Profiles</title>
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
          <h1 class="h3 mb-0 text-secondary">Farmers Profiles</h1>

        </div>

        <?php include 'summary.php'; ?>

        <div class="row">

          <!-- Area Chart -->
          <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Approved Farmers</h6>
                <a href="../reports/registered_farmers.php" class="btn btn-sm btn-primary pull-right" target="_blank"
                   download><i class="fa fa-download fa-fw"></i>Generate
                  Report</a>
              </div>

              <div class="card-body">
                <?php
              $sql = "SELECT ccm_farmers.id, fullname,username, mobile_number, national_id, county \n"

                . "FROM ccm_farmers \n"

                . "JOIN ccm_counties\n"

                . "ON ccm_farmers.location = ccm_counties.id\n"

                . "WHERE approved = ?";

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
                          <th scope='col'>Mobile</th>
                          <th scope='col'>National Id</th>
                          <th scope='col'>County</th>
                          <th scope='col'>Land Utilization</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";

                    $n = 1;

                    while ($row = $result->fetch_array()) {
                      echo "<tr>";
                      echo "<td>" . $n . "</td>";
                      echo "<td>" . $row['fullname'] . "</td>";
                      echo "<td>" . $row['username'] . "</td>";
                      echo "<td>" . $row['mobile_number'] . "</td>";
                      echo "<td>" . $row['national_id'] . "</td>";
                      echo "<td>" . $row['county'] . "</td>";
                      echo "<td><a class='btn btn-primary btn-sm' href='a_farmers.php?admin=" . $_GET['admin'] . "&farmer=" . $row['id'] . "'>View</a></td>";
                      echo "</tr>";

                      $n++;
                    }
                    echo "</tbody></table>";
                    echo "</div>";
                  } else {
                    echo "<p class='card-text'>No farmers registered / Approved yet.</p>";
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
                <h6 class="m-0 font-weight-bold text-primary">Land Utilization</h6>
              </div>
              <!-- Card Body -->
              <div class="card-body">
                <?php
              $sql = "SELECT land_size, grain, fullname\n"

                . "FROM ccm_land \n"

                . "JOIN ccm_cereals \n"

                . "ON ccm_land.cereal = ccm_cereals.id \n"

                . "JOIN ccm_farmers \n"

                . "ON ccm_land.owner = ccm_farmers.id \n"

                . "WHERE ccm_land.owner = ?";

              if (isset($_GET['farmer'])) {
                if ($stmt = $conn->prepare($sql)) {
                  $stmt->bind_param("i", $param_owner);

                  $param_owner = $_GET['farmer'];

                  if ($stmt->execute()) {
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {

                      echo "<div class='table-responsive'>";
                      echo "<table class='table table-bordered table-sm'>";
                      echo "<thead class='text-secondary'>";
                      echo "<tr>";
                      echo "<th scope='col'>Land Size (Acres)</th>
                          <th scope='col'>Cereal Planted</th>";
                      echo "</tr>";
                      echo "</thead>";
                      echo "<tbody>";

                      $total = 0;
                      $user;

                      while ($row = $result->fetch_array()) {
                        $user = $row['fullname'];
                        echo "<tr>";
                        echo "<td>" . $row['land_size'] . "</td>";
                        echo "<td>" . $row['grain'] . "</td>";
                        echo "</tr>";
                        $total += $row['land_size'];
                      }
                      echo "<tr><td colspan='2' class='font-weight-bold'>Total Land Size &nbsp;&nbsp;" . $total . " Acres</td></tr>";
                      echo "</tbody></table>";
                      echo "</div>";
                      echo "<p class='card-text text-secondary'>Viewing land information for: " . $user . "</p>";
                    } else {
                      echo "<p class='card-text'>No Land Registered by farmer.</p>";
                    }
                  }
                }
                $stmt->close();
              } else {
                echo "<p class='card-text text-muted'>Select Farmer to view land.</p>";
              }
              ?>
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
