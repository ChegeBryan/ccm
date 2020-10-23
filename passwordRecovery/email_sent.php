<!DOCTYPE html>
<html lang="en">

  <head>
    <?php include '../head.php'; ?>
    <title>Password reset link sent</title>
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
        <h5 class="text-info card-title">Email Sent Successfully</h5>
        <p class="card-text">Email sent to <b><?php echo $_GET['email'] ?></b> to help you recover your account.
        </p>
        <p class="card-text">Please login into your email account and click on the password reset link sent.</p>
      </div>
    </div>
  </body>

</html>
