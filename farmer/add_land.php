<?php
session_start();

require_once "../includes/config.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $sql = "INSERT INTO ccm_land (owner, land_size, cereal) VALUES (?, ?, ?)";

  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("idi", $param_owner, $param_size, $param_cereal);

    $param_owner = $_GET["farmer"];
    $param_cereal = $_POST["cereal"];
    $param_size = floatval(trim($_POST["land_size"]));

    if ($stmt->execute()) {
      header("location: land.php?farmer=" . $_GET["farmer"]);
    } else {
      echo "Oops! Something went wrong. Please try again later.";
    }
    $stmt->close();
  }
}
