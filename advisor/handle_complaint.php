<?php
session_start();

require_once "../includes/config.php";

$sql = "UPDATE ccm_complaints SET handled_by = ?, handled = ?, handled_on = ? WHERE id = ?";
if ($stmt = $conn->prepare($sql)) {
  $stmt->bind_param("iisi", $param_advisor, $param_handled, $param_handled_on, $param_complaint);

  $param_advisor = $_GET['advisor'];
  $param_handled = 1;
  $param_complaint = $_GET['complaint'];
  $param_handled_on = date('Y-m-d H:i:s');

  if ($stmt->execute()) {
    header("location: dashboard.php?advisor=" . $_GET["advisor"]);
  } else {
    echo "Oops! Something went wrong. Please try again later.";
  }
}
$stmt->close();
