<?php 
include("header.php");

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
  
  .small-box {
    border-radius: 2px;
    position: relative;
    display: block;
    margin-bottom: 20px;
    box-shadow: 0 1px 1px rgba(0,0,0,0.1);
}
.small-box>.inner {
    padding: 10px;
}
.small-box .icon {
    -webkit-transition: all .3s linear;
    -o-transition: all .3s linear;
    transition: all .3s linear;
    position: absolute;
    top: 5px;
    right: 10px;
    z-index: 0;
    font-size: 90px;
    color: rgba(0,0,0,0.15);
}
.small-box h3, .small-box p {
    z-index: 5;
}
.small-box h3 {
    font-size: 38px;
    font-weight: bold;
    margin: 0 0 10px 0;
    white-space: nowrap;
    padding: 0;
}
.small-box h3, .small-box p {
    z-index: 5;
}
.small-box p {
    font-size: 15px;
}
.small-box>.small-box-footer {
    position: relative;
    text-align: center;
    padding: 3px 0;
    color: #fff;
    color: rgba(255,255,255,0.8);
    display: block;
    z-index: 10;
    background: rgba(0,0,0,0.1);
    text-decoration: none;
}
</style>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
		  
		  <?php
			$plan1 = mysqli_num_rows(mysqli_query($con,"SELECT * FROM `users` WHERE plan_id = '1' AND plan_expire >= DATE(NOW()) AND status = 'Verified' "));
			$plan2 = mysqli_num_rows(mysqli_query($con,"SELECT * FROM `users` WHERE plan_id = '2' AND plan_expire >= DATE(NOW()) AND status = 'Verified' "));
			$plan3 = mysqli_num_rows(mysqli_query($con,"SELECT * FROM `users` WHERE plan_id = '3' AND plan_expire >= DATE(NOW()) AND status = 'Verified' "));
			$plan4 = mysqli_num_rows(mysqli_query($con,"SELECT * FROM `users` WHERE plan_id = '4' AND plan_expire >= DATE(NOW()) AND status = 'Verified' "));
		  ?>

        var data = google.visualization.arrayToDataTable([
          ['Plan', 'No.of Subscribers'],
          ['Free',     <?php echo $plan1;?> ],
          ['Silver',      <?php echo $plan2;?>],
          ['Gold',  <?php echo $plan3;?>],
          ['Premium', <?php echo $plan4;?>]
          
        ]);

        var options = {
          
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
      }
	  
	  
    </script>
	<script type="text/javascript">
      google.charts.load('current', {
        'packages':['corechart']
       
      });
      google.charts.setOnLoadCallback(drawRegionsMap);

      function drawRegionsMap() {
        var data = google.visualization.arrayToDataTable([
             ['Year', 'plan start', 'Plan Expired'],
            <?php
			$query='SELECT * FROM users WHERE 1 GROUP BY MONTH(plan_start)';
			$execute=mysqli_query($con,$query);
 

                while($row = mysqli_fetch_assoc($execute)){
					
					$plantable = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `plan_details` WHERE id = '".$row["plan_main_id"]."'"));
					
					$countstart = mysqli_num_rows(mysqli_query($con,"SELECT * FROM `users` WHERE MONTH(plan_start) = '".date('m',strtotime($row["plan_start"]))."' AND status = 'Verified'"));
					$countend   = mysqli_num_rows(mysqli_query($con,"SELECT * FROM `users` WHERE MONTH(plan_end) = '".date('m',strtotime($row["plan_end"]))."' AND status = 'Verified'"));
					
                    echo "['".date('F',strtotime($row["plan_start"]))."', ".$countstart." , ".$countend ."],";
                }
            ?>
        ]);

        var options = {
        };

        var chart = new google.visualization.LineChart(document.getElementById('regions_div'));

        chart.draw(data, options);
      }
    </script>
	
	
	
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);
	  
	
			

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Month', 'Free', 'Silver', 'Gold', 'Premium'],
		  
		  
		  <?php
			$query='SELECT * FROM users WHERE 1 GROUP BY MONTH(plan_start)';
			$execute=mysqli_query($con,$query);
 

                while($row = mysqli_fetch_assoc($execute)){
					
					
					$plan1 = mysqli_num_rows(mysqli_query($con,"SELECT * FROM `users` WHERE plan_id = '1'  AND MONTH(plan_start) = '".date('m',strtotime($row["plan_start"]))."' AND status = 'Verified' AND plan_expire >= DATE(NOW())"));
			$plan2 = mysqli_num_rows(mysqli_query($con,"SELECT * FROM `users` WHERE plan_id = '2' AND MONTH(plan_start) = '".date('m',strtotime($row["plan_start"]))."' AND status = 'Verified' AND plan_expire >= DATE(NOW())"));
			$plan3 = mysqli_num_rows(mysqli_query($con,"SELECT * FROM `users` WHERE plan_id = '3' AND MONTH(plan_start) = '".date('m',strtotime($row["plan_start"]))."' AND status = 'Verified' AND plan_expire >= DATE(NOW())"));
			$plan4 = mysqli_num_rows(mysqli_query($con,"SELECT * FROM `users` WHERE plan_id = '4' AND MONTH(plan_start) = '".date('m',strtotime($row["plan_start"]))."' AND status = 'Verified' AND plan_expire >= DATE(NOW())"));
		 
                    echo "['".date('F',strtotime($row["plan_start"]))."', ".$plan1.", ".$plan2.", ".$plan3.", ".$plan4."],";
                }
            ?>
			
			
          
        ]);

        var options = {
          chart: {
            title: 'Plan Subscription - Month wise',
            subtitle: 'Free, Silver, Gold and Premium: 2021',
          }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
 
<!-- partial -->
<div class="container-fluid page-body-wrapper">
  <div class="main-panel">
    <div class="content-wrapper">
     
      <div class="row">
        <div class="col-md-12">
         
          <div class="tab-content tab-transparent-content">
            <div class="tab-pane fade show <?php if(!isset($_GET["msg"]) && !isset($_GET["err"])){?> active <?php } ?>" id="business-1" role="tabpanel" aria-labelledby="business-tab">
              <div class="row">
                  
                  <div class="col-lg-2 col-xs-6">
             <!-- small box -->
                <div class="small-box" style="background: linear-gradient(to bottom, #d41459, #911a6c); color:#FFF;" href="subscription.php" class="card-danger-gradient">
				    				    <div class="inner">
                        <h3><?php echo $countall = mysqli_num_rows(mysqli_query($con,"SELECT * FROM `users` WHERE role NOT IN(1)  ")); ?></h3>
                        <p>Total</p>
                    </div>
					                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <a href="subscription.php" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i></a>
					<!--employee_list.php-->
                </div>
            </div>
			
			 <div class="col-lg-2 col-xs-6">
             <!-- small box -->
                <div class="small-box" style="background-color:#228B22; color:#FFF;" href="subscription.php">
				    				    <div class="inner">
                        <h3><?php echo $countall = mysqli_num_rows(mysqli_query($con,"SELECT * FROM `users` WHERE status='Verified'  AND role NOT IN(1) ")); ?></h3>
                        <p>All Subscribers</p>
                    </div>
					                    <div class="icon">
                        <i class="fa fa-sign-out"></i>
                    </div>
                    <a href="subscription.php" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i></a>
					<!--employee_list.php-->
                </div>
            </div>
			
			 <div class="col-lg-2 col-xs-6">
             <!-- small box -->
                <div class="small-box" style="background-color:#32CD32; color:#FFF;" href="awaiting_approval.php">
				    				    <div class="inner">
                        <h3><?php echo $countall = mysqli_num_rows(mysqli_query($con,"SELECT * FROM `users` WHERE status='Pending' AND role NOT IN(1) ")); ?></h3>
                        <p>Awaiting Approval</p>
                    </div>
					                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <a href="awaiting_approval.php" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i></a>
					<!--employee_list.php-->
                </div>
            </div>
			
			 <div class="col-lg-2 col-xs-6">
             <!-- small box -->
                <div class="small-box" style="background-color:#228B22; color:#FFF;" href="due_reminder.php">
				    				    <div class="inner">
                        <h3><?php echo $countall = mysqli_num_rows(mysqli_query($con,"SELECT * FROM users WHERE  status = 'Verified' AND role NOT IN(1) AND plan_expire = '".$expairy_date."' AND renewal_status != 'Y' ")); ?></h3>
                        <p>Due</p>
                    </div>
					                    <div class="icon">
                        <i class="fa fa-sign-out"></i>
                    </div>
                    <a href="due_reminder.php" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i></a>
					<!--employee_list.php-->
                </div>
            </div>
			
			 <div class="col-lg-2 col-xs-6">
             <!-- small box -->
                <div class="small-box" style="background-color:#32CD32; color:#FFF;" href="employee_list.php">
				    <div class="inner">
                        <h3><?php echo $countall = mysqli_num_rows(mysqli_query($con,"SELECT * FROM `subscription_history` WHERE status='Renewed' ")); ?></h3>
                        <p>Renewed</p>
                    </div>
					                    <div class="icon">
                        <i class="fa fa-users"></i>
                    </div>
                    <a href="subscription.php" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i></a>
					<!--employee_list.php-->
                </div>
            </div>
            
            <div class="col-lg-2 col-xs-6">
             <!-- small box -->
                <div class="small-box" style="background-color:#228B22; color:#FFF;" href="planexpired.php">
				    				    <div class="inner">
                        <h3><?php echo $countall = mysqli_num_rows(mysqli_query($con,"SELECT * FROM users WHERE  status = 'Verified' AND role NOT IN(1) AND ((DATE(plan_expire) < DATE(NOW()) AND renewal_status != 'Y') OR ((DATE(renewal_date) <= DATE(NOW())) AND  renewal_date != '')) ")); ?></h3>
                        <p>Plan Expired</p>
                    </div>
					                    <div class="icon">
                        <i class="fa fa-building"></i>
                    </div>
                    <a href="planexpired.php" class="small-box-footer">More Info <i class="fa fa-arrow-circle-right"></i></a>
					<!--employee_list.php-->
                </div>
            </div>
            
           
            
           
                  <br><div></div>
                <div class="col-sm-4 grid-margin stretch-card" >
                    <br>
                  <div class="card" style="border-top:3px solid #228B22;">
					
					
					<div class="text-center border-right border-md-0">
					    <br>
					<h4>Plan Statistics</h4>
					</div>
					
					<div id="piechart" style="width: 400px; height: 300px;"></div>
					
                    <div class="card-body bg-white pt-4">
                      <div class="row pt-4">
                        <div class="col-sm-6">
                          <div class="text-center border-right border-md-0">
                            <h4>Awaiting Approval</h4>
							
                            <h1 class="text-dark font-weight-bold mb-md-3"><?php echo $req = mysqli_num_rows(mysqli_query($con,"SELECT * FROM users WHERE  status = 'Pending' ")); ?></h1>
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="text-center">
                            <h4>Plan Expired</h4>
                            <h1 class="text-dark font-weight-bold"><?php echo $expired = mysqli_num_rows(mysqli_query($con,"SELECT * FROM `users` WHERE plan_expire <= DATE(NOW()) AND status = 'Verified' AND role NOT IN(1)")); ?></h1>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
				
			
				<div class="col-sm-8  grid-margin stretch-card">
                  <div class="card" style="border-top:3px solid #228B22;">
                    <div class="card-body">
                      <div class="d-xl-flex justify-content-between mb-2">
                        
                         <div id="columnchart_material" style="width: 1200px; height: 500px;"></div>
                      </div>
                      
                    </div>
                  </div>
                </div>
			
				
                
              </div>
              <br>
              <div class="row">
				<div class="col-xl-3 col-lg-6 col-sm-6 grid-margin stretch-card">
                  <div class="card" style="border-top:3px solid #228B22;">
                    <div class="card-body text-center">
                      <h5 class="mb-2 text-dark font-weight-normal">Free</h5>
                      <h2 class="mb-4 text-dark font-weight-bold"><?php echo $countall = mysqli_num_rows(mysqli_query($con,"SELECT * FROM `users` WHERE plan_id = '1' AND plan_expire >= DATE(NOW()) AND status = 'Verified' ")); ?></h2>
                      <div class="dashboard-progress dashboard-progress-4 d-flex align-items-center justify-content-center item-parent"><i class="mdi mdi-account-circle icon-md absolute-center text-dark"></i></div>
                     
                    </div>
                  </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-sm-6 grid-margin stretch-card">
                  <div class="card" style="border-top:3px solid #228B22;">
                    <div class="card-body text-center">
                      <h5 class="mb-2 text-dark font-weight-normal">Silver</h5>
                      <h2 class="mb-4 text-dark font-weight-bold"><?php echo $countall = mysqli_num_rows(mysqli_query($con,"SELECT * FROM `users` WHERE plan_id = '2'AND plan_expire >= DATE(NOW()) AND status = 'Verified' ")); ?></h2>
                      <div class="dashboard-progress dashboard-progress-1 d-flex align-items-center justify-content-center item-parent"><i class="mdi mdi-account-circle icon-md absolute-center text-dark"></i></div>
                     
                    </div>
                  </div>
                </div>
				 <div class="col-xl-3  col-lg-6 col-sm-6 grid-margin stretch-card">
                  <div class="card" style="border-top:3px solid #228B22;">
                    <div class="card-body text-center">
                      <h5 class="mb-2 text-dark font-weight-normal">Gold</h5>
                      <h2 class="mb-4 text-dark font-weight-bold"><?php echo $countall = mysqli_num_rows(mysqli_query($con,"SELECT * FROM `users` WHERE plan_id = '3' AND plan_expire >= DATE(NOW()) AND status = 'Verified' ")); ?></h2>
                      <div class="dashboard-progress dashboard-progress-3 d-flex align-items-center justify-content-center item-parent"><i class="mdi mdi-account-circle icon-md absolute-center text-dark"></i></div>
                      
                    </div>
                  </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-sm-6 grid-margin stretch-card">
                  <div class="card" style="border-top:3px solid #228B22;">
                    <div class="card-body text-center">
                      <h5 class="mb-2 text-dark font-weight-normal">Premium</h5>
                      <h2 class="mb-4 text-dark font-weight-bold"><?php echo $countall = mysqli_num_rows(mysqli_query($con,"SELECT * FROM `users` WHERE plan_id = '4' AND plan_expire >= DATE(NOW()) AND status = 'Verified'")); ?></h2>
                      <div class="dashboard-progress dashboard-progress-2 d-flex align-items-center justify-content-center item-parent"><i class="mdi mdi-account-circle icon-md absolute-center text-dark"></i></div>
                      
                    </div>
                  </div>
                </div>
               
                
              </div>
              <div class="row">
			  <br>
			   <div class="col-xl-12">
                  <div class="card" align="center">
               
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

    
  




  <!-- plugins:js -->

<?php include("footer.php");?>