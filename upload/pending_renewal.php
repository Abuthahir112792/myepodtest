<?php 
include("header.php");


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


if(isset($_POST['tempValues']))
{
	
		
	$i = 0;	
	//$temparr = explode(",",$_POST['tempValues']); 
	$tempname = array_values(array_filter($_FILES['invimg']['tmp_name'])); 
	$imgname= array_values(array_filter($_FILES['invimg']['name']));
	
	
	foreach($_POST['tempValues'] as $arrval){
		
		$usertab=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `users` WHERE userid = '".$arrval."' "));
		
		$plantable=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `plan_details` WHERE id = '".$usertab["current_plan_id"]."' "));
		$plan = $usertab["current_plan_id"];
		
		$current_date = $usertab["plan_expire"];
		
		if($usertab["plan_expire"] >= $current_date){
			
			$current_date = $usertab["plan_expire"];
		}else{
			
			$current_date = date('Y-m-d');
		}
		
		
		$todaydate = date('d-m-Y');
		
		
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
		
		
		
		$sqlQueryupdate = "UPDATE users SET plan_id = '".$plan."' , plan_name = '".$plan_name."' ,renewal_status = 'C', plan_start = '".$current_date."', plan_expire = '".$end_date."' WHERE userid = '".$arrval."' ";
		$result = mysqli_query($con, $sqlQueryupdate);
		
		$invoicetab=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `invoice_table` WHERE sid = '".$arrval."' order by id desc limit 1 "));
		mysqli_query($con,"UPDATE invoice_table SET status = 'R'  WHERE sid = '".$arrval."' order by id desc limit 1");	
				
	
	$dupQry = mysqli_num_rows(mysqli_query($con,"SELECT * FROM `subscription_history` WHERE subscriber_id = '".$arrval."' AND
	plan_start = '".$current_date."' AND plan_end = '".$end_date."' AND plan_id= '".$plan."' AND status = 'Renewed'"));	
	
	if($dupQry == 0){
	$sqlQueryinsertagain = "INSERT INTO subscription_history SET  subscriber_id = '".$arrval."' , 
	plan_start = '".$current_date."', plan_end = '".$end_date."',create_date = NOW(),
	plan_id= '".$plan."', status = 'Renewed' ,invoiceno = '".$invoicetab["invoiceno"]."' ";
	
	$resultinsert1 = mysqli_query($con, $sqlQueryinsertagain);
	
	}
	
	$email = $usertab["email"];
	$invoiceno =	$invoicetab["invoiceno"];
	
	$dupQry1 = mysqli_num_rows(mysqli_query($con,"SELECT * FROM `mail_history` WHERE subscriber_id = '".$arrval."' AND
	plan_start = '".$current_date."' AND plan_end = '".$end_date."' AND plan_id= '".$plan."' AND status = 'Renewal Approved Email' AND type= 'Receipt'"));	
			
	if($dupQry1 == 0){
		$sqlQueryinsertagain1 = "INSERT INTO mail_history SET  subscriber_id = '".$arrval."' , 
		plan_start = '".$current_date."', plan_end = '".$end_date."',plan_name = '".$plan_name."', amount = '".$plantable["amount"]."' ,create_date = NOW(),
		plan_id= '".$plan."', email = '".$email."', status = 'Renewal Approved Email' , type= 'Receipt' , invoiceno = '".$invoiceno."'  ";
			
		$resultinsert2 = mysqli_query($con, $sqlQueryinsertagain1);
			
	}
	
	
	
	
	
	
	//print_r($_FILES['invimg']['name']);
	
		// Loop through every file
		 
		   //The temp file path is obtained
		   $tmpFilePath = $tempname[$i];
		   //A file path needs to be present
		   if ($tmpFilePath != ""){
			  //Setup our new file path
			   $pics    = $arrval.$invoicetab["invoiceno"].$imgname[$i];
			  
			  $newFilePath = "./uploads/invoice/" .$pics;
			  //File is uploaded to temp dir
			  if(move_uploaded_file($tmpFilePath, $newFilePath)) {
				  
				  $sqlQueryupdatedet = "UPDATE invoice_table SET  invoice_file = '".$imgname[$i]."'
					WHERE  invoiceno = '".$invoicetab["invoiceno"]."' ";
					$result = mysqli_query($con, $sqlQueryupdatedet);
				 //Other code goes here
			  }
		   }
		
	
	
	
  
	$clientsubject = "Account Renewed - Receipt No: $invoiceno";
	
	$clientbody = '<html><body>';
	
	
	$clientbody .= '<table rules="all" style="border-color: #666;" cellpadding="10" align="center">';
	$clientbody .= "<tr style='background: #eee;'><td colspan='2' align='center'><img src='https://my-epod.com/epodlite/assets/login/img/housinglogosmall.png' width='200' height='200'/></tr>";
	$clientbody .= "<tr style='background: #eee;'><td colspan='2' align='center'><strong>Account verified!</strong></td></tr>";
	$clientbody .= "<tr style='background: #eee;'><td colspan='2' align='center'><strong>Account is verified!</strong></td></tr>";
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
                    <DIV id="page_2" >
                      <DIV class="dclr"></DIV>
                      <TABLE cellpadding=0 cellspacing=0 border="0" width="100%" height="100%">
                      
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
					  
					   <tr><td colspan="3" style="height:70px;"></td></tr>
					  
					  <tr>
					  <td>
					  For,  <br><p>'.$usertab['contact_person'].' 
					  <br> '.$usertab['company_name'].' <br> '.$usertab['address'].' <br> '.$usertab['mobile'].'</p>
					  </td>
					  <td colspan="2">
						<table border="0" width="100%" style="border-left:0;border-right:0;">
							<tr>
							  <td align="center"><b>Receipt No</b></td>
							  <td align="center">'.$invoicetab["invoiceno"].'</td>
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
							  <td align="center">'.date("d-m-Y",strtotime($current_date)).' to '.date("d-m-Y",strtotime($usertab["plan_expire"])).'</td>
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
					  
					  <td colspan="3" align="right" ><img src="https://my-epod.com/epodtest/sign.png" /></td>
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
$y = (($h-$txtHeight)/2); 
 
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
        
        
        //Content
        $mail->isHTML(true);                                  
      

        
			
		$mail->Subject = $clientsubject;
        $mail->Body    = $clientbody;	
		$mail->addAddress($email);
		$mail->AddAttachment($filename);
		$mail->send();	
		
	$i++;		
		
	}
	
	 echo "<script> window.location.href = 'pending_renewal.php?msg=Y';</script>";
	
}


?>
<style>
  a.disabled {
    pointer-events: none;
    cursor: default;
  }
  
   table,
              td {
                white-space: normal !important;
              }

               .table.dataTable {
                border-collapse: collapse !important;border: 1px solid rgba(0, 0, 0, 0.125);
              }
</style>
<!-- partial -->
<div class="container-fluid page-body-wrapper">
  <div class="main-panel">
    <div class="content-wrapper">
      
      <div class="row">
        <div class="col-md-12">
          <div class="d-sm-flex justify-content-between align-items-center transaparent-tab-border {">
            <ul class="nav nav-tabs tab-transparent" role="tablist">
				
			 <li class="nav-item">
                <a  class="nav-link" href="subscription.php" role="tab" aria-selected="false">All Subscribers</a>
              </li>	
				
             <li class="nav-item">
                <a class="nav-link" href="awaiting_approval.php" role="tab" aria-selected="false">Approvals</a>
              </li>
              
             
			  
              <li class="nav-item">
                <a class="nav-link"  href="due_reminder.php" role="tab" aria-selected="false">Due</a>
              </li>
			  
			  <li class="nav-item">
                 <a class="nav-link active"  href="pending_renewal.php" role="tab" aria-selected="false">Pending Renewal</a>
              </li>
			  
			  <li class="nav-item">
                 <a class="nav-link"  href="planexpired.php" role="tab" aria-selected="false">Plan Expired</a>
              </li>
              
            </ul>
            <div class="d-md-block d-none">
              <a href="#" class="text-light p-1"><i class="mdi mdi-view-dashboard"></i></a>
              <a href="#" class="text-light p-1"><i class="mdi mdi-dots-vertical"></i></a>
            </div>
          </div>
          <div class="tab-content tab-transparent-content">
            
			
			
            <style>
             
            </style>

            <div class="tab-pane fade show  <?php if(!isset($_GET["err"])){?>active <?php } ?>" id="approvals" role="tabpanel" aria-labelledby="business-tab">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title" style="margin-bottom: 8px;">Pending Renewal</h4>
                  <div class="row">
                    <div class="col-12">
					
					<?php if(isset($_GET["msg"])){?>
					<div class="alert alert-success show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                        </button>
                        Approved successfully.                       
					</div>
					<?php } ?>
					
                      <div style="min-height:500px;">
                         <form   method="post" class="form-sample" action="" id="form_id" enctype='multipart/form-data'>  
                        <table id="order-listing1" class="table" style="" border="1">
                          <thead>
                              <tr><td colspan="17" align="right"><input type="submit" name="add" id="add" class="btn btn-info" style="padding: 15px 32px;" value="Approve" onclick="myFunctionapprove()" ></td></tr>
                            <tr>
                              <th style="text-align: center;font-weight: bold;color: #4b4b4C;">S.No</th>
                              <th style="text-align: center;font-weight: bold;color: #4b4b4C;">Company Name</th>
                              <th style="text-align: center;font-weight: bold;color: #4b4b4C;">Contact Person</th>
                              <th style="text-align: center;font-weight: bold;color: #4b4b4C;">Register Type</th>
                              <th style="text-align: center;font-weight: bold;color: #4b4b4C;">Register No</th>
                              <th style="text-align: center;font-weight: bold;color: #4b4b4C;">Address</th>
                              <th style="text-align: center !important;font-weight: bold;color: #4b4b4C;">Username</th>
                              <th style="text-align: center!important;font-weight: bold;color: #4b4b4C;">Email</th>
                              <th style="text-align: center !important;font-weight: bold;color: #4b4b4C;">Contact</th>
                              <th style="text-align: center;font-weight: bold;color: #4b4b4C;">Plan Duration</th>
							   <th style="text-align: center;font-weight: bold;color: #4b4b4C;">Invoice No</th>
							  <th style="text-align: center;font-weight: bold;color: #4b4b4C;">Paid Status</th>
							  <th style="text-align: center;font-weight: bold;color: #4b4b4C;">Upload Files</th>
							  <th style="text-align: center;font-weight: bold;color: #4b4b4C;">Plan Date</th>
							  <th style="text-align: center;font-weight: bold;color: #4b4b4C;">Renew Date</th>
                              <th style="text-align: center;font-weight: bold;color: #4b4b4C;">Status</th>
                              <th style="text-align: center;font-weight: bold;color: #4b4b4C;">Actions</th>
                            </tr>
                          </thead>
                          <tbody>
								
								<?php
								$i=1;
								
								$sql 	= "SELECT * FROM users WHERE  renewal_status = 'Y' AND renewal_date >= DATE(NOW()) ORDER BY userid";
								$result = mysqli_query($con,$sql); 
								
								while( $row = mysqli_fetch_array($result)){ 
									$invoicetab=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `invoice_table` WHERE sid = '".$row['userid']."' order by id desc limit 1 "));
								
									$url = "pdfdisplayinvoice.php?id=".$invoicetab["invoiceno"];
								?>
								<tr>
								  <td><?php echo $i;?></td>
                                  <td style="text-transform: capitalize;color: #676767;text-align: center !important;"><?php echo $row['company_name']; ?></td>
                                  <td style="text-transform: capitalize;color: #676767;text-align: center !important;"><?php echo $row['contact_person']; ?></td>
                                  <td style="text-transform: capitalize;color: #676767;text-align: center !important;"><?php echo $row['identification_type']; ?></td>
                                  <td style="text-transform: capitalize;color: #676767;text-align: center !important;"><?php echo $row['identification_no']; ?></td>
                                  <td style="text-transform: capitalize;color: #676767;text-align: center !important;"><?php echo $row['address']; ?></td>
                                  <td style="text-transform: capitalize;color: #676767;text-align: center !important;"><?php echo $row['username']; ?></td>
                                  <td style="color: #676767;text-align: center !important;"><?php echo $row['email']; ?></td>
                                  <td style="text-transform: lowercase;color: #676767;text-align: center !important;"><?php echo $row['mobile']; ?></td>
                                 

                                 <?php $plantable=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `plan_details` WHERE id = '".$row['current_plan_id']."' ")); ?>															  
																		  
									<td style="text-transform: capitalize;color: #676767;text-align: center !important;"><?php echo $plantable['plan_name']; ?></td>
                                 
								   <td align = "center"> <a href="<?php echo $url;?>" target="_blank"> <?php echo $invoicetab["invoiceno"];?>    <i class="fa fa-eye" aria-hidden="true"></i></a></td>
								  <td><?php if($row['current_plan_id'] == 1) { echo "Free"; } else {echo "Not Paid";} ?></td>
								  

								 <td><div class="col-sm-8">
									<input type="file" id="file" name="invimg[]" onchange="changeLogoemployee(this,<?php echo $row['userid']; ?>,<?php echo $invoicetab["invoiceno"];?>)" />
								
								  </div></td>
																		  
									<?php $currentplandt=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `mail_history` WHERE invoiceno = '".$invoicetab['invoiceno']."' ")); ?>
									
									<td><?php echo date("d-m-Y",strtotime($currentplandt['plan_start'])).'<br> ----to---- <br>'.date("d-m-Y",strtotime($currentplandt['plan_end']));?></td>

									<td style="text-transform: lowercase;color: #676767;text-align: center !important;"><?php echo date("d-m-Y",strtotime($row['renewal_date'])); ?></td>
                                  <td>
                                    <label class="badge badge-danger">Renew</label>
                                  </td>
                                  <td class="myBox">
                                    <center> 
									<input type="checkbox"  name="tempValues[]" id="selid_<?php echo $row['userid']; ?>" value="<?php echo $row['userid']; ?>" disabled="disabled" required>
									</center>
                                  </td>
                                </tr>
							<?php
							$i++;
								}
							?>
							
                          </tbody>
                        </table>
						</form>
						
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>
           
            
			
			
			
			
			
           
			
			
			
			
          </div>
        </div>
      </div>






     
     


      <!-- content-wrapper ends -->
      <!-- partial:partials/_footer.html -->

      <!-- partial -->
    </div>
    <!-- main-panel ends -->
  </div>
  <!-- page-body-wrapper ends -->

 
  <!-- container-scroller -->
  
  
  <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <script>
	
	 function changeLogoemployee(opts,val,inv) {
        
		

        if (opts.value != '') {
			
			document.getElementById("selid_"+val).disabled = false;
			 $('#selid_'+val).prop('required',true);
			document.getElementById("selid_"+val).required = true;
            
        }
        else {
			
			document.getElementById("selid_"+val).disabled = true;
			document.getElementById("selid_"+val).checked = false;
			 $('#selid_'+val).prop('required',false);
            document.getElementById("selid_"+val).required = false;
			$('#selid_'+val).removeAttr('required');
        }
    }
	
	 function fetch_selectplan(val){

      $("#plan").val(val);
	  
	
    }
	
     
        function fetch_select(val,id){
          
          $.ajax({
            url:'fetch_data.php',
            type:'post',
            data:{id:id,val:val},
            success:function(res){
              alert("Plan Changed");
            }
          });
       
      }
	  
function myFunctionapprove(){	  
	
 
     if ($("input[type='checkbox']:checked").length >= 1){
		 
		 
		 var tempValue='';
      tempValue=$('.myBox  input:checkbox').map(function(n){
          if(this.checked){
               document.getElementById("selid_"+val).required = true; 
              };
       }).get().join(',');
		 
        
		//document.getElementById("form_id").submit();// Form submission
	  
		
		
		
		
     }else{
          alert ('You didn\'t choose any of the checkboxes!');
         return false;
     }
 
      
   
    
}




</script>
    
  
  <script>
  
	$(document).ready(function() {
    $('#order-listing1').dataTable( {
		 
        "scrollX": true
    } );
	} );
	
	$(document).ready(function() {
    $('#order-listing2').dataTable( {
		 
        "scrollX": false
    } );
	} );
	
	$(document).ready(function() {
    $('#order-listing3').dataTable( {
		 
        "scrollX": false
    } );
	} );
	
	$(document).ready(function() {
    $('#order-listing4').dataTable( {
		 
        "scrollX": false
    } );
	} );
  
  
  
   
  </script>
  <!-- plugins:js -->

<?php include("footer.php");?>