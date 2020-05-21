<?php
session_start();

require_once "../includes/config.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $sql = "INSERT INTO ccm_messages (asked_by, message) VALUES (?, ?)";

  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("is", $param_farmer, $param_message);

    $param_farmer = $_GET["farmer"];
    $param_message = trim($_POST["message"]);

    if ($stmt->execute()) {
      header("location: farm_expert.php?farmer=" . $_GET["farmer"]);
    } else {
      echo "Oops! Something went wrong. Please try again later.";
    }
    $stmt->close();
  }
}
