<?php


session_start();

if (isset($_SESSION["farmer_logged_In"]) || $_SESSION["farmer_logged_in"] !== true) {
  header("location: login.php");
  exit;
}

if (!isset($_SESSION["farmer_approved_status"]) || $_SESSION["farmer_approved_status"] == 0) {
  header("location: not_approved.php?farmer=" . $_SESSION['farmer_id']);
  exit;
}

require_once '../includes/config.php';
?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <title>Farmer Dashboard</title>
    <?php include '../head.php'; ?>
    <link rel="stylesheet" href="../css/dashboard.css">
  </head>

  <body>

    <div class="d-flex">
      <?php include 'menu.php' ?>
      <!-- Begin Page Content -->
      <div class="container-fluid pt-9">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h1 class="h3 mb-0 text-secondary">Complaints</h1>
        </div>

        <!-- Summary Row -->
        <?php include 'summary.php'; ?>
        <!-- Summary Row -->
        <div class="row">

          <!-- Content Column -->
          <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">Raise Complaint</h6>
              </div>
              <div class="card-body overflow-auto" style="max-height: 18.75rem">
                <?php
              $sql = "SELECT subject, message, made_on FROM ccm_complaints WHERE raised_by = ? ORDER BY id DESC";

              if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param('i', $param_raiser);

                $param_raiser = intval($_GET['farmer']);
                if ($stmt->execute()) {
                  $result =  $stmt->get_result();
                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_array()) {
                      echo "<div class='card mb-2 bg-secondary text-white'>
                            <div class='card-body'>
                              <h5 class='card-title'>" . $row['subject'] . "</h5>
                              <p class='card-text'>" . $row['message'] . "</p>
                            </div>
                            <div class='card-footer text-right'>" . $row['made_on'] . "</div>
                          </div>";
                    }
                    $result->free();
                  } else {
                    echo "<p class='card-text'>No complaint Raised by you yet.</p>";
                  }
                }
                $stmt->close();
              } else {
                echo "Could not able to process request, try again later.";
              }
              ?>
              </div>
              <div class="card-footer py-3">

                <form action="<?php echo "send_complaint.php?farmer=" . $_GET["farmer"]; ?>" method="POST"
                      class="needs-validation" novalidate>
                  <div class="form-group">
                    <label class="sr-only" for="subject">Subject</label>
                    <input class="form-control" name="subject" id="subject" placeholder="Subject" required>
                  </div>
                  <textarea class="form-control mt-1" id="message" name="message" placeholder="Write your complaint.."
                            required></textarea>

                  <button class="btn btn-success btn-block mt-2">Send <i class="fa  fa-fw fa-paper-plane"></i></button>
                </form>
              </div>
            </div>
          </div>

          <div class="col-lg-6 mb-4">
            <?php include 'alerts.php'; ?>
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


    <script src="../assets/js/jquery.min.js"></script>

    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/bootstrap-4.4.1-dist/js/bootstrap.min.js"></script>
    <script src="../js/validate_form.js"></script>
    <script src="deny_resubmission.js"></script>
  </body>

</html>
