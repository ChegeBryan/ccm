<?php
require_once '../includes/config.php';

$username = "";
$username_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty(trim($_POST["username"]))) {
    $username_err = "Please enter a username.";
  } else {
    $sql = "SELECT id FROM ccm_farmers WHERE username = ?";

    if ($stmt = $conn->prepare($sql)) {
      $stmt->bind_param("s", $param_username);
      $param_username = trim($_POST["username"]);

      if ($stmt->execute()) {
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
          $stmt->bind_result($id);

          if ($stmt->fetch()) {
            if ($id != $_GET["farmer"]) {
              $username_err = "This username is already taken.";
            } else {
              $username = trim($_POST["username"]);
            }
          }
        } else {

          $username_err = "Check username again";
        }
      } else {
        echo "Oops! Something went wrong. Please try again later.";
      }
      $stmt->close();
    }
  }

  if (empty($username_err)) {

    $sql = "UPDATE ccm_farmers SET fullname = ?, username = ?, mobile_number = ?, email = ? WHERE id = ?";

    if ($stmt = $conn->prepare($sql)) {
      $stmt->bind_param("sssss", $param_fullname, $param_username, $param_mobile, $param_email, $param_id);

      $param_fullname = trim($_POST["fullname"]);
      $param_username = $username;
      $param_mobile = trim($_POST["mobile_number"]);
      $param_email = trim($_POST["email"]);
      $param_id = $_GET["farmer"];

      if ($stmt->execute()) {
        echo "here";
        header("location: edit_profile.php?farmer=" . $_GET["farmer"]);
      } else {
        header("location: ../error.php");
      }
      $stmt->close();
    }
  }
  $conn->close();
}
