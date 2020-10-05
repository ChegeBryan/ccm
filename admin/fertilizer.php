<?php

session_start();

if (isset($_SESSION["admin_logged_In"]) || $_SESSION["admin_logged_in"] !== true) {
  header("location: login.php");
  exit;
}

require_once '../includes/config.php';

$fertilizer = "";
$fertilizer_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (empty(trim($_POST["fertilizer"]))) {
    $fertilizer_err = "Please enter fertilizer name.";
  } else {
    $sql = "SELECT id FROM ccm_farm_inputs WHERE farm_input = ?";

    if ($stmt = $conn->prepare($sql)) {
      $stmt->bind_param("s", $param_fertilizer);
      $param_fertilizer = trim($_POST["fertilizer"]);

      if ($stmt->execute()) {
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
          $fertilizer_err = $param_fertilizer . " is already registered.";
        } else {
          $fertilizer = trim($_POST["fertilizer"]);
        }
      } else {
        echo "Oops! Something went wrong. Please try again later.";
      }
      $stmt->close();
    }
  }
  if (empty($fertilizer_err)) {
    $sql = "INSERT INTO ccm_farm_inputs (farm_input, cost) VALUES (?, ?)";

    if ($stmt = $conn->prepare($sql)) {
      $stmt->bind_param("sd", $param_fertilizer, $param_cost);

      $param_fertilizer = $fertilizer;
      $param_cost = $_POST["cost"];

      if ($stmt->execute()) {
        header("location: fertilizer.php?admin=" . $_GET["admin"]);
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
          <h1 class="h3 mb-0 text-secondary">Farm Inputs</h1>
        </div>

        <?php include 'summary.php'; ?>

        <div class="row">

          <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Farm Inputs</h6>
              </div>

              <div class="card-body">
                <?php
              $sql = "SELECT id, farm_input, cost FROM ccm_farm_inputs";

              if ($result = $conn->query($sql)) {
                echo "<div class='table-responsive'>";
                echo "<table class='table table-bordered table-sm'>";
                echo "<thead class='text-secondary'>";
                echo "<tr>";
                echo "<th scope='col'>#</th>";
                echo "<th scope='col'>Fertilizer</th>";
                echo "<th scope='col'>Cost per Kg (Ksh.)</th>";
                echo "<th>Actions</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                $n = 1;

                while ($row = $result->fetch_array()) {
                  echo "<tr>";
                  echo "<td>" . $n . "</td>";
                  echo "<td>" . $row['farm_input'] . "</td>";
                  echo "<td align='right'>" . $row['cost'] . "</td>";
                  echo "<td class='d-flex justify-content-around'>
                  <a href='edit_fertilizer.php?admin=" . $_GET['admin'] . "&fertilizer=" . $row['id'] . "' class='btn btn-info btn-sm'><i class='fa fa-fw fa-edit'></i></a>
                  <a href='delete_fertilizer.php?admin=" . $_GET['admin'] . "&fertilizer=" . $row['id'] . "' class='btn btn-danger btn-sm'><i class='fa fa-fw fa-trash'></i></a></td>";
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
                <h6 class="m-0 font-weight-bold text-primary">Register Fertilizer</h6>
              </div>
              <!-- Card Body -->
              <div class="card-body">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?admin=" . $_GET["admin"]; ?>"
                      method="POST" class="needs-validation" novalidate>
                  <div class="form-group <?php echo (!empty($fertilizer_err)) ? 'has-error' : ''; ?>">
                    <label for="fertilizer" class="text-secondary">Fertilizer Name</label>
                    <input type="text" class="form-control" id="fertilizer" placeholder="Name" name="fertilizer"
                           required>
                    <span class="form-text text-danger"><small><?php echo $fertilizer_err; ?></small></span>
                  </div>
                  <div class="form-group <?php echo (!empty($cost_err)) ? 'has-error' : ''; ?>">
                    <label for="cost" class="text-secondary">Cost <small class="text-secondary">/ Kg</small></label>
                    <input type="number" class="form-control" id="cost" placeholder="Ksh." name="cost" min="1" required>
                    <span class="form-text text-danger"><small><?php echo $cost_err; ?></small></span>
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
