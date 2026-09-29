<?php echo view('parsial/navbar'); ?>
<?php echo view('parsial/sidebar'); ?>
<!-- Begin page -->
<?php $session = session(); ?>
<div class="page-content-wrapper ">

    <div class="container-fluid">

        <!--<div class="row">-->
        <!--    <div class="col-sm-12">-->
        <!--        <div class="page-title-box">-->
        <!--            <div class="btn-group float-right">-->
        <!--                <ol class="breadcrumb hide-phone p-0 m-0">-->

        <!--                    <li class="breadcrumb-item active">Detail Data Cemaran Volumetrik</li>-->
        <!--                </ol>-->
        <!--            </div>-->
        <!--            <h4 class="page-title">Detail Data Cemaran Volumetrik</h4>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--    <div class="clearfix"></div>-->
        <!--</div>-->
        
         <!--Header Judul-->
         <div class="header-body">
          <div class="row align-items-center py-2"> 
            <div class="col-lg-12 col-5">
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-2">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  <li class="breadcrumb-item"><a href="<?= base_url() ?>DataPpoj"><i class="fa fa-home "></i></a></li>
                  <li class="breadcrumb-item"><a href="<?= base_url() ?>Mas">Data Cemaran Mikroba Volumetrik</a></li>
                  <li class="breadcrumb-item"><a href="<?= base_url() ?>Mas/ViewDetail/<?= $Detail_Ruangan['id_ahu'] ?>">Detail Data Cemaran Mikroba Volumetrik</a></li>
                  <li class="breadcrumb-item"><a href="#" style="font-weight: bold; color: black; font-size: 14px;">Add Data Cemaran Mikroba Volumetrik</a></li>
                </ol>
              </nav>
            </div>
           
          </div>
          <div>
              <!--End Header Judul-->
        <div class="row">

            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="mt-0 header-title">Description</h4>


                        <dl class="row mb-0">
                            <dt class="col-sm-4">AHU</dt>
                            <dd class="col-sm-8"><?= $Detail_Ruangan['ahu'] ?></dd>

                            <dt class="col-sm-4">Nama Ruangan</dt>
                            <dd class="col-sm-8"><?= $Detail_Ruangan['nama_ruangan'] ?></dd>


                            <dt class="col-sm-4">No Report</dt>
                            <dd class="col-sm-8"><?= $Detail_Ruangan['no_ppoj'] ?></dd>


                            <dt class="col-sm-4">Kelas</dt>
                            <dd class="col-sm-8">
                                <?= $Detail_Ruangan['kelas'] ?>
                            </dd>
                    
                            <dt class="col-sm-4">Titik Mikro</dt>
                            <dd class="col-sm-8">
                               <?= $titik_mikro ?>
                            </dd>
                            
                             <dt class="col-sm-4">Volumetrik TPC</dt>
                            <dd class="col-sm-8">
                                <?= $Syarat->Volumetrik_TPC ?>
                            </dd>
                            
                             <dt class="col-sm-4">Volumetrik KK</dt>
                            <dd class="col-sm-8">
                                <?= $Syarat->Volumetrik_KK ?>
                            </dd>
                        </dl>

                    </div>

                </div>

            </div> <!-- end col -->

        </div> <!-- end row -->

        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="card">

                    <!-- Modal Insert -->

                    <div class="modal fade" id="exampleModalLong-1" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <form method="POST" action="<?= base_url() ?>Mas/Insert">
                                <div class="modal-content">
                                    <div class="modal-header">

                                        <h5 class="modal-title mt-0">Input Data Cemaran Volumetrik</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" class="form-control" name="ppoj" value="<?= $Detail_Ruangan['no_ppoj'] ?>">
                                        <input type="hidden" class="form-control" name="ruangan" value="<?= $Detail_Ruangan['nama_ruangan'] ?>">
                                        <input type="hidden" class="form-control" name="id_ppoj" value="<?= $Detail_Ruangan['id'] ?>">
                                        <input type="hidden" class="form-control" name="kelas" value="<?= $Detail_Ruangan['kelas'] ?>">
                                          <input type="hidden" class="form-control" name="id_ahu" value="<?= $Detail_Ruangan['id_ahu'] ?>">
                                        <div class="mb-3">
                                            <label for="validationCustom04" class="form-label">No Report</label>
                                            <input type="text" class="form-control" name="ppoj" value="<?= $Detail_Ruangan['no_ppoj'] ?>" disabled>
                                        </div>

                                        <div class="mb-3">

                                            <label for="validationCustom04" class="form-label">Nama Analis</label>
                                            <input type="text" class="form-control" name="analis" placeholder="Nama Analis" value="<?= $session->get('username') ?>" disabled>

                                        </div>


                                        <label>Data Cemaran Volumetrik</label>
                                        <div id="inputContainer">
                                            <?php for ($i = 1; $i <= ($titik_mikro - $total_mikro); $i++) : ?>
                                                <div class="input-group mb-3">

                                                    <div class="input-group-prepend">

                                                        <span class="input-group-text" for="tpc_1">TPC</span>
                                                    </div>
                                                    <input type="text" class="form-control tpc" id="tpc_1" name="tpc[]" placeholder="TPC" required>

                                                    <div class="input-group-prepend">

                                                        <span class="input-group-text" for="kk_1">KK</span>
                                                    </div>
                                                    <input type="text" class="form-control kk" id="kk_1" name="kk[]" placeholder="KK">

                                                </div>
                                            <?php endfor; ?>

                                        </div>
                                       
                                        <button type="button" class="btn btn-success btn-sm" onclick="tambahInput()"><i class="mdi mdi-plus icon-large"></i></button>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="kurangiInput()"><i class="mdi mdi-minus icon-large"></i></button>


                                       

                                        <div class="mb-3">
                                            <label for="validationCustom04" class="form-label">Keterangan</label>
                                            <select class="form-control" id="keterangan" name="keterangan"  required>
                                                <option selected disabled value="">MS or TMS</option>
                                                <option>MS</option>
                                                <option>TMS</option>
                                            </select>
                                        </div>

                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light " data-dismiss="modal">Close</button>
                                        <input type="submit" class="btn btn-primary" id="saveButton" value="Save">

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <script>
                        function fetchPPOJData(ppoj) {
                            console.log(ppoj); // cek nama ahu yang di ambil
                            $.ajax({
                                url: "<?php echo base_url() ?>ambil_ruangan", // setting ambil_ruangan ada di routes
                                method: "POST",
                                data: {
                                    no_ppoj: ppoj
                                },
                                success: function(result) {
                                    let data = JSON.parse(result);

                                    let output = "<option selected disabled value=''>Choose...</option>";
                                    for (let row in data) {
                                        output += `<option value="${data[row].nama_ruangan}">${data[row].nama_ruangan}</option>`;

                                    }
                                    document.querySelector("#ruangan_id2").innerHTML = output;

                                    console.log('Berhasil sist');
                                },
                                error: function(jqXHR, exception) {

                                    console.log('Erorr sist');
                                }
                            });
                        }
                    </script>
                    <?php
                    $session = session();
                    $toast = $session->getFlashdata('Toast');

                    ?>

                    <script>
                        <?php if ($toast) { ?>
                            var textToast = "<?php echo $toast; ?>";
                            window.onload = (event) => {

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
                        var inputCounter = 1; // Counter for input fields

                        function tambahInput() {
                            var inputContainer = document.getElementById('inputContainer');

                            // Clone the input container
                            var newInputContainer = inputContainer.firstElementChild.cloneNode(true);

                            // Increment the counter to ensure unique IDs
                            inputCounter++;

                            // Update the IDs to ensure uniqueness

                            newInputContainer.querySelector('.form-control').id = 'tpc_' + inputCounter;
                            // newInputContainer.querySelector('.form-control').name = 'tpc[]'; // Ensure name remains as an array
                            newInputContainer.querySelector('.tpc').value = ''; // Clear the input value
                            // newInputContainer.querySelector('.form-control').value = '';
                            newInputContainer.querySelector('.form-control').id = 'kk_' + inputCounter;
                            // newInputContainer.querySelector('.form-control').name = 'kk[]'; // Ensure name remains as an array
                            newInputContainer.querySelector('.kk').value = ''; // Clear the input value

                            // Append the new input container to the document
                            inputContainer.appendChild(newInputContainer);

                            // Show the "Kurangi" button
                            document.querySelector('.btn-danger').style.display = 'inline-block';
                        }

                        function kurangiInput() {
                            var inputContainers = document.querySelectorAll('.input-group');

                            // Ensure that at least one input container remains
                            if (inputContainers.length > 1) {
                                // Remove the last input container
                                inputContainers[inputContainers.length - 1].remove();
                            }

                            // Hide the "Kurangi" button if only one input container is left
                            if (inputContainers.length === 1) {
                                document.querySelector('.btn-danger').style.display = 'none';
                            }
                        }

                        // Hide the "Kurangi" button initially if there is only one input
                        if (document.querySelectorAll('.input-group').length === 1) {
                            document.querySelector('.btn-danger').style.display = 'none';
                        }
                    </script>

                    <div class="card-body table-responsive">
                        <!-- Tombol untuk membuka modal -->
                        <?php if (($titik_mikro > 0 || $titik_mikro != 'NA') && $titik_mikro > $total_mikro) { ?>
                            <button type="button" class="btn btn-primary mt-3 btn-animation" data-animation="slideInUp" style="float:right;" data-toggle="modal" data-target="#exampleModalLong-1">Add Data</button>
                        <?php } ?>
                        <h4 class="card-title mb-4">Data Cemaran Volumetrik</h4>
                        <div class="">
                            <table id="datatable2" class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>TPC</th>
                                        <th>KK</th><!--Dropdown dari tabel Master Data-->
                                        <!--No PPOJ dibentuk dari gabungan AHU, Site, Nama Ruangan, dan Tanggal-->
                                        <th>Analis</th>
                                        <th>Keterangan</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>


                                <tbody>

                                    <?php foreach ($List_MAS as $no => $row) :  ?>
                                        <tr>
                                            <td><?= $no + 1 ?></td>

                                            <td> <?= $row['hasil_tpc'] ?></td>
                                            <td> <?= $row['hasil_kk'] ?></td>


                                            <td> <?= $row['analis'] ?></td>
                                            <td> <?= $row['keterangan'] ?></td>

                                            <td>
                                               <div class="btn-group btn-group-sm" style="float: none;">

                                                    <?php if ($row['editable'] == 1 && $row['approve_edit'] == 1 && $session->get('username') == $row['analis'] ||( $session->get('jabatan') == 'Manager QC' || $session->get('jabatan') == 'Spv QC' )){  ?>
                                                    <div class="btn-group btn-group-sm" style="float: none;">
                                                        
                                                        <button type="button" class="tabledit-edit-button btn btn-sm btn-info" style="float: none; margin: 5px;" data-animation="slideInUp" style="float:right;" data-toggle="modal" data-target="#EditMas<?=$row['id'] ?>">
                                                            <span class="ti-pencil"></span>
                                                        </button>
                                                        <a href="<?= base_url() ?>Mas/Delete/<?= $row['id'] ?>" onclick="return confirm('Yakin Ingin menghapus nya ?')" class="tabledit-delete-button btn btn-sm btn-danger" style="float: none; margin: 5px;">
                                                            <span class="ti-trash"></span>
                                                        </a>
                                                    <?php }  ?>
                                                    
                                                     <?php if ( ($row['editable'] == 0 || $row['approve_edit'] == 0 ||  $session->get('username') != $row['analis']) && (  $session->get('jabatan') != 'Manager QC' && $session->get('jabatan') != 'Spv QC' ) ){  ?>
                                                    <div class="btn-group btn-group-sm" style="float: none;">
                                                        
                                                        <button type="button" class="tabledit-edit-button btn btn-sm btn-info" style="float: none; margin: 5px;" data-animation="slideInUp" style="float:right;" data-toggle="modal" data-target="#ViewMas<?=$row['id'] ?>">
                                                            <span class="ti-eye"></span>
                                                        </button>
                                                       
                                                    <?php }  ?>
                                                    </div>

                                            </td>
                                            <!-- <td style="width: 134px">
                                                    <div class="btn btn-soft-primary btn-sm">View detail<i class="mdi mdi-arrow-right ms-1"></i></div>
                                                </td> -->
                                        </tr>
                                        <!-- Modal Update -->
                                        <div class="modal fade" id="EditMas<?= $row['id'] ?>" tabindex="-1" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <form method="POST" action="<?= base_url() ?>Mas/Update">
                                                    <div class="modal-content">
                                                        <div class="modal-header">

                                                            <h5 class="modal-title mt-0">Update Data Cemaran Volumetrik </h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input type="hidden" class="form-control" name="ppoj" value="<?= $Detail_Ruangan['no_ppoj'] ?>">
                                                            <input type="hidden" class="form-control" name="ruangan" value="<?= $Detail_Ruangan['nama_ruangan'] ?>">
                                                            <input type="hidden" class="form-control" name="id_ppoj" value="<?= $Detail_Ruangan['id'] ?>">
                                                            <input type="hidden" class="form-control" name="kelas" value="<?= $Detail_Ruangan['kelas'] ?>">
                                                            <input type="hidden" class="form-control" name="id" value="<?= $row['id'] ?>">
                                                            

                                                            <div class="mb-3">

                                                                <label for="validationCustom04" class="form-label">Nama Analis</label>
                                                                <input type="text" class="form-control" name="analis" placeholder="Nama Analis" value="<?= $session->get('username') ?>" disabled>

                                                            </div>


                                                            <label>Cemaran Volumetrik</label>
                                                            <div id="inputContainer">
                                                                <div class="input-group mb-3">

                                                                    <div class="input-group-prepend">

                                                                        <span class="input-group-text" for="tpc_1">TPC</span>
                                                                    </div>
                                                                    <input type="text" class="form-control tpc" id="tpc" name="tpc" placeholder="TPC" value="<?= $row['hasil_tpc'] ?>" required>

                                                                    <div class="input-group-prepend">

                                                                        <span class="input-group-text" for="kk_1">KK</span>
                                                                    </div>
                                                                    <input type="text" class="form-control kk" id="kk_1" name="kk" placeholder="KK" value="<?= $row['hasil_kk'] ?>" required>

                                                                </div>
                                                                <div class="mb-3">

                                                                    <label for="validationCustom04" class="form-label">Keterangan</label>
                                                                    <input type="text" class="form-control" name="keterangan" placeholder="Keterangan" value="<?= $row['keterangan'] ?>">

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-light " data-dismiss="modal">Close</button>
                                                            <input type="submit" class="btn btn-primary" id="saveButton" value="Change">
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                         <!-- Modal View -->
                                        <div class="modal fade" id="ViewMas<?= $row['id'] ?>" tabindex="-1" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <form method="POST" action="<?= base_url() ?>Mas/RequestEdit">
                                                    <div class="modal-content">
                                                        <div class="modal-header">

                                                            <h5 class="modal-title mt-0">Update Data Cemaran Volumetrik </h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input type="hidden" class="form-control" name="ppoj" value="<?= $Detail_Ruangan['no_ppoj'] ?>">
                                                            <input type="hidden" class="form-control" name="ruangan" value="<?= $Detail_Ruangan['nama_ruangan'] ?>">
                                                            <input type="hidden" class="form-control" name="id_ppoj" value="<?= $Detail_Ruangan['id'] ?>">
                                                            <input type="hidden" class="form-control" name="kelas" value="<?= $Detail_Ruangan['kelas'] ?>">
                                                            <input type="hidden" class="form-control" name="id" value="<?= $row['id'] ?>">
                                                            
                                                                <input type="hidden" class="form-control" name="analis" placeholder="Nama Analis" value="<?= $session->get('username') ?>" >



                                                            <label>Cemaran Volumetrik</label>
                                                            <div id="inputContainer">
                                                                <div class="input-group mb-3">

                                                                    <div class="input-group-prepend">

                                                                        <span class="input-group-text" for="tpc_1">TPC</span>
                                                                    </div>
                                                                    <input type="text" class="form-control tpc" id="tpc" name="tpc" placeholder="TPC" value="<?= $row['hasil_tpc'] ?>" readonly>

                                                                    <div class="input-group-prepend">

                                                                        <span class="input-group-text" for="kk_1">KK</span>
                                                                    </div>
                                                                    <input type="text" class="form-control kk" id="kk_1" name="kk" placeholder="KK" value="<?= $row['hasil_kk'] ?>" readonly>

                                                                </div>
                                                                <div class="mb-3">

                                                                    <label for="validationCustom04" class="form-label">Keterangan</label>
                                                                    <input type="text" class="form-control" name="keterangan" placeholder="Keterangan" value="<?= $row['keterangan'] ?>" readonly>

                                                                </div>
                                                            </div>
                                                        </div>
                                                         <?php if ($row['editable'] == 1 && $row['approve_edit'] == 0 && $session->get('username') == $row['analis'] ){  ?>
                                                        <div class="card-body">
                                                            <div class="alert alert-success" role="alert">
                                                                <strong>Your request has been successful, pending in approval.
                                                            </div>
                                                        </div>
                                                        <?php } ?>
                                                        <div class="modal-footer">
                                                             <button type="button" class="btn btn-light " data-dismiss="modal">Close</button>
                                                        
                                                            
                                                             <?php if ( $session->get('username') == $row['analis'] && $row['editable'] == 0){  ?>
                                                                <input type="submit" class="btn btn-primary"  value="Request Edit"  >
                                                            <?php } else { ?>
                                                                <input type="submit" class="btn btn-primary"  value="Request Edit" disabled >
                                                            <?php } ?>
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
                </div>
            </div>
        </div><!--end row-->




    </div><!-- container -->

</div> <!-- Page content Wrapper -->

</div> <!-- content -->
<?php echo view('parsial/footer'); ?>