<?php
require_once("config.php");

 $resetcnt = mysqli_num_rows(mysqli_query($con,"SELECT * FROM password_reset_history WHERE sid = ".$_GET['id']." AND status='D' "));



if($resetcnt > 0){
   echo "<script> window.location.href = 'index.php?link=C';</script>"; 
}else{}

	if(isset($_POST["register_button"])){
		
	$password = md5($_POST["password"]);
		
	$sqlQueryupdate = "UPDATE users SET password = '".$password."' WHERE userid = '".$_POST["uid"]."' ";
	$result = mysqli_query($con, $sqlQueryupdate);
	
	$sqlQueryinsert1 = "UPDATE password_reset_history SET 

	 status='D' WHERE  sid = '".$_POST["uid"]."' ";   
	 $resultinsert1 = mysqli_query($con, $sqlQueryinsert1);
	
	header('Location:index.php?msg=P');
	
	}

?>

<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
  <meta charset="utf-8" />
  <title>EPOD Lite</title>
  <meta name="description" content="Login page example" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!--begin::Fonts-->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
  <link href="https://my-epod.com/epodtest/assets/login/css/login-615aa.css?v=7.2.2" rel="stylesheet" type="text/css" />
  <link href="https://my-epod.com/epodtest/assets/login/css/plugins.bundle15aa.css?v=7.2.2" rel="stylesheet" type="text/css" />
  <link href="https://my-epod.com/epodtest/assets/login/css/style.bundle15aa.css?v=7.2.2" rel="stylesheet" type="text/css" />

  <!--end::Layout Themes-->
  <link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
  <style>
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

    /* Firefox */
    input[type=number] {
      -moz-appearance: textfield;
    }
    @font-face {
    font-family: 'password';
    src: url(https://jsbin-user-assets.s3.amazonaws.com/rafaelcastrocouto/password.ttf);
    }
    .key {
    font-family: 'password';
    }
    
   
form i {
	margin-left: -30px;
	cursor: pointer;
}

.sizevisit {
    font-size: 24px;
    font-weight: bold;
    color: #145380;
    float: left;
    padding-top: 7px;
    width: 100%;
    padding-bottom: 7px;
}
    
  </style>
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
  <!-- Google Tag Manager (noscript) -->
  <noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5FS8GGP" height="0" width="0" style="display:none;visibility:hidden"></iframe>
  </noscript>
  <!-- End Google Tag Manager (noscript) -->
  <!--begin::Main-->
  <div class="d-flex flex-column flex-root">
    <!--begin::Login-->
    <div class="login login-6 login-signin-on login-signin-on d-flex flex-column-fluid" id="kt_login">
      <div class="d-flex flex-column flex-lg-row flex-row-fluid text-center" style="background-image: url(https://my-epod.com/epodtest/assets/login/img/bg-3.jpg);">
          
        <!--begin:Aside-->
        <div class="d-flex w-100 flex-center p-15">
          <div class="login-wrapper">
            <!--begin:Aside Content-->
            <div class="text-dark-75" >
              <a href="#">
                <img src="https://my-epod.com/epodtest/assets/login/img/housinglogosmall.png" class="max-h-150px" alt="" />
              </a>
              <br>
              <span class="sizevisit">EPOD Lite</span>
              <h3 class="mb-8 mt-22 font-weight-bold" style="margin-top: 4.5rem!important;margin-bottom: -28px !important;font-size: 17px;">TRACK IN SECONDS..</h3>
              <p class="mb-15 text-muted font-weight-bold"></p>
             
            </div>
            <!--end:Aside Content-->
          </div>
        </div>
        <!--end:Aside-->
        <!--begin:Divider-->
        <div class="login-divider">
          <div></div>
        </div>
        <!--end:Divider-->
        <!--begin:Content-->
        <div class="d-flex w-100 flex-center p-15 position-relative overflow-hidden" style="padding:35px!important;">
          <div class="login-wrapper">
		  
				
			   
			   <div id="error">
			   </div>
			   <?php
				if(isset($_SESSION['mailresult'] )){ ?>
				<div class="alert alert-success alert-dismissible fade show" role="alert">
                Registered successfully.Your account is under admin verification                
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>	
				<?php	
				}
			   ?>
            <!--begin:Sign In Form-->
              <div class="login-signin" id="kt_loginsigninform" style="margin: 0 auto;">
              <div class="text-center mb-10 mb-lg-20">
                <h2 class="font-weight-bold">Reset Password</h2>
                <p class="text-muted font-weight-bold"></p>
              </div>
              <form id="login-form" method="post" action="" accept-charset="UTF-8" autocomplete="off" class="form text-left">


                <div class="form-group">
                  <label for="exampleInputUsername1">Password</label>
                  <input type="password"  required id="password" name="password" autocomplete="off" style="width:100%;border: 1px solid #e4e6ef;padding: .65rem 1rem;"><i class="bi bi-eye-slash" id="togglePassword"></i>
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Confirm Password</label>
                  <input type="password"  style="width:100%;border: 1px solid #e4e6ef;padding: .65rem 1rem;" required id="c_password" name="c_password" autocomplete="off"/><i class="bi bi-eye-slash" id="togglePassword1"></i>
                </div>



                <div class="form-group d-flex flex-wrap justify-content-between align-items-center mt-5">
                  <!-- <div class="checkbox-inline">
                                            <label class="checkbox m-0 text-muted font-weight-bold">
                                            <input type="checkbox" name="remember" />
                                            <span></span>Remember me</label>
                                        </div> -->
                 
                </div>
                <div class="text-center mt-15">
					<input type="hidden" name="uid" value="<?php echo $_GET['id'];?>">
                  <button type="button" class="btn btn-success mr-2" onclick="passwordcheck()" id="register_button" style="float:right;margin-left:-3%;background-color:#32BA30;">Submit</button>
                  <button type="submit" id="formsubmit" name="register_button" style="display: none;" class="btn btn-success mr-2" style="float:right;margin-left:-3%;background-color:#32BA30;">Submit</button>
                
                </div>
              </form>
            </div>
            <!--end:Sign In Form-->
            <!--begin:Sign Up Form-->
            
            </div>
            <!--end:Forgot Password Form-->
          </div>
        </div>
        <!--end:Content-->
      </div>
    </div>
    <!--end::Login-->
  
  <!--end::Main-->
  <!--begin::Global Config(global config for global JS scripts)-->

  <!--end::Global Config-->
  <!--begin::Global Theme Bundle(used by all pages)-->
  <script src="https://my-epod.com/epodtest/assets/login/js/plugins.bundle15aa.js?v=7.2.2"></script>
  <script src="https://my-epod.com/epodtest/assets/login/js/prismjs.bundle15aa.js?v=7.2.2"></script>
  <script src="https://my-epod.com/epodtest/assets/login/js/scripts.bundle15aa.js?v=7.2.2"></script>
  <!--end::Global Theme Bundle-->
  <script src="https://my-epod.com/epodtest/assets/login/js/login-general15aa.js?v=7.2.2"></script>
  <!--end::Page Scripts-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script type="text/javascript" src="script/validation.min.js"></script>

  <script type="text/javascript">
  function passwordcheck() {
		
      var pass = $("#password").val();
      var pass1 = $("#c_password").val();
      if (pass != pass1) {
        alert('Password and Confirm password does not match');
      } else {
        $("#formsubmit").trigger("click");
      }

    }
    
const togglePassword1 = document.querySelector("#togglePassword1");
const togglePassword = document.querySelector("#togglePassword");
const password = document.querySelector("#password");
const password1 = document.querySelector("#c_password");

togglePassword.addEventListener("click", function () {
	// toggle the type attribute
	const type = password.getAttribute("type") === "password" ? "text" : "password";
	
	password.setAttribute("type", type);
	
	// toggle the icon
	this.classList.toggle("bi-eye");
});

togglePassword1.addEventListener("click", function () {
	// toggle the type attribute
	
	const type = password1.getAttribute("type") === "password" ? "text" : "password";
	
	password1.setAttribute("type", type);
	// toggle the icon
	this.classList.toggle("bi-eye");
});



	</script>
</body>
<!--end::Body-->
</html>