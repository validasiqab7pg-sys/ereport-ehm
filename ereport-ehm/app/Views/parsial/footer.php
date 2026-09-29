
<footer class="footer">
                   
<script>document.write(new Date().getFullYear())</script> © Digitalization
                   
                   </footer>

            </div>
            <!-- End Right content here -->

        </div>
        <!-- END wrapper -->


        <!-- jQuery  -->
        <script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
        <script src="<?= base_url() ?>assets/js/popper.min.js"></script>
        <script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>
        <script src="<?= base_url() ?>assets/js/modernizr.min.js"></script>
        <script src="<?= base_url() ?>assets/js/detect.js"></script>
        <script src="<?= base_url() ?>assets/js/fastclick.js"></script>
        <script src="<?= base_url() ?>assets/js/jquery.blockUI.js"></script>
        <script src="<?= base_url() ?>assets/js/waves.js"></script>
        <script src="<?= base_url() ?>assets/js/jquery.nicescroll.js"></script>

          <!-- Dropzone js -->
          <script src="<?= base_url() ?>assets/plugins/dropzone/dist/dropzone.js"></script>
        <script src="<?= base_url() ?>assets/plugins/dropify/js/dropify.min.js"></script>

        <script src="<?= base_url() ?>assets/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
        <script src="<?= base_url() ?>assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
        
        <script src="<?= base_url() ?>assets/plugins/skycons/skycons.min.js"></script>
        <script src="<?= base_url() ?>assets/plugins/fullcalendar/vanillaCalendar.js"></script>
        
        <script src="<?= base_url() ?>assets/plugins/raphael/raphael-min.js"></script>
        <script src="<?= base_url() ?>assets/plugins/morris/morris.min.js"></script> 
         
        <script src="<?= base_url() ?>assets/pages/dashborad.js"></script>

        <script src="<?= base_url() ?>assets/pages/modal-animation.init.js"></script>
        <!-- App js -->
        <script src="<?= base_url() ?>assets/js/app.js"></script>


        <!-- Required datatable js -->
        <script src="<?= base_url() ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="<?= base_url() ?>assets/plugins/datatables/dataTables.bootstrap4.min.js"></script>
        <!-- Buttons examples -->
        <script src="<?= base_url() ?>assets/plugins/datatables/dataTables.buttons.min.js"></script>
        <script src="<?= base_url() ?>assets/plugins/datatables/buttons.bootstrap4.min.js"></script>
        <script src="<?= base_url() ?>assets/plugins/datatables/jszip.min.js"></script>
        <script src="<?= base_url() ?>assets/plugins/datatables/pdfmake.min.js"></script>
        <script src="<?= base_url() ?>assets/plugins/datatables/vfs_fonts.js"></script>
        <script src="<?= base_url() ?>assets/plugins/datatables/buttons.html5.min.js"></script>
        <script src="<?= base_url() ?>assets/plugins/datatables/buttons.print.min.js"></script>
        <script src="<?= base_url() ?>assets/plugins/datatables/buttons.colVis.min.js"></script>
        <!-- Responsive examples -->
        <script src="<?= base_url() ?>assets/plugins/datatables/dataTables.responsive.min.js"></script>
        <script src="<?= base_url() ?>assets/plugins/datatables/responsive.bootstrap4.min.js"></script>
 
        <!-- Datatable init js -->
        <script src="<?= base_url() ?>assets/pages/datatables.init.js"></script> 

        
        <!-- Plugins js -->
        <script src="<?= base_url() ?>assets/plugins/timepicker/moment.js"></script>
        <script src="<?= base_url() ?>assets/plugins/timepicker/tempusdominus-bootstrap-4.js"></script>
        <script src="<?= base_url() ?>assets/plugins/timepicker/bootstrap-material-datetimepicker.js"></script>
        <script src="<?= base_url() ?>assets/plugins/clockpicker/jquery-clockpicker.min.js"></script>
        <script src="<?= base_url() ?>assets/plugins/colorpicker/jquery-asColor.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>assets/plugins/colorpicker/jquery-asGradient.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>assets/plugins/colorpicker/jquery-asColorPicker.min.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>assets/plugins/select2/select2.min.js" type="text/javascript"></script>
 
        <script src="<?= base_url() ?>assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
        <script src="<?= base_url() ?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
        <script src="<?= base_url() ?>assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>assets/plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js" type="text/javascript"></script>
 
        <!-- Plugins Init js -->
        <script src="<?= base_url() ?>assets/pages/form-advanced.js"></script>
        <!-- <script src="https://code.jquery.com/jquery-3.7.1.slim.js" integrity="sha256-UgvvN8vBkgO0luPSUl2s8TIlOSYRoGFAX4jlCIm9Adc=" crossorigin="anonymous"></script> -->
        <!-- Sweet-Alert  -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.7/dist/sweetalert2.all.min.js"></script>
       
        <script src="<?= base_url() ?>assets/pages/upload.init.js"></script>
        <!-- <script src="<?= base_url() ?>assets/plugins/sweet-alert2/sweetalert2.min.js"></script>
        <script src="<?= base_url() ?>assets/pages/sweet-alert.init.js"></script>  -->
        <script>
            $(document).ready(function() {
                $('#datatable2').DataTable();  
            } );
        </script>
        
        <script>
    let inactivityTime = function() {
        let time;

        function resetTimer() {
            clearTimeout(time);
            time = setTimeout(showExpiredAlert, 600000); // 10 menit dalam milidetik
        }

        function showExpiredAlert() {
            Swal.fire({
                title: 'Session Expired',
                text: 'Your session has expired. You will be redirected to the login page.',
                icon: 'warning',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    logout();
                }
            });
        }

        function logout() {
            window.location.href = '<?= base_url('/Auth/Logout') ?>'; // URL logout Anda
        }

        window.onload = resetTimer;
        document.onmousemove = resetTimer;
        document.onkeypress = resetTimer;
        document.onscroll = resetTimer;
        document.onclick = resetTimer;
    };

    inactivityTime();
</script>


    </body>
</html>