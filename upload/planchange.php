<?php 
include("header.php");

if(isset($_POST['formsubmit'])) {	

	 $planid = $_POST["plan"]; 
	
	$usertable=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `users` WHERE userid = '".$_POST["userid"]."' "));
	$subscribertable=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `subscription` WHERE subscriber_id = '".$_POST["userid"]."' "));
	
	$current_date = $subscribertable["plan_start"];
	
	$plantable=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `plan_details` WHERE id = '".$planid."' "));
	$plan = $plantable["id"];
	
	
	$todaydate = date("Y-m-d");
	
	if ($plan == 4) {
      $end_date = date('Y-m-d', strtotime("+12 months", strtotime($current_date)));
      $plan_name = '1 Year';
      $plan_duration = '1 Year';
    } else if ($plan == 1) {
      $end_date = date('Y-m-d', strtotime("+30 days", strtotime($current_date)));

      $plan_name = 'Free Trial (30 Days)';
      $plan_duration = '30 Days';
    } else if ($plan == 2) {
      $end_date = date('Y-m-d', strtotime("+3 months", strtotime($current_date)));

      $plan_name = '3 Months';
      $plan_duration = '3 Months';
    }else if ($plan == 3) {
      $end_date = date('Y-m-d', strtotime("+6 months", strtotime($current_date)));

      $plan_name = '6 Months';
      $plan_duration = '6 Months';
    }else {
     
    }
 
 
 

  $sqlQueryupdate = "UPDATE users SET plan_id = '".$planid."', plan_expire='".$end_date."', plan_name='".$plan_name."' WHERE userid = '".$_POST["userid"]."' "; 
 $result = mysqli_query($con, $sqlQueryupdate);
 
    $sqlQueryinsert = "INSERT INTO subscription_history SET  subscriber_id = '".$_POST["userid"]."' , 
	plan_start = '".$current_date."', plan_end = '".$end_date."',
	plan_id= '".$planid."', create_date = NOW(), status='Change' ";
	
	$resultinsert = mysqli_query($con, $sqlQueryinsert);
	
	$sqlQueryupdates = "UPDATE subscription SET  
	plan_start = '".$current_date."', plan_end = '".$end_date."',
	plan_main_id= '".$planid."', modify_date = '".$todaydate."' WHERE  subscriber_id = '".$_POST["userid"]."'";
	
	$resultinsert = mysqli_query($con, $sqlQueryupdates);
	
	 echo "<script> window.location.href = 'planchange.php?err=Y';</script>";

}
?>
 <style>
              table,
              td {
                white-space: normal !important;
              }

              .table.dataTable {
                border-collapse: collapse !important;border: 1px solid rgba(0, 0, 0, 0.125);
              }
            </style>
