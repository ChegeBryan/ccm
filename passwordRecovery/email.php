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
