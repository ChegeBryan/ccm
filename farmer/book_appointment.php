<?php
session_start();

require_once "../includes/config.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $sql = "INSERT INTO ccm_appointments (made_by, farm_input, quantity, pick_date) VALUES (?, ?, ?, ?)";

  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("iiis", $param_farmer, $param_farm_input, $param_quantity, $param_date);

    $param_farmer = $_GET["farmer"];
    $param_farm_input = intval($_POST["farm_input"]);
    $param_quantity = intval($_POST["quantity"]);
    $param_date = trim($_POST["p_date"]);

    if ($stmt->execute()) {
      header("location: appointment_booking.php?farmer=" . $_GET["farmer"]);
    } else {
      echo "Oops! Something went wrong. Please try again later.";
    }
    $stmt->close();
  }
}
