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
    <title>Farm Input Payments</title>
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
          <h1 class="h3 mb-0 text-secondary">Farm Input Payments</h1>
        </div>

        <?php include 'summary.php'; ?>

        <div class="row">

          <!-- Area Chart -->
          <div class="col-lg-8">
            <div class="card shadow mb-4">
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-dark">Payments Due</h6>
                <a href="../reports/farm_input_payments.php" class="btn btn-sm btn-secondary pull-right" target="_blank"
                   download><i class="fa fa-download fa-fw"></i>Payments Report</a>
              </div>

              <div class="card-body">
                <?php
              $sql = "SELECT ccm_appointments.id, quantity, total_cost, pick_date, confirmed_on, ccm_farmers.id AS farmer, fullname, username, national_id, ccm_farm_inputs.farm_input  \n"

                . "FROM ccm_appointments \n"

                . "JOIN ccm_farmers\n"

                . "ON ccm_appointments.made_by = ccm_farmers.id\n"

                . "JOIN ccm_farm_inputs\n"

                . "ON ccm_appointments.farm_input = ccm_farm_inputs.id\n"

                . "WHERE confirmed = ? AND paid = ?";

              if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("ii", $param_confirmed, $param_paid);

                $param_confirmed = 1;
                $param_paid = 0;

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
                          <th scope='col'>National Id No.</th>
                          <th scope='col'>Picked</th>
                          <th scope='col'>Quantity (Kgs)</th>
                          <th scope='col'>Cost (Ksh)</th>
                          <th scope='col'>Picked On</th>
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
                      echo "<td>" . $row['national_id'] . "</td>";
                      echo "<td>" . $row['farm_input'] . "</td>";
                      echo "<td>" . $row['quantity'] . "</td>";
                      echo "<td align='right'>" . number_format($row['total_cost'], 2) . "</td>";
                      echo "<td>" . date('M-d-Y', strtotime($row['pick_date'])) . "</td>";
                      echo "<td><a class='btn btn-secondary text-white btn-sm' href='i_payments.php?staff=" . $_GET['staff'] .  "&appointment=" . $row['id'] . "&farmer=" . $row['farmer'] . "'>Payment</a></td>";

                      echo "</tr>";

                      $n++;
                    }
                    echo "</tbody></table>";
                    echo "</div>";
                  } else {
                    echo "<p class='card-text'>No appointments made / scheduled yet.</p>";
                  }
                }
              }
              $stmt->close();
              ?>
              </div>
            </div>
          </div>

          <!-- Pie Chart -->
          <div class="col-lg-4">
            <div class="card shadow mb-4">
              <!-- Card Header - Dropdown -->
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-dark">Confirm Payment</h6>
              </div>
              <!-- Card Body -->
              <div class="card-body">
                <?php
              if (isset($_GET['appointment'])) {

                $sql = "SELECT total_cost FROM ccm_appointments WHERE id=?";

                if ($stmt = $conn->prepare($sql)) {

                  $stmt->bind_param("i", $param_id);
                  $param_id = trim($_GET["appointment"]);
                  if ($stmt->execute()) {
                    $result = $stmt->get_result();

                    if ($result->num_rows == 1) {
                      $row = $result->fetch_array(MYSQLI_ASSOC);
                      $total = "Ksh. " . number_format($row['total_cost'], 2);
                    } else {
                      echo "Please login to update details.";
                      exit();
                    }
                  } else {
                    header('location: ../error.php');
                  }
                }

                echo <<<EOT
                       <form
                       action="receive_payment.php?staff={$_GET['staff']}&appointment={$_GET['appointment']}&farmer={$_GET['farmer']}"
                       method="POST"
                       class="needs-validation" novalidate>
                  <div class="form-group">
                    <label for="amount" class="text-secondary">Confirm payment of the following amount (Kshs.)</label>
                    <input type="text" readonly class="form-control-plaintext" id="amount"
                           value="{$total}">
                    <span class="form-text"><small></small></span>
                  </div>
                  <div class="form-group">
                    <label for="cereal" class="text-secondary">Mode of Payment</label>
                    <select class="custom-select" id="mode" name="mode" required>
                      <option selected disabled value="">Payment received through...</option>
                      <option value="Cash">Cash</option>
                      <option value="M-Pesa">M-Pesa</option>
                      <option value="Bank Deposit">Bank Deposit</option>
                    </select>
                  </div>
                  <button class="btn btn-secondary text-white text-capitalize btn-block">Record Payment</button>
                  </form>
                  EOT;
              } else {
                echo "<p class='card-text'>Select payment to process.</p>";
              }
              ?>
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
    <script src="../js/validate_form.js"></script>
    <script src="../js/deny_resbumission.js"></script>
  </body>

</html>
