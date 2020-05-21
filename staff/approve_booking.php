<?php

session_start();

require_once "../includes/config.php";

$sql = "UPDATE ccm_bookings SET approved = ?, approved_on = ? WHERE id = ?";

if ($stmt = $conn->prepare($sql)) {
  $stmt->bind_param("isi", $param_approve, $param_approved_date, $param_book);

  $param_book = $_GET["book"];
  $param_approve = 1;
  $param_approved_date = date("Y-m-d H:i:s");

  if ($stmt->execute()) {
    header("location: n_bookings.php?staff=" . $_SESSION["staff_id"]);
  } else {
    header("location: ../error.php");
  }
  $stmt->close();
}
