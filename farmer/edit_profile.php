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
          <h1 class="h3 mb-0 text-secondary">Edit Profile</h1>
        </div>

        <!-- Content Row -->
        <?php include 'summary.php'; ?>
        <!-- Content Row -->

        <div class="row">
          <!-- Area Chart -->
          <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-success">Edit Profile</h6>
              </div>

              <div class="card-body">
                <div class="row">
                  <?php
                $sql = "SELECT * FROM ccm_farmers WHERE id = ?";
                if ($stmt = $conn->prepare($sql)) {

                  $stmt->bind_param("i", $param_id);
                  $param_id = trim($_GET["farmer"]);
                  if ($stmt->execute()) {
                    $result = $stmt->get_result();

                    if ($result->num_rows == 1) {
                      $row = $result->fetch_array(MYSQLI_ASSOC);
                    } else {
                      echo "Please login to edit farmer profile.";
                      exit();
                    }
                  } else {
                    header('location: ../error.php');
                  }
                }
                ?>
                  <div class="col-4">
                    <img src="<?php echo $row["pic"]; ?>" class="mr-3 w-100 border rounded-circle border-success"
                         alt="Profile Image">
                    <p class="text-muted p-1">Upload a different image</p>
                    <form action="<?php echo "change_pic.php?farmer=" . $_GET['farmer']; ?>" method="POST"
                          enctype="multipart/form-data">
                      <div class="custom-file mb-3 <?php echo (!empty($uploadError)) ? 'has-error' : ''; ?>">
                        <input type="file" class="custom-file-input form-control-sm" id="fileToUpload"
                               name="fileToUpload" required>
                        <label class="custom-file-label" for="pic">Choose file...</label>
                        <span class="form-text text-danger text"><small></small></span>
                      </div>
                      <button class="btn btn-success btn-sm" type="submit">Change image</button>
                    </form>
                  </div>

                  <div class="col-8">

                    <form action="<?php echo "update_profile.php?farmer=" . $_GET['farmer']; ?>" method="POST">
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="fullname">Full Name</label>
                          <input type="text" class="form-control" id="fullname" name="fullname"
                                 value="<?php echo $row["fullname"]; ?>" required>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="username">Username</label>
                          <input type="text" class="form-control" id="username" name="username"
                                 value="<?php echo $row["username"]; ?>" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="id_number">National ID</label>
                        <input type="text" class="form-control" id="id_number" placeholder="National ID number"
                               name="id_number" value="<?php echo $row["national_id"]; ?>" disabled>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="email">Email</label>
                          <input type="email" class="form-control" id="email" name="email"
                                 value="<?php echo $row["email"]; ?>" required>
                        </div>
                        <div class="form-group col-md-6">
                          <label for="mobile_number">Mobile Number</label>
                          <input type="text" class="form-control" id="mobile_number" name="mobile_number"
                                 value="<?php echo $row["mobile_number"]; ?>" required>
                        </div>
                      </div>
                      <button type="submit" class="btn btn-success">Edit Profile</button>
                    </form>

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
                <h6 class="m-0 font-weight-bold text-success">Change Password</h6>
              </div>
              <!-- Card Body -->
              <div class="card-body">
                <form action="<?php echo "change_password.php?farmer=" . $_GET["farmer"]; ?>" method="POST"
                      class="needs-validation" novalidate>
                  <div
                       class="form-group <?php echo (isset($_SESSION["new_password_err"]) && !empty($_SESSION["new_password_err"])) ? 'has-error' : ''; ?>">
                    <label for="psw" class="text-secondary">New Password</label>
                    <input type="password" class="form-control" placeholder="Enter new password" name="new_psw"
                           value="<?php echo isset($_SESSION["new_password"]) ? $_SESSION["new_password"] : ""; ?>"
                           required>
                    <span
                          class="form-text text-danger"><small><?php echo isset($_SESSION["new_password_err"]) ? $_SESSION["new_password_err"] : ""; ?></small></span>
                  </div>
                  <div class="form-group">
                    <label for="psw"
                           class="text-secondary <?php echo (isset($_SESSION["confirm_password_err"]) && !empty($_SESSION["confirm_password_err"])) ? 'has-error' : ''; ?>">Confirm
                      New Password</label>
                    <input type="password" class="form-control" placeholder="Confirm Password" name="psw_rpt" required>
                    <span
                          class="form-text text-danger"><small><?php echo isset($_SESSION["confirm_password_err"]) ? $_SESSION["confirm_password_err"] : ""; ?></small></span>
                  </div>
                  <button class="btn btn-success">Reset Password</button>
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
