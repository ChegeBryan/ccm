<?php

session_start();

if (isset($_SESSION["staff_logged_in"]) && $_SESSION["staff_logged_in"] === true) {
  header("location: dashboard.php?staff=" . $_SESSION['staff_id']);
  exit;
}

require_once "../includes/config.php";

$username = $password = "";
$username_err = $password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (empty(trim($_POST["username"]))) {
    $username_err = "Please enter username.";
  } else {
    $username = trim($_POST["username"]);
  }

  if (empty(trim($_POST["password"]))) {
    $password_err = "Please enter your password.";
  } else {
    $password = trim($_POST["password"]);
  }

  if (empty($username_err) && empty($password_err)) {
    $sql = "SELECT id, fullname, username, password, approved FROM ccm_staff WHERE username = ?";

    if ($stmt = $conn->prepare($sql)) {

      $stmt->bind_param("s", $param_username);
      $param_username = $username;
      if ($stmt->execute()) {
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
          $stmt->bind_result($id, $name, $username, $hashed_password, $approved);

          if ($stmt->fetch()) {
            if (password_verify($password, $hashed_password)) {

              $_SESSION["staff_logged_in"] = true;
              $_SESSION["staff_id"] = $id;
              $_SESSION["staff_fullname"] = $name;
              $_SESSION["staff_uname"] = $username;
              $_SESSION["staff_approved_status"] = $approved;

              header("location: dashboard.php?staff=" . $_SESSION['staff_id']);
            } else {
              $password_err = "The password you entered was not valid.";
            }
          }
        } else {
          $username_err = "No account found with that username.";
        }
      } else {
        header("location: ../error.php");
      }
      $stmt->close();
    }
  }
  $conn->close();
}
?>

<!DOCTYPE html>
<html>

  <head>
    <?php include '../head.php'; ?>
    <title>Staff | Login</title>

  </head>

  <body>

    <nav class="navbar navbar-expand navbar-light bg-white mb-4 shadow">

      <a class="navbar-brand text-secondary" href="../index.php">CCM</a>

      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link text-text-secondary" href="signup.php">Sign Up</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-text-secondary" href="../index.php">Home</a>
        </li>
      </ul>
    </nav>

    <div class="container d-flex justify-content-center mt-5">
      <div class="card p-4 shadow-lg" style="width: 400px;">
        <h4>Staff login</h4>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="needs-validation" method="POST"
              novalidate>
          <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
            <label for="uname" class="text-muted"><b>Username</b></label>
            <input type="text" class="form-control" id="uname" placeholder="Enter username" name="username"
                   value="<?php echo $username; ?>" required>
            <span class="form-text text-danger"><small><?php echo $username_err; ?></small></span>
          </div>
          <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
            <label for=" psw" class="text-muted"><b>Password</b></label>
            <input type="password" class="form-control" id="psw" placeholder="Enter password" name="password" required>
            <span class="form-text text-danger"><small><?php echo $password_err; ?></small></span>
          </div>
          <button type="submit" class="btn btn-secondary text-white btn-block">Submit</button>
          <p class="pt-1">Forgot password? <a href="../passwordRecovery/send_email.php" class="">Reset</a></p>
        </form>
      </div>
    </div>


    <script src="../assets/js/jquery.min.js"></script>

    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/bootstrap-4.4.1-dist/js/bootstrap.min.js"></script>
    <script src="../js/deny_resubmission.js"> </script>
    <script src="../js/validate_form.js"> </script>
  </body>

</html>
