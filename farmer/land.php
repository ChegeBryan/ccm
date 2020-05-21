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
          <h1 class="h3 mb-0 text-secondary">Land information</h1>
        </div>

        <!-- Content Row -->
        <?php include 'summary.php'; ?>
        <!-- Content Row -->

        <div class="row">
          <!-- Area Chart -->
          <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-success">Land Use Distribution</h6>
              </div>

              <div class="card-body">
                <div class="d-flex justify-content-around">

                  <?php include 'land_use.php'; ?>

                  <span class="badge badge-pill badge-primary p-4 rounded-circle"><?php echo $maize; ?> Acres</span>
                  <span class="badge badge-pill badge-secondary p-4 rounded-circle"><?php echo $wheat; ?> Acres</span>
                  <span class="badge badge-pill badge-success p-4 rounded-circle"><?php echo $millet; ?> Acres</span>
                  <span class="badge badge-pill badge-warning p-4 rounded-circle"><?php echo $sorghum; ?> Acres</span>
                  <span class="badge badge-pill badge-info p-4 rounded-circle"><?php echo $beans; ?> Acres</span>
                  <span class="badge badge-pill badge-dark p-4 rounded-circle"><?php echo $rice; ?> Acres</span>
                </div>

                <div class="mt-4 text-center small">
                  <span class="mr-2">
                    <i class="fa fa-circle text-primary"></i> Maize
                  </span>
                  <span class="mr-2">
                    <i class="fa fa-circle text-secondary"></i> Wheat
                  </span>
                  <span class="mr-2">
                    <i class="fa fa-circle text-success"></i> Millet
                  </span>
                  <span class="mr-2">
                    <i class="fa fa-circle text-warning"></i> Sorghums
                  </span>
                  <span class="mr-2">
                    <i class="fa fa-circle text-info"></i> Beans
                  </span>
                  <span class="mr-2">
                    <i class="fa fa-circle text-dark"></i> Rice
                  </span>
                </div>

              </div>

            </div>
          </div>

          <!-- Pie Chart -->
          <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
              <!-- Card Header - Dropdown -->
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-success">Add land information</h6>
              </div>
              <!-- Card Body -->
              <div class="card-body">
                <form action="<?php echo "add_land.php?farmer=" . $_GET["farmer"]; ?>" method="POST">
                  <div class="form-group">
                    <label for="land_size" class="text-secondary">Land size (Acres)</label>
                    <input type="number" class="form-control" id="land_size" placeholder="Land Size" name="land_size"
                           min="0" required>
                    <span class="form-text"><small></small></span>
                  </div>
                  <div class="form-group">
                    <label for="cereal" class="text-secondary">Cereal Planted</label>
                    <select class="custom-select" id="cereal" name="cereal" required>
                      <option selected disabled value="">Land used for..</option>
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
                  <button class="btn btn-success text-capitalize btn-block">Add land</button>
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
  </body>

</html>
