<?php


session_start();

if (isset($_SESSION["farmer_logged_In"]) || $_SESSION["farmer_logged_in"] !== true) {
  header("location: login.php");
  exit;
}

if (!isset($_SESSION["farmer_approved_status"]) || $_SESSION["farmer_approved_status"] == 0) {
  header("location: not_approved.php?farmer=" . $_SESSION['farmer_id']);
  exit;
}

require_once '../includes/config.php';
?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <title>Farmer Dashboard</title>
    <?php include '../head.php'; ?>
    <link rel="stylesheet" href="../css/dashboard.css">
  </head>

  <body>

    <div class="d-flex">
      <?php include 'menu.php' ?>
      <!-- Begin Page Content -->
      <div class="container-fluid pt-9">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h1 class="h3 mb-0 text-secondary">Booking information</h1>
        </div>


        <?php include 'summary.php'; ?>

        <div class="row">
          <!-- Area Chart -->
          <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-success">CCM Appointment Booking</h6>
              </div>

              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered">
                    <thead class="text-secondary">
                      <tr>
                        <th>Farm input</th>
                        <th>Quantity (Kgs)</th>
                        <th>Amount to pay (Ksh.)</th>
                        <th>Booked on</th>
                        <th>Pick up Date</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                    $sql = "SELECT ccm_farm_inputs.farm_input, quantity, pick_date, made_on, total_cost
                    FROM ccm_appointments
                    JOIN ccm_farm_inputs
                    ON ccm_appointments.farm_input=ccm_farm_inputs.id
                    WHERE ccm_appointments.made_by=? AND paid = ?
                    ORDER BY ccm_appointments.id DESC";

                    if ($stmt = $conn->prepare($sql)) {
                      $stmt->bind_param("ii", $param_farmer, $param_paid);

                      $param_farmer = $_GET["farmer"];
                      $param_paid = 0;

                      if ($stmt->execute()) {
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                          while ($row = $result->fetch_array()) {
                            echo "<tr>";
                            echo "<td>" . $row["farm_input"] . "</td>";
                            echo "<td>" . $row['quantity'] . "</td>";
                            echo "<td align='right'>" . number_format($row['total_cost'], 2) . "</td>";
                            echo "<td>" . date_format(date_create($row['made_on']), "d-M-Y") . "</td>";
                            echo "<td>" . date_format(date_create($row['pick_date']), "d-M-Y") . "</td>";
                            echo "</tr>";
                          }
                        } else {
                          echo "<tr><td colspan='5'>No Bookings yet to be made.</td></tr>";
                        }
                      }
                      $stmt->close();
                    }
                    ?>
                    </tbody>
                  </table>
                </div>
              </div>

            </div>
          </div>

          <!-- Pie Chart -->
          <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
              <!-- Card Header - Dropdown -->
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-success">Make farm input Appointment</h6>
              </div>
              <!-- Card Body -->
              <div class="card-body">
                <form action="<?php echo "book_appointment.php?farmer=" . $_GET["farmer"]; ?>" method="POST"
                      class="needs-validation" novalidate>
                  <div class="form-group">
                    <label for="farm_input" class="text-secondary">Farm input to pick</label>
                    <select class="custom-select" id="farm_input" name="farm_input" required>
                      <option selected disabled value="">Select Farm input to pick</option>
                      <?php

                    $sql = "SELECT id, farm_input FROM ccm_farm_inputs";

                    if ($result = $conn->query($sql)) {
                      if ($result->num_rows > 0) {
                        while ($row = $result->fetch_array()) {
                          echo "<option value=" . $row['id'] . ">" . $row['farm_input'] . "</option>";
                        }
                        $result->free();
                      } else {
                        echo "<option disabled value=''>No Farm inputs available.</option>";
                      }
                    }
                    ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="quantity" class="text-secondary">Quantity to pick (Kgs)</label>
                    <input type="number" class="form-control" id="quantity" placeholder="Quantity to pick"
                           name="quantity" min="1" required>
                    <span class="form-text text-danger"><small></small></span>
                  </div>

                  <div class="form-group">
                    <label for="p_date" class="text-secondary">Pickup date</label>
                    <input type="date" class="form-control" id="p_date" name="p_date"
                           min="<?php echo date("Y-m-d", strtotime("tomorrow")); ?>" onkeydown="return false" required>
                    <span class="form-text text-danger"><small></small></span>
                  </div>


                  <button class="btn btn-success text-capitalize btn-block">Make booking</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /.container-fluid -->

    </div>
    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="logout.php">Logout</a>
          </div>
        </div>
      </div>
    </div>


    <script src="../assets/js/jquery.min.js"></script>

    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/bootstrap-4.4.1-dist/js/bootstrap.min.js"></script>
    <script src="../js/validate_form.js"></script>
  </body>

</html>
