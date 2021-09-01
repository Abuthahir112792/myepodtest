<?php
require_once('config.php');
 
$id=$_POST['id'];
 
$query='SELECT * FROM `users` where userid="'.$id.'"';
$execute=mysqli_query($con,$query);
 
$result=mysqli_fetch_assoc($execute);

 
$response='<form>
                <div class="form-group">
                    <label>Company Name</label>
                    <input type="text" class="form-control" value="'.$result["company_name"].'" readonly>
                </div>
				
            </form>';
			
$response .='<table border="1" width="100%">
                <tr><td><b>Plan Name</b></td><td><b>Start</b></td><td><b>End</b></td><td><b>Status</b></td></tr>';

				$sql 	= "SELECT * FROM subscription_history WHERE `subscriber_id` = '".$id."' ";
				$result = mysqli_query($con,$sql); 
								
				while( $row = mysqli_fetch_array($result)){ 
				
				$plantable=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `plan_details` WHERE id = '".$row["plan_id"]."' "));
				
				$response .='<tr style="color:#000"><td>'.$plantable["plan_name"].'</td><td>'.date("d-m-Y",strtotime($row["plan_start"])).'</td><td>'.date("d-m-Y",strtotime($row["plan_end"])).'</td><td>'.$row["status"].'</td></tr>';
				
				}
 $response .='</table>';
 
 
 $response .='<br>';
 
 $response .='<table border="1" width="100%">
                <tr><td><b>Status</b></td><td><b>Plan Name</b></td><td><b>Plan Date</b></td><td><b>Invoice/Receipt</b></td></tr>';

				$sql2 	= "SELECT * FROM mail_history WHERE  subscriber_id = '".$id."' ";
				$result2 = mysqli_query($con,$sql2); 
				
				
								
				while( $row2 = mysqli_fetch_array($result2)){ 
				
				
				$usertab=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `users` WHERE userid = '".$row2["subscriber_id"]."' "));
				$plantable=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `plan_details` WHERE id = '".$row2["plan_id"]."' "));
				
				if($row2["type"] == "Receipt"){
				$url = "pdfdisplayreceipt.php?id=".$row2["invoiceno"];
				}
				if($row2["type"] == "Invoice"){
				$url = "pdfdisplayinvoice.php?id=".$row2["invoiceno"];
				}
				
				$response .='<tr style="color:#000"><td>'.$row2["status"].'</td><td>'.$plantable["plan_name"].'</td><td>'.date("d-m-Y",strtotime($row2['plan_start'])).'<br> ----to---- <br>'.date("d-m-Y",strtotime($row2['plan_end'])).'</td><td><a href='.$url.' target="_blank">'.$row2['invoiceno'].'</a></td></tr>';
				
				}
 $response .='</table>';
 
 
 
  $response .='<br>';
 
 $response .='<table border="1" width="100%">
                <tr><td colspan="5">Reminder E-mail</td></tr>
				<tr><td><b>Email</b></td><td><b>Plan Name</b></td><td><b>Plan Expiry</b></td><td><b>Mail Date</b></td><td><b>Period</b></td><td><b>Download</b></td></tr>';

				$sql1 	= "SELECT * FROM reminder_history WHERE  subscriber_id = '".$id."' ";
				$result1 = mysqli_query($con,$sql1); 
				
				
								
				while( $row1 = mysqli_fetch_array($result1)){ 
				$url="pdfsave.php?id=".$row1["id"];
				$plantable=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `plan_details` WHERE id = '".$row1["plan_id"]."' "));
				$response .='<tr style="color:#000"><td>'.$row1["email"].'</td><td>'.$plantable["plan_name"].'</td><td>'.date("d-m-Y",strtotime($row1["plan_end"])).'</td><td>'.date("d-m-Y H:i:s",strtotime($row1["date_time"])).'</td><td>'.$row1["rem_period"].'</td><td><a href='.$url.'>Download</a></td></tr>';
				
				}
 $response .='</table>';
echo $response;
 
?>