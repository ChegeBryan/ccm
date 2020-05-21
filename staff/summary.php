 <div class="row">
   <div class="col-xl-3 col-md-6 mb-4">
     <div class="card border-bottom-primary shadow-lg h-100 py-2">
       <div class="card-body">
         <div class="row no-gutters align-items-center">
           <div class="col mr-2">
             <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Bookings To Approve</div>
             <div class="h5 mb-0 font-weight-bold text-secondary">
               <?php
                $sql = "SELECT COUNT(id) FROM ccm_bookings WHERE approved = ?";

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
             <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Appointments To Confirm</div>
             <div class="h5 mb-0 font-weight-bold text-secondary">
               <?php
                $sql = "SELECT COUNT(id) FROM ccm_appointments WHERE confirmed = ?";

                if ($stmt = $conn->prepare($sql)) {
                  $stmt->bind_param("i", $param_confirmed);

                  $param_confirmed = 0;

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
             <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Farm input Payments</div>
             <div class="h5 mb-0 font-weight-bold text-secondary">
               <?php
                $sql = "SELECT COALESCE(SUM(ccm_farm_input_payments.amount), 0) FROM ccm_farm_input_payments;";

                if ($result = $conn->query($sql)) {

                  $total = $result->fetch_row()[0];

                  echo "Kshs. " . $total;
                }
                $result->free();
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
             <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Pending Farmer Approvals</div>
             <div class="h5 mb-0 font-weight-bold text-secondary">
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
