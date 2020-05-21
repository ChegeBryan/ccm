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
  <title>Admin - Edit Profile</title>
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

        <div class="col-md-4"></div>
        <div class="col-md-4">
          <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold text-primary">Change password</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
              <form action="<?php echo "change_password.php?admin=" . $_GET["admin"]; ?>" method="POST" class="needs-validation" novalidate>
                <div class="form-group <?php echo (isset($_SESSION["new_password_err"]) && !empty($_SESSION["new_password_err"])) ? 'has-error' : ''; ?>">
                  <label for="psw" class="text-secondary">New Password</label>
                  <input type="password" class="form-control" placeholder="Enter new password" name="new_psw" value="<?php echo isset($_SESSION["new_password"]) ? $_SESSION["new_password"] : ""; ?>" required>
                  <span class="form-text text-danger"><small><?php echo isset($_SESSION["new_password_err"]) ? $_SESSION["new_password_err"] : ""; ?></small></span>
                </div>
                <div class="form-group">
                  <label for="psw" class="text-secondary <?php echo (isset($_SESSION["confirm_password_err"]) && !empty($_SESSION["confirm_password_err"])) ? 'has-error' : ''; ?>">Confirm
                    New Password</label>
                  <input type="password" class="form-control" placeholder="Confirm Password" name="psw_rpt" required>
                  <span class="form-text text-danger"><small><?php echo isset($_SESSION["confirm_password_err"]) ? $_SESSION["confirm_password_err"] : ""; ?></small></span>
                </div>
                <button class="btn btn-block btn-primary">Reset Password</button>
              </form>
            </div>
          </div>
        </div>
        <div class="col-md-4"></div>
      </div>

    </div>
    <!-- /.container-fluid -->

  </div>

  <?php include '../logout_modal.php'; ?>

  <script src="../assets/js/jquery.min.js"></script>

  <script src="../assets/js/popper.min.js"></script>
  <script src="../assets/bootstrap-4.4.1-dist/js/bootstrap.min.js"></script>
  <script src="../js/validate_form.js"></script>
</body>

</html>
