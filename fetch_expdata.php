<?php 
require_once("login.php");
require_once("config.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
//$remindertab=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `reminder_info` WHERE  "));
//$remindertab["reminder_period"] = "EXPIRED";
require_once 'PHPMailer/src/Exception.php';
require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';
//14 days Reminder
	
$sql 	= "SELECT * FROM users WHERE status = 'Verified' AND  plan_expire < DATE(NOW()) AND userid = '".$_POST["id"]."' ";
$row = mysqli_fetch_array(mysqli_query($con,$sql)); 

	
	
		
		 $current_date = date('Y-m-d');
		
		
			
			
	
			$email = $row["email"];
			
			$countval= mysqli_fetch_array(mysqli_query($con,"SELECT COUNT(email) AS countmail FROM reminder_history WHERE rem_period = 'Exp' AND 
			plan_end = '".$row["plan_expire"]."' AND plan_id = '".$row["plan_id"]."' AND
			subscriber_id = '".$row["userid"]."' AND email = '".$email."' "));
			
			
			if($countval["countmail"] < 1){
			
			$sql_Queryinsert = "INSERT INTO reminder_history SET  rem_period = 'Exp' , 
			plan_end = '".$row["plan_expire"]."', plan_id = '".$row["plan_id"]."',
			subscriber_id = '".$row["userid"]."', email = '".$email."', date_time = NOW() ";
			
			$resultinsert = mysqli_query($con, $sql_Queryinsert);
			
			$tid=mysqli_insert_id($con);
			
			mysqli_query($con,"UPDATE `users` SET  renewal_status = '', renewal_date = '', renewalentry = '' WHERE userid  = '".$row["userid"]."' ");
		  
			$clientsubject = "Account Expiary - Notification";
			
			$clientbody = '<html><body>';
			
			
			$clientbody .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
			$clientbody .= "<tr style='background: #eee;'><td colspan='2' align='center'><img src='https://my-epod.com/epodlite/assets/login/img/housinglogosmall.png' width='200' height='200'/></tr>";
			$clientbody .= "<tr style='background: #eee;'><td colspan='2' align='center'><strong>Account Expairy - Notification!</strong></td></tr>";
			$clientbody .= "<tr style='background: #eee;'><td colspan='2' align='center'><strong></strong></td></tr>";
			$clientbody .= "<tr style='background: #eee;'><td colspan='2' align='center'><strong>Account Credentials:</strong></td></tr>";
			$clientbody .= "<tr><td><strong>Plan:</strong> </td><td>" . $row["plan_name"] . "</td></tr>";
			$clientbody .= "<tr><td><strong>Expiary Date:</strong> </td><td>" . $row["plan_expire"] . "</td></tr>";
			
			$clientbody .= "<tr style='background: #eee;'><td></td><td><a href='https://my-epod.com/epodtest/planrenewexpire.php?rid=$tid'><input type='button' name='btn' value='Renew Plan'style='background-color: #008CBA;color: white;padding: 15px 32px; text-align: center;'></a></td></tr>";
			$clientbody .= "</table>";
			$clientbody .= "</body></html>";
			
			
		   
			
			$mail = new PHPMailer;                            
		   
				//Server settings
				$mail->isSMTP();                                     
				$mail->Host     = "my-epod.com";                      
				$mail->SMTPAuth = true;                             
			    $mail->Username = "admin@my-epod.com";
                $mail->Password = "Admin@27111976";             
				                    
				$mail->SMTPSecure = 'ssl';                           
				$mail->Port = 465;                                   

				//Send Email
				 $mail->setFrom('admin@my-epod.com');
				
				//Recipients
				
				
				//Content
				$mail->isHTML(true);                                  
				$mail->Subject = $clientsubject;
				$mail->Body    = $clientbody;	
				$mail->addAddress($email);	
				$mail->send();	

			
				
			
			
			
		

?>