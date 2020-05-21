<?php
session_start();

require_once "../includes/config.php";

$_SESSION["new_password"] = $_SESSION["confirm_password"] = "";
$_SESSION["new_password_err"] = $_SESSION["confirm_password_err"] = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (empty(trim($_POST["new_psw"]))) {
    $_SESSION["new_password_err"] = "Please enter the new password.";
    header("location: edit_profile.php?farmer=" . $_GET["farmer"]);
  } elseif (strlen(trim($_POST["new_psw"])) < 6) {
    $_SESSION["new_password_err"] = "Password must have at least 6 characters.";
    header("location: edit_profile.php?farmer=" . $_GET["farmer"]);
  } else {
    $_SESSION["new_password"] = trim($_POST["new_psw"]);
    header("location: edit_profile.php?farmer=" . $_GET["farmer"]);
  }

  if (empty(trim($_POST["psw_rpt"]))) {
    $_SESSION["confirm_password_err"] = "Please confirm the password.";
    header("location: edit_profile.php?farmer=" . $_GET["farmer"]);
  } else {
    $_SESSION["confirm_password"] = trim($_POST["psw_rpt"]);
    if (empty($_SESSION["confirm_password_err"]) && ($_SESSION["new_password"]  != $_SESSION["confirm_password"])) {
      $_SESSION["confirm_password_err"] = "Password did not match.";
      header("location: edit_profile.php?farmer=" . $_GET["farmer"]);
    }
  }

  if (empty($_SESSION["new_password_err"]) && empty($_SESSION["confirm_password_err"])) {
    $sql = "UPDATE ccm_farmers SET password = ? WHERE id = ?";

    if ($stmt = $conn->prepare($sql)) {
      $stmt->bind_param("si", $param_password, $param_id);

      $param_password = password_hash($new_password, PASSWORD_DEFAULT);
      $param_id = $_GET["id"];

      if ($stmt->execute()) {
        session_destroy();
        header("location: login.php");
        exit();
      } else {
        echo "Oops! Something went wrong. Please try again later.";
      }
      $stmt->close();
    }
  }
}
