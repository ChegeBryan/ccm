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
    $county_err = "Please enter a County name.";
  } else {
    $sql = "SELECT id FROM ccm_counties WHERE county = ?";

    if ($stmt = $conn->prepare($sql)) {
      $stmt->bind_param("s", $param_county);
      $param_county = trim($_POST["county"]);

      if ($stmt->execute()) {
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
          $stmt->bind_result($id);

          if ($stmt->fetch()) {
            if ($id != $_GET["county"]) {
              $county_err = $param_county . " exists.";
            } else {
              $county = trim($_POST["county"]);
            }
          }
        }
      } else {
        $_SESSION["error_message"] = "Something went wrong. County name not updated.";
        header("location: county.php?admin=" . $_SESSION["admin_id"]);
      }
      $stmt->close();
    }
  }

  if (empty($county_err)) {

    $sql = "UPDATE ccm_counties SET county = ? WHERE id = ?";

    if ($stmt = $conn->prepare($sql)) {
      $stmt->bind_param("si", $param_county, $param_id);

      $param_county = trim($_POST["county"]);
      $param_id = $_GET["county"];

      if ($stmt->execute()) {
        $_SESSION["success_message"] = "County name updated.";
        header("location: county.php?admin=" . $_SESSION["admin_id"]);
      } else {
        $_SESSION["error_message"] = "Something went wrong. County name not updated.";
        header("location: county.php?admin=" . $_SESSION["admin_id"]);
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
          <h1 class="h3 mb-0 text-secondary">Edit County</h1>
        </div>

        <?php include 'summary.php'; ?>

        <div class="d-flex justify-content-center mt-3">

          <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Update County</h6>
              </div>
              <div class="card-body">
                <?php
              $sql = "SELECT id, county FROM ccm_counties WHERE id=?";

              if ($stmt = $conn->prepare($sql)) {

                $stmt->bind_param("i", $param_id);
                $param_id = trim($_GET["county"]);
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
                <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?county=" . $_GET["county"]; ?>
                      method="POST" class="needs-validation" novalidate>
                  <div class="form-group <?php echo (!empty($county_err)) ? 'has-error' : ''; ?>">
                    <label for="county" class="text-secondary">County Name</label>
                    <input type="text" class="form-control" id="county" placeholder="County name" name="county"
                           value="<?php echo $row['county']; ?>" required>
                    <span class="form-text text-danger"><small><?php echo $county_err; ?></small></span>
                  </div>
                  <button class=" btn btn-primary text-capitalize btn-block">Update</button>
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
