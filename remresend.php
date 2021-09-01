<?php 
require_once("config.php");


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$remindertab=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `reminder_info` "));

require_once 'PHPMailer/src/Exception.php';
require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';
//14 days Reminder
	
$current_date = date('Y-m-d');
		
		
		
		
	if($remindertab["reminder_period"] == "1 day"){
		$noofdays = "+1 day";
		$redays = "-1 day";
	}else if($remindertab["reminder_period"] == "2 days"){
		$noofdays = "+2 days";
		$redays = "-2 days";
	}else if($remindertab["reminder_period"] == "3 days"){
		$noofdays = "+3 days";
		$redays = "-3 days";
	}else if($remindertab["reminder_period"] == "1 week"){
		$noofdays = "+7 days";
		$redays = "-7 days";
	}else if($remindertab["reminder_period"] == "2 week"){
		$noofdays = "+14 days";
		$redays = "-14 days";
	}else if($remindertab["reminder_period"] == "1 month"){
		$noofdays = "+30 days";
		$redays = "-30 days";
	}
		
		
 $expairy_date= date('Y-m-d', strtotime($noofdays, strtotime($current_date)));
 $expairy_datestart= date('Y-m-d', strtotime($redays, strtotime($expairy_date)));
 
 
	
$sql 	= "SELECT * FROM mail_history WHERE  plan_end >= DATE(NOW()) AND mid= '".$_GET['mid']."' ";
$result = mysqli_query($con,$sql); 

	
	while( $row = mysqli_fetch_array($result)){ 
		
	
		
		if($row["plan_end"] >= $expairy_datestart && $row["plan_end"] <= $expairy_date){
			
			//echo $row["plan_expire"];
			
			$usertab=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `users` WHERE userid = '".$row["subscriber_id"]."' "));
	
	
			$email = $usertab["email"];
			
			
			
			$dupQry1 = mysqli_num_rows(mysqli_query($con,"SELECT * FROM `mail_history` WHERE subscriber_id = '".$row["subscriber_id"]."' AND
			plan_start = '".$row["plan_start"]."' AND plan_end = '".$row["plan_end"]."' AND plan_id= '".$row["plan_id"]."' AND status = 'Reminder Email' AND type= 'Reminder'"));	
			
			if($dupQry1 == 0){
			$sqlQueryinsertagain1 = "INSERT INTO mail_history SET  subscriber_id = '".$row["subscriber_id"]."' , 
			plan_start = '".$row["plan_start"]."', plan_end = '".$row["plan_end"]."',plan_name = '".$row["plan_name"]."', amount = '".$row["amount"]."' ,create_date = NOW(),
			plan_id= '".$row["plan_id"]."', email = '".$email."', status = 'Reminder Email' , type= 'Reminder' , invoiceno = '".$row["invoiceno"]."'  ";
			
			$resultinsert2 = mysqli_query($con, $sqlQueryinsertagain1);
			
			}
			
			$sql_Queryinsert = "INSERT INTO reminder_history SET  rem_period = '".$remindertab["reminder_period"]."' , 
			plan_end = '".$row["plan_end"]."', plan_id = '".$row["plan_id"]."',
			subscriber_id = '".$row["subscriber_id"]."', email = '".$email."', date_time = '".$current_date."' ";
			
			
			
			$resultinsert = mysqli_query($con, $sql_Queryinsert);
			
			$tid=mysqli_insert_id($con);
	
			
			
			$clientsubject = "Account Expiry - Notification";
			
			$clientbody = '<html><body>';
			
			
			$clientbody .= '<table rules="all" style="border-color: #666;" cellpadding="10" align="center">';
			$clientbody .= "<tr style='background: #eee;'><td colspan='2' align='center'><img src='https://my-epod.com/epodlite/assets/login/img/housinglogosmall.png' width='200' height='200'/></tr>";
			$clientbody .= "<tr style='background: #eee;'><td colspan='2' align='center'><strong>Account Expiry - Notification!</strong></td></tr>";
			$clientbody .= "<tr style='background: #eee;'><td colspan='2' align='center'><strong>Your Account will Expired with in ".$remindertab["reminder_period"] ." !</strong></td></tr>";
			$clientbody .= "<tr style='background: #eee;'><td colspan='2' align='center'><strong>Account Credentials:</strong></td></tr>";
			$clientbody .= "<tr><td><strong>Plan:</strong> </td><td>" . $row["plan_name"] . "</td></tr>";
			$clientbody .= "<tr><td><strong>Expiry Date:</strong> </td><td>" . $row["plan_end"] . "</td></tr>";
			
			$clientbody .= "<tr style='background: #eee;'><td></td><td><a href='https://my-epod.com/epodtest/planrenew.php?rid=$tid'><input type='button' name='btn' value='Renew Plan'style='background-color: #008CBA;color: white;padding: 15px 32px; text-align: center;'></a></td></tr>";
			$clientbody .= "</table>";
			$clientbody .= "</body></html>";
			
			
		   
			
			$mail = new PHPMailer;                            
		   
				//Server settings
				$mail->isSMTP();                                     
				$mail->Host     = $mailhost;                      
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
				$mail->send();	

			
				
			echo "<script> window.location.href = 'allmailtrack.php?msg=Y';</script>";
			
			
		}
		
		}	
		
		
	
	
	

?>