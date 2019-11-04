<?php $userTypeSession = $this->session->userdata('U_USER_TYPE'); ?>

  <nav class="navbar navbar-expand navbar-light header-background static-top border border-bottom">
    <div class="col-md-6">
    <a class="navbar-brand" href="<?= site_url('Dashboard'); ?>">Dashboard</a>
    <button style="display: none;" class="btn btn-link btn-sm text-white" id="sidebarToggle" href="#">
      <i class="fas fa-bars"></i>
    </button>
    <!-- Navbar Search -->
   </div>
  <div class="col-md-6">
    <!-- Navbar -->
    <ul class="navbar-nav" style="float: right;">
      <li class="nav-item dropdown no-arrow mx-1">
        <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span class="badge badge-danger">9+</span>
          <i class="fas fa-bell fa-fw"></i>
         
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>
    
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-user-circle fa-fw"></i>
        </a>
        <div  class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
          <a class="dropdown-item" href="#">Settings</a>          
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
        </div>
      </li>
    </ul>
    </div>
  </nav>

  <div id="wrapper">
    <!-- Sidebar -->
 <?php if($userTypeSession=="SUPERADMIN" || "ADMIN" || "EMPLOYEE"){  ?>

    <ul class="sidebar navbar-nav toggled">
      <li class="nav-item">
        <a class="nav-link" href="<?= site_url('Dashboard'); ?>">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </a>
      </li> 
      <li class="nav-item">
        <a class="nav-link" href="charts.html">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Charts</span></a>
      </li>
    <?php } ?>
    <!--   <li class="nav-item">
        <a class="nav-link" href="tables.html">
          <i class="fas fa-fw fa-table"></i>
          <span>Tables</span></a>
      </li> -->  
      <?php if($userTypeSession=="SUPERADMIN"){  ?>
        <li class="nav-item" id="dropmenu">
             <a href="#menu1sub1" class="nav-link dropdown-toggle" data-toggle="collapse" aria-expanded="false">
              <i class="fas fa-fw fa-folder"></i>
              <span>Setting</span>
            </a>
        </li>  
       <div class="collapse" id="menu1sub1">
          <li class="nav-item">
          <a href="<?php echo site_url('Dashboard/AdminUser'); ?>" class="nav-link" > <i class="fas fa-fw fa-folder"></i><span>Users</span></a>
          </li>
      </div> 
    <?php } ?>
      
    </ul>

    <div id="content-wrapper">
         <!-- /.container-fluid -->
        <div class="container-fluid">
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="<?= site_url('Welcome/Logout'); ?>">Logout</a>
        </div>
      </div>
    </div>
  </div>
