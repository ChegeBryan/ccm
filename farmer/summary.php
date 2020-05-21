 <div class="row">
   <div class="col-xl-3 col-md-6 mb-4">
     <div class="card border-bottom-primary shadow-lg h-100 py-2">
       <div class="card-body">
         <div class="row no-gutters align-items-center">
           <div class="col mr-2">
             <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Bookings</div>
             <div class="h5 mb-0 font-weight-bold text-secondary">
               <?php
                $sql = "SELECT COUNT(id) FROM ccm_bookings WHERE booked_by = ? AND paid = ?";

                if ($stmt = $conn->prepare($sql)) {
                  $stmt->bind_param("ii", $param_farmer, $param_paid);

                  $param_farmer = $_GET["farmer"];
                  $param_paid = 0;

                  if ($stmt->execute()) {
                    $result = $stmt->get_result();

                    $count = $result->fetch_row()[0];

                    echo $count;
                  }
                  $result->free();
                }
                $stmt->close();
                ?>
             </div>
           </div>
           <div class="col-auto">
             <i class="fa fa-calendar fa-2x text-muted"></i>
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
             <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Appointments</div>
             <div class="h5 mb-0 font-weight-bold text-secondary">
               <?php
                $sql = "SELECT COUNT(id) FROM ccm_appointments WHERE made_by = ? AND paid = ?";

                if ($stmt = $conn->prepare($sql)) {
                  $stmt->bind_param("ii", $param_farmer, $param_paid);

                  $param_farmer = $_GET["farmer"];
                  $param_paid = 0;

                  if ($stmt->execute()) {
                    $result = $stmt->get_result();

                    $count = $result->fetch_row()[0];

                    echo $count;
                  }
                  $result->free();
                }
                $stmt->close();
                ?>
             </div>
           </div>
           <div class="col-auto">
             <i class="fa fa-book fa-2x text-muted"></i>
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
             <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Farm Input Payments</div>
             <div class="h5 mb-0 font-weight-bold text-secondary">

               <?php
                $sql = "SELECT COALESCE(SUM(ccm_farm_input_payments.amount), 0) \n"

                  . "FROM ccm_appointments\n"

                  . "JOIN ccm_farm_input_payments\n"

                  . "ON ccm_appointments.id = ccm_farm_input_payments.paying_for \n"

                  . "WHERE ccm_appointments.made_by = ? \n";

                if ($stmt = $conn->prepare($sql)) {
                  $stmt->bind_param("i", $param_farmer);

                  $param_farmer = $_GET["farmer"];

                  if ($stmt->execute()) {
                    $result = $stmt->get_result();

                    $total = $result->fetch_row()[0];

                    echo "Kshs. " . $total;
                  }
                  $result->free();
                }
                $stmt->close();
                ?>
             </div>
           </div>
           <div class="col-auto">
             <i class="fa fa-dollar fa-2x text-secondary"></i>
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
             <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Pending Replies</div>
             <div class="h5 mb-0 font-weight-bold text-secondary">
               <?php
                $sql = "SELECT COUNT(ccm_messages.replied) FROM ccm_messages WHERE asked_by = ? AND replied= ?";

                if ($stmt = $conn->prepare($sql)) {
                  $stmt->bind_param("ii", $param_farmer, $param_replied);

                  $param_farmer = $_GET["farmer"];
                  $param_replied = 0;

                  if ($stmt->execute()) {
                    $result = $stmt->get_result();

                    $count = $result->fetch_row()[0];

                    echo $count;
                  }
                  $result->free();
                }
                $stmt->close();
                ?>
             </div>
           </div>
           <div class="col-auto">
             <i class="fa fa-comments fa-2x text-secondary"></i>
           </div>
         </div>
       </div>
     </div>
   </div>
 </div>
