<div class="row">
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-bottom-primary shadow-lg h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Approved Advisors</div>
            <div class="h5 mb-0 font-weight-bold text-secondary">
              <?php
              $sql = "SELECT COUNT(id) FROM ccm_advisors WHERE approved = ?";

              if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("i", $param_approved);

                $param_approved = 1;

                if ($stmt->execute()) {
                  $result = $stmt->get_result();

                  $count = $result->fetch_row()[0];

                  echo $count;
                  $_SESSION['approved_advisors'] = $count;
                }
                $result->free();
              }
              $stmt->close();
              ?>
            </div>
          </div>
          <div class="col-auto">
            <i class="fa fa-users fa-2x text-muted"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-bottom-warning shadow-lg h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Approved Farmers</div>
            <div class="h5 mb-0 font-weight-bold text-secondary">
              <?php
              $sql = "SELECT COUNT(id) FROM ccm_farmers WHERE approved = ?";

              if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("i", $param_approved);

                $param_approved = 1;

                if ($stmt->execute()) {
                  $result = $stmt->get_result();

                  $count = $result->fetch_row()[0];

                  echo $count;
                  $_SESSION['approved_farmers'] = $count;
                }
                $result->free();
              }
              $stmt->close();
              ?>
            </div>
          </div>
          <div class="col-auto">
            <i class="fa fa-users fa-2x text-muted"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-bottom-success shadow-lg h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Land size registered</div>
            <div class="h5 mb-0 font-weight-bold text-secondary">
              <?php
              $sql = "SELECT SUM(land_size) AS total_land FROM ccm_land";

              if ($result = $conn->query($sql)) {
                if ($result->num_rows > 0) {
                  $landsize = $result->fetch_row()[0];
                  echo round($landsize, 2) . " Acres";
                  $result->free();
                } else {
                  echo 0;
                }
              } else {
                echo "Could not able to process request.";
              }
              ?>
            </div>
          </div>
          <div class="col-auto">
            <i class="fa fa-map fa-2x text-secondary"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Pending Requests Card Example -->
  <div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-bottom-info shadow-lg h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Pending User approvals</div>
            <div class="h5 mb-0 font-weight-bold text-secondary">
              <?php
              $sql = "SELECT COUNT(id) FROM ccm_advisors WHERE approved = ?";
              $sql2 = "SELECT COUNT(id) FROM ccm_farmers WHERE approved = ?";
              $sql3 = "SELECT COUNT(id) FROM ccm_staff WHERE approved = ?";
              $users = 0;

              if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("i", $param_approved);

                $param_approved = 0;

                if ($stmt->execute()) {
                  $result = $stmt->get_result();
                  $users += $result->fetch_row()[0];
                }
                $result->free();
              }
              $stmt->close();

              if ($stmt2 = $conn->prepare($sql2)) {
                $stmt2->bind_param("i", $param_approved);

                $param_approved = 0;

                if ($stmt2->execute()) {
                  $result = $stmt2->get_result();
                  $users += $result->fetch_row()[0];
                }
                $result->free();
              }
              $stmt2->close();

              if ($stmt3 = $conn->prepare($sql3)) {
                $stmt3->bind_param("i", $param_approved);

                $param_approved = 0;

                if ($stmt3->execute()) {
                  $result = $stmt3->get_result();
                  $users += $result->fetch_row()[0];
                }
                $result->free();
              }
              $stmt3->close();
              echo $users;
              ?>
            </div>
          </div>
          <div class="col-auto">
            <i class="fa fa-user-plus fa-2x text-secondary"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
