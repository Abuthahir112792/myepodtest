<?php
require_once("config.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'PHPMailer/src/Exception.php';
require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';

			$email = $_POST["email"];
			
			$usertab=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `users` WHERE email = '".$email."' "));
			$sid = $usertab["userid"];
			
			if($sid==""){
				
				header('Location:index.php?nmfid=Y');
				
			}else{
		  
			$clientsubject = "Reset Your Password!";
			
			$clientbody = '<html><body>';
			
			
			$clientbody .= '<table rules="all" style="border-color: #666;" cellpadding="10" align="center">';
			$clientbody .= "<tr style='background: #eee;'><td colspan='2' align='center'><img src='https://my-epod.com/epodlite/assets/login/img/housinglogosmall.png' width='200' height='200'/></tr>";
			
			$clientbody .= "<tr style='background: #eee;'><td colspan='2' align='center'></td></tr>";
			$clientbody .= "<tr style='background: #eee;'><td colspan='2' align='center'><strong>Password Reset Request</strong></td></tr>";
			
			$clientbody .= "<tr style='background: #eee;'><td colspan='2' align='center'><a href='https://my-epod.com/epodtest/resetpassword.php?id=$sid'><input type='button' name='btn' value='Password Reset Link' style='background-color: #008CBA;color: white;padding: 15px 32px; text-align: center;'></a></td></tr>";
			$clientbody .= "</table>";
			$clientbody .= "</body></html>";
			
			
				$resetcnt = mysqli_num_rows(mysqli_query($con,"SELECT * FROM password_reset_history WHERE sid = '".$sid."' "));
			
		if($resetcnt < 1){	
			$sqlQueryinsert1 = "INSERT INTO password_reset_history SET  sid = '".$sid."' , 

	email= '".$email."',  status='A' ";
		}else{
		    
		 	$sqlQueryinsert1 = "UPDATE password_reset_history SET 

	 status='A' WHERE  sid = '".$sid."' ";   
		}
	
	$resultinsert1 = mysqli_query($con, $sqlQueryinsert1);
		   
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
				$mail->send();	
				
				header('Location:index.php?fid='.$sid);
				
			}


?>