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
  <title>Approved Staff Profiles</title>
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
        <h1 class="h3 mb-0 text-secondary">Staff Profiles</h1>
      </div>

      <?php include 'summary.php'; ?>

      <div class="row">

        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-7">
          <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary">Approved Staff</h6>
            </div>

            <div class="card-body">
              <?php
              $sql = "SELECT ccm_staff.id As staff, fullname, username\n"

                . "FROM ccm_staff \n"

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
                          <th scope='col'>Actions</th>
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
                      echo "<td><a class='btn btn-primary btn-sm' href='a_staff.php?admin=" . $_GET['admin'] . "&staff=" . $row['staff'] . "&name=" . $row['fullname'] . "'>View Activities</a></td>";
                      echo "</tr>";

                      $n++;
                    }
                    echo "</tbody></table>";
                    echo "</div>";
                  } else {
                    echo "<p class='card-text'>No staff registered / Approved yet.</p>";
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
              <h6 class="m-0 font-weight-bold text-primary">Staff:
                <?php echo isset($_GET['name']) ? $_GET['name'] : ""; ?> Activities</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
              <?php
              $sql = "SELECT COUNT(ccm_farm_input_payments.id) FROM ccm_farm_input_payments WHERE ccm_farm_input_payments.staff = ?\n"

                . "UNION ALL\n"

                . "SELECT COALESCE(SUM(ccm_farm_input_payments.amount), 0) FROM ccm_farm_input_payments WHERE ccm_farm_input_payments.staff = ?\n"

                . "UNION ALL\n"

                . "SELECT COUNT(ccm_farm_produce_payments.id) FROM ccm_farm_produce_payments WHERE ccm_farm_produce_payments.staff = ?\n"

                . "UNION ALL\n"

                . "SELECT COALESCE(SUM(ccm_farm_produce_payments.amount),0) FROM ccm_farm_produce_payments WHERE ccm_farm_produce_payments.staff = ?";


              if (isset($_GET['staff'])) {
                if ($stmt = $conn->prepare($sql)) {
                  $stmt->bind_param("iiii", $param_staff, $param_staff, $param_staff, $param_staff);

                  $param_staff = $_GET['staff'];

                  if ($stmt->execute()) {
                    $result = $stmt->get_result();

                    $res = array();

                    while ($row =  $result->fetch_array(MYSQLI_NUM)) {
                      foreach ($row as $r) {
                        array_push($res, $r);
                      }
                    }

                    echo "<h6 class='card-subtitle mb-2 text-muted'>Farm Input Payments</h6>";

                    echo "<div class='d-flex justify-content-around'>";
                    echo "<span class='badge badge-pill badge-success p-4 rounded-circle'>" . $res[0] . "</span>";
                    echo "<span class='badge badge-pill badge-danger p-4 rounded-circle'> Ksh. " . $res[1] . "</span>";
                    echo "</div>";

                    echo "<div class='mt-4 text-center small'>";
                    echo "<span class='mr-2'>";
                    echo "<i class='fa fa-circle text-success'></i> Payments received.";
                    echo "</span>";
                    echo "<span class='mr-2'>";
                    echo "<i class='fa fa-circle text-danger'></i> Amount Received";
                    echo "</span>";
                    echo "</div>";


                    echo "<h6 class='card-subtitle mb-2 mt-3 text-muted'>Produce Payments</h6>";
                    echo "<div class='d-flex justify-content-around'>";
                    echo "<span class='badge badge-pill badge-success p-4 rounded-circle'>" . $res[2] . "</span>";
                    echo "<span class='badge badge-pill badge-danger p-4 rounded-circle'> Kshs. " . $res[3] . "</span>";
                    echo "</div>";

                    echo "<div class='mt-4 text-center small'>";
                    echo "<span class='mr-2'>";
                    echo "<i class='fa fa-circle text-success'></i> Payments Processed.";
                    echo "</span>";
                    echo "<span class='mr-2'>";
                    echo "<i class='fa fa-circle text-danger'></i> Amount Paid";
                    echo "</span>";
                    echo "</div>";
                  }
                }
                $stmt->close();
              } else {
                echo "<p class='card-text text-muted'>Select the Staff view activities.</p>";
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
