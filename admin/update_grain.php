<?php
require_once '../includes/config.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $sql = "UPDATE ccm_cereals SET cost = ? WHERE id = ?";

  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("di", $param_cost, $param_id);

    $param_cost = $_POST["cost"];
    $param_id = $_GET["grain"];

    if ($stmt->execute()) {
      header("location: cereal_grain.php?admin=" . $_SESSION["admin_id"]);
    } else {
      header("location: ../error.php");
    }
    $stmt->close();
  }
  $conn->close();
}
