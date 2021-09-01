<?php 
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

include("config.php");

if(isset($_GET['mid']))
{
	
	
	
	$mailtable=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `mail_history` WHERE mid= '".$_GET['mid']."' "));

	$planid = $mailtable["plan_id"];
	
	$plantable=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `plan_details` WHERE id = '".$planid."' "));
	$plan = $plantable["id"];
	
	$usertab=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `users` WHERE userid = '".$mailtable["subscriber_id"]."' "));
			
	
	$dupQry1 = mysqli_num_rows(mysqli_query($con,"SELECT * FROM `mail_history` WHERE subscriber_id = '".$mailtable["subscriber_id"]."' AND
	plan_start = '".$mailtable["plan_start"]."' AND plan_end = '".$mailtable["plan_end"]."' AND plan_id= '".$mailtable["plan_id"]."' AND status = 'Awaiting Approved Email' AND type= 'Receipt'"));	
	
	$email = $usertab["email"];
    $invoiceno =	$mailtable["invoiceno"];
	
	
	if($dupQry1 == 0){
	$sqlQueryinsertagain1 = "INSERT INTO mail_history SET  subscriber_id = '".$mailtable["subscriber_id"]."' , 
	plan_start = '".$mailtable["plan_start"]."', plan_end = '".$mailtable["plan_end"]."',plan_name = '".$mailtable["plan_name"]."', amount = '".$mailtable["amount"]."' ,create_date = NOW(),
	plan_id= '".$mailtable["plan_id"]."', email = '".$email."', status = 'Awaiting Approved Email' , type= 'Receipt' , invoiceno = '".$invoiceno."' ";
	
	$resultinsert2 = mysqli_query($con, $sqlQueryinsertagain1);
	
	}
	
	
	
	
	
	
  
	$clientsubject = "Account Verified - Receipt No:  $invoiceno";
	
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
                      <title>Receipt</title>
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
                          <table style="border-left:0;border-right:0;" align="right" width="100%">
                            <tr style="width:100%;">
								<td align="right">
									<span style="font-size:25px;"><b>SUBSCRIPTION RECEIPT</b></span>
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
					  <td style="height:40px">
					  For,  <br><p>'.$usertab['contact_person'].' <br> '.$usertab['company_name'].' <br> '.$usertab['address'].' <br> '.$usertab['mobile'].'</p>
					  </td>
					  <td colspan="2" style="height:40px">
						<table border="0" width="100%" style="border-left:0;border-right:0;">
							<tr>
							  <td align="center"><b>Receipt No</b></td>
							  <td align="center">'.$mailtable["invoiceno"].'</td>
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
							  <td align="center">'.date("d-m-Y",strtotime($mailtable["plan_start"])).' to '.date("d-m-Y",strtotime($mailtable["plan_end"])).'</td>
							  <td align="center">'.$mailtable["plan_name"].'</td>
							  <td align="center">'.number_format($mailtable["amount"], 2, '.', '').'</td>
							  <td align="center"><b></b></td>
							  <td align="center">'.number_format($mailtable["amount"], 2, '.', '').'</td>
							 </tr>
							 <tr>
							  <td></td>
							  <td></td>
							  <td></td>
							  <td>Total(MYR):</td>
							  <td align="center">'.number_format($mailtable["amount"], 2, '.', '').'</td>
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
        
        
        //Content
        $mail->isHTML(true);                                  
      

        
			
		$mail->Subject = $clientsubject;
        $mail->Body    = $clientbody;	
		$mail->addAddress($email);
		$mail->AddAttachment($filename);
		$mail->send();	
		
		echo "<script> window.location.href = 'allmailtrack.php?msg=Y';</script>";
		
	}
	
	
	





?>
