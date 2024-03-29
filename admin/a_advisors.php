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
    <title>Approved Advisors Profiles</title>
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
          <h1 class="h3 mb-0 text-secondary">Advisors Profiles</h1>
        </div>

        <?php include 'summary.php'; ?>

        <div class="row">

          <!-- Area Chart -->
          <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Approved Advisors</h6>
                <a href="../reports/registered_advisors.php" class="btn btn-sm btn-primary pull-right" target="_blank"
                   download><i class="fa fa-download fa-fw"></i>Generate
                  Report</a>
              </div>

              <div class="card-body">
                <?php
              $sql = "SELECT ccm_advisors.id As advisor, fullname, username\n"

                . "FROM ccm_advisors \n"

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
                      echo "<td><a class='btn btn-primary btn-sm' href='a_advisors.php?admin=" . $_GET['admin'] . "&advisor=" . $row['advisor'] . "&name=" . $row['fullname'] . "'>View Activities</a></td>";
                      echo "</tr>";

                      $n++;
                    }
                    echo "</tbody></table>";
                    echo "</div>";
                  } else {
                    echo "<p class='card-text'>No Advisors registered / Approved yet.</p>";
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
                <h6 class="m-0 font-weight-bold text-primary">Advisor Activities</h6>
              </div>
              <!-- Card Body -->
              <div class="card-body">
                <?php
              $sql = "SELECT COUNT(DISTINCT ccm_replies.question) FROM ccm_replies WHERE ccm_replies.replied_by = ?\n"

                . "UNION ALL\n"

                . "SELECT COUNT(ccm_alerts.id) FROM ccm_alerts WHERE ccm_alerts.made_by = ?\n"

                . "UNION ALL\n"

                . "SELECT COUNT(ccm_complaints.id) FROM ccm_complaints WHERE ccm_complaints.handled_by = ?";


              if (isset($_GET['advisor'])) {
                if ($stmt = $conn->prepare($sql)) {
                  $stmt->bind_param("iii", $param_advisor, $param_advisor, $param_advisor);

                  $param_advisor = $_GET['advisor'];

                  if ($stmt->execute()) {
                    $result = $stmt->get_result();

                    echo "<p class='card-text text-secondary mb-2'>Viewing number of questions answered, complaints handled and alerts created by: " . $_GET['name'] . "</p>";

                    $res = array();

                    while ($row =  $result->fetch_array(MYSQLI_NUM)) {
                      foreach ($row as $r) {
                        array_push($res, $r);
                      }
                    }
                    echo "<div class='d-flex justify-content-around'>";
                    echo "<span class='badge badge-pill badge-success p-4 rounded-circle'>" . $res[0] . "</span>";
                    echo "<span class='badge badge-pill badge-danger p-4 rounded-circle'>" . $res[1] . "</span>";
                    echo "<span class='badge badge-pill badge-warning p-4 rounded-circle'>" . $res[2] . "</span>";
                    echo "</div>";

                    echo "<div class='mt-4 text-center small'>";
                    echo "<span class='mr-2'>";
                    echo "<i class='fa fa-circle text-success'></i> Questions";
                    echo "</span>";
                    echo "<span class='mr-2'>";
                    echo "<i class='fa fa-circle text-danger'></i> Alerts";
                    echo "</span>";
                    echo "<span class='mr-2'>";
                    echo "<i class='fa fa-circle text-warning'></i> Complaints";
                    echo "</span>";
                    echo "</div>";
                  }
                }
                $stmt->close();
              } else {
                echo "<p class='card-text text-muted'>Select Advisor view activities.</p>";
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
