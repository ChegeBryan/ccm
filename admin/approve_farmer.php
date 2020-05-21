<?php

session_start();

require_once "../includes/config.php";

$sql = "UPDATE ccm_farmers SET approved = ? WHERE id = ?";

if ($stmt = $conn->prepare($sql)) {
  $stmt->bind_param("ii", $param_approve, $param_farmer);

  $param_farmer = $_GET["farmer"];
  $param_approve = 1;

  if ($stmt->execute()) {
    header("location: n_farmers.php?admin=" . $_SESSION["admin_id"]);
  } else {
    header("location: ../error.php");
  }
  $stmt->close();
}
