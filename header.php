<?php include "config.php";
include("loginfunction.php");
 
if($_SESSION['username']== "") {
		header("Location: logout.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<!-- Mirrored from www.bootstrapdash.com/demo/connect-plus/jquery/template/demo_3/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 23 Jun 2021 10:39:07 GMT -->
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>EPOD LITE</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="<?php echo $base_url; ?>assets/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="<?php echo $base_url; ?>assets/vendors/flag-icon-css/css/flag-icon.min.css">
  <link rel="stylesheet" href="<?php echo $base_url; ?>assets/vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="<?php echo $base_url; ?>assets/vendors/font-awesome/css/font-awesome.min.css" />
  <link rel="stylesheet" href="<?php echo $base_url; ?>assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <!-- endinject -->
  <!-- Layout styles -->
  <link rel="stylesheet" href="<?php echo $base_url; ?>assets/vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="<?php echo $base_url; ?>assets/css/demo_3/style.css">
  <!-- End layout styles -->
  <link rel="shortcut icon" href="<?php echo $base_url; ?>assets/images/favicon.png" />
  <link rel="stylesheet" href="<?php echo $base_url; ?>assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
  
  <link rel="stylesheet" href="<?php echo $base_url; ?>assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
   <link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
</head>

<body>

<div class="container-scroller">
        <div class="horizontal-menu">
      <nav class="navbar top-navbar col-lg-12 col-12 p-0">
        <div class="container">
          <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
            <a class="navbar-brand brand-logo" href="<?php echo $base_url; ?>dashboard"><img src="<?php echo $base_url; ?>assets/images/logo.png" alt="logo" /></a>
            <a class="navbar-brand brand-logo-mini" href="<?php echo $base_url; ?>dashboard"><img src="<?php echo $base_url; ?>assets/images/logo.png" alt="logo" /></a>
          </div>
          <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
            
            <ul class="navbar-nav navbar-nav-right">
                
                
                       
                 
                
             
              <li class="nav-item nav-language dropdown d-none d-md-flex">
                <a class="nav-link dropdown-toggle" id="languageDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                  <div class="nav-language-icon">
                    <i class="flag-icon flag-icon-us" title="us" id="us"></i>
                  </div>
                  <div class="nav-language-text">
                    <p class="mb-1">English</p>
                  </div>
                </a>
                <div class="dropdown-menu navbar-dropdown" aria-labelledby="languageDropdown">
                  <a class="dropdown-item" href="#">
                    <div class="nav-language-icon mr-2">
                      <i class="flag-icon flag-icon-ae" title="ae" id="ae"></i>
                    </div>
                    <div class="nav-language-text">
                      <p class="mb-1">Arabic</p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="#">
                    <div class="nav-language-icon mr-2">
                      <i class="flag-icon flag-icon-gb" title="GB" id="gb"></i>
                    </div>
                    <div class="nav-language-text">
                      <p class="mb-1 text-black">English</p>
                    </div>
                  </a>
                </div>
              </li>
              <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                  <div class="nav-profile-img">
                                             <img src="https://my-epod.com/epodlite/assets/images/default-avatar.png"" alt="image">
                     
                    <!--<img src="<?php echo $base_url; ?>assets/images/default-avatar.png" alt="image">-->
                  </div>
                  <div class="nav-profile-text">
                    <p class="">Admin</p>
                  </div>
                </a>
                <div class="dropdown-menu navbar-dropdown dropdown-menu-right p-0 border-0 font-size-sm" aria-labelledby="profileDropdown" data-x-placement="bottom-end">
                  <div class="p-3 text-center bg-primary">
                                                  <img class="img-avatar img-avatar48 img-avatar-thumb" src="https://my-epod.com/epodlite/assets/images/default-avatar.png"" alt="image">
                     
                    <!--<img class="img-avatar img-avatar48 img-avatar-thumb" src="<?php echo $base_url; ?>assets/images/default-avatar.png" alt="">-->
                  </div>
                  <div class="p-2">
                    <h5 class="dropdown-header text-uppercase pl-2 text-dark">User Options</h5>
                    <a class="dropdown-item py-1 d-flex align-items-center justify-content-between" href="#">
                      <span>Inbox</span>
                      <span class="p-0">
                        <span class="badge badge-primary">3</span>
                        <i class="mdi mdi-email-open-outline ml-1"></i>
                      </span>
                    </a>
                    <a class="dropdown-item py-1 d-flex align-items-center justify-content-between" href="#">
                      <span>Profile</span>
                      <span class="p-0">
                        <span class="badge badge-success">1</span>
                        <i class="mdi mdi-account-outline ml-1"></i>
                      </span>
                    </a>
                    <a class="dropdown-item py-1 d-flex align-items-center justify-content-between" href="javascript:void(0)">
                      <span>Settings</span>
                      <i class="mdi mdi-settings"></i>
                    </a>
                    <div role="separator" class="dropdown-divider"></div>
                    <h5 class="dropdown-header text-uppercase  pl-2 text-dark mt-2">Actions</h5>
                    <a class="dropdown-item py-1 d-flex align-items-center justify-content-between" href="#">
                      <span>Lock Account</span>
                      <i class="mdi mdi-lock ml-1"></i>
                    </a>
                    <a class="dropdown-item py-1 d-flex align-items-center justify-content-between" href="#">
                      <span>Profile</span>
                      <!--   <i class="mdi mdi-logout ml-1"></i> -->
                    </a>
                    <a class="dropdown-item py-1 d-flex align-items-center justify-content-between" href="<?php echo $base_url; ?>logout.php">
                      <span>Log Out</span>
                      <!--   <i class="mdi mdi-logout ml-1"></i> -->
                    </a>
                  </div>
                </div>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                  <i class="mdi mdi-email-outline"></i>
                  <span class="count-symbol bg-success"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
                  <h6 class="p-3 mb-0 bg-primary text-white py-4">Messages</h6>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <img src="<?php echo $base_url; ?>assets/images/faces/face4.jpg" alt="image" class="profile-pic">
                    </div>
                    <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                      <h6 class="preview-subject ellipsis mb-1 font-weight-normal">Mark send you a message</h6>
                      <p class="text-gray mb-0"> 1 Minutes ago </p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <img src="<?php echo $base_url; ?>assets/images/faces/face2.jpg" alt="image" class="profile-pic">
                    </div>
                    <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                      <h6 class="preview-subject ellipsis mb-1 font-weight-normal">Cregh send you a message</h6>
                      <p class="text-gray mb-0"> 15 Minutes ago </p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <img src="<?php echo $base_url; ?>assets/images/faces/face3.jpg" alt="image" class="profile-pic">
                    </div>
                    <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                      <h6 class="preview-subject ellipsis mb-1 font-weight-normal">Profile picture updated</h6>
                      <p class="text-gray mb-0"> 18 Minutes ago </p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <h6 class="p-3 mb-0 text-center">4 new messages</h6>
                </div>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
                  <i class="mdi mdi-bell-outline"></i>
                  <span class="count-symbol bg-danger"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                  <h6 class="p-3 mb-0 bg-primary text-white py-4">Notifications</h6>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-success">
                        <i class="mdi mdi-calendar"></i>
                      </div>
                    </div>
                    <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                      <h6 class="preview-subject font-weight-normal mb-1">Event today</h6>
                      <p class="text-gray ellipsis mb-0"> Just a reminder that you have an event today </p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-warning">
                        <i class="mdi mdi-settings"></i>
                      </div>
                    </div>
                    <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                      <h6 class="preview-subject font-weight-normal mb-1">Settings</h6>
                      <p class="text-gray ellipsis mb-0"> Update dashboard </p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-info">
                        <i class="mdi mdi-link-variant"></i>
                      </div>
                    </div>
                    <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                      <h6 class="preview-subject font-weight-normal mb-1">Launch Admin</h6>
                      <p class="text-gray ellipsis mb-0"> New admin wow! </p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <h6 class="p-3 mb-0 text-center">See all notifications</h6>
                </div>
              </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="horizontal-menu-toggle">
              <span class="mdi mdi-menu"></span>
            </button>
          </div>
        </div>
      </nav>
	  
      <nav class="bottom-navbar">
        <div class="container">
          <ul class="nav page-navigation" style="width:50%">
            <li class="nav-item">
              <a class="nav-link" href="<?php echo $base_url; ?>dashboard.php">
                <i class="fa fa-dashboard" style="font-size:20px"></i> 
                <span class="menu-title">&nbsp;Dashboard</span>
              </a>
            </li>
            
            
            <li class="nav-item" >
              <a class="nav-link" href="<?php echo $base_url; ?>subscription.php">
                <i class="ti-user menu-icon"></i>
                <span class="menu-title">Subscription</span>
				
              </a>
			
            </li>
            
           <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="ti-settings menu-icon"></i>
                <span class="menu-title">Settings</span>
               </a>
              <div class="submenu">
                <ul class="submenu-item">
					<li class="nav-item"><a class="nav-link" href="<?php echo $base_url; ?>userpwdsetting.php">Profile Reset</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo $base_url; ?>remindersettings.php">Reminder Setting</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo $base_url; ?>subscription-planchange.php">Plan Change</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo $base_url; ?>planexpiredemailnotification.php">Plan Expired Notification</a></li>
					<li class="nav-item"><a class="nav-link" href="<?php echo $base_url; ?>allmailtrack.php">All Mail Track</a></li>
					<li class="nav-item"><a class="nav-link" href="<?php echo $base_url; ?>mailtab.php">Reminder Mail Track</a></li>
                </ul>
              </div>
            </li>
           
           
        
            
           
          </ul>
        </div>
      </nav>
    </div>