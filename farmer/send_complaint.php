<?php
session_start();

require_once "../includes/config.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $sql = "INSERT INTO ccm_complaints (raised_by, subject, message) VALUES (?, ?, ?)";

  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("iss", $param_farmer, $param_subject, $param_message);

    $param_farmer = $_GET["farmer"];
    $param_subject = trim($_POST["subject"]);
    $param_message = trim($_POST["message"]);

    if ($stmt->execute()) {
      header("location: complaint.php?farmer=" . $_GET["farmer"]);
    } else {
      echo "Oops! Something went wrong. Please try again later.";
    }
    $stmt->close();
  }
}
