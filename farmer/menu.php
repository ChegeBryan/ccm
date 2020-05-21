<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar fixed-top mb-4 shadow">

  <!-- Sidebar Toggle (Topbar) -->
  <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
    <i class="fa fa-bars"></i>
  </button>

  <!-- Topbar Navbar -->
  <ul class="navbar-nav ml-auto">

    <div class="d-none d-sm-block"></div>

    <!-- Nav Item - User Information -->
    <li class="nav-item dropdown no-arrow">
      <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
         aria-haspopup="true" aria-expanded="false">
        <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION["farmer_fullname"]; ?></span>
        <img class="img-profile rounded-circle" src="../profileImages/profileDefault.png">
      </a>
      <!-- Dropdown - User Information -->
      <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
        <a class="dropdown-item" href="<? echo 'dashboard.php?farmer=' . $_GET['farmer']; ?>">
          <i class="fa fa-user fa-xs fa-fw mr-2 text-secondary"></i>
          Profile
        </a>
        <a class="dropdown-item" href="<? echo 'edit_profile.php?farmer=' . $_GET['farmer']; ?>">
          <i class="fa fa-cogs fa-xs fa-fw mr-2 text-secondary"></i>
          Manage Profile
        </a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
          <i class="fa fa-sign-out fa-fw mr-2 text-secondary"></i>
          Logout
        </a>
      </div>
    </li>

  </ul>

</nav>
<!-- End of Topbar -->

<!-- Sidebar -->
<ul class="navbar-nav bg-success sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center"
     href="<?php echo "dashboard.php?farmer=" . $_SESSION["farmer_id"] ?>">
    <div class="sidebar-brand-icon">
      <i class="fa fa-leaf"></i>
    </div>
    <div class="sidebar-brand-text mx-3">FARMER</div>
  </a>
  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- Nav Item - Dashboard -->
  <li class="nav-item">
    <a class="nav-link" href="<?php echo "dashboard.php?farmer=" . $_SESSION["farmer_id"] ?>">
      <i class="fa fa-fw fa-tachometer"></i>
      <span>Dashboard</span>
    </a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Heading -->
  <div class="sidebar-heading text-uppercase">
    Profile
  </div>

  <!-- Nav Item - Pages Collapse Menu -->
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
       aria-controls="collapseTwo">
      <i class="fa fa-fw fa-cog"></i>
      <span>Manage Profile</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Profile options:</h6>
        <a class="collapse-item active" href="<?php echo "edit_profile.php?farmer=" . $_GET["farmer"] ?>">Edit
          Profile</a>
      </div>
    </div>
  </li>

  <!-- Nav Item - Utilities Collapse Menu -->
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFarm" aria-expanded="true"
       aria-controls="collapseFarm">
      <i class="fa fa fa-leaf fa-fw"></i>
      <span>Farm</span>
    </a>
    <div id="collapseFarm" class="collapse" aria-labelledby="headingFarm" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Farm Options:</h6>
        <a class="collapse-item" href="<?php echo "land.php?farmer=" . $_GET["farmer"] ?>">Land
          information</a>
      </div>
    </div>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Heading -->
  <div class="sidebar-heading text-uppercase">
    CCM Visits
  </div>

  <!-- Nav Item - Pages Collapse Menu -->
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true"
       aria-controls="collapsePages">
      <i class="fa fa-calendar fa-fw"></i>
      <span>Bookings</span>
    </a>
    <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Booking Pages:</h6>
        <a class="collapse-item" href="<?php echo "produce_delivery.php?farmer=" . $_GET["farmer"]; ?>">Produce
          delivery</a>
        <a class="collapse-item" href="<?php echo "appointment_booking.php?farmer=" . $_GET["farmer"]; ?>">Appointments
          to CCM</a>
      </div>
    </div>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Heading -->
  <div class="sidebar-heading text-uppercase">
    CCM Help Desk
  </div>

  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseHelpDesk" aria-expanded="true"
       aria-controls="collapseHelpDesk">
      <i class="fa fa-comments fa-fw"></i>
      <span>Help Desk</span>
    </a>
    <div id="collapseHelpDesk" class="collapse" aria-labelledby="headingHelpDesk" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Help Desk Options:</h6>
        <a class="collapse-item" href="<?php echo "farm_expert.php?farmer=" . $_GET["farmer"]; ?>">Farm Expert</a>
        <a class="collapse-item" href="<?php echo "complaint.php?farmer=" . $_GET["farmer"]; ?>">Raise Complaint</a>
      </div>
    </div>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">

  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>
<!-- End sidebar --->
