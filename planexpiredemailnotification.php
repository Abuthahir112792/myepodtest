<?php 
include("header.php");


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
//$remindertab=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `reminder_info` WHERE  "));
//$remindertab["reminder_period"] = "EXPIRED";
require_once 'PHPMailer/src/Exception.php';
require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';
//14 days Reminder
if(isset($_POST['add']))
{	
  $sql 	= "SELECT * FROM users WHERE status = 'Verified' AND  plan_expire < DATE(NOW()) AND userid = '".$_POST["id"]."' ";
$row = mysqli_fetch_array(mysqli_query($con,$sql)); 

	
	
		
		 $current_date = date('Y-m-d');
		
		
			
			
	
			$email = $row["email"];
			
			$countval= mysqli_fetch_array(mysqli_query($con,"SELECT COUNT(email) AS countmail FROM reminder_history WHERE rem_period = 'Exp' AND 
			plan_end = '".$row["plan_expire"]."' AND plan_id = '".$row["plan_id"]."' AND
			subscriber_id = '".$row["userid"]."' AND email = '".$email."' "));
			
			
			if($countval["countmail"] < 1){
			
			$sql_Queryinsert = "INSERT INTO reminder_history SET  rem_period = 'Exp' , 
			plan_end = '".$row["plan_expire"]."', plan_id = '".$row["plan_id"]."',
			subscriber_id = '".$row["userid"]."', email = '".$email."', date_time = NOW() ";
			
			$resultinsert = mysqli_query($con, $sql_Queryinsert);
			
			$tid=mysqli_insert_id($con);
			
				mysqli_query($con,"UPDATE `users` SET  renewal_status = '', renewal_date = '', renewalentry = '' WHERE userid  = '".$row["userid"]."' ");
		  
		  
		    $plantable=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `plan_details` WHERE id = '".$row["plan_id"]."' "));
			$invoicetab=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `invoice_table` WHERE sid = '".$row["userid"]."' AND status='R' order by id desc limit 1 "));
			
			
			$dupQry1 = mysqli_num_rows(mysqli_query($con,"SELECT * FROM `mail_history` WHERE subscriber_id = '".$row["userid"]."' AND
			plan_start = '".$current_date."' AND plan_end = '".$row["plan_expire"]."' AND plan_id= '".$row["plan_id"]."' AND status = 'Plan Expired Notification Email' AND type= 'Notification'"));	
			
			if($dupQry1 == 0){
				
			$sqlQueryinsertagain1 = "INSERT INTO mail_history SET  subscriber_id = '".$row["userid"]."' , 
			plan_start = '".$current_date."', plan_end = '".$row["plan_expire"]."',plan_name = '".$row["plan_name"]."', amount = '".$plantable["amount"]."' ,create_date = NOW(),
			plan_id= '".$row["plan_id"]."', email = '".$email."', status = 'Plan Expired Notification Email' , type= 'Notification' , invoiceno = '".$invoicetab["invoiceno"]."'  ";
			
			$resultinsert2 = mysqli_query($con, $sqlQueryinsertagain1);
			
			}
			
			
			$clientsubject = "Account Expiry - Notification";
			
			$clientbody = '<html><body>';
			
			
			$clientbody .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
			$clientbody .= "<tr style='background: #eee;'><td colspan='2' align='center'><img src='https://my-epod.com/epodlite/assets/login/img/housinglogosmall.png' width='200' height='200'/></tr>";
			$clientbody .= "<tr style='background: #eee;'><td colspan='2' align='center'><strong>Account Expiry - Notification!</strong></td></tr>";
			$clientbody .= "<tr style='background: #eee;'><td colspan='2' align='center'><strong></strong></td></tr>";
			$clientbody .= "<tr style='background: #eee;'><td colspan='2' align='center'><strong>Account Credentials:</strong></td></tr>";
			$clientbody .= "<tr><td><strong>Plan:</strong> </td><td>" . $row["plan_name"] . "</td></tr>";
			$clientbody .= "<tr><td><strong>Expiry Date:</strong> </td><td>" . $row["plan_expire"] . "</td></tr>";
			
			$clientbody .= "<tr style='background: #eee;'><td></td><td><a href='https://my-epod.com/epodtest/planrenewexpire.php?rid=$tid'><input type='button' name='btn' value='Renew Plan'style='background-color: #008CBA;color: white;padding: 15px 32px; text-align: center;'></a></td></tr>";
			$clientbody .= "</table>";
			$clientbody .= "</body></html>";
			
			
		   
			
			$mail = new PHPMailer;                            
		   
				//Server settings
				$mail->isSMTP();                                     
				$mail->Host     = $mailhost;                      
				$mail->SMTPAuth = true;                             
			    $mail->Username = $mailusername;
                $mail->Password = $mailpwd;             
				                    
				$mail->SMTPSecure = 'ssl';                           
				$mail->Port = 465;                                   

				//Send Email
				 $mail->setFrom($mailsetfrom);
				
				//Recipients
				
				
				//Content
				$mail->isHTML(true);                                  
				$mail->Subject = $clientsubject;
				$mail->Body    = $clientbody;	
				$mail->addAddress($email);	
				$mail->send();	

			
	echo "<script> window.location.href = 'planexpiredemailnotification.php?msg=Y';</script>";			
			
			
}}		
		
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
                <a  class="nav-link " href="subscription.php" role="tab" aria-selected="false">All Subscribers</a>
              </li>
              
              <li class="nav-item">
                <a class="nav-link" href="awaiting_approval.php" role="tab" aria-selected="false">Approvals</a>
              </li>
			  
              <li class="nav-item">
                <a class="nav-link"  href="due_reminder.php" role="tab" aria-selected="false">Due</a>
              </li>
			  
			  <li class="nav-item">
                 <a class="nav-link"  href="pending_renewal.php" role="tab" aria-selected="false">Pending Renewal</a>
              </li>
			  
			  <li class="nav-item">
                 <a class="nav-link active"  href="planexpired.php" role="tab" aria-selected="false">Plan Expired</a>
              </li>
              
            </ul>
            <div class="d-md-block d-none">
              <a href="#" class="text-light p-1"><i class="mdi mdi-view-dashboard"></i></a>
              <a href="#" class="text-light p-1"><i class="mdi mdi-dots-vertical"></i></a>
            </div>
          </div>
          <div class="tab-content tab-transparent-content">
            
			
			
            <div class="tab-pane fade show active" id="expired" role="tabpanel" aria-labelledby="business-tab">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title" style="margin-bottom:15px;">Plan Expired</h4>
                  <div class="row">
                    <div class="col-12">
                        
                    <?php if(isset($_GET["msg"])){?>
					<div class="alert alert-success show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                        </button>
                        Mail Send successfully!                       
					</div>
					<?php } ?>
                        
                        
                      <div style="min-height:500px;">
					  <form   method="post" class="form-sample" action="" id="form_id" enctype='multipart/form-data'>
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
                              <th style="text-align: center;font-weight: bold;color: #4b4b4C;">Plan Duration</th>
							  <th style="text-align: center;font-weight: bold;color: #4b4b4C;">Receipt No</th>
							  <th style="text-align: center;font-weight: bold;color: #4b4b4C;">Paid Status</th>
							  
                              <th style="text-align: center;font-weight: bold;color: #4b4b4C;"> Plan Date </th>
                              <th style="text-align: center;font-weight: bold;color: #4b4b4C;">Status</th>
							  <th style="text-align: center;font-weight: bold;color: #4b4b4C;">Send invoice</th>
                              
                            </tr>
                          </thead>
                          <tbody id="expirelist">
							<?php
								$j=1;
								$sql 	= "SELECT * FROM users WHERE  status = 'Verified' AND ((DATE(plan_expire) < DATE(NOW()) AND renewal_status != 'Y') OR ((DATE(renewal_date) < DATE(NOW())) AND  renewal_date != '')) ORDER BY userid";
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

								 <td style="color: #676767;text-align: center !important;"><label class="badge badge-danger">Deactive</label></td>
								  
								  <input type="hidden" name="id" value="<?php echo $row['userid'];?>">
								  <td style="color: #676767;text-align: center !important;"><input type="submit" name="add" id="add" class="btn btn-success" style="padding: 15px 15px;" value="Send"  ></td>
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
	
     
        function fetch_select(id){
          
          $.ajax({
            url:'fetch_expdata.php',
            type:'post',
            data:{id:id},
            success:function(res){
              alert("mail send");
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