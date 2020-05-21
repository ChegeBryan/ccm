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
          <h1 class="h3 mb-0 text-secondary">Produce Delivery</h1>
        </div>

        <!-- Content Row -->
        <?php include 'summary.php'; ?>

        <!-- Content Row -->

        <div class="row">
          <!-- Area Chart -->
          <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-success">Produce Delivery Booking</h6>
              </div>

              <div class="card-body">
                <div class="table-responsive">
                  <table class="table table-bordered">
                    <thead class="text-secondary">
                      <tr>
                        <th>Product</th>
                        <th>Quantity (Kgs)</th>
                        <th>Booked on</th>
                        <th>To Deliver On</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                    $sql = "SELECT grain, quantity_to_deliver, date_booked, delivery_date
                    FROM ccm_bookings
                    JOIN ccm_cereals
                    ON ccm_bookings.product_to_deliver=ccm_cereals.id
                    WHERE ccm_bookings.booked_by= ? AND paid = ?
                    ORDER BY ccm_bookings.id DESC";

                    if ($stmt = $conn->prepare($sql)) {
                      $stmt->bind_param("ii", $param_farmer, $param_paid);

                      $param_farmer = $_GET["farmer"];
                      $param_paid = 0;

                      if ($stmt->execute()) {
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                          while ($row = $result->fetch_array()) {
                            echo "<tr>";
                            echo "<td>" . $row["grain"] . "</td>";
                            echo "<td>" . $row['quantity_to_deliver'] . "</td>";
                            echo "<td>" . date_format(date_create($row['date_booked']), "d-M-Y") . "</td>";
                            echo "<td>" . date_format(date_create($row['delivery_date']), "d-M-Y") . "</td>";
                            echo "</tr>";
                          }
                        } else {
                          echo "<tr><td colspan='4'>No Bookings yet to be made.</td></tr>";
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
                <h6 class="m-0 font-weight-bold text-success">Make Delivery Booking</h6>
              </div>
              <!-- Card Body -->
              <div class="card-body">
                <form action="<?php echo "booking.php?farmer=" . $_GET["farmer"]; ?>" method="POST"
                      class="needs-validation" novalidate>
                  <div class="form-group">
                    <label for="product" class="text-secondary">Product</label>
                    <select class="custom-select" id="product" name="product" required>
                      <option selected disabled value="">Select Product to deliver</option>
                      <?php

                    $sql = "SELECT id, grain FROM ccm_cereals";

                    if ($result = $conn->query($sql)) {
                      if ($result->num_rows > 0) {
                        while ($row = $result->fetch_array()) {
                          echo "<option value=" . $row['id'] . ">" . $row['grain'] . "</option>";
                        }
                        $result->free();
                      } else {
                        echo "<option disabled value=''>No grain registered.</option>";
                      }
                    }
                    ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="quantity" class="text-secondary">Product Quantity (Kgs)</label>
                    <input type="number" class="form-control" id="quantity" placeholder="Quantity to deliver"
                           name="quantity" min="1" required>
                    <span class="form-text text-danger"><small></small></span>
                  </div>
                  <div class="form-group">
                    <label for="d_date" class="text-secondary">Date to make deliver</label>
                    <input type="date" class="form-control" id="d_date" placeholder="Quantity to deliver" name="d_date"
                           min="<?php echo date("Y-m-d"); ?>" onkeydown="return false" required>
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
