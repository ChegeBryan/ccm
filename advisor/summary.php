 <div class="row">
   <div class="col-xl-3 col-md-6 mb-4">
     <div class="card border-bottom-primary shadow-lg h-100 py-2">
       <div class="card-body">
         <div class="row no-gutters align-items-center">
           <div class="col mr-2">
             <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Complaints</div>
             <div class="h5 mb-0 font-weight-bold text-secondary">
               <?php
                $sql = "SELECT COUNT(id) FROM ccm_complaints WHERE handled = ?";

                if ($stmt = $conn->prepare($sql)) {
                  $stmt->bind_param("i", $param_handled);

                  $param_handled = 0;

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
             <i class="	fa fa-bullhorn fa-2x text-muted"></i>
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
             <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Land registered</div>
             <div class="h5 mb-0 font-weight-bold text-secondary">
               <?php
                $sql = "SELECT land_size FROM ccm_land";

                $landsize = 0;

                if ($result = $conn->query($sql)) {
                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_array()) {
                      $landsize += $row['land_size'];
                    }
                    echo $landsize . " Acres";
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
             <i class="fa fa-map fa-2x text-muted"></i>
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
             <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Questions Answered</div>
             <div class="h5 mb-0 font-weight-bold text-secondary">
               <?php
                $sql = "SELECT COUNT(DISTINCT question) FROM ccm_replies WHERE replied_by = ?";

                if ($stmt = $conn->prepare($sql)) {
                  $stmt->bind_param("i", $param_advisor);

                  $param_advisor = intval($_GET['advisor']);

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
             <i class="fa fa-question fa-2x text-secondary"></i>
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
                $sql = "SELECT COUNT(ccm_messages.replied) FROM ccm_messages WHERE replied= ?";

                if ($stmt = $conn->prepare($sql)) {
                  $stmt->bind_param("i", $param_replied);

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
