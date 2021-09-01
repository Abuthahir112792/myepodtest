<?php
include_once 'config.php'; 

$remindertab=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `reminder_info` "));
								
	if($remindertab["reminder_period"] == "1 day"){
		$noofdays = "+1 day";
	}else if($remindertab["reminder_period"] == "2 days"){
		$noofdays = "+2 days";
	}else if($remindertab["reminder_period"] == "3 days"){
		$noofdays = "+3 days";
	}else if($remindertab["reminder_period"] == "1 week"){
		$noofdays = "+7 days";
	}else if($remindertab["reminder_period"] == "2 week"){
		$noofdays = "+14 days";
	}else if($remindertab["reminder_period"] == "1 month"){
		$noofdays = "+30 days";
	}
	
	$current_date = date('Y-m-d');
	$expairy_date= date('Y-m-d', strtotime($noofdays, strtotime($current_date)));
	
$werecond = "";
if(isset($_GET["cond"]))
{ $werecond = $_GET["cond"]; } 


$j=1;
$output = '';
//if(isset($_POST["export_excel"]))
	//{
		$sql 	= "SELECT * FROM users WHERE  status = 'Verified' ".$werecond."  ORDER BY userid";
		$result = mysqli_query($con, $sql);
	//	if(mysqli_num_rows($result) > 0)
		//	{
				$output .= '
					<table border="1">
							  <th style="text-align: center;font-weight: bold;color: #4b4b4C;">S.No</th>
                              <th style="text-align: center;font-weight: bold;color: #4b4b4C;">Company Name</th>
                              <th style="text-align: center;font-weight: bold;color: #4b4b4C;">Contact Person</th>
                              <th style="text-align: center;font-weight: bold;color: #4b4b4C;">Register Type</th>
                              <th style="text-align: center;font-weight: bold;color: #4b4b4C;">Register No</th>
                              <th style="text-align: center;font-weight: bold;color: #4b4b4C;">Address</th>
                              <th style="text-align: center !important;font-weight: bold;color: #4b4b4C;">Username</th>
                              <th style="text-align: center !important;font-weight: bold;color: #4b4b4C;">Email</th>
                              <th style="text-align: center !important;font-weight: bold;color: #4b4b4C;">Contact</th>
                              <th style="text-align: center !important;font-weight: bold;color: #4b4b4C;">Plan Duration</th>
                              <th style="text-align: center;font-weight: bold;color: #4b4b4C;">Plan Expire &nbsp;</th>
                              <th style="text-align: center;font-weight: bold;color: #4b4b4C;">Status</th>
						';
						while($row = mysqli_fetch_array($result))
						{
							
								$renewsql 	= mysqli_num_rows(mysqli_query($con,"SELECT * FROM users WHERE  renewal_status = 'Y' AND renewal_date >= DATE(NOW()) AND userid = '".$row['userid']."' "));
								$duesql 	= mysqli_num_rows(mysqli_query($con,"SELECT * FROM users WHERE  status = 'Verified' AND plan_expire = '".$expairy_date."' AND renewal_status != 'Y'   AND userid = '".$row['userid']."' "));
								$expirysql 	= mysqli_num_rows(mysqli_query($con,"SELECT * FROM users WHERE  status = 'Verified' AND ((DATE(plan_expire) < DATE(NOW()) AND renewal_status != 'Y') OR ((DATE(renewal_date) <= DATE(NOW())) AND  renewal_date != '')) AND userid = '".$row['userid']."' "));
								
								if($expirysql == 1){
									$badge = "<label class='badge badge-danger' style='color:red'>Deactive</label>";
									
								}else if($duesql == 1){
									$badge = "<label class='badge badge-success' style='color:blue'>Due</label>";
								}else if($renewsql == 1){
									$badge = "<label class='badge badge-success' style='color:orange'>Pending Renewal</label>";
								}else{
									$badge = "<label class='badge badge-success' style='color:green'>Active</label>";
								}
								
							$plan_expire = "";
							 if($row['plan_expire'] != "0000-00-00"){ $plan_expire = date("d-m-Y",strtotime($row['plan_expire'])); }
							
							$output .= '
								<tr>
								  <td style="text-transform: capitalize;color: #676767;text-align: center !important;">'.$j.'</td>
                                  <td style="text-transform: capitalize;color: #676767;text-align: center !important;">'.$row['company_name'].'</td>
                                  <td style="text-transform: capitalize;color: #676767;text-align: center !important;">'.$row['contact_person'].'</td>
                                  <td style="text-transform: capitalize;color: #676767;text-align: center !important;">'.$row['identification_type'].'</td>
                                  <td style="text-transform: capitalize;color: #676767;text-align: center !important;">'.$row['identification_no'].'</td>
                                  <td style="text-transform: capitalize;color: #676767;text-align: center !important;">'.$row['address'].'</td>
                                  <td style="text-transform: capitalize;color: #676767;text-align: center !important;">'.$row['username'].'</td>
                                  <td style="color: #676767;text-align: center !important;">'.$row['email'].'</td>
                                  <td style="text-transform: lowercase;color: #676767;text-align: center !important;">'.$row['mobile'].'</td>
								  <td style="color: #676767;text-align: center !important;">'.$row['plan_name'].'</td>
								  <td style="text-transform: lowercase;color: #676767;text-align: center !important;">'.$plan_expire.'</td>
								  <td style="color: #676767;text-align: center !important;">'.$badge.'</td>
								  
								</tr>
							';
							$j++;
						}
						$output .= '</table>';
						
						$fileName = "members-data_" . date('Y-m-d') . ".xls"; 
						
						header("Content-Type: application/xls");
						header("Content-Disposition: attachment; filename=\"$fileName\""); 
						echo $output;
		//	}		
	//}
?>