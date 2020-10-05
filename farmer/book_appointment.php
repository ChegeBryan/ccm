<?php
session_start();

require_once "../includes/config.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $cost = "SELECT cost FROM ccm_farm_inputs WHERE id=?";

  if ($stmt = $conn->prepare($cost)) {

    $stmt->bind_param("i", $param_id);
    $param_id = $_POST["farm_input"];
    if ($stmt->execute()) {
      $result = $stmt->get_result();

      if ($result->num_rows == 1) {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $cost_per_kg = $row['cost'];
      } else {
        exit();
      }
    } else {
      header('location: ../error.php');
    }
  }
  $sql = "INSERT INTO ccm_appointments (made_by, farm_input, quantity, total_cost, pick_date) VALUES (?, ?, ?, ?, ?)";

  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("iiids", $param_farmer, $param_farm_input, $param_quantity, $param_total_cost, $param_date);

    $param_farmer = $_GET["farmer"];
    $param_farm_input = intval($_POST["farm_input"]);
    $param_quantity = intval($_POST["quantity"]);
    $param_total_cost = intval($_POST["quantity"]) * $cost_per_kg;
    $param_date = trim($_POST["p_date"]);

    if ($stmt->execute()) {
      header("location: appointment_booking.php?farmer=" . $_GET["farmer"]);
    } else {
      echo "Oops! Something went wrong. Please try again later.";
    }
    $stmt->close();
  }
}
