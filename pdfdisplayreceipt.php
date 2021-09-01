<?php
require_once("config.php");
				$row1 	= mysqli_fetch_array(mysqli_query($con,"SELECT * FROM mail_history WHERE  invoiceno = '".$_GET["id"]."' AND type = 'Receipt' "));
				
				//$plantable=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `plan_details` WHERE id = '".$row1["plan_id"]."' "));

			
			$usertab=mysqli_fetch_array(mysqli_query($con,"SELECT * FROM `users` WHERE userid = '".$row1["subscriber_id"]."' "));
			
			
		use Dompdf\Dompdf;
		// Reference the Options namespace 
		use Dompdf\Options; 
		// Reference the Font Metrics namespace 
		use Dompdf\FontMetrics;

		require 'dompdf/autoload.inc.php';
		
		
		
		 // instantiate and use the dompdf class
    $options = new Options(); 
    $options->set('isPhpEnabled', 'true'); 
        
    // instantiate and use the dompdf class
    $pdf = new DOMPDF($options);
	
	$fname = '
              <!DOCTYPE html>
                <html lang="en">
                  <head>
                      <title>Receipt</title>
                      <meta charset="utf-8">
                      <meta name="viewport" content="width=device-width, initial-scale=1">
                      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
                  </head>
                  <body>
                      <STYLE type="text/css">
                      
                      

                      </STYLE>
                    <DIV id="page_2" >
                      <DIV class="dclr"></DIV>
                      <TABLE cellpadding=0 cellspacing=0 border="0" width="100%" height="100%">
                      
					  <tr style="border-bottom:1px solid grey;">
                        <td>
                          <table>
                            <tr style="width:100%;float:right;" rowspan="10">
                            <td>
							<img src="https://my-epod.com/epodlite/assets/login/img/housinglogosmall.png" width="200" height="200"/>
							</td>
							</tr>
                          </table>
                        </td>
						
						<td></td>
						
						<td align="right">
                          <table style="border-left:0;border-right:0;" align="right" width="100%">
                            <tr style="width:100%;">
								<td align="right">
									<span style="font-size:25px;"><b>SUBSCRIPTION RECEIPT</b></span>
								</td>
							</tr>
                            <tr style="width:100%;">
                            <td align="right"><b>Follo Pte. Ltd.,</b></td>
							</tr>
							<tr style="width:100%;">
                            <td align="right">Block A, Floor A-28-09,</td>
							</tr>
							<tr style="width:100%;">
                            <td align="right">Trefoil@Setia City,</td>
							</tr>
							<tr style="width:100%;">
                            <td align="right">Jalan SetiaDagang Ah U13/AH,</td>
							</tr>
							<tr style="width:100%;">
                            <td align="right">Seksyen U13, 40170 Setia Alam,</td>
							</tr>
							<tr style="width:100%;">
                            <td align="right">Selangor Darul Ehsan, Malaysia</td>
							</tr>
							<tr style="width:100%;">
                            <td align="right"></td>
							</tr>
							<tr style="width:100%;">
                            <td align="right">Admin</td>
							</tr>
							<tr style="width:100%;">
                            <td align="right">0333625017</td>
							</tr>
							<tr style="width:100%;">
                            <td align="right">track@my-epod.com</td>
							</tr>
							<tr style="width:100%;">
                            <td align="right">www.my-epod.com</td>
							</tr>
							<tr style="width:100%;">
                            <td align="right"></td>
							</tr>
                          </table>
                        </td>
                      </tr>
					  
					  <tr>
					  <td></td>
					  <td></td>
					  <td></td>
					  </tr>
					  
					  <tr>
					  <td style="height:40px"></td>
					  <td></td>
					  <td></td>
					  </tr>
					  
					   <tr><td colspan="3" style="height:70px;"></td></tr>
					  
					  <tr>
					  <td style="height:40px">
					  For,  <br><p>'.$usertab['contact_person'].' <br> '.$usertab['company_name'].' <br> '.$usertab['address'].' <br> '.$usertab['mobile'].'</p>
					  </td>
					  <td colspan="2" style="height:40px">
						<table border="0" width="100%" style="border-left:0;border-right:0;">
							<tr>
							  <td align="center"><b>Receipt No</b></td>
							  <td align="center">'.$row1["invoiceno"].'</td>
							</tr>
							
						</table>
					  
					  </td>
					  </tr>
					  
					  <tr>
					  <td style="height:30px"></td>
					  <td></td>
					  <td></td>
					  </tr>
					 
                     
                      <tr>
					  <td colspan="3" style="height:20px">
						<table border="1" width="100%" style="border-left:0;border-right:0;">
							<tr>
							  <td align="center"><b>PLAN (FROM - TO)</b></td>
							  <td align="center"><b>PLAN</b></td>
							  <td align="center"><b>PRICE</b></td>
							  <td align="center"><b>DISCOUNT</b></td>
							  <td align="center"><b>TOTAL AMOUNT</b></td>
							 </tr>
							 <tr>
							  <td align="center">'.date("d-m-Y",strtotime($row1["plan_start"])).' to '.date("d-m-Y",strtotime($row1["plan_end"])).'</td>
							  <td align="center">'.$row1["plan_name"].'</td>
							  <td align="center">'.number_format($row1["amount"], 2, '.', '').'</td>
							  <td align="center"><b></b></td>
							  <td align="center">'.number_format($row1["amount"], 2, '.', '').'</td>
							 </tr>
							 <tr>
							  <td></td>
							  <td></td>
							  <td></td>
							  <td>Total(MYR):</td>
							  <td align="center">'.number_format($row1["amount"], 2, '.', '').'</td>
							 </tr>
						</table>
					  
					  </td>
					  </tr>
					  
					  <tr>
					  <td style="height:40px"></td>
					  <td></td>
					  <td></td>
					  </tr>
					  
					  
					  
					  <tr>
					  <td colspan="3" align="right"><b>Issued By Signature:</b></td>
					  </tr>
					  
					  <tr>
					  
					  <td colspan="3" align="right" ><img src="https://my-epod.com/epodtest/sign.png" /></td>
					  </tr>
                     
					
                     
                     
                      
                       
                  </table>
                </DIV>
                  </body>
                </html>';
	
				
				
		$filename    = "Receipt.pdf";

        $pdf->set_option('isRemoteEnabled', true);
        $pdf->set_option('enable_html5_parser', TRUE);
        // Load HTML content
        $pdf->loadHtml($fname);
        // (Optional) Setup the paper size and orientation
        $pdf->setPaper('legal', 'portrait');
        // Render the HTML as PDF
        $pdf->render();
        
        $canvas = $pdf->getCanvas(); 
		
		
		
		// Instantiate font metrics class 
