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