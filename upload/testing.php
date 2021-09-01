 <?php
	include("config.php");	

		$query='SELECT * FROM users WHERE 1 GROUP BY MONTH(plan_start)';
			$execute=mysqli_query($con,$query);
 

                while($row = mysqli_fetch_assoc($execute)){
					
					//echo date('m',strtotime($row["plan_start"]));
					
					
					echo "SELECT MONTH(plan_start) FROM `users` WHERE plan_id = '1' AND DATE_FORMAT(plan_start,'%m') = '".date('m',strtotime($row["plan_start"]))."' AND status = 'Verified'";
					
					echo $plan1 = mysqli_num_rows(mysqli_query($con,"SELECT * FROM `users` WHERE plan_id = '1' AND DATE_FORMAT(plan_start,'%m') = '".date('m',strtotime($row["plan_start"]))."' AND status = 'Verified'"));
			$plan2 = mysqli_num_rows(mysqli_query($con,"SELECT * FROM `users` WHERE plan_id = '2' AND MONTH(plan_start) = '".date('m',strtotime($row["plan_start"]))."' AND status = 'Verified'"));
			$plan3 = mysqli_num_rows(mysqli_query($con,"SELECT * FROM `users` WHERE plan_id = '3' AND MONTH(plan_start) = '".date('m',strtotime($row["plan_start"]))."' AND status = 'Verified'"));
			$plan4 = mysqli_num_rows(mysqli_query($con,"SELECT * FROM `users` WHERE plan_id = '4' AND MONTH(plan_start) = '".date('m',strtotime($row["plan_start"]))."' AND status = 'Verified'"));
		 
                    //echo "['".date('F',strtotime($row["plan_start"]))."', ".$plan1.", ".$plan2.", ".$plan3.", ".$plan4."],";
                }
            ?>