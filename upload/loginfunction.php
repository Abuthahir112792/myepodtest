<?php
require_once("config.php");

if(isset($_POST['login_button'])) {
	$user_email = trim($_POST['email']);
	$user_password = md5(trim($_POST['password']));
	
	$sql = "SELECT userid , username, password, email, role FROM users WHERE email='$user_email' AND status='Verified'  ";
	$resultset = mysqli_query($con, $sql) or die("database error:". mysqli_error($con));
	$row = mysqli_fetch_assoc($resultset);	
		
	if($row['password']==$user_password){
	    $_SESSION['user_session'] = $row['userid'];
	    $_SESSION['role'] = $row['role'];
		$_SESSION['username'] = $row['username'];
		echo "ok";
		
	} else {				
		echo "email or password does not exist."; // wrong details 
	}		
}

if(isset($_POST['register_button'])) {
	$user_email = trim($_POST['email']);
	$user_password = md5(trim($_POST['password']));
	
	$sql = "SELECT userid , username, password, email FROM users WHERE email='$user_email' ";
	$resultset = mysqli_query($con, $sql) or die("database error:". mysqli_error($con));
	$row = mysqli_fetch_assoc($resultset);	
		
	if($row['email']==$user_email){				
		
		echo "email id already exist.";
	} else{
		
		
		
	$_SESSION['company_name'] = $_POST["company_name"];
	$_SESSION['contact_person'] = $_POST["contact_person"];
	
	$_SESSION['membershipRadios'] = $_POST["membershipRadios"];
	$_SESSION['identification_no'] = $_POST["identification_no"];
	$_SESSION['address'] = $_POST["address"];
	$_SESSION['username'] = $_POST["username"];
	$_SESSION['email'] = $_POST["email"];
	$_SESSION['password'] = md5($_POST["password"]);
	$_SESSION['contact_no'] = $_POST["contact_no"];
	$_SESSION['c_password'] = $_POST["c_password"];
	if(isset($_FILES['file']['tmp_name'])){
		$_SESSION['user_image'] = $_FILES['file']['tmp_name'];
	
	
		$file_tmp  = $_FILES['user_image']['tmp_name'];
		$file_name = $_FILES['user_image']['name'];
		move_uploaded_file($file_tmp,"uploads/profile/".$file_name);
	
	}else{ $_SESSION['user_image'] = ""; }
	
		echo "ok";
		
	}	
}

if(isset($_FILES['file']['tmp_name'])) 
  {
    $src  = $_FILES['file']['tmp_name'];
    $src1 = $_FILES['file']['name'];
    $time_on    = time();
    $string1 = str_replace(' ', '', $src1);
    $pics    = $time_on . $string1;
    $targ = "./uploads/profile/" . $pics;
    move_uploaded_file($src, $targ);
    $str = $pics;
    echo trim($str, '"');
  }
	
	

?>