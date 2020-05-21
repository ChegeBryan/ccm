<?php
session_start();

require_once "../includes/config.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $sql = "INSERT INTO ccm_alerts (made_by, title, message) VALUES (?, ?, ?)";

  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("iss", $param_advisor, $param_title, $param_message);

    $param_advisor = intval($_GET["advisor"]);
    $param_title = trim($_POST["title"]);
    $param_message = trim($_POST["message"]);

    if ($stmt->execute()) {
      header("location: create_alert.php?advisor=" . $_GET["advisor"]);
    } else {
      echo "Oops! Something went wrong. Please try again later." . $conn->error;
    }
    $stmt->close();
  }
}
