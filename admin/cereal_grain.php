<?php

session_start();

if (isset($_SESSION["admin_logged_In"]) || $_SESSION["admin_logged_in"] !== true) {
  header("location: login.php");
  exit;
}

require_once '../includes/config.php';

$cereal = "";
$cereal_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (empty(trim($_POST["cereal"]))) {
    $cereal_err = "Please enter cereal or grain name.";
  } else {
    $sql = "SELECT id FROM ccm_cereals WHERE grain = ?";

    if ($stmt = $conn->prepare($sql)) {
      $stmt->bind_param("s", $param_cereal);
      $param_cereal = trim($_POST["cereal"]);

      if ($stmt->execute()) {
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
          $cereal_err = $param_cereal . " is already registered.";
        } else {
          $cereal = trim($_POST["cereal"]);
        }
      } else {
        echo "Oops! Something went wrong. Please try again later.";
      }
      $stmt->close();
    }
  }
  if (empty($cereal_err)) {
    $sql = "INSERT INTO ccm_cereals (grain, cost) VALUES (?, ?)";

    if ($stmt = $conn->prepare($sql)) {
      $stmt->bind_param("sd", $param_cereal, $param_cost);

      $param_cereal = $cereal;
      $param_cost = $_POST["cost"];

      if ($stmt->execute()) {
        header("location: cereal_grain.php?admin=" . $_GET["admin"]);
      } else {
        echo "Oops! Something went wrong. Please try again later.";
      }
      $stmt->close();
    }
  }
}
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
          <h1 class="h3 mb-0 text-secondary">Cereals and Grains</h1>
        </div>

        <?php include 'summary.php'; ?>

        <div class="row">

          <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Cereals and Grains</h6>
              </div>

              <div class="card-body">
                <?php
              $sql = "SELECT id, grain, cost FROM ccm_cereals";

              if ($result = $conn->query($sql)) {
                echo "<div class='table-responsive'>";
                echo "<table class='table table-bordered table-sm'>";
                echo "<thead class='text-secondary'>";
                echo "<tr>";
                echo "<th scope='col'>#</th>";
                echo "<th scope='col'>Cereal/Grain</th>";
                echo "<th scope='col'>Cost per Kg (Ksh.)</th>";
                echo "<th scope='col'>Actions</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                $n = 1;

                while ($row = $result->fetch_array()) {
                  echo "<tr>";
                  echo "<td>" . $n . "</td>";
                  echo "<td>" . $row['grain'] . "</td>";
                  echo "<td align='right'>" . number_format($row['cost'], 2) . "</td>";
                  echo "<td class='d-flex justify-content-center'>
                  <a href='edit_grain.php?admin=" . $_GET['admin'] . "&grain=" . $row['id'] . "' class='btn btn-info btn-sm'><i class='fa fa-fw fa-edit'></i></a></td>";
                  echo "</tr>";

                  $n++;
                }
                echo "</tbody></table>";
                echo "</div>";
              }
              $result->free();
              ?>
              </div>
            </div>
          </div>

          <!-- Pie Chart -->
          <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
              <!-- Card Header - Dropdown -->
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Register a Cereal / Grain</h6>
              </div>
              <!-- Card Body -->
              <div class="card-body">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?admin=" . $_GET["admin"]; ?>"
                      method="POST" class="needs-validation" novalidate>
                  <div class="form-group <?php echo (!empty($cereal_err)) ? 'has-error' : ''; ?>">
                    <label for="cereal" class="text-secondary">Cereal / Grain Name</label>
                    <input type="text" class="form-control" id="cereal" placeholder="Name" name="cereal" required>
                    <span class="form-text text-danger"><small><?php echo $cereal_err; ?></small></span>
                  </div>
                  <div class="form-group">
                    <label for="cost" class="text-secondary">Cost <small class="text-secondary">/ Kg</small></label>
                    <input type="number" class="form-control" id="cost" placeholder="Ksh." name="cost" min="1" required>
                  </div>
                  <button class="btn btn-primary text-capitalize btn-block">Save</button>
                </form>
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
