<?php
require_once("config.php");

use Dompdf\Dompdf;
// Reference the Options namespace 
use Dompdf\Options; 
// Reference the Font Metrics namespace 
use Dompdf\FontMetrics;   
   
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

error_reporting(E_ALL);
   ini_set("display_errors", 1);
   


require_once 'PHPMailer/src/Exception.php';
require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';

if(isset($_POST['formsubmit'])) {

	$planid = $_POST["plan"];
	
	$plantable=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `plan_details` WHERE id = '".$planid."' "));
	$plan = $plantable["id"];
	
	
	$policytable=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `policies` WHERE 1"));
	
	
	$current_date = date("Y-m-d");
	
	if ($plan == 4) {
      $end_date = date('Y-m-d', strtotime("+12 months", strtotime($current_date)));
      $plan_name = 'Premium (1 Year)';
      $plan_duration = '1 Year';
    } else if ($plan == 1) {
      $end_date = date('Y-m-d', strtotime("+30 days", strtotime($current_date)));

      $plan_name = 'Free Trial (30 Days)';
      $plan_duration = '30 Days';
    } else if ($plan == 2) {
      $end_date = date('Y-m-d', strtotime("+3 months", strtotime($current_date)));

      $plan_name = 'Silver (3 Months)';
      $plan_duration = '3 Months';
    }else if ($plan == 3) {
      $end_date = date('Y-m-d', strtotime("+6 months", strtotime($current_date)));

      $plan_name = 'Gold (6 Months)';
      $plan_duration = '6 Months';
    }else {
     
    }
	
	
	
	$remindertable=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `reminder_history` WHERE id = '".$_POST["rid"]."' "));
	
	$usertab=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `users` WHERE userid = '".$remindertable["subscriber_id"]."' "));
	
	if($usertab["renewalentry"] != 'C'){
		
	
	$renewal_date = date('Y-m-d', strtotime("+3 days", strtotime($remindertable["plan_end"])));

	mysqli_query($con,"UPDATE `reminder_history` SET new_plan_id = '".$plan."' ,renewal_status = 'Y' WHERE id = '".$_POST["rid"]."' ");
	
	
	mysqli_query($con,"UPDATE `users` SET current_plan_id='".$plan."' , renewal_status = 'Y', renewal_date = '".$renewal_date."', renewalentry = 'C' WHERE userid  = '".$remindertable["subscriber_id"]."' ");	
		
	
 
	
	
	$invoiceno = mysqli_num_rows(mysqli_query($con,"SELECT * FROM `invoice_table`"));
	
	if($invoiceno == 0){
		$invoiceno = 1;
		
	}else{
		$invoiceno++;
	}
	
	$sqlQueryinsertagain = mysqli_query($con,"INSERT INTO invoice_table SET  sid = '".$remindertable["subscriber_id"]."' , status = 'P', invoiceno = '".$invoiceno."' ,create_date = NOW() ");
	
	$current_date = date("Y-m-d");
	
	$email=$usertab['email'];	
	
	
	$dupQry1 = mysqli_num_rows(mysqli_query($con,"SELECT * FROM `mail_history` WHERE subscriber_id = '".$remindertable["subscriber_id"]."' AND
	plan_start = '".$current_date."' AND plan_end = '".$end_date."' AND plan_id= '".$plan."' AND status = 'Expired Renewal Email' AND type= 'Invoice'"));	
			
	if($dupQry1 == 0){
		$sqlQueryinsertagain1 = "INSERT INTO mail_history SET  subscriber_id = '".$remindertable["subscriber_id"]."' , 
		plan_start = '".$current_date."', plan_end = '".$end_date."',plan_name = '".$plan_name."', amount = '".$plantable["amount"]."' ,create_date = NOW(),
		plan_id= '".$plan."', email = '".$email."', status = 'Expired Renewal Email' , type= 'Invoice' , invoiceno = '".$invoiceno."'  ";
			
		$resultinsert2 = mysqli_query($con, $sqlQueryinsertagain1);
			
	}
	
	
		
		
	$clientsubject = "Account Renewal - Invoice No: $invoiceno";
	
	$clientbody = '<html><body>';
	
	
	$clientbody .= '<table rules="all" align="center" style="border-color: #666;" cellpadding="10">';
	$clientbody .= "<tr style='background: #eee;'><td colspan='2' align='center'><img src='https://my-epod.com/epodlite/assets/login/img/housinglogosmall.png' width='200' height='200'/></tr>";
	$clientbody .= "<tr style='background: #eee;'><td colspan='2' align='center'><strong>Account Renewed!</strong></td></tr>";
	$clientbody .= "<tr style='background: #eee;'><td colspan='2' align='center'><strong>Account is under admin verification!</strong></td></tr>";
	$clientbody .= "<tr style='background: #eee;'><td colspan='2' align='center'><strong>Login Credentials:</strong></td></tr>";
	$clientbody .= "<tr style='background: #eee;'><td><strong>Email:</strong> </td><td>" . $usertab['email'] . "</td></tr>";
	
	$clientbody .= "</table>";
	$clientbody .= "</body></html>";
	
	
	
	
	
	require 'dompdf/autoload.inc.php';
        
    // instantiate and use the dompdf class
   	// Set options to enable embedded PHP 
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
						
						
						
						<td align="right" colspan="2">
                           <table style="border-left:0;border-right:0;" align="right" width="100%">
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
					  
					  <tr><td colspan="3" style="height:70px;"></td></tr>
					  
					  <tr>
					  <td>
					  For,  <br><p> '.$usertab['contact_person'].' <br> '.$usertab['company_name'].' <br> '.$usertab['address'].' <br> '.$usertab['mobile'].'</p>
					  </td>
					  <td colspan="2">
						<table border="0" width="100%" style="margin-right:0;">
							<tr>
							  <td align="center"><b>Invoice No</b></td>
							  <td align="center">'.$invoiceno.'</td>
							</tr>
							<tr>
							  <td align="center"><b>Issue Date</b></td>
							  <td align="center">'.date("d-m-Y",strtotime($current_date)).'</td>
							</tr>
						    <tr>
							  <td align="center"><b>Valid Until</b></td>
							  <td align="center">'.date("d-m-Y",strtotime($end_date)).'</td>
							</tr>
						</table>
					  
					  </td>
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
					  
					  
					  
					  
                     
					 <tr><td colspan="3" style="height:420px;"></td></tr>
                     
					   <tr>
						<td colspan="3">
   
				
							  <div  style="border-top:1px solid grey;float: left;width: 100%;font-size: 12px!important;color: #555555;text-align: initial;margin-bottom: 3px;text-align: justify;">
							  Beneficiary Name: <b>FOLLO SDN. BHD.</b> Account No: <b>2293044629</b> Beneficiary Bank: <b>United Overseas Bank(Malaysia) Bhd</b> Bank Address: <b>Wisma UOB, 2108, Jalan Meru, Kawasan 17, 41050 Klang, Selangor, Malaysia</b>
							  SWIFT Code: <b>UOVBMYKL</b>
							  </div>
				
			
							</td>
						</tr>
                     
                     
                     
                      
                       
                  </table>
                </DIV>
                  </body>
                </html>';
				
				
		$filename    = "Invoice.pdf";

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
$text = "UN PAID"; 
 
// Get height and width of text 
$txtHeight = $fontMetrics->getFontHeight($font, 75); 
$textWidth = $fontMetrics->getTextWidth($text, $font, 75); 
 
// Set text opacity 
$canvas->set_opacity(.1); 
 
// Specify horizontal and vertical position 
$x = (($w-$textWidth)/2); 
$y = (($h-$txtHeight)/3); 
 
// Writes text at the specified x and y coordinates 
$canvas->text($x, $y, $text, $font, 75); 
        
        
        $file = $pdf->output();
        file_put_contents($filename, $file);
	
   
    //Load composer's autoloader

    $mail1 = new PHPMailer;                            
    
        //Server settings
        $mail1->isSMTP();                                     
        $mail1->Host = $mailhost;                      
        $mail1->SMTPAuth = true;                             
        $mail1->Username = $mailusername;     
        $mail1->Password = $mailpwd;             
                               
        $mail1->SMTPSecure = 'ssl';                           
        $mail1->Port = 465;                                   

        //Send Email
        $mail1->setFrom($mailsetfrom, 'EPOD Lite');
        
        //Recipients
        $mail1->addAddress($email);              
        
        
        //Content
        $mail1->isHTML(true);                                  
        $mail1->Subject = $clientsubject;
        $mail1->Body    = $clientbody;
		$mail1->AddAttachment($filename);

       $mail1->send();
	
	
	header('Location:index.php?mailresult=Y');
    
	
	}else{ header('Location:index.php?MC=Y'); }
	}
	
?>

<html lang="en"><!-- Mirrored from www.bootstrapdash.com/demo/connect-plus/jquery/template/demo_3/pages/samples/pricing-table.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 23 Jun 2021 10:40:33 GMT --><head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>EPOD Lite</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="https://my-epod.com/epodlite/assets/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="https://my-epod.com/epodlite/assets/vendors/flag-icon-css/css/flag-icon.min.css">
  <link rel="stylesheet" href="https://my-epod.com/epodlite/assets/vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <!-- endinject -->
  <!-- Layout styles -->
  <link rel="stylesheet" href="https://my-epod.com/epodlite/assets/css/demo_3/style.css">
  <!-- End layout styles -->
  <link rel="shortcut icon" href="https://my-epod.com/epodlite/assets/images/favicon.png">

  <style>
    h2 {
     
      text-transform: uppercase;
      text-align: center;
      color: #325d88;
      margin-bottom: 20px;
    }

    .pricing {
      width: 100%;
      margin: 0 auto;
    }
    .duration{
      font-size:15px!important;
    }

    .pricing .panel {
      cursor: pointer;
      float: left;
      width: 25%;
      border-radius: 0;
      text-align: center;
      transition: all .5s;
    }

    .panel-default>.panel-heading {
      padding: 2px;
      background-color: white;
    }

    .panel-default>.panel-heading h3 {
      background-color: #DAF5D9;
      color: black;
      padding: 20px 10px;
      
      font-weight: 400;
      font-size: 16px;
      margin: 0;
      text-transform: uppercase;
      /* text-shadow: 1px 1px 4px #000; */
      position: relative;
      transition: all .5s;
    }

    .panel-default>.panel-heading h3 span {
      display: block;
      margin-top: 6px;
      font-size: 28px;
      font-weight: 700;
    }

    h3 .fa-check {
      position: absolute;
      top: 10px;
      right: 10px;
      text-shadow: none;
      opacity: 0;
    }

    .panel .panel-body {
      padding: 2px;
      background-color: white;
      height: 300px;
    }

    .table-container {
      background-color: #eee;
      /* background-image: linear-gradient(#f0f0fa, #d0d0d5); */
      height: 100%;
    }

    .panel-body .table th {
     
      font-size: 18px;
      font-weight: 400;
      color: #555;
      text-align: center;
    }

    .panel.active {
      box-shadow: 0 0 2px #999;
      margin-top: -10px;
    }

    .panel.active h3 {
      background-color: #0062FF;
      color: #fff;
    }

    .active .fa-check {
      opacity: 1;
    }
    .mt-5, .my-5 {
    margin-top: 0rem !important;
   }
   .mb-5, .my-5 {
    margin-bottom: 1rem !important;
   }
   .pt-5, .py-5 {
    padding-top: 0rem !important;
   }
  </style>
</head>

<body>
  <div class="container-scroller">
    <!-- partial:../../partials/_horizontal-navbar.html -->
    <div class="horizontal-menu">
      <nav class="navbar top-navbar col-lg-12 col-12 p-0">
        <div class="container">
          <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
            <a class="navbar-brand brand-logo"><img src="https://my-epod.com/epodlite/assets/images/logo.png" alt="logo"></a>
            <a class="navbar-brand brand-logo-mini"><img src="https://www.bootstrapdash.com/demo/connect-plus/jquery/template/assets/images/logo-mini.svg" alt="logo"></a>
          </div>

        </div>
      </nav>

    </div>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <div class="main-panel">
        <div class="content-wrapper">

          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <div class="container text-center pt-5">
                    <h4 class="mb-3 mt-5">Start up your Bussiness today</h4>
                    <p class="w-75 mx-auto mb-5">Choose a plan that suits you the best. If you are not fully satisfied, we offer 3-day money-back guarantee no questions asked!!</p>
                    

                      <div class="pricing">
                       <h2>Select a Plan Below</h2>
						<div class=" panel panel-default " >
                          
                             <h4 class="mb-3 mt-5"> Customer Details </h4>
                              <?php
							  $remindertable=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `reminder_history` WHERE id = '".$_GET["rid"]."' "));
	
							  $usertab=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `users` WHERE userid = '".$remindertable["subscriber_id"]."' "));
							  ?>
							  <table class="table">
							  <tr><td>Name :</td><td><?php echo $usertab["username"];?></td></tr>
							  <tr><td>email :</td><td><?php echo $usertab["email"];?></td></tr>
							  <tr><td>Current Plan  :</td><td><?php echo $usertab["plan_name"];?></td></tr>
							  </table>
                         
                        </div>
                        
                        <div class="panel panel-default option-starter" onclick="chooseplan(2);">
                          <div class="panel-heading">
                            <h3>
                              Silver
                              <span class="price">$15</span>
                              <span class="duration">3 Months</span>
                              <i class="fa fa-check"></i>
                            </h3>
                          </div>
                          <div class="panel-body">
                            <div class="table-container">
                              <table class="table">
                                <thead>
                                  <tr>
                                    <th>FEATURES</th>
                                  </tr>
                                </thead>
                                <tbody><tr>
                                  <td>10 GB Storage</td>
                                </tr>
                                <tr>
                                  <td>1000 page views per month</td>
                                </tr>
                                <tr>
                                  <td>Insatiable Desire for a Little more</td>
                                </tr>
                              </tbody></table>
                            </div>
                          </div>
                        </div>

                        <div class="panel panel-default option-starter" onclick="chooseplan(3);">
                          <div class="panel-heading">
                            <h3>
                             Gold
                              <span class="price">$50</span>
                              <span class="duration">6 Months</span>
                              <i class="fa fa-check"></i>
                            </h3>
                          </div>
                          <div class="panel-body">
                            <div class="table-container">
                              <table class="table">
                                <thead>
                                  <tr>
                                    <th>FEATURES</th>
                                  </tr>
                                </thead>
                                <tbody><tr>
                                  <td>10 GB Storage</td>
                                </tr>
                                <tr>
                                  <td>1000 page views per month</td>
                                </tr>
                                <tr>
                                  <td>Insatiable Desire for a Little more</td>
                                </tr>
                              </tbody></table>
                            </div>
                          </div>
                        </div>

                        <div class="panel panel-default option-premium" onclick="chooseplan(4);">
                          <div class="panel-heading">
                            <h3>
                              Premium 
                              <span class="price">$200</span>
                              <span class="duration">1 Year</span>
                              <i class="fa fa-check"></i>
                            </h3>
                          </div>
                          <div class="panel-body">
                            <div class="table-container">
                              <table class="table">
                                <thead>
                                  <tr>
                                    <th>FEATURES</th>
                                  </tr>
                                </thead>
                                <tbody><tr>
                                  <td>Enter card information to see price</td>
                                </tr>
                                <tr>
                                  <td>100 GB Storage</td>
                                </tr>
                                <tr>
                                  <td>Unlimited Page Views</td>
                                </tr>
                                <tr>
                                  <td>Finally, some satisfaction!</td>
                                </tr>
                              </tbody></table>
                            </div>
                          </div>
                        </div>

                      </div>
					 
                      <div class="wrapper" style="">
                      <form action="" method="post" class="form-sample">
                      <input type="hidden" name="plan" id="plan" value="0">
                       <input type="hidden" name="rid"  value="<?php echo $_GET["rid"];?>">
						<button type="submit" id="formsubmit" name="formsubmit" style="display: none;"  class="btn btn-outline-primary btn-block col-md-3">Proceed</button>
                        <button type="button" onclick="plancheck();" style="float: right;margin-top:2%;" class="btn btn-outline-primary btn-block col-md-3">Proceed</button>

                        </form>
                      </div>
                   
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <footer class="footer">
          <div class="footer-inner-wraper">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
              <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2018 <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap Dash</a>. All rights reserved.</span>
              <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted &amp; made with <i class="mdi mdi-heart text-danger"></i></span>
            </div>
          </div>
        </footer>

      </div>
      <!-- main-panel ends -->















    </div>
    <!-- page-body-wrapper ends -->
  </div>

  <script>
    $(".panel").click(function() {
      $(".panel").removeClass("active");
      $(this).addClass("active");
    });

    function plancheck() {
      var plan = $("#plan").val();
      if (plan==0) {
        alert('Please Choose a Plan to Proceed');
        
      } else {
        $("#formsubmit").trigger("click");
      }


    }


    function chooseplan(val){

      $("#plan").val(val);
	  
	
    }
	
	
	
	
	

  </script>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="https://my-epod.com/epodlite/assets/vendors/js/vendor.bundle.base.js"></script>

  <!-- endinject -->
  <!-- Plugin js for this page -->
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="https://my-epod.com/epodlite/assets/js/off-canvas.js"></script>
  <script src="https://my-epod.com/epodlite/assets/js/hoverable-collapse.js"></script>
  <script src="https://my-epod.com/epodlite/assets/js/misc.js"></script>
  <script src="https://my-epod.com/epodlite/assets/js/settings.js"></script>
  <script src="https://my-epod.com/epodlite/assets/js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page -->
  <!-- End custom js for this page -->


<!-- Mirrored from www.bootstrapdash.com/demo/connect-plus/jquery/template/demo_3/pages/samples/pricing-table.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 23 Jun 2021 10:40:33 GMT -->

</body></html>