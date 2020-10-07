<?php
session_start();

require_once "../includes/config.php";

$sql = "DELETE FROM ccm_counties WHERE id = ?";

if ($stmt = $conn->prepare($sql)) {
  $stmt->bind_param("i", $param_county);

  $param_county = intval($_GET["county"]);

  if ($stmt->execute()) {
    $_SESSION["success_message"] = "County deleted.";
    header("location: county.php?admin=" . $_SESSION["admin"]);
  } else {
    $_SESSION["error_message"] = "County has associated farmers records. Delete aborted.";
    header("location: county.php?admin=" . $_SESSION["admin"]);
  }
  $stmt->close();
}
