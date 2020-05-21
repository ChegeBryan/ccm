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
      <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="mr-2 d-none d-lg-inline text-secondary small"><?php echo $_SESSION["staff_fullname"]; ?></span>
        <img class="img-profile rounded-circle" src="../profileImages/profileDefault.png">
      </a>
      <!-- Dropdown - User Information -->
      <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
        <a class="dropdown-item" href="<? echo 'dashboard.php?staff=' . $_GET['staff']; ?>">
          <i class="fa fa-user fa-xs fa-fw mr-2 text-secondary"></i>
          Profile
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
<ul class="navbar-nav bg-dark sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo "dashboard.php?staff=" . $_SESSION["staff_id"] ?>">
    <div class="sidebar-brand-icon">
      <i class="fa fa-support"></i>
    </div>
    <div class="sidebar-brand-text mx-3">Staff</div>
  </a>
  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- Nav Item - Dashboard -->
  <li class="nav-item">
    <a class="nav-link" href="<?php echo "dashboard.php?staff=" . $_SESSION["staff_id"] ?>">
      <i class="fa fa-fw fa-tachometer"></i>
      <span>Dashboard</span>
    </a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Heading -->
  <div class="sidebar-heading text-uppercase">
    CCM Visits
  </div>

  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseApprovedVisits" aria-expanded="true" aria-controls="collapseApprovedVisits">
      <i class="fa fa-truck fa-fw"></i>
      <span>Approved Visits</span>
    </a>
    <div id="collapseApprovedVisits" class="collapse" aria-labelledby="headingApprovedVisits" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Visit Type:</h6>
        <a class="collapse-item" href="<?php echo "a_bookings.php?staff=" . $_GET["staff"]; ?>">Bookings</a>
        <a class="collapse-item" href="<?php echo "a_appointments.php?staff=" . $_GET["staff"]; ?>">Appointments</a>
      </div>
    </div>
  </li>

  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseVisits" aria-expanded="true" aria-controls="collapseVisits">
      <i class="fa fa-truck fa-fw"></i>
      <span>Pending Approval</span>
    </a>
    <div id="collapseVisits" class="collapse" aria-labelledby="headingVisits" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Visit Type:</h6>
        <a class="collapse-item" href="<?php echo "n_bookings.php?staff=" . $_GET["staff"]; ?>">Bookings</a>
        <a class="collapse-item" href="<?php echo "n_appointments.php?staff=" . $_GET["staff"]; ?>">Appointments</a>
      </div>
    </div>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Heading -->
  <div class="sidebar-heading text-uppercase">
    Payments Desk
  </div>

  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePaymentsDesk" aria-expanded="true" aria-controls="collapsePaymentsDesk">
      <i class="fa fa-money fa-fw"></i>
      <span>Payments Desk</span>
    </a>
    <div id="collapsePaymentsDesk" class="collapse" aria-labelledby="headingPaymentsDesk" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Payment Options:</h6>
        <a class="collapse-item" href="<?php echo "p_payment.php?staff=" . $_GET["staff"]; ?>">Farmer
          Produce Payment</a>
        <a class="collapse-item" href="<?php echo "i_payments.php?staff=" . $_GET["staff"]; ?>">Farm input
          Payments</a>
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
