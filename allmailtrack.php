<?php 
include("header.php");

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
                <a class="nav-link active" href="#" role="tab" aria-selected="false">Track All Mail</a>
              </li>
              
              
              
            </ul>
           
          </div>
          <div class="tab-content tab-transparent-content">
            
			
			
            <style>
             
            </style>

            
            <div class="tab-pane fade show active" id="subscribers" role="tabpanel" aria-labelledby="business-tab">
              <div class="card">
                <div class="card-body">
				
				<h4 class="card-title" style="margin-bottom:15px;">Track Mail</h4> 
				
				  <div class="row">
                    <div class="col-12">
					
					<?php if(isset($_GET["msg"])){?>
					<div class="alert alert-success show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                        </button>
                        Mail Send successfully.                       
					</div>
					<?php } ?>
					
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
                             
                              <th style="text-align: center !important;font-weight: bold;color: #4b4b4C;">Email</th>
                              <th style="text-align: center !important;font-weight: bold;color: #4b4b4C;">Contact</th>
                              <th style="text-align: center !important;font-weight: bold;color: #4b4b4C;">Plan Name</th>
							  <th style="text-align: center;font-weight: bold;color: #4b4b4C;">Receipt/Invoice No </th>
                              <th style="text-align: center;font-weight: bold;color: #4b4b4C;">Plan Date </th>
                              <th style="text-align: center;font-weight: bold;color: #4b4b4C;">Status</th>
							  
							  <th style="text-align: center;font-weight: bold;color: #4b4b4C;">Resend</th>
							  
                            </tr>
                          </thead>
                          <tbody id="activelist">
						  
							<?php
							
							
								
								$j=1;
								
								$sql 	= "SELECT * FROM mail_history ORDER BY mid DESC";
								
								
								
								
								$result = mysqli_query($con,$sql); 
								
								while( $row = mysqli_fetch_array($result)){ 
								
								$usertab=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `users` WHERE userid = '".$row["subscriber_id"]."' "));
								
								$plantable=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `plan_details` WHERE id = '".$row["plan_id"]."' "));
								$url1 = "pdfdisplayreceipt.php?id=".$row["invoiceno"];
								$url2 = "pdfdisplayinvoice.php?id=".$row["invoiceno"];
									
								?>
								<tr>
								  <td><?php echo $j;?></td>
                                  <td style="text-transform: capitalize;color: #676767;text-align: center !important;"><?php echo $usertab['company_name']; ?></td>
                                  <td style="text-transform: capitalize;color: #676767;text-align: center !important;"><?php echo $usertab['contact_person']; ?></td>
                                  <td style="text-transform: capitalize;color: #676767;text-align: center !important;"><?php echo $usertab['identification_type']; ?></td>
                                  <td style="text-transform: capitalize;color: #676767;text-align: center !important;"><?php echo $usertab['identification_no']; ?></td>
                                  <td style="text-transform: capitalize;color: #676767;text-align: center !important;"><?php echo $usertab['address']; ?></td>
                                 
                                  <td style="color: #676767;text-align: center !important;"><?php echo $row['email']; ?></td>
                                  <td style="text-transform: lowercase;color: #676767;text-align: center !important;"><?php echo $usertab['mobile']; ?></td>
                                  
								  <td style="color: #676767;text-align: center !important;"><?php echo $plantable['plan_name']; ?></td>
								  
								 <td align = "center"> <?php if($row['type'] == 'Invoice'){ ?>  <a href="<?php echo $url2;?>" target="_blank"> <?php echo $row["invoiceno"];?>    <i class="fa fa-eye" aria-hidden="true"></i></a><?php }else{?> <a href="<?php echo $url1;?>" target="_blank"> <?php echo $row["invoiceno"];?>    <i class="fa fa-eye" aria-hidden="true"></i></a> <?php } ?></td>
								 <td><?php echo date("d-m-Y",strtotime($row['plan_start'])).'<br> ----to---- <br>'.date("d-m-Y",strtotime($row['plan_end']));?></td>
								 <td><?php echo $row['status']; ?></td>
								 
								 <td>
									<?php if($row['status'] == "Awaiting Approval Request" && $row['type'] == "Invoice"){?><a href= "requestresendinv.php?mid=<?php echo $row["mid"];?>" >Send</a><?php } ?>
									<?php if($row['status'] == "Awaiting Approved Email" && $row['type'] == "Receipt"){?><a href= "requestresendrec.php?mid=<?php echo $row["mid"];?>" >Send</a><?php } ?>
									<!--<?php if($row['status'] == "Plan Change" && $row['type'] == "Invoice"){?><a href= "planchginv.php?mid=<?php echo $row["mid"];?>" >Send</a><?php } ?>-->
									<?php if($row['status'] == "Renewal Request Email" && $row['type'] == "Invoice"){?><a href= "renreqinv.php?mid=<?php echo $row["mid"];?>" >Send</a><?php } ?>
									<?php if($row['status'] == "Renewal Approved Email" && $row['type'] == "Receipt"){?><a href= "renreqrec.php?mid=<?php echo $row["mid"];?>" >Send</a><?php } ?>
									
									<?php if($row['status'] == "Expired Renewal Email" && $row['type'] == "Invoice"){?><a href= "expreqinv.php?mid=<?php echo $row["mid"];?>" >Send</a><?php } ?>
									<?php if($row['status'] == "Plan Expired Renewed Email" && $row['type'] == "Receipt"){?><a href= "expreqrec.php?mid=<?php echo $row["mid"];?>" >Send</a><?php } ?>
									
									
									
									
									<?php 
									$renewal_date = date('Y-m-d', strtotime("+3 days", strtotime($row["plan_end"])));
									$current_date = date('Y-m-d');
									if($row['status'] == "Reminder Email" && $renewal_date >= $current_date){?><a href= "remresend.php?mid=<?php echo $row["mid"];?>" >Send</a><?php } ?>
									
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