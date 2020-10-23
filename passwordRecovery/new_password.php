<!DOCTYPE html>
<html lang="en">

  <head>
    <?php include '../head.php'; ?>
    <title>Password Reset PHP</title>
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
        <h4>New Password</h4>
        <form action="<?php echo "change_password.php?farmer=" . $_GET["farmer"]; ?>" method="POST"
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
