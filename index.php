<?php
require_once("config.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use Dompdf\Dompdf;
// Reference the Options namespace 
use Dompdf\Options; 
// Reference the Font Metrics namespace 
use Dompdf\FontMetrics; 

require_once 'PHPMailer/src/Exception.php';
require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';



if(isset($_GET["id"])){
		
		
	$usertab=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `users` WHERE userid = '".$_GET["id"]."' "));	
	
	if($usertab["mailentry"] != 'C'){
		
	$current_date = date("Y-m-d");
	$todaydate = date('Y-m-d');
	$plan = $usertab["plan_id"];
	
	if ($plan == 4) {
      $end_date = date('Y-m-d', strtotime("+12 months", strtotime($current_date)));
      $plan_name = 'Premium';
      $plan_duration = '1 Year';
    } else if ($plan == 1) {
      $end_date = date('Y-m-d', strtotime("+30 days", strtotime($current_date)));

      $plan_name = 'Free Trial (30 Days)';
      $plan_duration = '30 Days';
    } else if ($plan == 2) {
      $end_date = date('Y-m-d', strtotime("+3 months", strtotime($current_date)));

      $plan_name = 'Silver';
      $plan_duration = '3 Months';
    }else if ($plan == 3) {
      $end_date = date('Y-m-d', strtotime("+6 months", strtotime($current_date)));

      $plan_name = 'Gold';
      $plan_duration = '6 Months';
    }else {
     
    }	
		
		
	$sqlQueryupdate = "UPDATE users SET status = 'Verified' , plan_start = '".$todaydate."', plan_expire = '".$end_date."', mailentry = 'C' WHERE userid = '".$_GET["id"]."' ";
	$result = mysqli_query($con, $sqlQueryupdate);
	
	
	
	
	$plantable=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `plan_details` WHERE id = '".$usertab["plan_id"]."' "));
	
	
	
	
	
	$dupQry = mysqli_num_rows(mysqli_query($con,"SELECT * FROM `subscription_history` WHERE subscriber_id = '".$_GET["id"]."' AND
	plan_start = '".$todaydate."' AND plan_end = '".$end_date."' AND plan_id= '".$usertab["plan_id"]."' AND status = 'New'"));	
	
	$invoicetab=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `invoice_table` WHERE sid = '".$_GET["id"]."' order by id desc limit 1 "));
	
	mysqli_query($con,"UPDATE invoice_table SET status = 'R'  WHERE sid = '".$_GET["id"]."' order by id desc limit 1");
	
	
	if($dupQry == 0){
	$sqlQueryinsertagain = "INSERT INTO subscription_history SET  subscriber_id = '".$_GET["id"]."' , 
	plan_start = '".$todaydate."', plan_end = '".$end_date."',create_date = NOW(),
	plan_id= '".$usertab["plan_id"]."', status = 'New',invoiceno = '".$invoicetab["invoiceno"]."' ";
	
	$resultinsert1 = mysqli_query($con, $sqlQueryinsertagain);
	}
	
	
	$dupQry1 = mysqli_num_rows(mysqli_query($con,"SELECT * FROM `mail_history` WHERE subscriber_id = '".$_GET["id"]."' AND
	plan_start = '".$current_date."' AND plan_end = '".$end_date."' AND plan_id= '".$usertab["plan_id"]."' AND status = 'Awaiting Approved Email' AND type= 'Receipt'"));	
	
	
	
	$email = $usertab["email"];
	$invoiceno = $invoicetab["invoiceno"];
	
	if($dupQry1 == 0){
	$sqlQueryinsertagain1 = "INSERT INTO mail_history SET  subscriber_id = '".$_GET["id"]."' , 
	plan_start = '".$current_date."', plan_end = '".$end_date."',plan_name = '".$plan_name."', amount = '".$plantable["amount"]."' ,create_date = NOW(),
	plan_id= '".$usertab["plan_id"]."', email = '".$email."', status = 'Awaiting Approved Email' , type= 'Receipt' , invoiceno = '".$invoiceno."' ";
	
	$resultinsert2 = mysqli_query($con, $sqlQueryinsertagain1);
	
	}
  
	$clientsubject = "Account Verified - Receipt No:  $invoiceno";
	
	$clientbody = '<html><body>';
	
	
	$clientbody .= '<table rules="all" style="border-color: #666;" cellpadding="10" align="center">';
	$clientbody .= "<tr style='background: #eee;'><td colspan='2' align='center'><img src='https://my-epod.com/epodlite/assets/login/img/housinglogosmall.png' width='200' height='200'/></tr>";
	$clientbody .= "<tr style='background: #eee;'><td colspan='2' align='center'></td></tr>";
	$clientbody .= "<tr style='background: #eee;'><td colspan='2' align='center'><strong>Account  verified!</strong></td></tr>";
	$clientbody .= "<tr style='background: #eee;'><td colspan='2' align='center'><strong>Login Credentials:</strong></td></tr>";
	$clientbody .= "<tr style='background: #eee;'><td><strong>Email:</strong> </td><td>" . $usertab["email"] . "</td></tr>";
	
	$clientbody .= "</table>";
	$clientbody .= "</body></html>";
	
	
	
	
	require 'dompdf/autoload.inc.php';
        
    // instantiate and use the dompdf class
   $options = new Options(); 
   $options->set('isPhpEnabled', 'true'); 
        
    // instantiate and use the dompdf class
    $pdf = new DOMPDF($options);
	
	$fname = '
              <!DOCTYPE html>
                <html lang="en">
                  <head>
                      <title>Invoice</title>
                      <meta charset="utf-8">
                      <meta name="viewport" content="width=device-width, initial-scale=1">
                      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
                  </head>
                  <body>
                      <STYLE type="text/css">
                     
                      </STYLE>
                    <DIV id="page_1">
                      <DIV class="dclr"></DIV>
                      <TABLE cellpadding=0 cellspacing=0 border="0" width="100%">
                      
					  <tr style="border-bottom:1px solid grey;">
                        <td>
                          <table>
                            <tr style="width:100%;float:right;" rowspan="10">
                            <td>
							<img src="https://my-epod.com/epodlite/assets/login/img/housinglogosmall.png" width="200" height="200"/>
							</td>
							</tr>
                          </table>
                        </td>
						
						<td></td>
						
						<td align="right">
                          <table >
                            <tr style="width:100%;">
								<td align="right">
									<span style="font-size:25px;"><b>SUBSCRIPTION INVOICE</b></span>
								</td>
							</tr>
                            <tr style="width:100%;">
                            <td align="right"><b>Follo Pte. Ltd.,</b></td>
							</tr>
							<tr style="width:100%;">
                            <td align="right">Block A, Floor A-28-09,</td>
							</tr>
							<tr style="width:100%;">
                            <td align="right">Trefoil@Setia City,</td>
							</tr>
							<tr style="width:100%;">
                            <td align="right">Jalan SetiaDagang Ah U13/AH,</td>
							</tr>
							<tr style="width:100%;">
                            <td align="right">Seksyen U13, 40170 Setia Alam,</td>
							</tr>
							<tr style="width:100%;">
                            <td align="right">Selangor Darul Ehsan, Malaysia</td>
							</tr>
							<tr style="width:100%;">
                            <td align="right"></td>
							</tr>
							<tr style="width:100%;">
                            <td align="right">Admin</td>
							</tr>
							<tr style="width:100%;">
                            <td align="right">0333625017</td>
							</tr>
							<tr style="width:100%;">
                            <td align="right">track@my-epod.com</td>
							</tr>
							<tr style="width:100%;">
                            <td align="right">www.my-epod.com</td>
							</tr>
							<tr style="width:100%;">
                            <td align="right"></td>
							</tr>
                          </table>
                        </td>
                      </tr>
					  
					  <tr>
					  <td></td>
					  <td></td>
					  <td></td>
					  </tr>
					  
					  <tr>
					  <td style="height:40px"></td>
					  <td></td>
					  <td></td>
					  </tr>
					  
					  
					  
					  <tr>
					  <td style="height:30px"></td>
					  <td></td>
					  <td></td>
					  </tr>
                     
                      <tr>
					  <td colspan="3" style="height:20px">
						<table border="1" width="100%" style="border-left:0;border-right:0;">
							<tr>
							<td></td>
							<td align="center"><b>'.$usertab["contact_person"].'</b></td>
								<td align="center"><b>'.$usertab["contact_person"].'</b></td>
							  <td align="center"><b>Invoice No</b></td>
							  <td align="center">'.$invoicetab["invoiceno"].'</td>
							</tr>
							<tr>
							  <td align="center"><b>PLAN (FROM - TO)</b></td>
							  <td align="center"><b>PLAN</b></td>
							  <td align="center"><b>PRICE</b></td>
							  <td align="center"><b>DISCOUNT</b></td>
							  <td align="center"><b>TOTAL AMOUNT</b></td>
							 </tr>
							 <tr>
							  <td align="center">'.date("d-m-Y",strtotime($current_date)).' to '.date("d-m-Y",strtotime($end_date)).'</td>
							  <td align="center">'.$plantable["plan_type"].'</td>
							  <td align="center">'.number_format($plantable["amount"], 2, '.', '').'</td>
							  <td align="center"><b></b></td>
							  <td align="center">'.number_format($plantable["amount"], 2, '.', '').'</td>
							 </tr>
							 <tr>
							  <td></td>
							  <td></td>
							  <td></td>
							  <td>Total(MYR):</td>
							  <td align="center">'.number_format($plantable["amount"], 2, '.', '').'</td>
							 </tr>
						</table>
					  
					  </td>
					  </tr>
					  
					  <tr>
					  <td style="height:40px"></td>
					  <td></td>
					  <td></td>
					  </tr>
					  
					  
					  
					  <tr>
					  <td colspan="3" align="right"><b>Issued By Signature:</b></td>
					  </tr>
					  
					  <tr>
					  
					  <td colspan="3" align="right"><img src="https://my-epod.com/epodtest/sign.png" /></td>
					  </tr>
                     
					 
                     
                     
                     
                      
                       
                  </table>
                </DIV>
                  </body>
                </html>';
				
				
		$filename    = "Receipt.pdf";

        $pdf->set_option('isRemoteEnabled', true);
        //$this->dompdf->set_option('enable_html5_parser', TRUE);
        // Load HTML content
        $pdf->loadHtml($fname);
        // (Optional) Setup the paper size and orientation
        $pdf->setPaper('legal', 'portrait');
        // Render the HTML as PDF
        $pdf->render();
        
        
        $canvas = $pdf->getCanvas(); 
		
		
		
		// Instantiate font metrics class 
$fontMetrics = new FontMetrics($canvas, $options); 
 
// Get height and width of page 
$w = $canvas->get_width(); 
$h = $canvas->get_height(); 
 
// Get font family file 
$font = $fontMetrics->getFont('times'); 
 
// Specify watermark text 
$text = "PAID"; 
 
// Get height and width of text 
$txtHeight = $fontMetrics->getFontHeight($font, 75); 
$textWidth = $fontMetrics->getTextWidth($text, $font, 75); 
 
// Set text opacity 
$canvas->set_opacity(.1); 
 
// Specify horizontal and vertical position 
$x = (($w-$textWidth)/2); 
$y = (($h-$txtHeight)/1.6); 
 
// Writes text at the specified x and y coordinates 
$canvas->text($x, $y, $text, $font, 75); 
        
        
        
        $file = $pdf->output();
        file_put_contents($filename, $file); 
   
    //Load composer's autoloader

    $mail = new PHPMailer;                            
   
        //Server settings
        $mail->isSMTP();                                     
        $mail->Host = $mailhost;                      
        $mail->SMTPAuth = true;                             
        $mail->Username = $mailusername;     
        $mail->Password = $mailpwd;             
                               
        $mail->SMTPSecure = 'ssl';                           
        $mail->Port = 465;                                   

        //Send Email
        $mail->setFrom($mailsetfrom, 'EPOD Lite');
        
        //Recipients
        $mail->addAddress($email);
        $mail->AddAttachment($filename);
        
        //Content
        $mail->isHTML(true);                                  
      

        
			
		$mail->Subject = $clientsubject;
        $mail->Body    = $clientbody;	
		
		$mail->send();	
		
	
    
	
	}else{ header('Location:index.php?MC=Y'); }
	
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
	label.error{
  color: red;
  font-size: 13px;
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
                <img src="https://my-epod.com/epodtest/assets/login/img/housinglogosmall.png" class="max-h-75px" alt="" />
              </a>
              <span class="sizevisit">EPOD Lite</span>
              <h3 class="mb-8 mt-22 font-weight-bold" style="margin-top: 4.5rem!important;margin-bottom: -28px !important;font-size: 17px;">TRACK IN SECONDS..</h3>
              <p class="mb-15 text-muted font-weight-bold"></p>
              <button type="button" id="kt_loginsignup" class="btn btn-outline-primary btn-pill py-4 px-9 font-weight-bold">Get An Account</button>
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
				if(isset($_GET['mailresult'] )){ ?>
				<div class="alert alert-success alert-dismissible fade show" role="alert">
                Registered successfully.Your account is under admin verification                
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>	
				<?php	
				}
			   ?>
			   
			   <?php
				if(isset($_GET['link'] )){ ?>
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
               Link Closed.Please Contact admin!                
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>	
				<?php	
				}
			   ?>
			   
			     <?php
				if(isset($_GET['MC'] )){ ?>
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
               Link Closed.Please Check!                
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>	
				<?php	
				}
			   ?>
			   
			   <?php
				if(isset($_GET['msg'])){ ?>
				<div class="alert alert-success alert-dismissible fade show" role="alert">
                Your Password Updated!              
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>	
				<?php	
				}
			   ?>
			   
			   <?php
				if(isset($_GET['fid'] )){ 
				$usertabemail=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `users` WHERE userid = '".$_GET["fid"]."' "));
				$usertabemailval =  $usertabemail["email"];
				?>
				<div class="alert alert-success alert-dismissible fade show" role="alert">
                Password reset link has been sent to your email - <?php echo $usertabemailval;?>.               
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>	
				<?php	
				}
			   ?>
			   
			   <?php
				if(isset($_GET['nmfid'] )){ 
				
				?>
				<div class="alert alert-danger alert-dismissible fade show" role="alert">
                E-mail id not available.               
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
                <h2 class="font-weight-bold">Sign In</h2>
                <p class="text-muted font-weight-bold">Enter your email and password</p>
              </div>
              <form id="login-form" method="post" accept-charset="UTF-8" autocomplete="off" class="form text-left">


                <div class="form-group">
                  <label for="exampleInputUsername1">Email</label>
                  <input type="email" class="form-control" id="exampleInputUsername1" name="email" placeholder="" style="text-transform:lowercase;" 
				  autocomplete="off">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Password</label>
                  <input type="text" class="form-control key" id="exampleInputEmail1" name="password" placeholder="" autocomplete="off">
                </div>



                <div class="form-group d-flex flex-wrap justify-content-between align-items-center mt-5">
                  <!-- <div class="checkbox-inline">
                                            <label class="checkbox m-0 text-muted font-weight-bold">
                                            <input type="checkbox" name="remember" />
                                            <span></span>Remember me</label>
                                        </div> -->
                  <a href="javascript:;" id="kt_loginforgot" class="text-muted text-hover-primary font-weight-bold">Forgot Password ?</a>
                </div>
                <div class="text-center mt-15">
                  <button type="submit" name="login_button" value="submit" id="login_button" style="float: left;" class="btn btn-primary mr-2">Submit</button>
                  <button id="ktoginsignupook" type="button" class="btn btn-light" style="float: right;">Register</button>

                </div>
              </form>
            </div>
            <!--end:Sign In Form-->
            <!--begin:Sign Up Form-->
            <div class="login-signup" id="ktloginsignup_form">
              <div class="text-center mb-10 mb-lg-20">
                <h3 class="">Registration</h3>
                <p class="text-muted font-weight-bold">Enter your details to create your account</p>
              </div>
              <form   method="post" class="form-sample" id="register_form">

                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label">Company Name</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" required name="company_name" style="text-transform:capitalize;" autocomplete="off"/>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label">Contact Person</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" required name="contact_person" style="text-transform:capitalize;" autocomplete="off"/>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label">Register Type</label>
                      <div class="row" style="margin-top:2%;">
                      <div class="col-sm-1">
                        </div>
                        <div class="col-sm-3">
                          <div class="form-check">
                            <label class="form-check-label" >
                              <input type="radio" class="form-check-input" required name="membershipRadios" id="membershipRadios1" value="ROB" checked> ROB </label>
                          </div>
                        </div>
                        <div class="col-sm-1">
                        </div>
                        <div class="col-sm-4">
                          <div class="form-check">
                            <label class="form-check-label">
                              <input type="radio" class="form-check-input" name="membershipRadios" id="membershipRadios2" value="ROC"> ROC </label>
                          </div>
                        </div>
                        
                        <div class="col-sm-2">
                          <div class="form-check">
                            <label class="form-check-label">
                              <input type="radio" class="form-check-input" name="membershipRadios" id="membershipRadios2" value="ROS"> ROS </label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label">Register No</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" required name="identification_no" autocomplete="off"/>
                      </div>
                    </div>
                  </div>

                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label">Address</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" required name="address" style="text-transform:capitalize;" autocomplete="off"/>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label">Username</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" required name="username" style="text-transform:capitalize;" autocomplete="off"/>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label">Email</label>
                      <div class="col-sm-8">
                        <input type="email" class="form-control" required name="email" style="text-transform:lowercase;" autocomplete="off"/>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label">Password</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control key" required id="password" name="password" autocomplete="off"/>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label">Contact Number</label>
                      <div class="col-sm-8">
                        <input type="number" class="form-control" required name="contact_no" autocomplete="off" />
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label">Confirm Password</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control key" required id="c_password" name="c_password" autocomplete="off"/>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">

                  <div class="col-md-6">
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label"></label>
                      <div class="col-sm-8">
                        <input type="file" id="file" name="user_image" onchange="changeLogoemployee(this)" />
                        <label for="file" class="btn-2">upload Logo</label>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group row">
                      <div class="file_prev"></div>
                    </div>
                  </div>
                </div>

                <!-- <div class="row">

                  <div class="col-md-12">
                    <div class="form-group row">
                      <label class="col-sm-1 col-form-label"></label>
                      <div class="col-sm-8">
                      <label class="checkbox checkbox-outline font-weight-bold">
                                            <input type="checkbox" required=""/>
                                            <span></span>Accept our
                                           <a href="https://my-epod.com/epodtest/Welcome/Terms" target="blank" style="padding-left: 4px;padding-right: 5px;">Terms & Conditions</a> | <a href="https://my-epod.com/epodtest/Welcome/Privacy" target="blank" style="padding-left:5px;">Privacy Policy</a></label>
                                      
                      </div>
                    </div>
                  </div>
                 
                </div> -->





                <div class="form-group col-lg-12 col-md-12">


                  <button id="ktloginsignupcancel1" style="float:right;" type="button" class="btn btn-light">Cancel</button>
                  <button type="button" class="btn btn-success mr-2" onclick="passwordcheck()" id="register_button" style="float:right;margin-left:-3%;background-color:#32BA30;">Submit</button>
                  <button type="submit" id="formsubmit" name="register_button" style="display: none;" class="btn btn-success mr-2" style="float:right;margin-left:-3%;background-color:#32BA30;">Submit</button>
                
				</div>
              </form>
            </div>
            <!--end:Sign Up Form-->
            <!--begin:Forgot Password Form-->
            <div class="login-forgot" id="ktloginforgot_form">
              <div class="text-center mb-10 mb-lg-20">
                <h3 class="">Forgot Password ?</h3>
                <p class="text-muted font-weight-bold">Enter your email to reset your password</p>
              </div>

              <form class="form text-left" action="https://my-epod.com/epodtest/forgotpassword.php" method="post" accept-charset="UTF-8" autocomplete="off">
                <div class="form-group py-2 m-0">
                  <input class="form-control h-auto border-0 px-0" type="email" placeholder="Enter Email" name="email" autocomplete="off" required="" style="text-transform: lowercase;border-bottom: 1px solid #e4e6ef !important;" />
                </div>
                <div class="form-group d-flex flex-wrap flex-center mt-10">
                  <button id="" class="btn btn-primary btn-pill font-weight-bold px-9 py-4 my-3 mx-2" type="submit">Reset My Password</button>
                  <span id="ktloginsignupcancel2" class="btn btn-outline-primary btn-pill font-weight-bold px-9 py-4 my-3 mx-2">Cancel</span>
                </div>
              </form>
            </div>
            <!--end:Forgot Password Form-->
          </div>
        </div>
        <!--end:Content-->
      </div>
    </div>
    <!--end::Login-->
  </div>
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

  
  $('document').ready(function() { 
	/* handling form validation */
	$("#login-form").validate({
		rules: {
			password: {
				required: true,
			},
			email: {
				required: true,
				email: true
			},
		},
		messages: {
			password:{
			  required: "please enter your password"
			 },
			  email: "please enter your email address",
		},
		submitHandler: submitForm	
	});	   
	/* Handling login functionality */
	function submitForm() {		
	
		var data = $("#login-form").serialize();				
		$.ajax({				
			type : 'POST',
			url  : 'loginfunction.php',
			data : data,
			beforeSend: function(){	
				$("#error").fadeOut();
				$("#login_button").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; sending ...');
			},
			success : function(response){						
				if(response=="ok"){									
					$("#login_button").html('Signing In ...');
					setTimeout(' window.location.href = "reminderemail.php?"; ',10);
				} else {									
					$("#error").fadeIn(1000, function(){						
						$("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+response+' !</div>');
						$("#login_button").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Sign In');
					});
				}
			}
		});
		return false;
	}   
	
	
	$("#register_form").validate({
		rules: {
			password: {
				required: true,
			},
			
		},
		messages: {
			password:{
			  required: "please enter your password"
			 },
			  
		},
		submitHandler: registerForm	
	});	   
	/* Handling login functionality */
	function registerForm() {		
	
		var data = $("#register_form").serialize();				
		$.ajax({				
			type : 'POST',
			url  : 'loginfunction.php',
			data : data,
			beforeSend: function(){	
				$("#error").fadeOut();
				$("#formsubmit").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; sending ...');
			},
			success : function(response){						
				if(response=="ok"){									
					$("#formsubmit").html('Signing In ...');
					setTimeout(' window.location.href = "plan.php"; ',10);
				} else {									
					$("#error").fadeIn(1000, function(){						
						$("#error").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; '+response+' !</div>');
						$("#formsubmit").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Sign In');
					});
				}
			}
		});
		return false;
	}   
	
	
	
	
});
  
    function changeLogoemployee(obj) {

      $(".gif-loader").show();
      var file_data = $(obj).prop('files')[0];
      var form_data = new FormData();
      form_data.append('file', file_data);

      $.ajax({
        url: "loginfunction.php",
        type: "POST",
        data: form_data,
        contentType: false,
        cache: false,
        processData: false,
        success: function(data) {
          $(".gif-loader").hide();
          setTimeout(function() {
            $(obj).closest('.topempld').addClass('removeBackground');
            $('.file_prev').html('<img src="https://my-epod.com/epodtest/uploads/profile/' + data + '" class="img-responsive img-profile" style="width:78px;"/><input type="file" name="companylogoloademp" id="companylogoloademp" onchange="changeLogoemployee(this)" /><input type="hidden" class="form-control" id="getfileprofile" name="getfileprofile" value=' + data + '> ');
          }, 200);
        }
      });
    }


    function passwordcheck() {
		
      var pass = $("#password").val();
      var pass1 = $("#c_password").val();
      if (pass != pass1) {
        alert('Password and Confirm password does not match');
      } else {
        $("#formsubmit").trigger("click");
      }

    }


    $('#ktoginsignupook').click(function() {
      $("#ktloginsignup_form").show();
	  $("#tshide").hide();
      $("#kt_loginsigninform").hide();
	  $("#error").hide();
      $(".alert-warning").hide();
      $(".alert-success").hide();

    });

    $('#kt_loginsignup').click(function() {

      $("#ktloginsignup_form").show();
	  $("#tshide").hide();
      $("#kt_loginsigninform").hide();
      $("#ktloginforgot_form").hide();
	  $("#error").hide();
      $(".alert-warning").hide();
      $(".alert-success").hide();
	  
    });

    $('#kt_loginforgot').click(function() {

      $("#ktloginforgot_form").show();
      $("#ktloginsignup_form").hide();
      $("#kt_loginsigninform").hide();
	  $("#error").hide();
      $(".alert-warning").hide();
      $(".alert-success").hide();
	  
    });

    $('#ktloginsignupcancel1').click(function() {
      $("#ktloginforgot_form").hide();
      $("#ktloginsignup_form").hide();
      $("#kt_loginsigninform").show();
	  $("#error").hide();
      $(".alert-warning").hide();
      $(".alert-success").hide();
	  
    });

    $('#ktloginsignupcancel2').click(function() {
      $("#ktloginforgot_form").hide();
      $("#ktloginsignup_form").hide();
      $("#kt_loginsigninform").show();
	   $("#error").hide();
      $(".alert-warning").hide();
      $(".alert-success").hide();
	 
    });
  </script>
  
  <style type="text/css">
  
    .login-signin {
      width: 530px;
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

    ::-webkit-input-placeholder {
      color: #000 !important;
      text-transform: capitalize !important;
    }

    [type="file"] {
      height: 0;
      overflow: hidden;
      width: 0;
    }

    [type="file"]+label {
      background: #3699ff;
      border: none;
      border-radius: 5px;
      color: #fff;
      cursor: pointer;
      display: inline-block;
      font-family: 'Rubik', sans-serif;
      font-size: inherit;
      text-transform: uppercase;
      font-weight: 500;
      margin-bottom: 1rem;
      outline: none;
      font-weight: bold;
      padding: 11px 22px;
      position: relative;
      transition: all 0.3s;
      vertical-align: middle;
    }

    .login.login-6 .login-wrapper {
      max-width: none;
    }

    .mt-22,
    .my-22 {
      margin-top: 2.5rem !important;
    }

    .max-h-75px {
      width: 37%;
      max-height: none !important;
    }

    .mb-lg-20,
    .my-lg-20 {
      margin-bottom: 3rem !important;
    }

    .placeholder-dark-75 {
      border-bottom: 1px solid #e4e6ef !important;
      text-transform: capitalize;
    }

    .formCard .wrapper label {
      pointer-events: auto;
      background: #141c1c;
      color: #fff;
    }

    .formCard .wrapper input {
      border: solid 1px #fff;
      color: #fff;
    }

    .formCard .wrapper>form {
      padding: 11px 0px 0px;
    }

    .p-b-45 {
      padding-bottom: 0px;
    }

    .custom-file-upload {
      display: inline-block;
      padding: 27px 26px;
      cursor: pointer;
      width: 100px;
      height: 100px;
      color: white;
      top: 12px;
      border: 1px solid #ececec;
      background: cornflowerblue;
    }

    .p2050 {
      padding: 0px 50px;
    }

    .custom-file-upload {
      padding: 10px 10px;
      cursor: pointer;
      width: 121px;
      height: 43px;
    }


    .login-footer {
      margin-top: 16px;
    }

    .gif-loader {
      background-color: rgba(100, 100, 100, 0.24);
      color: #333;
      position: fixed;
      height: 100%;
      width: 100%;
      z-index: 5000;
      top: 0;
      left: 0;
      float: left;
      text-align: center;
      padding-top: 25%;
      opacity: .80;
    }

    .spinner {
      margin: 0 auto;
      height: 64px;
      width: 65px;
      animation: rotate 0.7s infinite linear;
      border: 9px solid #46607C;
      border-right-color: transparent;
      border-radius: 50%;
    }

    @keyframes rotate {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(360deg);
      }
    }

    .note_file_link {
      float: right;
      width: 57%;
    }

    .custom-file-upload {
      position: relative;
      right: 100px;
    }

    .file_prev {
      position: relative;
      right: 58px;
      margin-bottom: -27px;
    }

    .form-wrapper img {
      width: 100%;
      max-width: 114px;
      height: 86px;
      /* height: auto; */
    }

    .form-header {
      margin: 17px -27px 14px;
    }

    .loginbtm {
      margin-top: 143px;
      margin-bottom: 8px;
      margin-left: -42px;
      float: left;
      width: 100%;
    }
  </style>
  
</body>
<!--end::Body-->
</html>