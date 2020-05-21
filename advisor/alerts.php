<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-info">CCM Alerts</h6>
  </div>
  <div class="card-body overflow-auto" style="max-height: 20.75rem">
    <?php
    $sql = "SELECT ccm_alerts.id AS alert, title, message, made_on, ccm_advisors.id AS advisor
    FROM ccm_alerts
    JOIN ccm_advisors
    ON ccm_alerts.made_by = ccm_advisors.id
    ORDER BY ccm_alerts.id DESC;
    ";
    if ($result = $conn->query($sql)) {
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_array()) {
          echo "<div class='card bg-info text-white mb-2'><div class='card-body'>";
          echo "<h6 class='card-title'>" . $row['title'] . "</h6>";
          echo "<h6 class='card-subtitle text-xs text-muted'>" . $row['made_on'] . "</h6>";
          echo "<p class='card-text'>" . $row['message'] . "</p>";
          echo "<div class='card-footer bg-transparent'>";
          echo ($row['advisor'] == $_GET['advisor'])
            ? "<a class='card-link text-white' href='delete_alert.php?alert=" . $row['alert'] . "'><i class='fa fa-fw fa-trash'></i> Delete</a>"
            : "<span class='text-secondary'>Can only delete own alerts.</span>";

          echo "</div></div></div>";
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
