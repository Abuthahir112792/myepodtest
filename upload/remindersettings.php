<?php 
include("header.php");
require_once("config.php");

$remindertab=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `reminder_info` "));


if(isset($_POST['formsubmit'])) {	

$remindertabnum=mysqli_num_rows(mysqli_query($con,"SELECT * FROM `reminder_info` "));
if($remindertabnum == 0){
	$sqlQueryupdates = "INSERT INTO reminder_info SET  reminder_period= '".$_POST["remdays"]."' ";
}else{
 $sqlQueryupdates = "UPDATE reminder_info SET  reminder_period= '".$_POST["remdays"]."' ";
}
 mysqli_query($con, $sqlQueryupdates);

		
		echo "<script> window.location.href = 'remindersettings.php?err=Y';</script>";
}

?>
 <style>
             
 </style>
<!-- partial -->
<div class="container-fluid page-body-wrapper">
  <div class="main-panel">
    <div class="content-wrapper">
     
      
         <div class="tab-pane fade show active"  id="approvals" role="tabpanel" aria-labelledby="business-tab">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title" style="margin-bottom: 8px;">Mail Reminder Settings</h4>
                  <div class="row">
                    <div class="col-12">
					
					 <?php if(isset($_GET["err"])){?>
						<div class="alert alert-success show" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">×</span>
							</button>
							Mail Data Updated successfully.                       
						</div>
						<?php } ?>
					
					
                      <div style="min-height:500px;">
					  
                       
							<form action="" method="post" class="form-sample">
								<div class="col-md-6">  
								  <select class="form-control" id="plancat" name="remdays" style="height: 28px;padding: 4px;">
                                      
                                        <option value="1 week" <?php if($remindertab['reminder_period']=="1 week"){echo "selected";} ?>>1 week</option>

                                        <option value="2 Week" <?php if($remindertab['reminder_period']=="2 Week"){echo "selected";} ?>>2 Week</option>
                                      
                                        <option value="3 days" <?php if($remindertab['reminder_period']=="3 days"){echo "selected";} ?>>3 days</option>
                                      
                                        <option value="1 day" <?php if($remindertab['reminder_period']=="1 day"){echo "selected";} ?>>1 day</option>
										
										<option value="2 days" <?php if($remindertab['reminder_period']=="2 days"){echo "selected";} ?>>2 days</option>
										
										<option value="1 month" <?php if($remindertab['reminder_period']=="1 month"){echo "selected";} ?>>1 month</option>

                                    </select>
								</div>	 
								<div class="col-md-3">   
								<br>
							    <input type="submit" id="formsubmit" name="formsubmit"  class="btn btn-info" value="Reminder Change">
								</div>
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
        

     
     

   
 
  <!-- container-scroller -->
  
  
    
  
  

  <!-- plugins:js -->

<?php include("footer.php");?>