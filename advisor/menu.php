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
        <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION["advisor_name"]; ?></span>
        <img class="img-profile rounded-circle" src="../profileImages/profileDefault.png">
      </a>
      <!-- Dropdown - User Information -->
      <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
        <a class="dropdown-item" href="<?php echo 'dashboard.php?advisor=' . $_GET['advisor']; ?>">
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
<ul class="navbar-nav bg-info sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center"
     href="<?php echo "dashboard.php?advisor=" . $_SESSION["advisor_id"] ?>">
    <div class="sidebar-brand-icon">
      <i class="fa fa-support"></i>
    </div>
    <div class="sidebar-brand-text mx-3">Advisor</div>
  </a>
  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- Nav Item - Dashboard -->
  <li class="nav-item">
    <a class="nav-link" href="<?php echo "dashboard.php?advisor=" . $_SESSION["advisor_id"] ?>">
      <i class="fa fa-fw fa-tachometer"></i>
      <span>Dashboard</span>
    </a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Heading -->
  <div class="sidebar-heading text-uppercase">
    Farms
  </div>

  <li class="nav-item">
    <a class="nav-link" href="<?php echo "farms.php?advisor=" . $_GET['advisor']; ?>">
      <i class="fa fa-fw fa-map"></i>
      <span>Farm information</span></a>
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
        <a class="collapse-item" href="<?php echo "respond_questions.php?advisor=" . $_GET["advisor"]; ?>">Respond to
          Questions</a>
        <a class="collapse-item" href="<?php echo "create_alert.php?advisor=" . $_GET["advisor"]; ?>">Create Alert</a>
      </div>
    </div>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">



</ul>
<!-- End sidebar --->
