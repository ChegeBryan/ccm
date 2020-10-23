<?php
require_once '../includes/config.php';

$username = $id_number = $password = $confirm_password = "";
$fullname = $mobile = $email = $id_number = "";

$username_err = $id_number_err = $password_err = $confirm_password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $fullname = trim($_POST["full_name"]);
  $mobile = trim($_POST["mobile_number"]);
  $email = trim($_POST["email"]);
  $id_number = trim($_POST["id_number"]);

  if (empty(trim($_POST["username"]))) {
    $username_err = "Please enter a username.";
  } else {
    $sql = "SELECT id FROM ccm_farmers WHERE username = ?";

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

  if (empty(trim($_POST["id_number"]))) {
    $id_number_err = "Please enter a national id number.";
  } else {
    $sql = "SELECT id FROM ccm_farmers WHERE national_id = ?";

    if ($stmt = $conn->prepare($sql)) {
      $stmt->bind_param("i", $param_id_number);
      $param_id_number = intval($_POST["id_number"]);

      if ($stmt->execute()) {
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
          $id_number_err = "This national number is already registered.";
        } else {
          $id_number = trim($_POST["id_number"]);
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

  if (empty($username_err) && empty($id_number_err) && empty($password_err) && empty($confirm_password_err)) {

    $sql = "INSERT INTO ccm_farmers (fullname, username, national_id, mobile_number, email, location, password, pic) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
      $stmt->bind_param("ssssssss", $param_fullname, $param_username, $param_id_number, $param_mobile, $param_email, $param_location, $param_password, $param_pic);

      $param_fullname = trim($_POST["full_name"]);
      $param_username = $username;
      $param_id_number = $id_number;
      $param_mobile = trim($_POST["mobile_number"]);
      $param_email = trim($_POST["email"]);
      $param_location = intval($_POST["county"]);
      $param_pic = "../profileImages/profileDefault.png";
      $param_password = password_hash($password, PASSWORD_DEFAULT);

      if ($stmt->execute()) {
        header("location: login.php");
      } else {
        header("location: ../error.php");
      }
      $stmt->close();
    }
  }
}
?>
<!DOCTYPE html>
<html>

  <head>
    <?php include '../head.php'; ?>
    <title>Farmer | Registration</title>
  </head>

  <body>

    <nav class="navbar navbar-expand navbar-light bg-white mb-4 shadow">

      <a class="navbar-brand text-secondary" href="../index.php">CCM</a>

      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link text-secondary" href="login.php">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-secondary" href="../index.php">Home</a>
        </li>
      </ul>
    </nav>
    <div class="container d-flex justify-content-center py-4">
      <div class="card p-4 shadow-lg">
        <h3>Farmer Registration</h3>
        <p>Fill in the form below to create a farmer account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="needs-validation"
              novalidate>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="name">Full Name</label>
              <input type="text" class="form-control" placeholder="Enter full names" name="full_name"
                     value="<?php echo $fullname; ?>" required>
            </div>
            <div class="form-group col-md-6 <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
              <label for="name">Username</label>
              <input type="text" class="form-control" placeholder="Enter Username to use" name="username"
                     value="<?php echo $username; ?>" required>
              <span class="form-text text-danger"><small><?php echo $username_err; ?></small></span>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6 <?php echo (!empty($id_number_err)) ? 'has-error' : ''; ?>">
              <label for="id_number">National ID</label>
              <input type="text" class="form-control" id="id_number" name="id_number" placeholder="National ID number"
                     value="<?php echo $id_number; ?>">
              <span class="form-text text-danger"><small><?php echo $id_number_err; ?></small></span>
            </div>
            <div class="form-group col-md-6">
              <label for="county">Select County</label>
              <select class="custom-select" id="county" name="county" required>
                <option selected disabled value="">Select County land is located</option>
                <?php

              $sql = "SELECT id, county FROM ccm_counties";

              if ($result = $conn->query($sql)) {
                if ($result->num_rows > 0) {
                  while ($row = $result->fetch_array()) {
                    echo "<option value=" . $row['id'] . ">" . $row['county'] . "</option>";
                  }
                  $result->free();
                } else {
                  echo "<option disabled value=''>No County registered.</option>";
                }
              }
              ?>
              </select>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="email"><b>Email</b></label>
              <input type="email" placeholder="Enter Email" class="form-control" name="email"
                     value="<?php echo $email; ?>"" required>
          </div>
          <div class=" form-group col-md-6">
              <label for="mobile"><b>Mobile Number</b></label>
              <input type="text" class="form-control" placeholder="Enter mobile number" name="mobile_number"
                     value="<?php echo $mobile; ?>" required>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6 <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
              <label for="psw"><b>Password</b></label>
              <input type="password" class="form-control" placeholder="Enter Password" name="psw"
                     value="<?php echo $password; ?>" required>
              <span class="form-text text-danger"><small><?php echo $password_err; ?></small></span>
            </div>
            <div class="form-group col-md-6 <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
              <label for="psw"><b>Confirm Password</b></label>
              <input type="password" class="form-control" placeholder="Confirm Password" name="psw_rpt" required>
              <span class="form-text text-danger"><small><?php echo $confirm_password_err; ?></small></span>
            </div>
          </div>
          <button type="submit" class="btn btn-success btn-block">Sign Up</button>
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
