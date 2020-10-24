<?php

session_start();

require_once '../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {

  if (empty(trim($_POST["new_psw"]))) {
    $_SESSION["new_password_err"] = "Please enter the new password.";
  } elseif (strlen(trim($_POST["new_psw"])) < 6) {
    $_SESSION["new_password_err"] = "Password must have at least 6 characters.";
  } else {
    $_SESSION["new_password"] = trim($_POST["new_psw"]);
  }

  if (empty(trim($_POST["psw_rpt"]))) {
    $_SESSION["confirm_password_err"] = "Please confirm the password.";
  } else {
    $_SESSION["confirm_password"] = trim($_POST["psw_rpt"]);
    if (empty($_SESSION["confirm_password_err"]) && ($_SESSION["new_password"]  != $_SESSION["confirm_password"])) {
      $_SESSION["confirm_password_err"] = "Password did not match.";
    }
  }

  $usertype = $_POST["usertype"];

  switch ($usertype) {
    case 'farmer':
      $tbl = "ccm_farmers";
      $tblsql = "UPDATE ccm_farmers SET password = ? WHERE email= ?";
      break;

    case 'advisor':
      $tbl = "ccm_advisors";
      $tblsql = "UPDATE ccm_advisors SET password = ? WHERE email= ?";
      break;

    case 'staff':
      $tbl = "ccm_staff";
      $tblsql = "UPDATE ccm_staff SET password = ? WHERE email= ?";
      break;

    default:
      $tbl = "ccm_farmers";
      $tblsql = "UPDATE ccm_farmers SET password = ? WHERE email= ?";
      break;
  }

  if (empty($_SESSION["new_password_err"]) && empty($_SESSION["confirm_password_err"])) {

    $sql = "SELECT email FROM password_reset WHERE token=? LIMIT 1";

    if ($stmt = $conn->prepare($sql)) {
      $stmt->bind_param("s", $param_token);

      $param_token = $_GET['token'];

      if ($stmt->execute()) {
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
          $stmt->bind_result($email);

          if ($stmt->fetch()) {
            if ($email) {
              if ($stmt = $conn->prepare($$tblsql)) {
                $stmt->bind_param("ss", $param_password, $param_email);

                $param_table = $tbl;
                $param_password = trim($_POST["new_psw"]);
                $param_email = $email;

                if ($stmt->execute()) {
                  header("location: reset_success.php");
                } else {
                  header("location: ../error.php");
                }
              }
            }
          }
        }
      }
    }
  } else {
    header("location: " . $_SERVER['HTTP_REFERER']);
  }
}
?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <?php include '../head.php'; ?>
    <title>New Password</title>
  </head>

  <body>

    <nav class="navbar navbar-expand navbar-light bg-white mb-4 shadow">

      <a class="navbar-brand text-secondary" href="../index.php">CCM</a>

      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link text-secondary" href="../index.php">Home</a>
        </li>
      </ul>
    </nav>

    <div class="container d-flex justify-content-center mt-5">
      <div class="card p-4 shadow" style="width: 400px;">
        <h4>New Password</h4>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?token=' . $_GET['token']; ?>" method="POST"
              class="needs-validation" novalidate>
          <div
               class="form-group <?php echo (isset($_SESSION["new_password_err"]) && !empty($_SESSION["new_password_err"])) ? 'has-error' : ''; ?>">
            <label for="psw" class="text-secondary">New Password</label>
            <input type="password" class="form-control" placeholder="Enter new password" name="new_psw"
                   value="<?php echo isset($_SESSION["new_password"]) ? $_SESSION["new_password"] : ""; ?>" required>
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
          <button class="btn btn-danger btn-block" type="submit">Reset Password</button>
        </form>
      </div>
    </div>
  </body>

</html>
