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
          <h1 class="h3 mb-0 text-secondary">Farmers' Questions</h1>
        </div>

        <!-- Summary Row -->
        <?php include 'summary.php'; ?>
        <!-- Summary Row -->

        <div class="row">


          <div class="col-lg-7 mb-4">
            <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-info">Advisor Chat Box</h6>
              </div>
              <div class="card-body overflow-auto" style="max-height: 18.75rem; min-height: 15.75rem">
                <?php
              if (isset($_GET['question'])) {
                $sql = "SELECT ccm_messages.id, ccm_messages.message, ccm_messages.asked_by,
              ccm_messages.asked_on, ccm_farmers.pic, ccm_farmers.username, ccm_farmers.id AS farmer
              FROM ccm_messages
              JOIN ccm_farmers
              ON ccm_messages.asked_by=ccm_farmers.id
              WHERE ccm_messages.id = ?";
                $sql2 = "SELECT ccm_replies.id, ccm_advisors.username, who_asked, reply, replied_on
               FROM ccm_replies
               JOIN ccm_advisors
               ON ccm_replies.replied_by = ccm_advisors.id
               WHERE question = ? AND who_asked = ?";

                if ($stmt = $conn->prepare($sql)) {
                  $stmt->bind_param("i", $param_question);

                  $param_question = $_GET["question"];
                  if ($stmt->execute()) {
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                      while ($row = $result->fetch_array()) {
                        echo "<div class='media pb-3'>";
                        echo "<img src=" . $row["pic"] . " class='mr-3 rounded rounded-circle' style='width: 48px; height: 48px;' alt=''>";
                        echo "<div class='media-body pr-5'>";
                        echo "<h6 class='mb-0 font-weight-bold text-secondary'>" . $row['username'] . "
                            <span class='text-right text-muted text-xs'>&nbsp;&nbsp;" . $row['asked_on'] . "</span></h6>";
                        echo "<p>" . $row['message'] . "</p>";
                        if ($stmt2 = $conn->prepare($sql2)) {
                          $stmt2->bind_param("ii", $param_question, $param_sender);

                          $param_sender = intval($row["farmer"]);
                          $param_question = intval($_GET["question"]);
                          if ($stmt2->execute()) {
                            $result2 = $stmt2->get_result();

                            if ($result2->num_rows > 0) {
                              echo "<span class='card-text text-muted'>Advisor reply to this question...</span>";
                              while ($row2 = $result2->fetch_array()) {
                                echo "<div class='media mt-3'>";
                                echo "<img src='../profileImages/profileDefault.png' class='mr-3'>";
                                echo "<div class='media-body'>";
                                echo "<h6 class='mt-0 font-weight-bold text-secondary'>" . $row2['username'] . "
                              <span class='text-right text-muted text-xs'>&nbsp;&nbsp;" . $row2['replied_on'] . "</span></h6>";
                                echo "<p>" . $row2['reply'] . "</p>";
                                echo "</div></div>";
                              }
                            } else {
                              echo "<span class='text-secondary'>No replies yet to this question.</span>";
                            }
                          }
                        }
                        echo "</div></div>";
                      }
                    } else {
                      echo "<h5>You have not asked any question yet.</h5>";
                    }
                  }
                }

                $stmt->close();
              } else {
                echo "<p class='card-link text-info'>Select Question you want to respond to first.</p>";
              }
              ?>
              </div>
              <div class="card-footer py-3">
                <form action="<?php echo "reply.php?advisor=" . $_GET["advisor"] .
                              "&question=" . $_GET['question'] .
                              "&sender=" . $_GET['sender']; ?>" method="POST" class="needs-validation" novalidate>
                  <textarea class="form-control" id="message" name="message" placeholder="Write reply..."
                            required></textarea>

                  <button class="btn btn-info btn-block mt-2">Send <i class="fa  fa-fw fa-paper-plane"></i></button>
                </form>
              </div>
            </div>
          </div>

          <div class="col-lg-5 mb-4">
            <div class="card shadow mb-4">
              <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-info">Farmers' Questions</h6>
              </div>
              <div class="card-body overflow-auto" style="max-height: 20.75rem">
                <?php
              $sql = "SELECT ccm_messages.id, ccm_messages.message, ccm_messages.asked_by,
              ccm_messages.replied, ccm_messages.asked_on, ccm_farmers.fullname
              FROM ccm_messages
              JOIN ccm_farmers
              ON ccm_messages.asked_by=ccm_farmers.id
              ORDER BY  replied ASC, ccm_messages.id DESC";


              if ($result = $conn->query($sql)) {
                if ($result->num_rows > 0) {
                  echo "<span class='card-text text-muted pb-2'>Showing messages with no replies first...</span>";
                  while ($row = $result->fetch_array()) {
                    echo "<div class='card mb-2'><div class='card-body'>";
                    echo "<h6 class='card-title'>" . $row['fullname'] . "</h6>";
                    echo "<h6 class='card-subtitle mb-2 text-xs text-muted'>" . $row['asked_on'] . "</h6>";
                    echo "<p class='card-text'>" . $row['message'] . "</p>";
                    echo ($row['replied'] == 1)
                      ? "<a href='respond_questions.php?advisor=" . $_GET['advisor'] . "&question=" . $row['id'] . "&sender=" . $row['asked_by'] . "' class='card-link text-info stretched-link'>Add Another Reply</a>"
                      : "<a href='respond_questions.php?advisor=" . $_GET['advisor'] . "&question=" . $row['id'] . "&sender=" . $row['asked_by'] . "' class='card-link text-info stretched-link'>Reply Message</a>";
                    echo "</div></div>";
                  }
                  $result->free();
                } else {
                  echo "<h5>There are no questions asked at the moment.</h5>";
                }
              } else {
                echo "Could not able to process request.";
              }
              ?>
              </div>
            </div>

          </div>


        </div>
      </div>
      <!-- /.container-fluid -->

    </div>
    <!-- Logout Modal-->
    <?php include '../logout_modal.php'; ?>


    <script src="../assets/js/jquery.min.js"></script>

    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/bootstrap-4.4.1-dist/js/bootstrap.min.js"></script>
    <script src="../js/deny_resubmission.js"></script>
    <script src="../js/validate_form.js"></script>
  </body>

</html>
