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

if(isset($_GET['mid'])){

	$mailtable=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `mail_history` WHERE mid= '".$_GET['mid']."' "));


	$planid = $mailtable["plan_id"];
	
	$plantable=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `plan_details` WHERE id = '".$planid."' "));
	$plan = $plantable["id"];
	
	$usertab=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `users` WHERE userid = '".$mailtable["subscriber_id"]."' "));
	
	
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
	
	
	
	
	
	$email=$usertab['email'];
	$invoiceno = $mailtable["invoiceno"];
	
	
	$dupQry1 = mysqli_num_rows(mysqli_query($con,"SELECT * FROM `mail_history` WHERE subscriber_id = '".$mailtable["subscriber_id"]."' AND
	plan_start = '".$current_date."' AND plan_end = '".$end_date."' AND plan_id= '".$plan."' AND status = 'Expired Renewal Email' AND type= 'Invoice'"));	
			
	if($dupQry1 == 0){
		$sqlQueryinsertagain1 = "INSERT INTO mail_history SET  subscriber_id = '".$mailtable["subscriber_id"]."' , 
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
	
	
	echo "<script> window.location.href = 'allmailtrack.php?msg=Y';</script>";
    
	
	}
	
	
?>

