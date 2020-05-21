<?php

session_start();

require_once "../includes/config.php";

$sql = "INSERT INTO `ccm_farm_produce_payments`(`paying_for`, `staff`, `amount`, `mode_of_payment`) VALUES (?, ? , ?, ?)";

if ($stmt = $conn->prepare($sql)) {
  $stmt->bind_param("iiis", $param_boooking, $param_staff, $param_amount, $param_mode);

  $param_boooking = $_GET["booking"];
  $param_staff = $_GET["staff"];
  $param_amount = intval($_POST["amount"]);
  $param_mode = $_POST["mode"];

  if ($stmt->execute()) {
    $sql2 = "UPDATE ccm_bookings SET paid = ? WHERE id= ?";

    if ($stmt2 = $conn->prepare($sql2)) {
      $stmt2->bind_param("ii", $param_paid, $param_app);

      $param_paid = 1;
      $param_app = $_GET['booking'];

      if ($stmt2->execute()) {
        header("location: p_payment.php?staff=" . $_SESSION["staff_id"]);
      } else {
        header("location: ../error.php");
      }
    } else {
      header("location: ../error.php");
    }
    $stmt2->close();
  }
}
$stmt->close();
