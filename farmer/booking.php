<?php
session_start();

require_once "../includes/config.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $cost = "SELECT cost FROM ccm_cereals WHERE id=?";

  if ($stmt = $conn->prepare($cost)) {

    $stmt->bind_param("i", $param_id);
    $param_id = $_POST["product"];
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


  $sql = "INSERT INTO ccm_bookings (booked_by, product_to_deliver, quantity_to_deliver, total_cost, delivery_date) VALUES (?, ?, ?, ?, ?)";

  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("iidds", $param_farmer, $param_product, $param_quantity, $param_total_cost, $param_date);

    $param_farmer = $_GET["farmer"];
    $param_product = intval($_POST["product"]);
    $param_quantity = doubleval($_POST["quantity"]);
    $param_total_cost = $_POST["quantity"] * $cost_per_kg;
    $param_date = trim($_POST["d_date"]);

    if ($stmt->execute()) {
      header("location: produce_delivery.php?farmer=" . $_GET["farmer"]);
    } else {
      echo "Oops! Something went wrong. Please try again later.";
    }
    $stmt->close();
  }
}
