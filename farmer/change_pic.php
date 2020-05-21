<?php

require_once '../includes/config.php';

$uploadError = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $targetDir = "../profileImages/";
  $pic = "../profileImages/profileDefault.png";
  $targetFile = $targetDir . rand(100, 999) . basename($_FILES["fileToUpload"]["name"]);
  $uploadOk = 1;
  $imageFileType = pathinfo($targetFile, PATHINFO_EXTENSION);

  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if ($check !== false) {
    $uploadOk = 1;
  } else {
    $uploadOk = 0;
    $uploadError = "Not an image please select an image.";
  }

  // Check if file already exists
  if (file_exists($targetFile)) {
    $uploadError = "Sorry, file already exists.";
    $uploadOk = 0;
  }
  // Allow certain file formats
  if (
    $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
  ) {
    $uploadOk = 0;
  }
  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
    $uploadError = "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
  } else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
      $pic = $targetFile;
    } else {
    }
  }

  $sql = "UPDATE ccm_farmers SET pic = ? WHERE id = ?";

  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("ss", $param_pic, $param_farmer);

    $param_pic = $pic;
    $param_farmer = $_GET['farmer'];

    if ($stmt->execute()) {
      header("location: edit_profile.php?farmer=" . $_GET["farmer"]);
    } else {
      echo "Hoelp";
    }
    $stmt->close();
  }
}
