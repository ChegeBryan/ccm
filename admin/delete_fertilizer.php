<?php
session_start();

require_once "../includes/config.php";

$sql = "DELETE FROM ccm_farm_inputs WHERE id = ?";

if ($stmt = $conn->prepare($sql)) {
  $stmt->bind_param("i", $param_fertilizer);

  $param_fertilizer = intval($_GET["fertilizer"]);

  if ($stmt->execute()) {
    $_SESSION["success_message"] = "Fertilizer delete.";
    header("location: fertilizer.php?admin=" . $_SESSION["admin"]);
  } else {
    $_SESSION["error_message"] = "There is associated farmer records. Deletion aborted.";
    header("location: fertilizer.php?admin=" . $_SESSION["admin"]);
  }
  $stmt->close();
}
