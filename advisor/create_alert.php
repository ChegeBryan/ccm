<?php


session_start();

if (isset($_SESSION["advisor_logged_In"]) || $_SESSION["advisor_logged_in"] !== true) {
  header("location: login.php");
  exit;
}

if (!isset($_SESSION["advisor_approved_status"]) || $_SESSION["advisor_approved_status"] == 0) {
  header("location: not_approved.php?advisor=" . $_SESSION['advisor_id']);
  exit;
}

require_once '../includes/config.php';

?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <title>Advisor - Create Alert</title>
    <?php include '../head.php'; ?>
    <link rel="stylesheet" href="../css/dashboard.css">
  </head>

  <body>

    <div class="d-flex">
      <?php include 'menu.php' ?>

      <div class="container-fluid pt-9">

        <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h1 class="h3 mb-0 text-secondary">Notify Farmers</h1>
        </div>

        <!-- Content Row -->
        <?php include 'summary.php'; ?>
        <!-- Content Row -->

        <div class="row">
          <!-- Area Chart -->
          <div class="col-lg-6">
            <?php include 'alerts.php' ?>
          </div>


          <div class="col-lg-6">
            <div class="card shadow mb-4">

              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-info">Create Alert</h6>
              </div>

              <div class="card-body">
                <form action="<?php echo "add_alert.php?advisor=" . $_GET["advisor"]; ?>" method="POST"
                      class="needs-validation" novalidate>
                  <div class="form-group">
                    <label for="title" class="text-secondary">Subject</label>
                    <input type="text" class="form-control" id="title" placeholder="Subject to address" name="title"
                           required>
                    <span class="form-text"><small></small></span>
                  </div>
                  <div class="form-group">
                    <label for="message" class="text-secondary">Message</label>
                    <textarea class="form-control mb-2" id="message" placeholder="Write the alert..." name="message"
                              required></textarea>
                  </div>
                  <span class="form-text text-danger"><small></small></span>
                  <button class="btn btn-info text-capitalize btn-block">Broadcast Alert <i
                       class="fa fa-fw fa-bullhorn"></i></button>
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
    <?php include '../logout_modal.php'; ?>

    <script src="../assets/js/jquery.min.js"></script>

    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/bootstrap-4.4.1-dist/js/bootstrap.min.js"></script>
    <script src="../js/deny_resubmission.js"></script>
    <script src="../js/validate_form.js"></script>
  </body>

</html>
