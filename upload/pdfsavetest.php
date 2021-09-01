<?php
require_once("config.php");
				$row1 	= mysqli_fetch_array(mysqli_query($con,"SELECT * FROM reminder_history WHERE  id = 39 "));
				
				$plantable=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `plan_details` WHERE id = '".$row1["plan_id"]."' "));

			
			
			
			
		use Dompdf\Dompdf; 

		require 'dompdf/autoload.inc.php';
        
        // instantiate and use the dompdf class
        $pdf = new DOMPDF();
        
       
	
		$fname = '
              <!DOCTYPE html>
                <html lang="en">
                  <head>
                      <title>mail</title>
                      <meta charset="utf-8">
                      <meta name="viewport" content="width=device-width, initial-scale=1">
                      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
                  </head>
                  <body>
                      <STYLE type="text/css">
                      body {
                      margin-top: 0px;margin-left: 0px;
                      }
                      #page_1 {position:relative; overflow: hidden;padding: 0px;border: none;width: 658px;height: 911px;margin-left: 34px;}
                      .dclr {clear:both;float:none;height:1px;margin:0px;padding:0px;overflow:hidden;}
                      
                      .ft0{font: bold 16px;color: #555555;line-height: 19px;margin-top:10px;margin-bottom:12px;}
                      .ft1{font: 1px;line-height: 1px;}
                      .ft2{font: 16px;color: #555555;line-height: 18px;}
                      
                      .ft5{font: bold 24px;color: #555555;line-height: 22px;margin-top:2%;text-transform:uppercase;}
                      .head{font: bold 18px;color: #555555;line-height: 32px;}
                      .tr8{height: 42px;}

                      </STYLE>
                    <DIV id="page_1">
                      <DIV class="dclr"></DIV>
					  
					  
					 <table align="center">
			<tr style="background: #eee;"><td colspan="2" align="center"><img src="https://my-epod.com/epodlite/assets/login/img/housinglogosmall.png" width="200" height="200"/></tr>
			<tr style="background: #eee;"><td colspan="2" align="center"><strong>Account Expiry - Notification!</strong></td></tr>
			<tr style="background: #eee;"><td colspan="2" align="center"><strong>Your Account will Expired with in '.$row1["rem_period"] .' !</strong></td></tr>
			<tr style="background: #eee;"><td colspan="2" align="center"><strong>Account Credentials:</strong></td></tr>
			<tr style="background: #eee;"><td ><strong>Plan:</strong> </td><td>' . $plantable["plan_type"] . '</td></tr>
			<tr style="background: #eee;"><td ><strong>Expiry Date:</strong> </td><td>' . date("d-m-Y",strtotime($row1["plan_end"])) . '</td></tr>
			</table>
			
                      
                </DIV>
                  </body>
                </html>';
				
				
				
	
				
                
		//$filename    = "DocketNo.pdf";

        $pdf->set_option('isRemoteEnabled', true);
         $pdf->set_option('enable_html5_parser', TRUE);
        // Load HTML content
        $pdf->loadHtml($fname);
        // (Optional) Setup the paper size and orientation
        $pdf->setPaper('legal', 'portrait');
        // Render the HTML as PDF
        $pdf->render();
        $pdf->output();
		
		$pdf->stream("dompdf_out.pdf", array("Attachment" => false));

exit(0);
		//$pdf->stream("remindermail.pdf");
?>