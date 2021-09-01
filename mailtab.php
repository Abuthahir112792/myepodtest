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
                <a class="nav-link active" href="#" role="tab" aria-selected="false">Track Reminder Mail</a>
              </li>
              
              
              
            </ul>
           
          </div>
          <div class="tab-content tab-transparent-content">
            
			
			
            <style>
             
            </style>

            
            <div class="tab-pane fade show active" id="subscribers" role="tabpanel" aria-labelledby="business-tab">
              <div class="card">
                <div class="card-body">
				
				<h4 class="card-title" style="margin-bottom:15px;">Track Reminder Mail</h4> <a href="dueexcel.php" align="right"><input type="button" name="export_excel" class="btn btn-success" value="Export to Excel"></a>
				
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
                              <th style="text-align: center;font-weight: bold;color: #4b4b4C;">Plan Expire &nbsp;</th>
							  <th style="text-align: center;font-weight: bold;color: #4b4b4C;">Reminder &nbsp;</th>
                              <th style="text-align: center;font-weight: bold;color: #4b4b4C;">Status</th>
							  <th style="text-align: center;font-weight: bold;color: #4b4b4C;">View</th>
                              
                            </tr>
                          </thead>
                          <tbody id="activelist">
						  
							<?php
							
							
								
								$j=1;
								
								$sql 	= "SELECT * FROM users A JOIN reminder_history B ON  B.subscriber_id = A.userid WHERE  A.status = 'Verified'    ORDER BY id DESC";
								
								
								
								
								$result = mysqli_query($con,$sql); 
								
								while( $row = mysqli_fetch_array($result)){ 
								
									$renewsql 	= mysqli_num_rows(mysqli_query($con,"SELECT * FROM users WHERE  renewal_status = 'Y' AND renewal_date >= DATE(NOW()) AND userid = '".$row['userid']."' "));
									$duesql 	= mysqli_num_rows(mysqli_query($con,"SELECT * FROM users WHERE  status = 'Verified' AND plan_expire = '".$expairy_date."' AND renewal_status != 'Y'   AND userid = '".$row['userid']."' "));
									$expirysql 	= mysqli_num_rows(mysqli_query($con,"SELECT * FROM users WHERE  status = 'Verified' AND ((DATE(plan_expire) < DATE(NOW()) AND renewal_status != 'Y') OR ((DATE(renewal_date) <= DATE(NOW())) AND  renewal_date != '')) AND userid = '".$row['userid']."' "));
									
									if($expirysql == 1){
										$badge = "<label class='badge badge-danger'>Deactive</label>";
										
									}else if($duesql == 1){
										$badge = "<label class='badge badge-success'>Due</label>";
									}else if($renewsql == 1){
										$badge = "<label class='badge badge-success'>Pending Renewal</label>";
									}else{
										$badge = "<label class='badge badge-success'>Active</label>";
									}
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
								  <td style="text-transform: lowercase;color: #676767;text-align: center !important;"><?php if($row['plan_expire'] != "0000-00-00"){echo date("d-m-Y",strtotime($row['plan_expire'])); }?></td>
								 
								

								 <td style="color: #676767;text-align: center !important;"><label class="badge badge-success"><?php echo $row['rem_period']; ?></label></td>
								
								   <td style="color: #676767;text-align: center !important;"><?php echo $badge;?></label></td>
                                   <td><button type="button" class="btn btn-primary modalButton" data-toggle="modal" data-id="<?php echo $row['userid'];?>">
									View More
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
	
	 function fetch_selectplan(val){

      $("#plan").val(val);
	  
	
    }
	
     
       
	  

  
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