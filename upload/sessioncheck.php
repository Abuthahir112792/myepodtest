<?php
 include("config.php");
 include("loginfunction.php");
 
if($_SESSION['username']== "") {
		header("Location: logout.php");
}
?>