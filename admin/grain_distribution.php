<?php

require_once "../includes/config.php";

$sql = "SELECT land_size
                FROM ccm_land
                JOIN ccm_cereals
                ON ccm_land.cereal = ccm_cereals.id
                WHERE ccm_cereals.grain = ?";
$maize = 0;
$wheat = 0;
$millet = 0;
$sorghum = 0;
$rice = 0;
$beans = 0;

if ($stmt = $conn->prepare($sql)) {
  $stmt->bind_param("s", $param_grain);

  $param_grain = 'Maize';

  if ($stmt->execute()) {
    $result = $stmt->get_result();
    $maize += $result->fetch_row()[0];
  }
  $result->free();
}
$stmt->close();

if ($stmt = $conn->prepare($sql)) {
  $stmt->bind_param("s", $param_grain);

  $param_grain = 'Wheat';

  if ($stmt->execute()) {
    $result = $stmt->get_result();
    $wheat += $result->fetch_row()[0];
  }
  $result->free();
}
$stmt->close();


if ($stmt = $conn->prepare($sql)) {
  $stmt->bind_param("s", $param_grain);

  $param_grain = 'Rice';

  if ($stmt->execute()) {
    $result = $stmt->get_result();
    $rice += $result->fetch_row()[0];
  }
  $result->free();
}
$stmt->close();

if ($stmt = $conn->prepare($sql)) {
  $stmt->bind_param("s", $param_grain);

  $param_grain = 'Sorghum';

  if ($stmt->execute()) {
    $result = $stmt->get_result();
    $sorghum += $result->fetch_row()[0];
  }
  $result->free();
}
$stmt->close();


if ($stmt = $conn->prepare($sql)) {
  $stmt->bind_param("s", $param_grain);

  $param_grain = 'Rice';

  if ($stmt->execute()) {
    $result = $stmt->get_result();
    $rice += $result->fetch_row()[0];
  }
  $result->free();
}
$stmt->close();


if ($stmt = $conn->prepare($sql)) {
  $stmt->bind_param("s", $param_grain);

  $param_grain = 'Beans';

  if ($stmt->execute()) {
    $result = $stmt->get_result();
    $beans += $result->fetch_row()[0];
  }
  $result->free();
}
$stmt->close();
