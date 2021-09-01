<?php 
require_once("config.php");
require_once("loginfunction.php");


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
	
$sql 	= "SELECT * FROM users WHERE status = 'Verified' AND  plan_expire >= DATE(NOW()) ";
$result = mysqli_query($con,$sql); 

	
	while( $row = mysqli_fetch_array($result)){ 
		
	
		
		if($row["plan_expire"] >= $expairy_datestart && $row["plan_expire"] <= $expairy_date){
			
			//echo $row["plan_expire"];
			
			
	
			$email = $row["email"];
			
			$countval= mysqli_fetch_array(mysqli_query($con,"SELECT COUNT(email) AS countmail FROM reminder_history WHERE rem_period = '".$remindertab["reminder_period"]."' AND 
			plan_end = '".$row["plan_expire"]."' AND plan_id = '".$row["plan_id"]."' AND
			subscriber_id = '".$row["userid"]."' AND email = '".$email."' AND date_time = '".$current_date."'"));
			
			
			if($countval["countmail"] < 1){
			
			$sql_Queryinsert = "INSERT INTO reminder_history SET  rem_period = '".$remindertab["reminder_period"]."' , 
			plan_end = '".$row["plan_expire"]."', plan_id = '".$row["plan_id"]."',
			subscriber_id = '".$row["userid"]."', email = '".$email."', date_time = '".$current_date."' ";
			
			
			
			$resultinsert = mysqli_query($con, $sql_Queryinsert);
			
			$tid=mysqli_insert_id($con);
			
			mysqli_query($con,"UPDATE `users` SET  renewal_status = '', renewal_date = '', renewalentry = '' WHERE userid  = '".$row["userid"]."' ");
		  
			$plantable=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `plan_details` WHERE id = '".$row["plan_id"]."' "));
			$invoicetab=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `invoice_table` WHERE sid = '".$row["userid"]."' AND status='R' order by id desc limit 1 "));
			
			$dupQry1 = mysqli_num_rows(mysqli_query($con,"SELECT * FROM `mail_history` WHERE subscriber_id = '".$row["userid"]."' AND
			plan_start = '".$row["plan_start"]."' AND plan_end = '".$row["plan_expire"]."' AND plan_id= '".$row["plan_id"]."' AND status = 'Reminder Email' AND type= 'Reminder'"));	
			
			if($dupQry1 == 0){
			$sqlQueryinsertagain1 = "INSERT INTO mail_history SET  subscriber_id = '".$row["userid"]."' , 
			plan_start = '".$row["plan_start"]."', plan_end = '".$row["plan_expire"]."',plan_name = '".$row["plan_name"]."', amount = '".$plantable["amount"]."' ,create_date = NOW(),
			plan_id= '".$row["plan_id"]."', email = '".$email."', status = 'Reminder Email' , type= 'Reminder' , invoiceno = '".$invoicetab["invoiceno"]."'  ";
			
			$resultinsert2 = mysqli_query($con, $sqlQueryinsertagain1);
			
			}
	
			
			
			$clientsubject = "Account Expiry - Notification";
			
			$clientbody = '<html><body>';
			
			
			$clientbody .= '<table rules="all" style="border-color: #666;" cellpadding="10" align="center">';
			$clientbody .= "<tr style='background: #eee;'><td colspan='2' align='center'><img src='https://my-epod.com/epodlite/assets/login/img/housinglogosmall.png' width='200' height='200'/></tr>";
			$clientbody .= "<tr style='background: #eee;'><td colspan='2' align='center'><strong>Account Expiry - Notification!</strong></td></tr>";
			$clientbody .= "<tr style='background: #eee;'><td colspan='2' align='center'><strong>Your Account will Expired with in ".$remindertab["reminder_period"] ." !</strong></td></tr>";
			$clientbody .= "<tr style='background: #eee;'><td colspan='2' align='center'><strong>Account Credentials:</strong></td></tr>";
			$clientbody .= "<tr><td><strong>Plan:</strong> </td><td>" . $row["plan_name"] . "</td></tr>";
			$clientbody .= "<tr><td><strong>Expiry Date:</strong> </td><td>" . $row["plan_expire"] . "</td></tr>";
			
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

			
				
			
			
			
		}
		
		}	
		
		
	}
	
	if($_SESSION['role'] == 1){
	header('Location:dashboard.php');
	}else{
	 	header('Location:underdevelopment.php');   
	    
	}

?>