<?php

session_start();

require_once "../includes/config.php";

$sql = "UPDATE ccm_appointments SET confirmed = ?, confirmed_on = ? WHERE id = ?";

if ($stmt = $conn->prepare($sql)) {
  $stmt->bind_param("isi", $param_approve, $param_confirm_date, $param_appointment);

  $param_appointment = $_GET["appointment"];
  $param_approve = 1;
  $param_confirm_date = date("Y-m-d H:i:s");

  if ($stmt->execute()) {
    header("location: n_appointments.php?staff=" . $_SESSION["staff_id"]);
  } else {
    header("location: ../error.php");
  }
  $stmt->close();
}
