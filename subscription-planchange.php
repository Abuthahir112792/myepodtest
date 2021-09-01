<?php 
include("header.php");


?>
<style>
  a.disabled {
    pointer-events: none;
    cursor: default;
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
              table,
              td {
                white-space: normal !important;
              }

               .table.dataTable {
                border-collapse: collapse !important;border: 1px solid rgba(0, 0, 0, 0.125);
              }
            </style>

            <div class="tab-pane fade show  active " id="approvals" role="tabpanel" aria-labelledby="business-tab">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title" style="margin-bottom: 8px;">Plan Change</h4>
                  <div class="row">
                    <div class="col-12">
					
				
					
                      <div style="min-height:500px;">
                          
                        <table id="order-listing" class="table" border="1">
                          <thead>
                             
						   <tr>
                              <th style="text-align: center;font-weight: bold;color: #4b4b4C;">S.No</th>
                              <th style="text-align: center;font-weight: bold;color: #4b4b4C;">Company Name</th>
                              <th style="text-align: center;font-weight: bold;color: #4b4b4C;">Contact Person</th>
                              <th style="text-align: center;font-weight: bold;color: #4b4b4C;">Register Type</th>
                              <th style="text-align: center;font-weight: bold;color: #4b4b4C;">Register No</th>
                              <th style="text-align: center;font-weight: bold;color: #4b4b4C;">Address</th>
                              <th style="text-align: center !important;font-weight: bold;color: #4b4b4C;">Username</th>
                              <th style="text-align: center!important;font-weight: bold;color: #4b4b4C;">Email</th>
                              <th style="text-align: center !important;font-weight: bold;color: #4b4b4C;">Contact</th>
                              <th style="text-align: center;font-weight: bold;color: #4b4b4C;">Plan Name</th>
                              <th style="text-align: center;font-weight: bold;color: #4b4b4C;">Status</th>
                              <!--<th style="text-align: center;font-weight: bold;color: #4b4b4C;">Actions</th>-->
                            </tr>
                          </thead>
                          <tbody>
								
								<?php
									$i=1;
								$sql 	= "SELECT * FROM users WHERE  status = 'Pending'  ORDER BY userid";
								$result = mysqli_query($con,$sql); 
								
								while( $row = mysqli_fetch_array($result)){ 
								?>
								<tr>
								  <td><?php echo $i;?></td>
                                  <td style="text-transform: capitalize;color: #676767;text-align: center !important;"><?php echo $row['company_name']; ?></td>
                                  <td style="text-transform: capitalize;color: #676767;text-align: center !important;"><?php echo $row['contact_person']; ?></td>
                                  <td style="text-transform: capitalize;color: #676767;text-align: center !important;"><?php echo $row['identification_type']; ?></td>
                                  <td style="text-transform: capitalize;color: #676767;text-align: center !important;"><?php echo $row['identification_no']; ?></td>
                                  <td style="text-transform: capitalize;color: #676767;text-align: center !important;"><?php echo $row['address']; ?></td>
                                  <td style="text-transform: capitalize;color: #676767;text-align: center !important;"><?php echo $row['username']; ?></td>
                                  <td style="color: #676767;text-align: center !important;"><?php echo $row['email']; ?></td>
                                  <td style="text-transform: lowercase;color: #676767;text-align: center !important;"><?php echo $row['mobile']; ?></td>
                                 

                                  <td><select class="form-control" style="height: 28px;padding: 4px;" onchange="fetch_select(this.value,<?php echo $row['userid'];?>);">
                                      
                                        <option value="1" <?php if($row['plan_id']=="1"){echo "selected";} ?>>Free</option>

                                      
                                        <option value="2" <?php if($row['plan_id']=="2"){echo "selected";} ?>>Silver</option>

                                      
                                        <option value="3" <?php if($row['plan_id']=="3"){echo "selected";} ?>>Gold</option>

                                      
                                        <option value="4" <?php if($row['plan_id']=="4"){echo "selected";} ?>>Premium</option>

                                                                          </select></td>

                                  <td>
                                    <label class="badge badge-danger">Pending</label>
                                  </td>
								  <!--
                                  <td class="myBox">
                                    <center> 
									<input type="checkbox"  name="selid" id="<?php echo $row['userid']; ?>" value="<?php echo $row['userid']; ?>">
									</center>
                                  </td>
								  -->
                                </tr>
							<?php
							$i++;
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
			
		 </div>	 </div>	 </div>	 </div>		
			
			
            


     

 
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
	
 
     if ($("input[type='checkbox']:checked").length > 1){
        
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
               
              window.open("subscription-planchange.php?msg=approvals","_self");
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
		 
        "scrollX": false
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
  
  
  
    function changehyperlink(pid, sid) {
      $("#hyperl").attr("href", "http://localhost/epodtest/Login/activate_account?pid=" + pid + "&sid=" + sid + "")
    }

    function planchange() {

      var planvalue = $("#plans").val();
      $.ajax({
        type: 'POST',
        url: 'http://localhost/epodtest/Login/getplandata',
        dataType: 'json',
        data: {
          planvalue: planvalue
        },
        success: function(data) {
          $("#amount").val(data[0].amount);
        }
      });
    }

    function plans(id) {


      $.ajax({
        url: "http://localhost/epodtest/Login/getuserdetail",
        type: "POST",
        dataType: 'json',
        data: {
          userid: id
        },
        success: function(data) {
          var planstatus = data[0].free_trial_status;
          //alert(planstatus);
          $('#myModal').modal('show');



          $.ajax({
            url: "http://localhost/epodtest/Login/getplandetail",
            type: "POST",
            dataType: 'json',
            data: {},
            success: function(data) {
              $("#memberid").val(id);
              //var wrapper   = $("#plans");
              $('#plans').children().remove();
              setTimeout(function() {

                var x = 0;
                $.each(data, function(index, data) {
                  if (planstatus == 1 && data.plan_name == 'Free Trial (3 Days)') {} else {

                    $('#plans').append('<option value="' + data.id + '">' + data.plan_name + '</option>');
                    if (x == 0) {
                      $("#amount").val(data.amount);
                      x++;

                    }
                  }

                });


              }, 100);
            }
          });




        }
      });



    }
    activelist();

    function activelist() {


      $.ajax({
        url: "http://localhost/epodtest/Login/activelist",
        type: "POST",
        dataType: 'json',
        data: {

        },
        success: function(data) {
          var x = 1;
          $("#activelist").empty();
          $.each(data, function(index, data) {

            $("#activelist").append('<tr>' +
              '<td style="text-align:center !important;">' + x + '</td>' +
              '<td style="text-align:center !important;">' + data.company_name + '</td>' +
              '<td style="text-align:center !important;">' + data.contact_person + '</td>' +
              '<td style="text-align:center !important;">' + data.identification_type + '</td>' +
              '<td style="text-align:center !important;">' + data.identification_no + '</td>' +
              '<td style="text-align:center !important;">' + data.address + '</td>' +
              '<td style="text-align:center !important;">' + data.username + '</td>' +
              '<td style="text-align:center !important;">' + data.email + '</td>' +
              '<td style="text-align:center !important;">' + data.mobile + '</td>' +
              '<td style="text-align:center !important;">' + data.plan_name + '</td>' +
              '<td>' + data.plan_expire + '</td>' +
              '<td>' +
              '<label class="badge badge-success">Active</label>' +
              '</td>' +
              '<td>' +
              '<center> <a href=""> <i class="mdi mdi-pencil-box" style="font-size: 25px;"></i></a></center>' +
              '</td>' +
              '</tr>');
            x++;
          });


        }
      });



    }

    expirelist();

    function expirelist() {


      $.ajax({
        url: "http://localhost/epodtest/Login/expirelist",
        type: "POST",
        dataType: 'json',
        data: {

        },
        success: function(data) {
          var x = 1;
          $("#expirelist").empty();
          $.each(data, function(index, data) {

            $("#expirelist").append('<tr>' +
              '<td style="text-align:center !important;">' + x + '</td>' +
              '<td style="text-align:center !important;">' + data.company_name + '</td>' +
              '<td style="text-align:center !important;">' + data.contact_person + '</td>' +
              '<td style="text-align:center !important;">' + data.identification_type + '</td>' +
              '<td style="text-align:center !important;">' + data.identification_no + '</td>' +
              '<td style="text-align:center !important;">' + data.address + '</td>' +
              '<td style="text-align:center !important;">' + data.username + '</td>' +
              '<td style="text-align:center !important;">' + data.email + '</td>' +
              '<td style="text-align:center !important;">' + data.mobile + '</td>' +

              '<td style="text-align:center !important;">' + data.plan_name + '</td>' +
              '<td style="text-align:center !important;">' + data.plan_expire + '</td>' +
              '<td>' +
              '<label class="badge badge-warning">Expired</label>' +
              '</td>' +
              '<td>' +
              '<center> <a href="#"> <i class="mdi mdi-pencil-box" style="font-size: 25px;"></i></a></center>' +
              '</td>' +
              '</tr>');
            x++;
          });


        }
      });



    }

    function setdocumentvalue(val) {

      var path = "http://localhost/epodtest/uploads/documents/" + val;

      $("#documentpopup").attr("src", path);
      if (val != '') {
        $('#documentmodal').modal('show');
      } else {
        alert('Document not found!');
      }
    }


    function shipmenthide() {

      var name = $("#shipmenttoggle").val();
      if (name == 'show') {
        $("#shipmenttoggle").val('hide');
        $("#shiptoggleshowname").text('Show');
        $("#shiptoggleshowicon").removeClass("mdi mdi-minus-circle-outline - mdi icons");
        $("#shiptoggleshowicon").addClass('mdi mdi-plus-circle-outline - mdi icons');
        $("#shipdetails").hide();
      } else {
        $("#shipmenttoggle").val('show');
        $("#shiptoggleshowname").text('Hide');
        $("#shiptoggleshowicon").removeClass('mdi mdi-plus-circle-outline - mdi icons');
        $("#shiptoggleshowicon").addClass("mdi mdi-minus-circle-outline - mdi icons");
        $("#shipdetails").show();
      }
    }

    function travelhide() {

      var name = $("#historytoggle").val();
      if (name == 'show') {
        $("#historytoggle").val('hide');
        $("#toggleshowname").text('Show');
        $("#toggleshowicon").removeClass("mdi mdi-minus-circle-outline - mdi icons");
        $("#toggleshowicon").addClass('mdi mdi-plus-circle-outline - mdi icons');
        $("#completehistory").hide();
      } else {
        $("#historytoggle").val('show');
        $("#toggleshowname").text('Hide');
        $("#toggleshowicon").removeClass('mdi mdi-plus-circle-outline - mdi icons');
        $("#toggleshowicon").addClass("mdi mdi-minus-circle-outline - mdi icons");
        $("#completehistory").show();
      }
    }

    function setpodvalue(val) {

      var path = "http://localhost/epodtest/uploads/pod/" + val;

      $("#podpopup").attr("src", path);
      if (val != '') {
        $('#podmodal').modal('show');
      } else {
        alert('POD  not found!');
      }
    }


    var wage = document.getElementById("trackvalue");
    wage.addEventListener("keydown", function(e) {
      if (e.code === "Enter") { //checks whether the pressed key is "Enter"
        searchhistory();
      }
    });




    function searchhistory() {
      var trackingno = $("#trackvalue").val();









      $("#historytoggle").val('show');
      $("#toggleshowname").text('Hide');
      $("#toggleshowicon").removeClass('mdi mdi-plus-circle-outline - mdi icons');
      $("#toggleshowicon").addClass("mdi mdi-minus-circle-outline - mdi icons");
      $("#completehistory").show();


      $("#shipmenttoggle").val('show');
      $("#shiptoggleshowname").text('Hide');
      $("#shiptoggleshowicon").removeClass('mdi mdi-plus-circle-outline - mdi icons');
      $("#shiptoggleshowicon").addClass("mdi mdi-minus-circle-outline - mdi icons");
      $("#shipdetails").show();










      $.ajax({
        url: "http://localhost/epodtest/Login/trackhistorymain",
        type: "POST",
        dataType: 'json',
        data: {
          trackingno: trackingno
        },
        success: function(data) {
          if (data.length != 0) {



            $("#modetypeimage").empty();

            if (data[0].mode_type == 'Road') {
              $("#modetypeimage").append('<img src="http://localhost/epodtest/assets/images/jobicon/trucking.png" style="position: relative;top: 4px;left:0px;width: 100px;height: 50px;">');
            } else if (data[0].mode_type == 'Air') {
              $("#modetypeimage").append('<img src="http://localhost/epodtest/assets/images/jobicon/air.png" style="position: relative;top: 0px;left:0px;width: 100px;height: 50px;">');
            } else if (data[0].mode_type == 'Hand Carry') {
              $("#modetypeimage").append('<img src="http://localhost/epodtest/assets/images/jobicon/handcarry.png" style="position: relative;top: 0px;left:0px;width: 100px;height: 50px;">');
            } else if (data[0].mode_type == 'Sea') {
              $("#modetypeimage").append('<img src="http://localhost/epodtest/assets/images/jobicon/sea.png" style="position: relative;top: 0px;left:0px;width: 100px;height: 50px;">');
            } else if (data[0].mode_type == 'Courier') {
              $("#modetypeimage").append('<img src="http://localhost/epodtest/assets/images/jobicon/courier.png" style="position: relative;top: 0px;left:0px;width: 100px;height: 50px;">');
            } else {
              $("#modetypeimage").append('<img src="http://localhost/epodtest/assets/images/jobicon/hotshot.png" style="position: relative;top: 0px;left:0px;width: 100px;height: 50px;">');
            }

            $("#trackstatusimage").empty();
            if (data[0].track_status == 'BOOKED') {
              $("#trackstatusimage").append('<div class="" style="float: left;width: 100%;margin-top: 5px;" id="trackimage' + data[0].job_id_primary + '">' +
                '<img src="http://localhost/epodtest/assets/track_icons/first_green.png" style="height:25px;width:40px;">' +
                '<img src="http://localhost/epodtest/assets/track_icons/middle_grey.png" style="height:25px;width:40px;">' +
                '<img src="http://localhost/epodtest/assets/track_icons/middle_grey.png" style="height:25px;width:40px;">' +
                '<img src="http://localhost/epodtest/assets/track_icons/last_grey.png" style="height:25px;width:40px;">' +
                '</div>');
            } else if (data[0].track_status == 'COLLECTING') {
              $("#trackstatusimage").append('<div class="" style="float: left;width: 100%;margin-top: 5px;" id="trackimage' + data[0].job_id_primary + '">' +
                '<img src="http://localhost/epodtest/assets/track_icons/first_green.png" style="height:25px;width:40px;">' +
                '<img src="http://localhost/epodtest/assets/track_icons/middle_green.png" style="height:25px;width:40px;">' +
                '<img src="http://localhost/epodtest/assets/track_icons/middle_grey.png" style="height:25px;width:40px;">' +
                '<img src="http://localhost/epodtest/assets/track_icons/last_grey.png" style="height:25px;width:40px;">' +
                '</div>');
            } else if (data[0].track_status == 'IN TRANSIT') {

              $("#trackstatusimage").append('<div class="" style="float: left;width: 100%;margin-top: 5px;" id="trackimage' + data[0].job_id_primary + '">' +
                '<img src="http://localhost/epodtest/assets/track_icons/first_green.png" style="height:25px;width:40px;">' +
                '<img src="http://localhost/epodtest/assets/track_icons/middle_green.png" style="height:25px;width:40px;">' +
                '<img src="http://localhost/epodtest/assets/track_icons/middle_green.png" style="height:25px;width:40px;">' +
                '<img src="http://localhost/epodtest/assets/track_icons/last_grey.png" style="height:25px;width:40px;">' +
                '</div>');
            } else if (data[0].track_status == 'DELIVERED') {
              $("#trackstatusimage").append('<div class="" style="float: left;width: 100%;margin-top: 5px;" id="trackimage' + data[0].job_id_primary + '">' +
                '<img src="http://localhost/epodtest/assets/track_icons/first_green.png" style="height:25px;width:40px;">' +
                '<img src="http://localhost/epodtest/assets/track_icons/middle_green.png" style="height:25px;width:40px;">' +
                '<img src="http://localhost/epodtest/assets/track_icons/middle_green.png" style="height:25px;width:40px;">' +
                '<img src="http://localhost/epodtest/assets/track_icons/last_complete.png" style="height:25px;width:40px;">' +
                '</div>');
            }

            var proof = '<td style="border:none!important;width:26%;"></td>';
            if (data[0].pod_image != '') {

              proof = '<td style="border:none!important;width:26%;">' +
                '<button onclick="setpodvalue(\'' + data[0].pod_image + '\')" type="button" class="btn btn-outline-success btn-icon-text" >' +
                '<i class="mdi mdi-file-check btn-icon-prepend"></i> Obtain Proof Of Delivery </button>' +
                '</td>';
            }

            var document = '<td style="border:none!important;width:26%;"></td>';
            if (data[0].documents != '') {
              document = '<td style="border:none!important;width:26%;">' +
                '<button onclick="setdocumentvalue(\'' + data[0].documents + '\')" style="" type="button" class="btn btn-outline-danger btn-icon-text" style="min-width:170px" >' +
                '<i class="mdi mdi-download"></i>' +
                'Documents</button>' +
                '</td>';
            }

            var refno = '<td style="border:none!important;width:26%;"></td>';
            if (data[0].client_reference_no != '') {
              refno = '<td style="border:none!important;width:26%;"><button type="button" class="btn btn-outline-danger btn-icon-text" data-toggle="modal" data-target="#docket"  style="min-width:173px">' +
                '<i class="mdi mdi-file-check btn-icon-prepend"></i>' +
                data[0].client_reference_no +
                '</button></td>';
            }




            $("#buttonsec").empty();
            $("#buttonsec").append('<table class="table" style="width:100%;border:none!important;">' +
              '<tr style="border:none!important;">' +
              '<td style="border:none!important;width:26%;">' +
              '<button type="button" class="btn btn-outline-info btn-icon-text" data-toggle="modal" data-target="#docket" onclick="getjobdetails(' + data[0].job_id_primary + ');">' +
              '<i class="mdi mdi-file-check btn-icon-prepend"></i>' +
              data[0].job_number +
              '</button>' +
              '</td>' +
              refno +

              proof +


              document +

              '</tr>' +
              '</table>');











            $("#trackingno").text(data[0].docket_number);
            $("#trackingno1").text(data[0].docket_number);
            $("#trackweight").text(data[0].weight + " Kg");
            $("#trackpackage").text(data[0].noof_package);
            $("#shipmenttype").text(data[0].transport_method_type);
            $("#special").text(data[0].special_cargo);
            $("#additionalservice").text(data[0].additional_service);
            $("#deliveryterms").text(data[0].term_of_delivery);
            $("#cargodesc").text(data[0].cargo_desc);
            $("#addinfo").text(data[0].additional_info);


            var ddate = data[0].job_etd_date.split("-");
            var etddate = ddate[2] + '-' + ddate[1] + '-' + ddate[0]
            var adate = data[0].job_eta_date.split("-");
            var etadate = adate[2] + '-' + adate[1] + '-' + adate[0]

            $("#tetddate").text(etddate);
            $("#tetadate").text(etadate);
            $("#tshipperaddress").text(data[0].shipper_locationaddress);
            $("#tshippername").text(data[0].shipper_name);
            $("#tconaddress").text(data[0].consignee_locationaddress);
            $("#tconname").text(data[0].consignee_name);
            $("#jobtrackstatus").text(data[0].track_status);
            $(".trackdetails").css("display", "block");
            $("#trackgifimage").css("display", "none");
            $("#nildata").css("display", "none");
          } else {
            $("#nildata").css("display", "block");
            $(".trackdetails").css("display", "none");
            $("#trackgifimage").css("display", "none");
          }
        }
      });

      $.ajax({
        url: "http://localhost/epodtest/Login/trackhistory",
        type: "POST",
        dataType: 'json',
        data: {
          trackingno: trackingno
        },
        success: function(data) {
          if (data.length != 0) {
            $("#latestactivity").text(data[0].activity);
            $("#latestlocation").text(data[0].location);
            var x = '';
            $("#completehistory").empty();
            $("#completehistory").append('<table class="table" style="border:none!important;width:100%;white-space:normal;text-align:left;margin-bottom:5%;" id="completehistory1"> </table>');
            var y = 0;
            var hide = '';
            $.each(data, function(index, data) {


              var date = data.date
              var gsDayNames = [
                'Sunday',
                'Monday',
                'Tuesday',
                'Wednesday',
                'Thursday',
                'Friday',
                'Saturday'
              ];

              var d = new Date(date);
              var dayName = gsDayNames[d.getDay()];

              var month = d.toLocaleString('default', {
                month: 'long'
              });
              let year = d.toLocaleString('default', {
                year: 'numeric'
              });
              let dayn = d.toLocaleString('default', {
                day: 'numeric'
              });
              var fulldate = dayName + ' ' + dayn + ' ' + month + ' ' + year;
              if (x != date) {
                var ddates = '<tr style="border:none!important;"><td style="border:none!important;color:#03A10A;" colspan="3"><h5>' + fulldate + '</h5></td></tr><tr style="color:#FC5A5A;"><th>Time</th><th>Activity</th><th>Location</th></tr>';
              } else {
                var ddates = '';
              }

              function tConvert(time) {
                // Check correct time format and split into components
                time = time.toString().match(/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];

                if (time.length > 1) { // If time format correct
                  time = time.slice(1); // Remove full string match value
                  time[5] = +time[0] < 12 ? 'AM' : 'PM'; // Set AM/PM
                  time[0] = +time[0] % 12 || 12; // Adjust hours
                }
                return time.join(''); // return adjusted time or original string
              }

              var ss = tConvert(data.time);
              //3:57:00PM

              var d1 = ss.split(":");
              var stime = d1[2];

              var res = stime.slice(2, 5);

              var finaltime = d1[0] + ":" + d1[1] + " " + res;


              $("#completehistory1").append(ddates +
                '<tr style="text-align:left;color:#676767;" class="' + hide + '">' +
                '<td style="text-align:left;color:#676767;">' + finaltime + '</td>' +
                '<td style="text-align:left;color:#676767;">' + data.activity + '</td>' +
                '<td style="text-align:left!important;color:#676767;">' + data.location + '</td>' +
                '</tr>');
              x = data.date;
              y++;
              if (y == 3) {
                hide = 'hide';


              }
              $(".hide").css("display", "none");
            });
            if (y > 3) {
              $("#completehistory1").append('<tr><td colspan="3" style="text-align:center;"><center><input type="button" class="btn btn-primary" onclick="togglehistory(this.value);" id="btndisplay" value="Expand History"></center></td></tr>');
            }

          } else {
            $("#completehistory").empty();
            $("#completehistory").append('<p style="text-align:center;">No data Available</p>');
            // $("#nildata").css("display", "block");
            // $(".trackdetails").css("display", "none");
            // $("#trackgifimage").css("display", "none");
          }
        }
      });

    }

    function togglehistory(val) {

      ///$("#ptext").toggle("slow");
      if (val == "Collapse History") {
        $("#btndisplay").val("Expand History");
        $(".hide").hide();
      } else {
        $("#btndisplay").val("Collapse History");
        $(".hide").show();
      }

    }
  </script>
  <!-- plugins:js -->

<?php include("footer.php");?>