<!-- partial -->
<div class="container-fluid page-body-wrapper">
  <div class="main-panel">
    <div class="content-wrapper">
     
      
         <div class="tab-pane fade show active"  id="approvals" role="tabpanel" aria-labelledby="business-tab">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title" style="margin-bottom: 8px;">Subscriber Plan Change</h4>
                  <div class="row">
                    <div class="col-12">
					
						<?php if(isset($_GET["err"])){?>
						<div class="alert alert-success show" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">×</span>
							</button>
							Plan changed successfully.                       
						</div>
						<?php } ?>
					
                      <div style="min-height:500px;">
                        <table id="order-listing1" class="table" border="1">
                          <thead>
                            <tr>
                              <th style="text-align: center;font-weight: bold;color: #4b4b4C;">No</th>
                              <th style="text-align: center;font-weight: bold;color: #4b4b4C;">Company Name</th>
                              <th style="text-align: center;font-weight: bold;color: #4b4b4C;">Contact Person</th>
                              <th style="text-align: center;font-weight: bold;color: #4b4b4C;">Register Type</th>
                              <th style="text-align: center;font-weight: bold;color: #4b4b4C;">Register No</th>
                              <th style="text-align: center !important;font-weight: bold;color: #4b4b4C;">Username</th>
                              <th style="text-align: center !important;font-weight: bold;color: #4b4b4C;">Email</th>
                              <th style="text-align: center !important;font-weight: bold;color: #4b4b4C;">Contact</th>
                              <th style="text-align: center;font-weight: bold;color: #4b4b4C;">Plan Duration</th>
                              <th style="text-align: center;font-weight: bold;color: #4b4b4C;"> Expired Date </th>
                              <th style="text-align: center;font-weight: bold;color: #4b4b4C;">Plan</th>
                              <th style="text-align: center;font-weight: bold;color: #4b4b4C;">Change Plan</th>
                            </tr>
                          </thead>
                          <tbody id="expirelist">
							<?php
								$j=1;
								$sql 	= "SELECT * FROM users WHERE  status = 'Verified' AND DATE(plan_expire) > DATE(NOW()) ORDER BY userid";
								$result = mysqli_query($con,$sql); 
								
								while( $row = mysqli_fetch_array($result)){ 
								?>
								<tr>
								  <td><?php echo $j;?></td>
                                  <td style="text-transform: capitalize;color: #676767;text-align: center !important;"><?php echo $row['company_name']; ?></td>
                                  <td style="text-transform: capitalize;color: #676767;text-align: center !important;"><?php echo $row['contact_person']; ?></td>
                                  <td style="text-transform: capitalize;color: #676767;text-align: center !important;"><?php echo $row['identification_type']; ?></td>
                                  <td style="text-transform: capitalize;color: #676767;text-align: center !important;"><?php echo $row['identification_no']; ?></td>
                                  
                                  <td style="text-transform: capitalize;color: #676767;text-align: center !important;"><?php echo $row['username']; ?></td>
                                  <td style="color: #676767;text-align: center !important;"><?php echo $row['email']; ?></td>
                                  <td style="text-transform: lowercase;color: #676767;text-align: center !important;"><?php echo $row['mobile']; ?></td>
                                  
								  <td style="color: #676767;text-align: center !important;"><?php echo $row['plan_name']; ?></td>
								  <td style="text-transform: lowercase;color: #676767;text-align: center !important;"><?php if($row['plan_expire'] != "0000-00-00"){echo date("d-m-Y",strtotime($row['plan_expire'])); }?></td>
								  <td>
								   <form action="" method="post" class="form-sample">
								  
								  <select class="form-control" id="plancat" name="plan" style="height: 28px;padding: 4px;">
                                      
                                        <option value="1" <?php if($row['plan_id']=="1"){echo "selected";} ?>>Free</option>

                                      
                                        <option value="2" <?php if($row['plan_id']=="2"){echo "selected";} ?>>Silver</option>

                                      
                                        <option value="3" <?php if($row['plan_id']=="3"){echo "selected";} ?>>Gold</option>

                                      
                                        <option value="4" <?php if($row['plan_id']=="4"){echo "selected";} ?>>Premium</option>

                                    </select>
								</td>
								<td>
								
							   
								
							    <input type="hidden" name="userid" id="userid" value="<?php echo $row['userid']; ?>">
								<input type="submit" id="formsubmit" name="formsubmit"  class="btn btn-info" value="Plan Change">
								
								</form>
									   
							   
							   </td> 
                                 
                                </tr>
							<?php
							$j++;
								}
							?>
                          </tbody>
                        </table>
						
						
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>  
           
             
               
               
            
	</div>
  </div>
</div>
        

     
     

   
 
  <!-- container-scroller -->
  
  
  <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <script>
	
	$(document).ready(function() {
    $('#order-listing1').dataTable( {
		 
        "scrollX": true
    } );
	} );
	
     
        function fetch_select(val,id){
          
          $.ajax({
            url:'fetch_details.php',
            type:'post',
            data:{id:id,val:val},
            success : function(response){						
				if(response=="ok"){									
					$("#success").html('<div class="alert alert-danger"> <span class="glyphicon glyphicon-info-sign"></span> &nbsp; Plan changed !</div>');
				} 
			}
          });
       
      }
	  



</script>
    
  
  

  <!-- plugins:js -->

<?php include("footer.php");?>