<?php 
include("header.php");


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
                  <h4 class="card-title" style="margin-bottom: 8px;">Subscriber History</h4>
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
                              <th style="text-align: center !important;font-weight: bold;color: #4b4b4C;">Username</th>
                              <th style="text-align: center !important;font-weight: bold;color: #4b4b4C;">Email</th>
                              <th style="text-align: center !important;font-weight: bold;color: #4b4b4C;">Contact</th>
                              <th style="text-align: center;font-weight: bold;color: #4b4b4C;">Plan Duration</th>
                              <th style="text-align: center;font-weight: bold;color: #4b4b4C;"> Expired Date </th>
                              <th style="text-align: center;font-weight: bold;color: #4b4b4C;">Plan</th>
                              <th style="text-align: center;font-weight: bold;color: #4b4b4C;">view</th>
                            </tr>
                          </thead>
                          <tbody id="expirelist">
							<?php
								$j=1;
								$sql 	= "SELECT * FROM users WHERE  status = 'Verified' ORDER BY userid";
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
								  
								  
								  <select class="form-control" id="plancat" name="plan" style="height: 28px;padding: 4px;">
                                      
                                        <option value="1" <?php if($row['plan_id']=="1"){echo "selected";} ?>>Free</option>

                                      
                                        <option value="2" <?php if($row['plan_id']=="2"){echo "selected";} ?>>Silver</option>

                                      
                                        <option value="3" <?php if($row['plan_id']=="3"){echo "selected";} ?>>Gold</option>

                                      
                                        <option value="4" <?php if($row['plan_id']=="4"){echo "selected";} ?>>Premium</option>

                                    </select>
								</td>
								
								
							   <td><button type="button" class="btn btn-primary modalButton" data-toggle="modal" data-id="<?php echo $row['userid'];?>">
                View More
                </button>
            </td>
								
							   
								
								
									   
							   
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
        

     

    
  <script>
$(document).ready(function(){
    $(".modalButton").click(function(){
        var id =$(this).data('id');
        
        $.ajax({
            url:"ajax.php",
            method:"post",
            data:{id:id},
            success:function(response){
                $(".modal-body").html(response);
                $("#dynamicModal").modal('show'); 
            }
        })
    })
})
</script>
<script>
$(document).ready(function() {
    $('#order-listing1').dataTable( {
		 
        "scrollX": true
    } );
	} );
  
</script>
  <!-- plugins:js -->

<?php include("footer.php");?>