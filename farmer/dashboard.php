<?php


session_start();

if (isset($_SESSION["farmer_logged_In"]) || $_SESSION["farmer_logged_in"] !== true) {
  header("location: login.php");
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

      <?php include 'menu.php'; ?>

      <!-- Begin Page Content -->
      <div class="container-fluid pt-9">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h1 class="h3 mb-0 text-secondary">Dashboard</h1>
        </div>

        <!-- Summary Row -->
        <?php include 'summary.php'; ?>
        <!-- Summary Row -->

        <div class="row">

          <!-- Area Chart -->
          <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-success">My Profile</h6>
              </div>

              <div class="card-body">
                <?php
              $sql = "SELECT fullname, username, mobile_number, national_id, email, county, pic
              FROM ccm_farmers
              JOIN ccm_counties
              ON ccm_farmers.location=ccm_counties.id
              WHERE ccm_farmers.id = ?";
              if ($stmt = $conn->prepare($sql)) {

                $stmt->bind_param("i", $param_id);
                $param_id = trim($_GET["farmer"]);
                if ($stmt->execute()) {
                  $result = $stmt->get_result();

                  if ($result->num_rows == 1) {
                    $row = $result->fetch_array(MYSQLI_ASSOC);
                  } else {
                    echo "Something went wrong.";
                    exit();
                  }
                } else {
                  header('location: ../error.php');
                }
              }
              ?>
                <div class="media">
                  <img src="<?php echo $row['pic']; ?>" class="align-self-center mr-3 w-25 rounded-circle"
                       alt="Profile Image">
                  <div class="media-body">
                    <div class="table-responsive">
                      <table class="table table-sm">
                        <tr>
                          <th>Full Name</th>
                          <td><?php echo $row['fullname']; ?>
                          </td>
                        </tr>
                        <tr>
                          <th>User Name</th>
                          <td><?php echo $row['username']; ?>
                          </td>
                        </tr>
                        <tr>
                          <th>National id</th>
                          <td><?php echo $row['national_id']; ?>
                          </td>
                        </tr>
                        <tr>
                          <th>Mobile Number</th>
                          <td><?php echo $row['mobile_number']; ?>
                          </td>
                        </tr>
                        <tr>
                          <th>Email</th>
                          <td><?php echo $row['email']; ?>
                          </td>
                        </tr>
                        <tr>
                          <th>County</th>
                          <td><?php echo $row['county']; ?>
                          </td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>

          <!-- Pie Chart -->
          <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
              <!-- Card Header - Dropdown -->
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-success">Income & Expenditure</h6>
              </div>
              <!-- Card Body -->
              <div class="card-body">
                <?php
              $sql = "SELECT COUNT(ccm_farm_input_payments.id) \n"

                . "FROM ccm_appointments\n"

                . "JOIN ccm_farm_input_payments\n"

                . "ON ccm_appointments.id = ccm_farm_input_payments.paying_for \n"

                . "WHERE ccm_appointments.made_by = ?\n"

                . "UNION ALL\n"

                . "SELECT COALESCE(SUM(ccm_farm_input_payments.amount), 0) \n"

                . "FROM ccm_appointments\n"

                . "JOIN ccm_farm_input_payments\n"

                . "ON ccm_appointments.id = ccm_farm_input_payments.paying_for \n"

                . "WHERE ccm_appointments.made_by = ? \n"

                . "UNION ALL \n"

                . "SELECT COUNT(ccm_farm_produce_payments.id) \n"

                . "FROM ccm_bookings\n"

                . "JOIN ccm_farm_produce_payments\n"

                . "ON ccm_bookings.id=ccm_farm_produce_payments.paying_for \n"

                . "WHERE ccm_bookings.booked_by = ? \n"

                . "UNION ALL \n"

                . "SELECT COALESCE(SUM(ccm_farm_produce_payments.amount),0) \n"

                . "FROM ccm_bookings\n"

                . "JOIN ccm_farm_produce_payments\n"

                . "ON ccm_bookings.id=ccm_farm_produce_payments.paying_for \n"

                . "WHERE ccm_bookings.booked_by = ?";


              if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("iiii", $param_farmer, $param_farmer, $param_farmer, $param_farmer);

                $param_farmer = $_GET['farmer'];
                if ($stmt->execute()) {
                  $result = $stmt->get_result();

                  $res = array();


                  while ($row =  $result->fetch_array(MYSQLI_NUM)) {
                    foreach ($row as $r) {
                      array_push($res, $r);
                    }
                  }

                  echo "<h6 class='card-subtitle mb-2 text-muted'>Produce Payments</h6>";
                  echo "<div class='d-flex justify-content-around'>";
                  echo "<span class='badge badge-pill badge-success p-4 rounded-circle'>" . $res[2] . "</span>";
                  echo "<span class='badge badge-pill badge-danger p-4 rounded-circle'> Kshs. " . $res[3] . "</span>";
                  echo "</div>";

                  echo "<div class='mt-4 text-center small'>";
                  echo "<span class='mr-2'>";
                  echo "<i class='fa fa-circle text-success'></i> Payments Received.";
                  echo "</span>";
                  echo "<span class='mr-2'>";
                  echo "<i class='fa fa-circle text-danger'></i> Amount Paid";
                  echo "</span>";
                  echo "</div>";

                  echo "<h6 class='card-subtitle mt-3 text-muted'>Farm Input Payments</h6>";

                  echo "<div class='d-flex justify-content-around'>";
                  echo "<span class='badge badge-pill badge-success p-4 rounded-circle'>" . $res[0] . "</span>";
                  echo "<span class='badge badge-pill badge-danger p-4 rounded-circle'> Ksh. " . $res[1] . "</span>";
                  echo "</div>";

                  echo "<div class='mt-4 text-center small'>";
                  echo "<span class='mr-2'>";
                  echo "<i class='fa fa-circle text-success'></i> Payments Paid.";
                  echo "</span>";
                  echo "<span class='mr-2'>";
                  echo "<i class='fa fa-circle text-danger'></i> Amount Paid out";
                  echo "</span>";
                  echo "</div>";
                }
              }
              $stmt->close();

              ?>
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
  </body>

</html>
