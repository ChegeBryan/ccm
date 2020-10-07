<?php

session_start();

if (isset($_SESSION["admin_logged_In"]) || $_SESSION["admin_logged_in"] !== true) {
  header("location: login.php");
  exit;
}

require_once '../includes/config.php';

$county = "";
$county_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (empty(trim($_POST["county"]))) {
    $county_err = "Please enter county name.";
  } else {
    $sql = "SELECT id FROM ccm_counties WHERE county = ?";

    if ($stmt = $conn->prepare($sql)) {
      $stmt->bind_param("s", $param_county);
      $param_county = trim($_POST["county"]);

      if ($stmt->execute()) {
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
          $county_err = "This county name is already taken.";
        } else {
          $county = trim($_POST["county"]);
        }
      } else {
        echo "Oops! Something went wrong. Please try again later.";
      }
      $stmt->close();
    }
  }
  if (empty($county_err)) {
    $sql = "INSERT INTO ccm_counties (county) VALUES (?)";

    if ($stmt = $conn->prepare($sql)) {
      $stmt->bind_param("s", $param_county);

      $param_county = $county;

      if ($stmt->execute()) {
        header("location: county.php?admin=" . $_GET["admin"]);
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
    <title>Counties</title>
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
          <h1 class="h3 mb-0 text-secondary">Counties</h1>
        </div>

        <?php include 'summary.php'; ?>

        <div class="row">

          <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Registered Counties</h6>
              </div>
              <div class="card-body">
                <?php
              if (isset($_SESSION["success_message"])) {
                echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>";
                echo $_SESSION["success_message"];
                echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                unset($_SESSION["success_message"]);
              } elseif (isset($_SESSION["error_message"])) {
                echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>";
                echo $_SESSION["error_message"];
                echo "<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                unset($_SESSION["error_message"]);
              }
              ?>

                <?php
              $sql = "SELECT id, county FROM ccm_counties";

              if ($result = $conn->query($sql)) {
                echo "<div class='table-responsive'>";
                echo "<table class='table table-bordered table-sm'>";
                echo "<thead class='text-secondary'>";
                echo "<tr>";
                echo "<th scope='col'>#</th><th scope='col'>County</th><th scope='col'>Actions</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                $n = 1;

                while ($row = $result->fetch_array()) {
                  echo "<tr>";
                  echo "<td>" . $n . "</td>";
                  echo "<td>" . $row['county'] . "</td>";
                  echo "<td class='d-flex justify-content-around'>
                  <a href='edit_county.php?admin=" . $_SESSION['admin_id'] . "&county=" . $row['id'] . "' class='btn btn-info btn-sm'><i class='fa fa-fw fa-edit'></i> Edit</a>
                  <a href='delete_county.php?admin=" . $_SESSION['admin_id'] . "&county=" . $row['id'] . "' class='btn btn-danger btn-sm'><i class='fa fa-fw fa-trash'></i> Delete</a></td>";
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
                <h6 class="m-0 font-weight-bold text-primary">Register new county</h6>
              </div>
              <!-- Card Body -->
              <div class="card-body">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?admin=" . $_GET["admin"]; ?>"
                      method="POST" class="needs-validation" novalidate>
                  <div class="form-group <?php echo (!empty($county_err)) ? 'has-error' : ''; ?>">
                    <label for="county" class="text-secondary">County Name</label>
                    <input type="text" class="form-control" id="county" placeholder="County name" name="county"
                           required>
                    <span class="form-text text-danger"><small><?php echo $county_err; ?></small></span>
                  </div>
                  <button class="btn btn-primary text-capitalize btn-block">Add County</button>
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
