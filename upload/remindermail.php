<?php
require_once("config.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'PHPMailer/src/Exception.php';
require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';
//14 days Reminder
	
$sql 	= "SELECT * FROM subscription WHERE  plan_end > DATE(NOW()) ORDER BY plan_id";
$result = mysqli_query($con,$sql); 

	
	while( $row = mysqli_fetch_array($result)){ 
		
		$current_date = date('Y-m-d');
		$expairy_date14 = date('Y-m-d', strtotime("+14 days", strtotime($current_date)));
		$expairy_date3 = date('Y-m-d', strtotime("+3 days", strtotime($current_date)));
		
		
		
		if($row["plan_end"] == $expairy_date14){
			
			
			//echo $row["plan_end"]; echo $expairy_date14;
			
			$usertab=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `users` WHERE userid = '".$row["subscriber_id"]."' "));
			
			$sqlQueryupdate = "UPDATE subscription SET oneweek_email_reminder = '1' WHERE plan_id  = '".$row["plan_id"]."' ";
			$result = mysqli_query($con, $sqlQueryupdate);
			
			
			
			$usertab=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `users` WHERE userid = '".$row["subscriber_id"]."' "));
	
			$email = $usertab["email"];
		  
			$clientsubject = "Account Expiry - Notification";
			
			$clientbody = '<html><body>';
			
			
			$clientbody .= '<table rules="all" style="border-color: #666;" cellpadding="10" align="center">';
			$clientbody .= "<tr style='background: #eee;'><td colspan='2' align='center'><img src='https://my-epod.com/epodlite/assets/login/img/housinglogosmall.png' width='200' height='200'/></tr>";
			$clientbody .= "<tr style='background: #eee;'><td colspan='2' align='center'><strong>Account Expiry - Notification!</strong></td></tr>";
			$clientbody .= "<tr style='background: #eee;'><td colspan='2' align='center'><strong>Your Account will Expired with in 2 Weeks!</strong></td></tr>";
			$clientbody .= "<tr style='background: #eee;'><td colspan='2' align='center'><strong>Account Credentials:</strong></td></tr>";
			$clientbody .= "<tr style='background: #eee;'><td><strong>Plan:</strong> </td><td>" . $usertab["plan_name"] . "</td></tr>";
			$clientbody .= "<tr style='background: #eee;'><td><strong>Expiry Date:</strong> </td><td>" . $row["plan_end"] . "</td></tr>";
			$clientbody .= "</table>";
			$clientbody .= "</body></html>";
		   
			//Load composer's autoloader
			//Load composer's autoloader

			$mail = new PHPMailer;                            
		   
				//Server settings
				$mail->isSMTP();                                     
				$mail->Host     = 'thefollo.com';                      
				$mail->SMTPAuth = true;                             
			    $mail->Username = 'sudhakar@thefollo.com';
                $mail->Password = 'follo2711';             
				                    
				$mail->SMTPSecure = 'ssl';                           
				$mail->Port = 465;                                   

				//Send Email
				 $mail->setFrom('admin@thefollo.com', 'EPOD Lite');
				
				//Recipients
				
				
				//Content
				$mail->isHTML(true);                                  
			  

				
					
				$mail->Subject = $clientsubject;
				$mail->Body    = $clientbody;	
				$mail->addAddress($email);	
				$mail->send();	

			
				
			
			
			
		}
		
		
		
		header('Location:reminder.php');
		
		
	}
?>
