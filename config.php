<?php
ob_start();
session_start();

$host = "localhost"; /* Host name */
$user = "root"; /* User */
$password = ""; /* Password */
$dbname = "myepodco_epodlite"; /* Database name */
$base_url ="/epodtest/";

$mailhost = 'my-epod.com';
$mailusername =  'admin@my-epod.com';
$mailpwd = 'Admin@27111976';
$mailsetfrom = 'admin@my-epod.com';

$con = new mysqli($host, $user, $password, $dbname); 

if($con->connect_error) {
    die("connection failed : " . $con->connect_error);
} 
?>