$fontMetrics = new FontMetrics($canvas, $options); 
 
// Get height and width of page 
$w = $canvas->get_width(); 
$h = $canvas->get_height(); 
 
// Get font family file 
$font = $fontMetrics->getFont('times'); 
 
// Specify watermark text 
$text = "PAID"; 
 
// Get height and width of text 
$txtHeight = $fontMetrics->getFontHeight($font, 75); 
$textWidth = $fontMetrics->getTextWidth($text, $font, 75); 
 
// Set text opacity 
$canvas->set_opacity(.1); 
 
// Specify horizontal and vertical position 
$x = (($w-$textWidth)/2); 
$y = (($h-$txtHeight)/1.7); 
 
// Writes text at the specified x and y coordinates 
$canvas->text($x, $y, $text, $font, 75); 
		
		
        //$file = $pdf->output();
        //file_put_contents($filename, $file); 
        
        
      
		
		
		
        
       

       // $pdf->set_option('isRemoteEnabled', true);
         $pdf->set_option('enable_html5_parser', TRUE);
        // Load HTML content
       // $pdf->loadHtml($fname);
        // (Optional) Setup the paper size and orientation
        $pdf->setPaper('legal', 'portrait');
        // Render the HTML as PDF
        //$pdf->render();
        $pdf->output();
		$pdf->stream("Invoice.pdf", array("Attachment" => false));

exit(0);
?>