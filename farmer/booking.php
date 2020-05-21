<?php
session_start();

require_once "../includes/config.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $sql = "INSERT INTO ccm_bookings (booked_by, product_to_deliver, quantity_to_deliver, delivery_date) VALUES (?, ?, ?, ?)";

  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("iids", $param_farmer, $param_product, $param_quantity, $param_date);

    $param_farmer = $_GET["farmer"];
    $param_product = intval($_POST["product"]);
    $param_quantity = doubleval($_POST["quantity"]);
    $param_date = trim($_POST["d_date"]);

    if ($stmt->execute()) {
      header("location: produce_delivery.php?farmer=" . $_GET["farmer"]);
    } else {
      echo "Oops! Something went wrong. Please try again later.";
    }
    $stmt->close();
  }
}
