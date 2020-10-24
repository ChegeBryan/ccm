<?php

session_start();

$email_err = "";
$user_err = "";

require_once '../includes/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (empty(trim($_POST["email"]))) {
    $email_err = "Please enter your email.";
  } else {
    $email = trim($_POST["email"]);
  }

  $usertype = $_POST["usertype"];
  switch ($usertype) {
    case 'farmer':
      $user = "ccm_farmers";
      break;

    case 'staff':
      $user = "ccm_staff";
      break;

    case 'advisor':
      $user = "ccm_advisors";
      break;

    default:
      $user = "ccm_farmers";
      break;
  }

  if (empty($email_err)) {
    $sql = "SELECT email FROM ? WHERE email=?";

    if ($stmt = $conn->prepare($sql)) {
      $stmt->bind_param("ss", $param_table, $param_email);

      $param_table = $user;
      $param_email = $email;

      if ($stmt->execute()) {
        $stmt->store_result();

        if ($stmt->num_rows() == 1) {
          $token = bin2hex(random_bytes(50));

          $sql = "INSERT INTO ccm_password_resets (email, token) VALUES (?, ?)";

          if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ss", $param_email, $param_token);

            $param_email = $email;
            $param_token = $token;

            if ($stmt->execute()) {

              $to = $email;
              $subject = "Reset your password on County Cereals Management";
              $msg = "Hi there, click on this <a href='passwordRecovery/new_password.php?token=' . $token . '&user=' . $usertype'>link</a> to reset your password.";
              $msg = wordwrap($msg, 70);
              $headers = "From: info@ccm.com";
              mail($to, $subject, $msg, $headers);

              header("location: email_sent.php?email=" . $email);
            } else {
              header("location: ../error.php");
            }
            $stmt->close();
          }
        } else {
          $user_err = "Sorry, no user exists on our system with that email.";
        }
      }
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <?php include '../head.php'; ?>
    <title>Password Reset</title>
  </head>

  <body>

    <nav class="navbar navbar-expand navbar-light bg-white mb-4 shadow">

      <a class="navbar-brand text-secondary" href="../index.php">CCM</a>

      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link text-secondary" href="signup.php">Sign Up</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-secondary" href="../index.php">Home</a>
        </li>
      </ul>
    </nav>


    <div class="container d-flex justify-content-center mt-5">
      <div class="card p-4 shadow" style="width: 400px;">
        <h4>Password reset</h4>

        <?php

      if (!empty($user_err)) {
        echo "<div class='alert alert-danger' role='alert'>
          $user_err;
          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
          </button>
        </div>";
      }
      ?>


        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="needs-validation" method="POST"
              novalidate>
          <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
            <label for="email" class="text-secondary">Email</label>
            <input type="email" class="form-control" id="email" placeholder="Enter your email" name="email"
                   value="<?php echo $email; ?>" required>
            <span class="form-text text-danger"><small><?php echo $email_err; ?></small></span>
          </div>

          <p class="form-text text-secondary">Select User Type</p>

          <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="usertype1" name="usertype" class="custom-control-input" checked value="farmer">
            <label class="custom-control-label" for="usertype1">Farmer</label>
          </div>
          <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="usertype2" name="usertype" class="custom-control-input" value="advisor">
            <label class="custom-control-label" for="usertype2">Advisor</label>
          </div>
          <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="usertype3" name="usertype" class="custom-control-input" value="staff">
            <label class="custom-control-label" for="usertype3">Staff</label>
          </div>
          <button type="submit" class="btn btn-danger btn-block mt-2">Submit</button>
        </form>
      </div>
    </div>
  </body>

</html>
