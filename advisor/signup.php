<?php
require_once '../includes/config.php';

$username = $email = $password = $confirm_password = "";
$username_err = $email_err = $password_err = $confirm_password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty(trim($_POST["username"]))) {
    $username_err = "Please enter a username.";
  } else {
    $sql = "SELECT id FROM ccm_advisors WHERE username = ?";

    if ($stmt = $conn->prepare($sql)) {
      $stmt->bind_param("s", $param_username);
      $param_username = trim($_POST["username"]);

      if ($stmt->execute()) {
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
          $username_err = "This username is already taken.";
        } else {
          $username = trim($_POST["username"]);
        }
      } else {
        echo "Oops! Something went wrong. Please try again later.";
      }
      $stmt->close();
    }
  }

  if (empty(trim($_POST["email"]))) {
    $email_err = "Please enter email address.";
  } else {
    $sql = "SELECT id FROM ccm_advisors WHERE email = ? LIMIT 1";

    if ($stmt = $conn->prepare($sql)) {
      $stmt->bind_param("s", $param_email);
      $param_email = trim($_POST["email"]);

      if ($stmt->execute()) {
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
          $email_err = "Email address is already registered.";
        } else {
          $email = trim($_POST["email"]);
        }
      } else {
        echo "Oops! Something went wrong. Please try again later.";
      }
      $stmt->close();
    }
  }

  if (empty(trim($_POST["psw"]))) {
    $password_err = "Please enter a password.";
  } elseif (strlen(trim($_POST["psw"])) < 6) {
    $password_err = "Password must have at least 6 characters.";
  } else {
    $password = trim($_POST["psw"]);
  }

  if (empty(trim($_POST["psw_rpt"]))) {
    $confirm_password_err = "Please confirm password.";
  } else {
    $confirm_password = trim($_POST["psw_rpt"]);
    if (empty($password_err) && ($password != $confirm_password)) {
      $confirm_password_err = "Password did not match.";
    }
  }

  if (empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($email_err)) {

    $sql = "INSERT INTO ccm_advisors (fullname, username, email, password) VALUES (?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
      $stmt->bind_param("ssss",  $param_fullname, $param_username, $param_email, $param_password);

      $param_fullname = trim($_POST["full_name"]);
      $param_username = $username;
      $param_email = $email;
      $param_password = password_hash($password, PASSWORD_DEFAULT);

      if ($stmt->execute()) {
        header("location: login.php");
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
    <title>Advisor | Registration</title>
  </head>

  <body>

    <nav class="navbar navbar-expand-sm navbar-light bg-white mb-4 shadow text-secondary">

      <a class="navbar-brand" href="../index.php">CCM</a>

      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="login.php">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../index.php">Home</a>
        </li>
      </ul>
    </nav>
    <div class="container d-flex justify-content-center py-4">
      <div class="card p-4 shadow-lg">
        <h3>Advisor Registration</h3>
        <p>Fill in the form below to create advisors account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="needs-validation"
              novalidate>
          <div class="form-group">
            <label for="name"><b>Full Name</b></label>
            <input type="text" class="form-control" placeholder="Enter full name" name="full_name" required>
          </div>
          <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
            <label for="name"><b>Username</b></label>
            <input type="text" class="form-control" placeholder="Enter Username to use" name="username" required>
            <span class="form-text text-danger"><small><?php echo $username_err; ?></small></span>
          </div>
          <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
            <label for="email"><b>Email</b></label>
            <input type="email" placeholder="Enter Email" class="form-control" name="email"
                   value="<?php echo $email; ?>"" required>
              <span class=" form-text text-danger"><small><?php echo $email_err; ?></small></span>
          </div>
          <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
            <label for="psw"><b>Password</b></label>
            <input type="password" class="form-control" placeholder="Enter Password" name="psw"
                   value="<?php echo $password; ?>" required>
            <span class="form-text text-danger"><small><?php echo $password_err; ?></small></span>
          </div>

          <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
            <label for="psw"><b>Confirm Password</b></label>
            <input type="password" class="form-control" placeholder="Confirm Password" name="psw_rpt" required>
            <span class="form-text text-danger"><small><?php echo $confirm_password_err; ?></small></span>
          </div>

          <button type="submit" class="btn btn-info btn-block">Sign Up</button>
          <p class="pt-1">Already have an account? <a href="login.php">Login here</a>.</p>
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
