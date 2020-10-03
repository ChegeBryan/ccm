    <!-- Topbar -->
    <nav class="navbar navbar-expand navbar-light bg-white topbar fixed-top mb-4 shadow">

      <!-- Sidebar Toggle (Topbar) -->
      <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
      </button>

      <!-- Topbar Navbar -->
      <ul class="navbar-nav ml-auto">

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
             aria-haspopup="true" aria-expanded="false">
            <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION['admin_uname']; ?></span>
            <img class="img-profile rounded-circle" src="../profileImages/profileDefault.png">
          </a>
          <!-- Dropdown - User Information -->
          <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
            <a class="dropdown-item" href="<?php echo 'dashboard.php?admin=' . $_SESSION['admin_id']; ?>">
              <i class="fa fa-user fa-sm fa-fw mr-2 text-secondary"></i>
              Profile
            </a>
            <a class="dropdown-item" href="<?php echo 'edit_profile.php?admin=' . $_SESSION['admin_id']; ?>"">
              <i class=" fa fa-cogs fa-sm fa-fw mr-2 text-secondary"></i>
              Manage Profile
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
              <i class="fa fa-sign-out fa-sm fa-fw mr-2 text-secondary"></i>
              Logout
            </a>
          </div>
        </li>

      </ul>

    </nav>
    <!-- End of Topbar -->

    <!-- Sidebar -->
    <ul class="navbar-nav bg-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center"
         href="<?php echo 'dashboard.php?admin=' . $_SESSION['admin_id']; ?>">
        <div class="sidebar-brand-icon">
          <i class="fa fa-shield"></i>
        </div>
        <div class="sidebar-brand-text text-uppercase mx-3">CCM Admin</div>
      </a>
      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="<?php echo 'dashboard.php?admin=' . $_SESSION['admin_id']; ?>">
          <i class="fa fa-fw fa-dashboard"></i>
          <span>Dashboard</span></a>
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
            <a class="collapse-item" href="<?php echo 'edit_profile.php?admin=' . $_SESSION['admin_id']; ?>">Edit
              Profile</a>
          </div>
        </div>
      </li>


      <!-- Divider -->
      <hr class=" sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading text-uppercase">
        Manage Users
      </div>

      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsers" aria-expanded="true"
           aria-controls="collapsePages">
          <i class="fa fa-user-plus fa-fw"></i>
          <span>New Users</span>
        </a>
        <div id="collapseUsers" class="collapse" aria-labelledby="headingUsers" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Pick Group:</h6>
            <a class="collapse-item" href="<?php echo 'n_farmers.php?admin=' . $_SESSION['admin_id']; ?>">Farmers</a>
            <a class="collapse-item" href="<?php echo 'n_advisors.php?admin=' . $_SESSION['admin_id']; ?>">Advisors</a>
            <a class="collapse-item" href="<?php echo 'n_staff.php?admin=' . $_SESSION['admin_id']; ?>">Staff</a>
          </div>
        </div>
      </li>


      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProfiles"
           aria-expanded="true" aria-controls="collapseProfiles">
          <i class="fa fa fa-users fa-fw"></i>
          <span>View Profiles</span>
        </a>
        <div id="collapseProfiles" class="collapse" aria-labelledby="headingProfile" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Pick Group:</h6>
            <a class="collapse-item" href="<?php echo 'a_farmers.php?admin=' . $_SESSION['admin_id']; ?>">Farmers</a>
            <a class="collapse-item" href="<?php echo 'a_advisors.php?admin=' . $_SESSION['admin_id']; ?>">Advisors</a>
            <a class="collapse-item" href="<?php echo 'a_staff.php?admin=' . $_SESSION['admin_id']; ?>">Staff</a>
          </div>
        </div>
      </li>


      <!-- Divider -->
      <hr class=" sidebar-divider">

      <li class="nav-item">
        <a class="nav-link" href="<?php echo 'county.php?admin=' . $_SESSION['admin_id']; ?>">
          <i class="fa fa-fw fa-compass"></i>
          <span>Counties</span></a>
      </li>

      <!-- Divider -->
      <hr class=" sidebar-divider">

      <li class="nav-item">
        <a class="nav-link" href="<?php echo 'cereal_grain.php?admin=' . $_SESSION['admin_id']; ?>">
          <i class="fa fa-fw fa-compass"></i>
          <span>Cereals & Grains</span></a>
      </li>
      <hr class="sidebar-divider d-none d-md-block">

    </ul>
    <!-- End sidebar --->
