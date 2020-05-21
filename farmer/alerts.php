<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-success">CCM Alerts</h6>
  </div>
  <div class="card-body overflow-auto" style="max-height: 18.75rem">
    <?php
    $sql = "SELECT title,message, made_on FROM ccm_alerts";
    if ($result = $conn->query($sql)) {
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_array()) {
          echo "<div class='card bg-info text-white mb-2'>
                            <div class='card-body'>
                              <h5 class='card-title'>" . $row['title'] . "</h5>
                              <p class='card-text'>" . $row['message'] . "</p>
                            </div>
                            <div class='card-footer text-right'>" . $row['made_on'] . "</div>
                          </div>";
        }
        $result->free();
      } else {
        echo "<p class='card-text'>No Alert yet.</p>";
      }
    } else {
      echo "Could not able to process request.";
    }
    ?>
  </div>
</div>
