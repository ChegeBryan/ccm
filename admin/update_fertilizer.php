<?php
require_once '../includes/config.php';

session_start();

$fertilizer = "";
$fertilizer_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty(trim($_POST["fertilizer"]))) {
    $fertilizer_err = "Please enter a fertilizer name.";
  } else {
    $sql = "SELECT id FROM ccm_farm_inputs WHERE farm_input = ?";

    if ($stmt = $conn->prepare($sql)) {
      $stmt->bind_param("s", $param_fertilizer);
      $param_fertilizer = trim($_POST["fertilizer"]);

      if ($stmt->execute()) {
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
          $stmt->bind_result($id);

          if ($stmt->fetch()) {
            if ($id != $_GET["fertilizer"]) {
              $fertilizer_err = $param_fertilizer . " exists.";
            } else {
              $fertilizer = trim($_POST["fertilizer"]);
            }
          }
        }
      } else {
        echo "Oops! Something went wrong. Please try again later.";
      }
      $stmt->close();
    }
  }

  if (empty($fertilizer_err)) {

    $sql = "UPDATE ccm_farm_inputs SET farm_input = ?, cost = ? WHERE id = ?";

    if ($stmt = $conn->prepare($sql)) {
      $stmt->bind_param("sdi", $param_fertilizer, $param_cost, $param_id);

      $param_fertilizer = trim($_POST["fertilizer"]);
      $param_cost = $_POST["cost"];
      $param_id = $_GET["fertilizer"];

      if ($stmt->execute()) {
        $_SESSION["success_message"] = "Fertilizer details updated.";
        header("location: fertilizer.php?admin=" . $_SESSION["admin_id"]);
      } else {
        header("location: ../error.php");
      }
      $stmt->close();
    }
  }
  $conn->close();
}
