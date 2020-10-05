<?php
session_start();

require_once "../includes/config.php";

$sql = "DELETE FROM ccm_farm_inputs WHERE id = ?";

if ($stmt = $conn->prepare($sql)) {
  $stmt->bind_param("i", $param_fertilizer);

  $param_fertilizer = intval($_GET["fertilizer"]);

  if ($stmt->execute()) {
    header("location: fertilizer.php?admin=" . $_SESSION["admin"]);
  } else {
    echo "Oops! Something went wrong. Please try again later.";
  }
  $stmt->close();
}