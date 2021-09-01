<?php 
include("header.php");
require_once("config.php");

	
							
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
	
	if(isset($_POST["formsubmit"])){
		
		$remdays = $_POST["remdays"];
		
		if($remdays == "+1 day"){
			$remindertab["reminder_period"] = "1 day";
		}else if($remdays == "+2 days"){
			$remindertab["reminder_period"] = "2 days";
		}else if($remdays == "+3 days"){
			$remindertab["reminder_period"] = "3 days";
		}else if($remdays == "+7 days"){
			$remindertab["reminder_period"] = "1 Week";
		}else if($remdays == "+14 days"){
			$remindertab["reminder_period"] = "2 Week";
		}else if($remdays == "+30 days"){
			$remindertab["reminder_period"] = "1 month";
		}
		
		$expairy_date= date('Y-m-d', strtotime($remdays, strtotime($current_date)));
		
	}
	
	
	

?>
<style>
  a.disabled {
    pointer-events: none;
    cursor: default;
  }
  
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
      
      <div class="row">
        <div class="col-md-12">
          <div class="d-sm-flex justify-content-between align-items-center transaparent-tab-border {">
            <ul class="nav nav-tabs tab-transparent" role="tablist">
                
                <li class="nav-item">
                <a  class="nav-link" href="subscription.php" role="tab" aria-selected="false">All Subscribers</a>
              </li>
			
              <li class="nav-item">
                <a class="nav-link" href="awaiting_approval.php" role="tab" aria-selected="false">Approvals</a>
              </li>
              
              
			  
              <li class="nav-item">
                <a class="nav-link active"  href="due_reminder.php" role="tab" aria-selected="false">Due</a>
              </li>
			  
			  <li class="nav-item">
                 <a class="nav-link"  href="pending_renewal.php" role="tab" aria-selected="false">Pending Renewal</a>
              </li>
			  
			  <li class="nav-item">
                 <a class="nav-link"  href="planexpired.php" role="tab" aria-selected="false">Plan Expired</a>
              </li>
              
            </ul>
           
          </div>
          <div class="tab-content tab-transparent-content">
            
			
			
            <style>
             
            </style>

            
            <div class="tab-pane fade show active" id="subscribers" role="tabpanel" aria-labelledby="business-tab">
              <div class="card">
                <div class="card-body">
				
				<form action="" method="post" class="form-sample">
								<div class="col-md-6">  
								  <select class="form-control" id="plancat" name="remdays" style="height: 28px;padding: 4px;">
                                      
                                        <option value="+7 days" <?php if($remindertab['reminder_period']=="1 week"){echo "selected";} ?>>1 week</option>

                                        <option value="+14 days" <?php if($remindertab['reminder_period']=="2 Week"){echo "selected";} ?>>2 Week</option>
                                      
                                        <option value="+3 days" <?php if($remindertab['reminder_period']=="3 days"){echo "selected";} ?>>3 days</option>
                                      
                                        <option value="+1 day" <?php if($remindertab['reminder_period']=="1 day"){echo "selected";} ?>>1 day</option>
										
										<option value="+2 days" <?php if($remindertab['reminder_period']=="2 days"){echo "selected";} ?>>2 days</option>
										
										<option value="+30 days" <?php if($remindertab['reminder_period']=="1 month"){echo "selected";} ?>>1 month</option>

                                    </select>
								</div>	 
								<div class="col-md-3">   
								<br>
							    <input type="submit" id="formsubmit" name="formsubmit"  class="btn btn-info" value="Search">
								</div>
							</form>
				
				<hr>
                  <h4 class="card-title" style="margin-bottom:15px;">Due Reminder - <?php echo $remindertab["reminder_period"]; ?> Expiry Date: <?php echo date("d-m-Y",strtotime($expairy_date));?> </h4>
                  <div class="row">
                    <div class="col-12">
                      <div style="min-height:500px;">
                        <table id="order-listing1" class="table" border="1">
                          <thead>
                            <tr>
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
                              <th style="text-align: center;font-weight: bold;color: #4b4b4C;">Receipt </th>
							  <th style="text-align: center;font-weight: bold;color: #4b4b4C;">Paid Status</th>
                              <th style="text-align: center;font-weight: bold;color: #4b4b4C;">Plan Date </th>
                              <th style="text-align: center;font-weight: bold;color: #4b4b4C;">Status</th>
							   <th style="text-align: center;font-weight: bold;color: #4b4b4C;">View</th>
                              
                            </tr>
                          </thead>
                          <tbody id="activelist">
						  
							<?php
							
							
								
								$j=1;
								
								$sql 	= "SELECT * FROM users WHERE  status = 'Verified' AND plan_expire = '".$expairy_date."' AND renewal_status != 'Y'   ORDER BY userid";
								
								
								
								
								$result = mysqli_query($con,$sql); 
								
								while( $row = mysqli_fetch_array($result)){ 
								
								$invoicetab=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `invoice_table` WHERE sid = '".$row['userid']."' AND status = 'R' order by id desc limit 1 "));
								
									$url = "pdfdisplayreceipt.php?id=".$invoicetab["invoiceno"];
								
								?>
								<tr>
								  <td><?php echo $j;?></td>
                                  <td style="text-transform: capitalize;color: #676767;text-align: center !important;"><?php echo $row['company_name']; ?></td>
                                  <td style="text-transform: capitalize;color: #676767;text-align: center !important;"><?php echo $row['contact_person']; ?></td>
                                  <td style="text-transform: capitalize;color: #676767;text-align: center !important;"><?php echo $row['identification_type']; ?></td>
                                  <td style="text-transform: capitalize;color: #676767;text-align: center !important;"><?php echo $row['identification_no']; ?></td>
                                  <td style="text-transform: capitalize;color: #676767;text-align: center !important;"><?php echo $row['address']; ?></td>
                                  <td style="text-transform: capitalize;color: #676767;text-align: center !important;"><?php echo $row['username']; ?></td>
                                  <td style="color: #676767;text-align: center !important;"><?php echo $row['email']; ?></td>
                                  <td style="text-transform: lowercase;color: #676767;text-align: center !important;"><?php echo $row['mobile']; ?></td>
                                  
								  <td style="color: #676767;text-align: center !important;"><?php echo $row['plan_name']; ?></td>
								   <td align = "center"> <a href="<?php echo $url;?>" target="_blank"> <?php echo $invoicetab["invoiceno"];?>    <i class="fa fa-eye" aria-hidden="true"></i></a></td>
								  <td><?php if($row['plan_id'] == 1) { echo "Free"; } else {echo "Paid";} ?></td>
								  
								  
								<td><?php echo date("d-m-Y",strtotime($row['plan_start'])).'<br> ----to---- <br>'.date("d-m-Y",strtotime($row['plan_expire']));?></td>



								 <td style="color: #676767;text-align: center !important;"><label style='border: 1px solid orange;background-color: orange;border-radius: .25rem;padding: .375rem .5625rem;color: #ffffff;'>Due</label></td>
								  
                                   <td><button type="button" class="btn btn-primary modalButton" data-toggle="modal" data-id="<?php echo $row['userid'];?>">
									<i class="fa fa-eye" aria-hidden="true"></i>
									</button>
								   </td>
                                 
                                </tr>
							<?php
							$j++;
								}
							?>

                          </tbody>
                        </table>
						
						<div class="modal fade" id="dynamicModal">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title">Subscriber History</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
									
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									</div>
								</div>
							</div>
						</div>
						
						
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>
           
			
			
			
			
           
			
			
			
			
          </div>
        </div>
      </div>






     
     


      <!-- content-wrapper ends -->
      <!-- partial:partials/_footer.html -->

      <!-- partial -->
    </div>
    <!-- main-panel ends -->
  </div>
  <!-- page-body-wrapper ends -->

 
  <!-- container-scroller -->
  
  
  <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <script>
	
	 function fetch_selectplan(val){

      $("#plan").val(val);
	  
	
    }
	
	$(document).ready(function(){
    $(".modalButton").click(function(){
        var id =$(this).data('id');
        
        $.ajax({
            url:"ajax1.php",
            method:"post",
            data:{id:id},
            success:function(response){
                $(".modal-body").html(response);
                $("#dynamicModal").modal('show'); 
            }
        })
    })
})
	
     
        function fetch_select(val,id){
          
          $.ajax({
            url:'fetch_data.php',
            type:'post',
            data:{id:id,val:val},
            success:function(res){
              alert("Plan Changed");
            }
          });
       
      }
	  
function myFunctionapprove(){	  
	
 
     if ($("input[type='checkbox']:checked").length >= 1){
        
		var tempValue='';
      tempValue=$('.myBox  input:checkbox').map(function(n){
          if(this.checked){
                return  this.value;
              };
       }).get().join(',');
	   
	   $.ajax({
            url:'fetch_data.php',
            type:'post',
            data:{tempValues:tempValue},
            success:function(res){
               
              window.open("subscription.php?msg=approvals","_self");
            }
          });
		
		
		
		
		
     }else{
          alert ('You didn\'t choose any of the checkboxes!');
         return false;
     }
 
      
   
    
}



</script>
    
  
  <script>
  
	$(document).ready(function() {
    $('#order-listing1').dataTable( {
		 
        "scrollX": true
    } );
	} );
	
	$(document).ready(function() {
    $('#order-listing2').dataTable( {
		 
        "scrollX": false
    } );
	} );
	
	$(document).ready(function() {
    $('#order-listing3').dataTable( {
		 
        "scrollX": false
    } );
	} );
	
	$(document).ready(function() {
    $('#order-listing4').dataTable( {
		 
        "scrollX": false
    } );
	} );
  
  
  
   
  </script>
  <!-- plugins:js -->

<?php include("footer.php");?>