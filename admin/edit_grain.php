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
    <title>Cereals and Grains</title>
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
          <h1 class="h3 mb-0 text-secondary">Edit Grain Details</h1>
        </div>

        <?php include 'summary.php'; ?>

        <div class="d-flex justify-content-center mt-3">

          <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Update Grain Cost</h6>
              </div>
              <div class="card-body">
                <?php
              $sql = "SELECT id, grain, cost FROM ccm_cereals WHERE id=?";

              if ($stmt = $conn->prepare($sql)) {

                $stmt->bind_param("i", $param_id);
                $param_id = trim($_GET["grain"]);
                if ($stmt->execute()) {
                  $result = $stmt->get_result();

                  if ($result->num_rows == 1) {
                    $row = $result->fetch_array(MYSQLI_ASSOC);
                  } else {
                    echo "Please login to update details.";
                    exit();
                  }
                } else {
                  header('location: ../error.php');
                }
              }
              ?>
                <!-- Card Body -->
                <form action="<?php echo "update_grain.php?" . "grain=" . $row["id"]; ?>" method="POST"
                      class="needs-validation" novalidate>
                  <div class="form-group">
                    <label for="grain" class="text-secondary">Cereal / Grain</label>
                    <input type="text" class="form-control" id="grain" placeholder="Name" name="grain"
                           value="<?php echo $row["grain"] ?>" disabled>
                  </div>
                  <div class="form-group">
                    <label for="cost" class="text-secondary">Cost <small class="text-secondary">/ Kg</small></label>
                    <input type="number" class="form-control" id="cost" placeholder="Ksh." name="cost" min="1"
                           value="<?php echo $row["cost"]; ?>" required>
                  </div>
                  <button class="btn btn-primary text-capitalize btn-block">Update</button>
                </form>
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
    <script src="../js/deny_resubmission.js"></script>

    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/bootstrap-4.4.1-dist/js/bootstrap.min.js"></script>
  </body>

</html>
