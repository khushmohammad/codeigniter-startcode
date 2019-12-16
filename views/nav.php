<?php $userTypeSession = $this->session->userdata('U_USER_TYPE'); 
 $SettingMenu =  $this->LoginModel->SettingMenu(); 
$DashboardMenu =  $this->LoginModel->DashboardMenu();
//echo '<pre>'; print_r($SettingMenu); echo '</pre>';  ?>    
  <nav class="navbar navbar-expand bg-light static-top ">
    <div class="col-md-6">
    <a class="navbar-brand" href="<?= site_url('Dashboard'); ?>">Vilayat</a>
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
    <!-- Sidebar
    .sidebar{    
   /* background: url('http://www.vilayat.online/dash/assets/img/sidebar-back.jpg');*/
} -->
    <ul class="sidebar navbar-nav toggled" style="background: url('<?php echo site_url("/assets/img/sidebar-back.jpg")?>')"> 

     <?php foreach($DashboardMenu as $Dashboard){ ?>
            <li class="nav-item">
                 <a href="<?php echo site_url($Dashboard['M_LINK']); ?>" class="nav-link" > 
			     <i class="<?php echo $Dashboard['M_ICON'] ?>"></i>
			     <span><?php echo $Dashboard['M_NAME'] ?></span></a>
            </li>
      <?php  }if($userTypeSession=="SUPERADMIN"){  ?>
        <li class="nav-item" id="dropmenu">
             <a href="#menu1sub1" class="nav-link dropdown-toggle" data-toggle="collapse" aria-expanded="false">
              <i class="fas fa-cogs"></i>
              <span>Setting</span>
            </a>
        </li>  
       <div class="collapse" id="menu1sub1">
           <?php foreach($SettingMenu as $Setting){ ?>
            <li class="nav-item">
                 <a href="<?php echo site_url($Setting['M_LINK']); ?>" class="nav-link" > 
			     <i class="<?php echo $Setting['M_ICON'] ?>"></i>
			     <span><?php echo $Setting['M_NAME'] ?></span></a>
            </li>
           
           <?php }  ?>
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
