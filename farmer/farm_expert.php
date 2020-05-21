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
          <h1 class="h3 mb-0 text-secondary">Help Desk</h1>
        </div>

        <!-- Content Row -->
        <?php include 'summary.php'; ?>
        <!-- Content Row -->
        <div class="row">

          <!-- Content Column -->
          <div class="col-lg-6 mb-4">

            <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">Advisor Help Desk</h6>
              </div>
              <div class="card-body overflow-auto" style="max-height: 18.75rem">
                <?php
              $sql = "SELECT ccm_messages.id, ccm_messages.message, ccm_messages.asked_by, ccm_messages.asked_on, ccm_farmers.pic
              FROM ccm_messages
              JOIN ccm_farmers
              ON ccm_messages.asked_by=ccm_farmers.id
              WHERE asked_by = ?";
              $sql2 = "SELECT ccm_replies.id, ccm_advisors.username, who_asked, reply, replied_on
               FROM ccm_replies
               JOIN ccm_advisors
               ON ccm_replies.replied_by = ccm_advisors.id
               WHERE question = ? AND who_asked = ?";

              if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("i", $param_farmer);

                $param_farmer = $_GET["farmer"];
                if ($stmt->execute()) {
                  $result = $stmt->get_result();

                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_array()) {
                      echo "
                      <div class='media pb-3'>
                            <img src=" . $row["pic"] . " class='mr-3 rounded rounded-circle w-25' alt=''>
                          <div class='media-body pr-5'>
                            <h6 class='mb-0 font-weight-bold text-secondary'>" . $_SESSION['farmer_uname'] . "<span class='text-right text-muted text-xs'>&nbsp;&nbsp;" . $row['asked_on'] . "</span>
                            </h6>
                            <p>" . $row['message'] . "</p>";
                      if ($stmt2 = $conn->prepare($sql2)) {
                        $stmt2->bind_param("ii", $param_question, $param_sender);

                        $param_sender = intval($_GET["farmer"]);
                        $param_question = intval($row["id"]);
                        if ($stmt2->execute()) {
                          $result2 = $stmt2->get_result();

                          if ($result2->num_rows > 0) {
                            while ($row2 = $result2->fetch_array()) {
                              echo "
                                  <div class='media mt-3'>
                                    <img src='../profileImages/profileDefault.png' class='mr-3'>
                                    <div class='media-body'>
                                      <h6 class='mt-0 font-weight-bold text-secondary'>" . $row2['username'] . "<span class='text-right text-muted text-xs'>&nbsp;&nbsp;" . $row2['replied_on'] . "</span></h6>
                                      <p>" . $row2['reply'] . "</p>
                                    </div>
                                  </div>
                                ";
                            }
                          }
                        }
                      }
                      echo "</div>
                      </div>";
                    }
                  } else {
                    echo "<h5>You have not asked any question yet.</h5>";
                  }
                }
              }

              $stmt->close();
              ?>
              </div>
              <div class="card-footer py-3">
                <form action="<?php echo "send_question.php?farmer=" . $_GET["farmer"]; ?>" method="POST"
                      class="needs-validation" novalidate>
                  <textarea class="form-control" id="message" name="message" placeholder="Write message..."
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
  </body>

</html>
