<?php
include_once("config.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dompdf\Dompdf;

require_once 'PHPMailer/src/Exception.php';
require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';


if(isset($_POST['tempValues']))
{
	
		
	$temparr = explode(",",$_POST['tempValues']); 
	 
	foreach($temparr as $arrval){
		
		$usertab=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `users` WHERE userid = '".$arrval."' "));
		
		$plantable=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `plan_details` WHERE id = '".$usertab["plan_id"]."' "));
		$plan = $usertab["plan_id"];
		
		$current_date = $usertab["plan_expire"];
		$todaydate = date('d-m-Y');
		
		
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
		
		
		
		$sqlQueryupdate = "UPDATE users SET renewal_status = 'C', plan_start = '".$current_date."', plan_expire = '".$end_date."' WHERE userid = '".$arrval."' ";
		$result = mysqli_query($con, $sqlQueryupdate);
		
		$invoicetab=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `invoice_table` WHERE sid = '".$arrval."' order by id desc limit 1 "));
		mysqli_query($con,"UPDATE invoice_table SET status = 'R'  WHERE sid = '".$arrval."' order by id desc limit 1");	
				
	
	$dupQry = mysqli_num_rows(mysqli_query($con,"SELECT * FROM `subscription_history` WHERE subscriber_id = '".$arrval."' AND
	plan_start = '".$current_date."' AND plan_end = '".$end_date."' AND plan_id= '".$usertab["plan_id"]."' AND status = 'Renewed'"));	
	
	if($dupQry == 0){
	$sqlQueryinsertagain = "INSERT INTO subscription_history SET  subscriber_id = '".$arrval."' , 
	plan_start = '".$current_date."', plan_end = '".$end_date."',create_date = NOW(),
	plan_id= '".$usertab["plan_id"]."', status = 'Renewed' ,invoiceno = '".$invoicetab["invoiceno"]."' ";
	
	$resultinsert1 = mysqli_query($con, $sqlQueryinsertagain);
	
	}
	
	$email = $usertab["email"];
  
	$clientsubject = "Account Renewed";
	
	$clientbody = '<html><body>';
	
	
	$clientbody .= '<table rules="all" style="border-color: #666;" cellpadding="10" align="center">';
	$clientbody .= "<tr style='background: #eee;'><td colspan='2' align='center'><img src='https://my-epod.com/epodlite/assets/login/img/housinglogosmall.png' width='200' height='200'/></tr>";
	$clientbody .= "<tr style='background: #eee;'><td colspan='2' align='center'><strong>Account verified!</strong></td></tr>";
	$clientbody .= "<tr style='background: #eee;'><td colspan='2' align='center'><strong>Account is verified!</strong></td></tr>";
	$clientbody .= "<tr style='background: #eee;'><td colspan='2' align='center'><strong>Login Credentials:</strong></td></tr>";
	$clientbody .= "<tr style='background: #eee;'><td><strong>Email:</strong> </td><td>" . $usertab["email"] . "</td></tr>";
	$clientbody .= "<tr style='background: #eee;'><td><strong>Password:</strong> </td><td>123456</td></tr>";
	$clientbody .= "</table>";
	$clientbody .= "</body></html>";
	
	
	require 'dompdf/autoload.inc.php';
        
    // instantiate and use the dompdf class
    $pdf = new DOMPDF();
	
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
					  
					  <tr>
					  <td>
					  For,  <br>'.$usertab['contact_person'].'
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
		
		
	}
	
}

?>