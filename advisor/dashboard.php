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
    <title>Advisor Dashboard</title>
    <?php include '../head.php'; ?>
    <link rel="stylesheet" href="../css/dashboard.css">
  </head>

  <body>

    <div class="d-flex">

      <?php include 'menu.php'; ?>

      <!-- Begin Page Content -->
      <div class="container-fluid pt-9">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h1 class="h3 mb-0 text-secondary">Dashboard</h1>
        </div>

        <!-- Summary Row -->
        <?php include 'summary.php'; ?>
        <!-- Summary Row -->

        <div class="row">


          <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-info">Farmers' Questions</h6>
              </div>
              <div class="card-body overflow-auto" style="max-height: 20.75rem">
                <?php
              $sql = "SELECT ccm_messages.id, ccm_messages.message, ccm_messages.asked_by, ccm_messages.asked_on, ccm_farmers.fullname
                      FROM ccm_messages
                      JOIN ccm_farmers
                      ON ccm_messages.asked_by=ccm_farmers.id
                      WHERE replied = ?
                      ORDER BY ccm_messages.id DESC";

              if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("i", $param_replied);

                $param_replied = 0;
                if ($stmt->execute()) {
                  $result = $stmt->get_result();

                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_array()) {
                      echo "<div class='card mb-2'><div class='card-body'>";
                      echo "<h6 class='card-title'>" . $row['fullname'] . "</h6>";
                      echo "<h6 class='card-subtitle mb-2 text-xs text-muted'>" . $row['asked_on'] . "</h6>";
                      echo "<a href='respond_questions.php?advisor=" . $_GET['advisor'] . "&question=" . $row['id'] . "&sender=" . $row['asked_by'] . "' class='card-link text-info stretched-link'>Reply Message</a>";
                      echo "</div></div>";
                    }
                  } else {
                    echo "<h5>There are no questions asked at the moment.</h5>";
                  }
                } else {
                  echo "Could complete request.";
                }
              }
              $stmt->close();
              ?>
              </div>
            </div>

          </div>

          <div class="col-lg-6 mb-4">

            <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-info">Farmers' Complaints</h6>
              </div>
              <div class="card-body overflow-auto" style="max-height: 20.75rem">
                <?php
              $sql = "SELECT ccm_complaints.id, subject, message, made_on
                      FROM ccm_complaints
                      WHERE handled = ?
                      ORDER BY id DESC";

              if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("i", $param_handled);

                $param_handled = 0;
                if ($stmt->execute()) {
                  $result = $stmt->get_result();

                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_array()) {
                      echo "<div class='card mb-2'>";
                      echo "<div class='card-body'>";
                      echo "<h6 class='card-subtitle mb-2 text-xs text-muted'>" . $row['made_on'] . "</h6>";
                      echo "<h6 class='card-title'>" . $row['subject'] . "</h6>";
                      echo "<p class='card-text'>" . $row['message'] . "</p>";
                      echo "<a href='handle_complaint.php?advisor=" . $_GET['advisor'] . "&complaint=" . $row['id'] . "' class='card-link text-info stretched-link'>Mark as Handled</a>";
                      echo "</div></div>";
                    }
                  } else {
                    echo "<h5>There are no complaints at the moment.</h5>";
                  }
                } else {
                  echo "Could complete request.";
                }
              }
              $stmt->close();
              ?>
              </div>
            </div>
          </div>


        </div>
      </div>
      <!-- /.container-fluid -->

    </div>


    <?php include '../logout_modal.php'; ?>
    <script src="../assets/js/jquery.min.js"></script>

    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/bootstrap-4.4.1-dist/js/bootstrap.min.js"></script>
  </body>

</html>
