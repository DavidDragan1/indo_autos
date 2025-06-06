	</div>
</div>
<!-- Body Content End -->


<footer class="main-footer">
    <div class="pull-right hidden-xs hidden">
        Loading Time <b>{elapsed_time}</b> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CI Version <b>' . CI_VERSION . '</b>' : '' ?>
    </div>

    <strong>Copyright &copy; CarQuest.</strong> All rights reserved.
</footer>


  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->




<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->



<!-- Select2 -->
<script src="assets/lib/plugins/select2/select2.min.js"></script>


<script src="assets/admin/attrvalidate.jquery.js" type="text/javascript"></script>

<!-- Sparkline -->
<script src="assets/lib/plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="assets/lib/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="assets/lib/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>

<!-- jQuery Knob Chart -->
<script src="assets/lib/plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="assets/lib/plugins/daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->





<!-- DataTables -->
<script src="assets/lib/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="assets/lib/plugins/datatables/dataTables.bootstrap.min.js"></script>



<script src="assets/lib/plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="assets/lib/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>

<!-- Slimscroll -->
<script src="assets/lib/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="assets/lib/plugins/fastclick/fastclick.js"></script>

<!-- AdminLTE App -->
<script src="assets/admin/dist/js/app.min.js"></script>


<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="assets/admin/dist/js/pages/dashboard.js"></script> -->

<!-- AdminLTE for demo purposes -->
<script src="assets/admin/dist/js/demo.js"></script>

<script src="assets/admin/custom_scripts.js" type="text/javascript"></script>

<script src="assets/admin/dist/js/custom.js"></script>

<script>


    jQuery(document).ready(function() {
        jQuery('.js_datepicker').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true
        });

        jQuery.widget.bridge('uibutton', jQuery.ui.button);



    });


    setInterval(function(){
      auto_logout();
    }, 1200000);
    function auto_logout(){
        var user_id = '<?php echo getLoginUserData('user_id'); ?>';
        jQuery.ajax({
                type: "POST",
                url: "auth/current_status_check",
                dataType: 'json',
                data: { user_id: user_id }
            });
       //
    }
</script>

</body>
</html>
