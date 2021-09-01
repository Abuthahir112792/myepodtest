<?php 
include("header.php");

if( isset($_GET['id']) )  
{  
$id = $_GET['id'];  
$res= mysqli_query($con,"SELECT * FROM users WHERE userid='$id'");  
$row= mysqli_fetch_array($res);  
}  
   
if( isset($_POST['edit']) )  
{
	
$emailaddr = $_POST['emailaddr']; 
$contperson = $_POST['contperson'];  
$contact = $_POST['contact']; 
$address = $_POST['address']; 
$username = $_POST['username']; 
 
$id   = $_POST['id']; 


 
$sql     = "UPDATE users SET email='$emailaddr', contact_person = '$contperson' , username = '$username' , address= '$address', mobile = '$contact' WHERE userid='$id'";  
$res  = mysqli_query($con,$sql) ;  
                                     
 echo "<script> window.location.href = 'userpwdsetting.php?msg=Y';</script>";
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
            
           
          </div>
          <div class="tab-content tab-transparent-content">
            
			
			
            <style>
             
            </style>

            <div class="tab-pane fade show  <?php if(!isset($_GET["err"])){?>active <?php } ?>" id="approvals" role="tabpanel" aria-labelledby="business-tab">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title" style="margin-bottom: 8px;">Profile Edit</h4>
                  <div class="row">
                    <div class="col-12">
					
					
					
                      <div style="min-height:500px;">
                          
                       <div class="tab-content tab-transparent-content" id="tabbodylist">
						<div class="tab-pane fade show active" id="bookingform" role="tabpanel" aria-labelledby="book-tab">
						<div class="card">
						<div class="card-body">
						  <form id="client_create_edit" class="forms-sample"  method="post" enctype="multipart/form-data" autocomplete="off">
						   
							<div class="row">
							  <div class="col-md-4">
								<div class="form-group">
								  <label for="exampleInputUsername1">Company Name</label> <sup style="color: red;">*</sup>
								  <input type="text" class="form-control ui-autocomplete-input"  readonly  style="text-transform:capitalize;" value="<?php echo $row["company_name"]; ?>" >
								  
								 
								</div>
								  <div class="form-group">
								  <label for="exampleInputEmail1">Register Type</label> <sup style="color: red;">*</sup>
								  <input type="text" class="form-control ui-autocomplete-input"  readonly value="<?php echo $row["identification_type"]; ?>" style="text-transform:capitalize;" >
								
								  
								</div>
								 <div class="form-group">
								  <label for="exampleInputUsername1">Email</label> <sup style="color: red;">*</sup>
								  <input type="text" class="form-control" autocomplete="off"   name="emailaddr" value="<?php echo $row["email"]; ?>" required>
								</div>
							   
							  </div>
							  <div class="col-md-4">
								 <div class="form-group">
								  <label for="exampleInputUsername1">Contact Person</label> <sup style="color: red;">*</sup>
								  <input type="text" class="form-control" autocomplete="off"  value="<?php echo $row["contact_person"]; ?>" name="contperson" required style="text-transform:capitalize;">
								</div>
							  
								<div class="form-group">
								  <label for="exampleInputUsername1">Register No</label> <sup style="color: red;">*</sup>
								  <input type="text" class="form-control" value="<?php echo $row["identification_no"]; ?>" readonly style="text-transform:capitalize;">
								</div>
								
								<div class="form-group">
								  <label for="exampleInputUsername1">Contact</label> <sup style="color: red;">*</sup>
								  <input type="text" class="form-control"  name="contact" value="<?php echo $row["mobile"]; ?>" required>
								</div>
								
								</div>
								
								
							 
							  <div class="col-md-4">
								<div class="form-group">
								  <label for="exampleInputEmail1">Address</label> <sup style="color: red;">*</sup>
								  <input type="text" class="form-control ui-autocomplete-input"  required value="<?php echo $row["address"]; ?>" name="address" autocomplete="off" style="text-transform:capitalize;">
								 
								 
								</div>
								<div class="form-group">
								  <label for="exampleInputUsername1">User Name</label> <sup style="color: red;">*</sup>
								  <input type="text" class="form-control" id="billaddress" value="<?php echo $row["username"]; ?>" name="username" required="" autocomplete="off"  style="text-transform:capitalize;">
								</div>
								
								 <div class="form-group">
								 
								  <?php $plantable=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `plan_details` WHERE id = '".$row['plan_id']."' ")); ?>															  
																				  
											
								  <label for="exampleInputUsername1">Plan</label> <sup style="color: red;">*</sup>
								  <input type="text" class="form-control" id="billaddress" readonly value="<?php echo $plantable['plan_name']; ?>" style="text-transform:capitalize;">
								</div>
							   
							   
							  </div>
						  
					  
						 <div class="form-group">
                          <input type="hidden" name="id" value="<?php echo $_GET['id'];?>">
                          <input type="submit"  name="edit" value="Submit" class="btn btn-success">
                        </div>
                       
					  
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

            </div>
            
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