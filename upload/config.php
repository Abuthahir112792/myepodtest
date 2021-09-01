<?php
ob_start();
session_start();

$host = "localhost"; /* Host name */
$user = "root"; /* User */
$password = ""; /* Password */
$dbname = "myepodco_epodlite"; /* Database name */
$base_url ="/epodtest/";

$mailhost = 'smtp.gmail.com';
$mailusername =  'cmala.sai@gmail.com';
$mailpwd = 'chinnaiya';
$mailsetfrom = 'cmala.sai@gmail.com';

$con = new mysqli($host, $user, $password, $dbname); 

if($con->connect_error) {
    die("connection failed : " . $con->connect_error);
} 
?>