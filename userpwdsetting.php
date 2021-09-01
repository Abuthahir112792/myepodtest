<?php 
include("header.php");

//require_once("config.php");

?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
                  <h4 class="card-title" style="margin-bottom: 8px;">Profile  Reset</h4>
                  <div class="row">
                    <div class="col-12">
					
					 <?php if(isset($_GET["err"])){?>
						<div class="alert alert-success show" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">×</span>
							</button>
							Password reset successfully. Kindly check your mail!                      
						</div>
						<?php } ?>
						
						<?php if(isset($_GET["msg"])){?>
					<div class="alert alert-success show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                        </button>
                        Updated successfully.                       
					</div>
					<?php } ?>
					
                      <div style="min-height:500px;">
					   <form action="" method="post" class="form-sample">
                        <table id="order-listing" class="table" border="1">
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
                              <th style="text-align: center !important;font-weight: bold;color: #4b4b4C;">Action</th>
                              
                            </tr>
                          </thead>
                          <tbody id="expirelist">
							<?php
								$j=1;
								$sql 	= "SELECT * FROM users WHERE  status = 'Verified' AND role IN ('0') ORDER BY userid";
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
                                  <td style="text-transform: lowercase;color: #676767;text-align: center !important;">
								<input type="hidden" name="email" id="email" value="<?php echo $row['email']; ?>">  
								<input type="hidden" name="uid" id="uid" value="<?php echo $row['userid']; ?>">
								<a href="emp_profile.php?id=<?php echo $row['userid']; ?>" title="edit">
								    <i class="fa fa-edit" style="font-size:25px">
								        
								    </i></a>&nbsp;
								<a style="cursor: pointer;" title="Change Password">
								    
								    <i class="fa fa-unlock-alt" style="font-size:25px"onclick="ActionFunction('passwordupdation.php',<?php echo $row['userid']; ?>,'edit');">
								        
								    </i>
								    
								   </a>
											&nbsp;&nbsp;
								
									
									</td> 
                                 
                                </tr>
							<?php
							$j++;
								}
							?>
                          </tbody>
                        </table>
						
						</form>
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
function ActionFunction(urls, accessnos, work)
	{
		if (work == "edit") 
		{
			var result = confirm("Are you sure you want to change Password?");
			if (result == true) 
			{
				$.ajax({
					url: urls,
					async: true,
					cache: false,
					data: {id: accessnos},
					type: 'get',			
					success: function (data) {
						data=data.replace(/\s+/g,"");
						var spancontainer=$('span#record'+accessnos);
						if(data != 0)
						{
							spancontainer.slideUp('slow', function(){
								spancontainer.fadeOut("slow");
								spancontainer.remove();
							});
							document.location.href = 'userpwdsetting.php?err=del';  
						}
						else 
						{
							spancontainer.slideUp('slow', function(){		
								spancontainer.html("Error While this deleting a record");
							});
						}
					},
					error : function(XMLHttpRequest, textStatus, errorThrown) {
						alert(textStatus);
					}
				});
			}
		}
	}
   
 
  <!-- container-scroller -->
  </script>
  

    
  
  

  <!-- plugins:js -->

<?php include("footer.php");?>