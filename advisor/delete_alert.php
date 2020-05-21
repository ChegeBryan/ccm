<?php
session_start();

require_once "../includes/config.php";

$sql = "DELETE FROM ccm_alerts WHERE id = ?";

if ($stmt = $conn->prepare($sql)) {
  $stmt->bind_param("i", $param_alert);

  $param_alert = intval($_GET["alert"]);

  if ($stmt->execute()) {
    header("location: create_alert.php?advisor=" . $_SESSION["advisor_id"]);
  } else {
    echo "Oops! Something went wrong. Please try again later.";
  }
  $stmt->close();
}
