   <footer class="footer">
          <div class="footer-inner-wraper">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
              <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2018 <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap Dash</a>. All rights reserved.</span>
              <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="mdi mdi-heart text-danger"></i></span>
            </div>
          </div>
        </footer>
</div>
<script>
$(window).on('load', function(){
  $.ajax({
                url: "<?php echo $base_url; ?>Login/setallopenstatus",
                dataType: "JSON",
                method: "POST",
                data: {
                  
                },
                success: function(data) {
                   
                }
              });
});
</script>
 <script src="<?php echo $base_url; ?>assets/vendors/js/vendor.bundle.base.js"></script>

 <script src="<?php echo $base_url; ?>assets/vendors/datatables.net/jquery.dataTables.js"></script>
 <script src="<?php echo $base_url; ?>assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="<?php echo $base_url; ?>assets/vendors/chart.js/Chart.min.js"></script>
  <script src="<?php echo $base_url; ?>assets/vendors/jquery-circle-progress/js/circle-progress.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="<?php echo $base_url; ?>assets/js/off-canvas.js"></script>
  <script src="<?php echo $base_url; ?>assets/js/hoverable-collapse.js"></script>
  <script src="<?php echo $base_url; ?>assets/js/misc.js"></script>
  <script src="<?php echo $base_url; ?>assets/js/settings.js"></script>
  <script src="<?php echo $base_url; ?>assets/js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page -->
  <script src="<?php echo $base_url; ?>assets/js/dashboard.js"></script>
  <!-- End custom js for this page -->
  <script src="<?php echo $base_url; ?>assets/js/data-table.js"></script>

  <script src="<?php echo $base_url; ?>assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
  <script src="<?php echo $base_url; ?>assets/js/formpickers.js"></script>

 <script src="<?php echo $base_url; ?>assets/js/paginate.js"></script>

  <script src="<?php echo $base_url; ?>assets/vendors/select2/select2.min.js"></script>
  <script src="<?php echo $base_url; ?>assets/vendors/typeahead.js/typeahead.bundle.min.js"></script>
  
  <script src="<?php echo $base_url; ?>assets/js/file-upload.js"></script>
  <script src="<?php echo $base_url; ?>assets/js/typeahead.js"></script>
  <script src="<?php echo $base_url; ?>assets/js/select2.js"></script>


</body>

<!-- Mirrored from www.bootstrapdash.com/demo/connect-plus/jquery/template/demo_3/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 23 Jun 2021 10:39:30 GMT -->

</html>