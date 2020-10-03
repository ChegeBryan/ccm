<?php

require_once "../includes/config.php";

$sql = "SELECT COALESCE(SUM(land_size), 0) \n"

  . "FROM ccm_land\n"

  . "JOIN ccm_cereals\n"

  . "ON ccm_land.cereal = ccm_cereals.id\n"

  . "WHERE ccm_cereals.grain = ? AND ccm_land.owner = ?";

if ($stmt = $conn->prepare($sql)) {
  $stmt->bind_param("si", $param_grain, $param_owner);

  $param_grain = 'Maize';
  $param_owner = $_GET['farmer'];

  if ($stmt->execute()) {
    $result = $stmt->get_result();
    $maize = $result->fetch_row()[0];
  }
  $result->free();
}
$stmt->close();

if ($stmt = $conn->prepare($sql)) {
  $stmt->bind_param("si", $param_grain, $param_owner);

  $param_grain = 'Wheat';
  $param_owner = $_GET['farmer'];

  if ($stmt->execute()) {
    $result = $stmt->get_result();
    $wheat = $result->fetch_row()[0];
  }
  $result->free();
}
$stmt->close();


if ($stmt = $conn->prepare($sql)) {
  $stmt->bind_param("si", $param_grain, $param_owner);

  $param_grain = 'Rice';
  $param_owner = $_GET['farmer'];

  if ($stmt->execute()) {
    $result = $stmt->get_result();
    $rice = $result->fetch_row()[0];
  }
  $result->free();
}
$stmt->close();

if ($stmt = $conn->prepare($sql)) {
  $stmt->bind_param("si", $param_grain, $param_owner);

  $param_grain = 'Sorghum';
  $param_owner = $_GET['farmer'];

  if ($stmt->execute()) {
    $result = $stmt->get_result();
    $sorghum = $result->fetch_row()[0];
  }
  $result->free();
}
$stmt->close();


if ($stmt = $conn->prepare($sql)) {
  $stmt->bind_param("si", $param_grain, $param_owner);

  $param_grain = 'Rice';
  $param_owner = $_GET['farmer'];

  if ($stmt->execute()) {
    $result = $stmt->get_result();
    $rice = $result->fetch_row()[0];
  }
  $result->free();
}
$stmt->close();


if ($stmt = $conn->prepare($sql)) {
  $stmt->bind_param("si", $param_grain, $param_owner);

  $param_grain = 'Beans';
  $param_owner = $_GET['farmer'];

  if ($stmt->execute()) {
    $result = $stmt->get_result();
    $beans = $result->fetch_row()[0];
  }
  $result->free();
}
$stmt->close();

if ($stmt = $conn->prepare($sql)) {
  $stmt->bind_param("si", $param_grain, $param_owner);

  $param_grain = 'Millet';
  $param_owner = $_GET['farmer'];

  if ($stmt->execute()) {
    $result = $stmt->get_result();
    $millet = $result->fetch_row()[0];
  }
  $result->free();
}
$stmt->close();
