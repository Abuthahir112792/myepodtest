<?php
//require_once("login.php");

error_reporting(E_ALL);
ini_set("display_errors", 1);
   
   
   
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'PHPMailer/src/Exception.php';
require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';



    $email = "mala@my-epod.com";
    

	
	
	
	
   
    //Load composer's autoloader

    $mail1 = new PHPMailer;                            
    
        //Server settings
        $mail1->isSMTP();                                     
        $mail1->Host = 'my-epod.com';                      
        $mail1->SMTPAuth = true;                             
        $mail1->Username = 'admin@my-epod.com';     
        $mail1->Password = 'Admin@27111976';             
                               
        $mail1->SMTPSecure = 'ssl';                           
        $mail1->Port = 465;                                   

        //Send Email
        $mail1->setFrom('admin@my-epod.com', 'EPOD Lite');
        
        //Recipients
        $mail1->addAddress('admin@my-epod.com', 'EPOD Lite');              
        //$mail->addReplyTo('cmala.sai@gmail.com');
        
        //Content
        $mail1->isHTML(true);                                  
        $mail1->Subject = "test";
        $mail1->Body    = "test";

       $mail1->send();
            
        
		
      
 
	

	
	?>

