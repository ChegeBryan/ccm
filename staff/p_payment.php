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
    <title>Farmer Produce payments</title>
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
          <h1 class="h3 mb-0 text-secondary">Farmer Produce payments</h1>
        </div>

        <?php include 'summary.php'; ?>

        <div class="row">

          <!-- Area Chart -->
          <div class="col-lg-8">
            <div class="card shadow mb-4">
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-dark">Farmer Produces</h6>
              </div>

              <div class="card-body">
                <?php
              $sql = "SELECT ccm_bookings.id, quantity_to_deliver, date_booked, delivery_date, fullname, username, total_cost, national_id, ccm_cereals.grain  \n"

                . "FROM ccm_bookings \n"

                . "JOIN ccm_farmers\n"

                . "ON ccm_bookings.booked_by = ccm_farmers.id\n"

                . "JOIN ccm_cereals\n"

                . "ON ccm_bookings.product_to_deliver = ccm_cereals.id\n"

                . "WHERE ccm_bookings.approved = ? AND paid = ?";

              if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("ii", $param_approved, $param_paid);

                $param_approved = 1;
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
                          <th scope='col'>Delivering</th>
                          <th scope='col'>Quantity (Kgs)</th>
                          <th scope='col'>Total Payout (Ksh.)</th>
                          <th scope='col'>Delivered On</th>
                          <th scope='col'>Action</th>
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
                      echo "<td>" . $row['national_id'] . "</td>";
                      echo "<td>" . $row['grain'] . "</td>";
                      echo "<td>" . $row['quantity_to_deliver'] . "</td>";
                      echo "<td align='right'>" . number_format($row['total_cost'], 2) . "</td>";
                      echo "<td>" . date('M-d-Y', strtotime($row['delivery_date'])) . "</td>";
                      echo "<td><a class='btn btn-secondary text-white btn-sm' href='p_payment.php?staff=" . $_GET['staff'] .  "&booking=" . $row['id'] . "'>Payment</a></td>";


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
          <div class="col-lg-4">
            <div class="card shadow mb-4">
              <!-- Card Header - Dropdown -->
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-dark">Make Payment</h6>
              </div>
              <!-- Card Body -->
              <div class="card-body">
                <?php
              if (isset($_GET['booking'])) {

                $sql = "SELECT total_cost FROM ccm_bookings WHERE id=?";

                if ($stmt = $conn->prepare($sql)) {

                  $stmt->bind_param("i", $param_id);
                  $param_id = trim($_GET["booking"]);
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
                <form action="make_payment.php?staff={$_GET['staff']}&booking={$_GET['booking']}" method="POST"
                class="needs-validation" novalidate>
                <div class="form-group">
                  <label for="amount" class="text-secondary">Amount (Kshs.) to pay to farmer</label>
                  <input type="text" readonly class="form-control-plaintext" id="amount" name="amount" value="{$total}">
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
