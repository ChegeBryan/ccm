<div class="d-flex justify-content-around">
  <span class="badge badge-pill badge-primary p-4 rounded-circle">
    <?php
    $sql = "SELECT COUNT(id) FROM ccm_advisors WHERE approved = ?";

    if ($stmt = $conn->prepare($sql)) {
      $stmt->bind_param("i", $param_approved);

      $param_approved = 0;

      if ($stmt->execute()) {
        $result = $stmt->get_result();

        $count = $result->fetch_row()[0];

        echo $count;
      }
      $result->free();
    }
    $stmt->close();
    ?>
  </span>
  <span class="badge badge-pill badge-secondary p-4 rounded-circle">
    <?php
    $sql = "SELECT COUNT(id) FROM ccm_staff WHERE approved = ?";

    if ($stmt = $conn->prepare($sql)) {
      $stmt->bind_param("i", $param_approved);

      $param_approved = 0;

      if ($stmt->execute()) {
        $result = $stmt->get_result();

        $count = $result->fetch_row()[0];

        echo $count;
      }
      $result->free();
    }
    $stmt->close();
    ?>
  </span>
  <span class="badge badge-pill badge-success p-4 rounded-circle">
    <?php
    $sql = "SELECT COUNT(id) FROM ccm_farmers WHERE approved = ?";

    if ($stmt = $conn->prepare($sql)) {
      $stmt->bind_param("i", $param_approved);

      $param_approved = 0;

      if ($stmt->execute()) {
        $result = $stmt->get_result();

        $count = $result->fetch_row()[0];

        echo $count;
      }
      $result->free();
    }
    $stmt->close();
    ?>
  </span>
</div>

<div class="mt-4 text-center small">
  <span class="mr-2">
    <i class="fa fa-circle text-primary"></i> Advisors
  </span>
  <span class="mr-2">
    <i class="fa fa-circle text-secondary"></i> Staff
  </span>
  <span class="mr-2">
    <i class="fa fa-circle text-success"></i> Farmers
  </span>
</div>
