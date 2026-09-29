<?php echo view('parsial/navbar'); ?>
<?php echo view('parsial/sidebar'); ?>
<div class="main-content">
    <?php $session = session(); ?>
    <div class="page-content">
        <div class="container-fluid">

         
         <div class="header-body">
          <div class="row align-items-center py-2"> 
            <div class="col-lg-12 col-5">
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-2">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  <li class="breadcrumb-item"><a href="<?= base_url() ?>DataPpoj"><i class="fa fa-home "></i></a></li>
                  <li class="breadcrumb-item"><a href="<?= base_url() ?>Approval" style="font-weight: bold; color: black; font-size: 14px;">Approval for Edit</a></li>
                 
                </ol>
              </nav>
            </div>
           
          </div>
          <div>
              <!--End Header Judul-->

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                    
                          
                            <div class="card-body table-responsive">
                        <h4 class="card-title mb-4">Data Approval</h4>
                        <div class="">
                            <table id="datatable2" class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Type</th>
                                        <th>No PPOJ</th>
                                        <th>Nama Ruangan</th>
                                        <th>Nama Analis</th>
                                        <th>Action</th>
                                   

                                    </tr>
                                </thead>


                                <tbody>

                                    <?php foreach ($List_Approval as $no => $row) :  ?>
                                        <tr>
                                            <td><?= $no + 1 ?></td>
                                            <td> <?= $row['type'] ?></td>
                                            <td> <?= $row['no_ppoj'] ?></td>
                                            <td> <?= $row['nama_ruangan'] ?></td>
                                            <td> <?= $row['analis'] ?></td>
                                            <td>
                                                <div class="btn-group btn-group-sm" style="float: none;">
                                                  
                                                  <button type="button" class="tabledit-edit-button btn btn-sm btn-info" style="float: none; margin: 5px;" data-animation="slideInUp" style="float:right;" data-toggle="modal" data-target="#Approve<?=$row['id'] ?>">
                                                            <span class="ti-check"></span>
                                                  </button>
                                            </td>
                                            
                                        </tr>
                                         <!-- Modal Approve -->
                                        <div class="modal fade" id="Approve<?=$row['id'] ?>" tabindex="-1" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <form method="POST" action="<?= base_url() ?>ApprovalMikro/Update">
                                                    <div class="modal-content">
                                                        <div class="modal-header">

                                                            <h5 class="modal-title mt-0">Approval </h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                           
                                                            <input type="hidden" class="form-control" name="type" value="<?= $row['type']  ?>">
                                                            <input type="hidden" class="form-control" name="id" value="<?=$row['id'] ?>">

                                                            <div id="inputContainer">
                                                   
                                                            <p>Approve ?</p>
                                                            
                                                            </div></br>
                                                          
                                                        </div>
                                                       
                                             
                                                        <div class="modal-footer">
                                                             <button type="button" class="btn btn-light " data-dismiss="modal">Close</button>
                                                            
                                                            <input type="submit" class="btn btn-primary" id="saveButton" value="Approve">
                                                            
                                                        </div>
                                                     
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <?php
                                        $session = session();
                                        $toast = $session->getFlashdata('Toast');
                                        ?>
                                        <script>
                                            <?php if ($toast) { ?>
                                                var textToast = "<?php echo $toast; ?>";
                                                window.onload = (event) => {
                                                    // Simulasikan penyimpanan data atau aksi yang sesuai di sini

                                                    {
                                                        Swal.fire({
                                                            title: "Success !",
                                                            text: textToast, //"You clicked the button!",
                                                            icon: "success",
                                                            //showCancelButton: !0,
                                                            confirmButtonColor: "#5664d2",
                                                            cancelButtonColor: "#ff3d60"
                                                        });
                                                    }
                                                }


                                            <?php } ?>
                                        </script>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                            <!-- end tableresponsive -->
                        </div>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container-fluid -->
    </div>
    <!-- End Page-content -->
</div>
<!-- end main content-->
</div>
<!-- END layout-wrapper -->
<?php echo view('parsial/footer'); ?>