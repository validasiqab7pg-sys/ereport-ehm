<?php echo view('parsial/navbar'); ?>
<?php echo view('parsial/sidebar'); ?>
<!-- Begin page -->
<?php $session = session(); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<div class="page-content-wrapper ">

    <div class="container-fluid">

        <!--<div class="row">-->
        <!--    <div class="col-sm-12">-->
        <!--        <div class="page-title-box">-->
        <!--            <div class="btn-group float-right">-->
        <!--                <ol class="breadcrumb hide-phone p-0 m-0">-->

        <!--                    <li class="breadcrumb-item active">Detail Data Suhu</li>-->
        <!--                </ol>-->
        <!--            </div>-->
        <!--            <h4 class="page-title">Detail Data Suhu</h4>-->
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
                  <li class="breadcrumb-item"><a href="<?= base_url() ?>Suhu">Data Suhu</a></li>
                  <li class="breadcrumb-item"><a href="<?= base_url() ?>Suhu/ViewDetail/<?= $Detail_Ruangan['id_ahu'] ?>">Detail Data Suhu</a></li>
                  <li class="breadcrumb-item"><a href="#" style="font-weight: bold; color: black; font-size: 14px;" >Add Data Suhu</a></li>
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
                            
                             <dt class="col-sm-4">Titik Suhu</dt>
                            <dd class="col-sm-8">
                                <?= $titik_suhu ?>
                            </dd>
                            
                               <dt class="col-sm-4">Suhu Min</dt>
                            <dd class="col-sm-8">
                                <?= $Syarat->suhu_min ?>
                            </dd>
                            
                             <dt class="col-sm-4">Suhu Max</dt>
                            <dd class="col-sm-8">
                                <?= $Syarat->suhu_max ?>
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
                            <form method="POST" action="<?= base_url() ?>Suhu/Insert">
                                <div class="modal-content">
                                    <div class="modal-header">

                                        <h5 class="modal-title mt-0">Input Data Suhu (°C)</h5>
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


                                        <label>Suhu</label>
                                        <div id="inputContainer">
                                            <div class="input-group mb-3">

                                                <div class="input-group-prepend">

                                                    <span class="input-group-text" for="smin_1">Suhu Min</span>
                                                </div>
                                                <input type="text" class="form-control smin" id="smin_1" name="smin[]" placeholder="Suhu Min" required>

                                                <div class="input-group-prepend">

                                                    <span class="input-group-text" for="smax_1">Suhu Max</span>
                                                </div>
                                                <input type="text" class="form-control smax" id="smax_1" name="smax[]" placeholder="Suhu Max" required>

                                            </div>


                                        </div>
                                        <!-- <button type="button" class="btn btn-success btn-sm" onclick="tambahInput()"><i class="mdi mdi-plus icon-large"></i></button>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="kurangiInput()"><i class="mdi mdi-minus icon-large"></i></button>
 -->


                                    

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
                    <script src="jquery.js"></script>
                    <script src="bootstrap.js"></script>
                    <script>
               const namaAhu = "<?= $Detail_Ruangan['ahu'] ?>";
const namaRuangan = "<?= $Detail_Ruangan['nama_ruangan'] ?>";
let syarat = null;

$('#exampleModalLong-1').on('shown.bs.modal', function () {
    const namaAhu = "<?= $Detail_Ruangan['ahu'] ?>";
    const namaRuangan = "<?= $Detail_Ruangan['nama_ruangan'] ?>";

    console.log('Modal terbuka, mengirim data:', { ahu: namaAhu, nama_ruangan: namaRuangan });

    $.ajax({
        url: "<?= base_url('suhu/getSyaratSuhu') ?>",
        type: "GET",
        data: { ahu: namaAhu, nama_ruangan: namaRuangan },
        dataType: "json",
        success: function (response) {
            console.log('Response AJAX:', response);
            if (response.error) {
                alert(response.error);
                syarat = null;
            } else {
                syarat = response;
                console.log('Syarat suhu diterima:', syarat);

                // Pasang event input di sini supaya pasti terpasang setelah modal dan input siap
                $('#smin_1, #smax_1').off('input').on('input', function () {
                    const smin = parseFloat($('#smin_1').val());
                    const smax = parseFloat($('#smax_1').val());
                    const ketField = $('#keterangan');

                    console.log('Input suhu:', smin, smax, 'Syarat:', syarat);

                    if (!syarat || isNaN(smin) || isNaN(smax)) {
                        ketField.val('');
                        return;
                    }

                    if (smin < syarat.suhu_min || smax > syarat.suhu_max) {
                        ketField.val('TMS'); // Tidak Memenuhi Syarat
                    } else {
                        ketField.val('MS'); // Memenuhi Syarat
                    }
                });
            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX error:', status, error);
            alert("Gagal mengambil syarat suhu.");
            syarat = null;
        }
    });
});

$('#exampleModalLong-1').on('hidden.bs.modal', function () {
    $('#smin_1').val('');
    $('#smax_1').val('');
    $('#keterangan').val('');
    syarat = null;
    console.log('Modal ditutup, reset form dan syarat');
});



                        </script>

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

                            newInputContainer.querySelector('.form-control').id = 'smin_' + inputCounter;
                            // newInputContainer.querySelector('.form-control').name = 'smin[]'; // Ensure name remains as an array
                            newInputContainer.querySelector('.smin').value = ''; // Clear the input value
                            // newInputContainer.querySelector('.form-control').value = '';
                            newInputContainer.querySelector('.form-control').id = 'smax_' + inputCounter;
                            // newInputContainer.querySelector('.form-control').name = 'smax[]'; // Ensure name remains as an array
                            newInputContainer.querySelector('.smax').value = ''; // Clear the input value

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
                           <?php if (($titik_suhu > 0 || $titik_suhu != 'NA') && $titik_suhu > $total_suhu) { ?>
                       
                        <button type="button" class="btn btn-primary mt-3 btn-animation" data-animation="slideInUp" style="float:right;" data-toggle="modal" data-target="#exampleModalLong-1">Add Data</button>
                        <?php } ?>

                        <h4 class="card-title mb-4">Add Data Suhu</h4>
                        <div class="">
                            <table id="datatable2" class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Suhu Min</th>
                                        <th>Suhu Max</th><!--Dropdown dari tabel Master Data-->


                                        <!--No PPOJ dibentuk dari gabungan AHU, Site, Nama Ruangan, dan Tanggal-->
                                        <th>Analis</th>
                                        <th>Keterangan</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>


                                <tbody>

                                    <?php foreach ($List_SUHU as $no => $row) :  ?>
                                        <tr>
                                            <td><?= $no + 1 ?></td>

                                            <td> <?= $row['suhu_min'] ?></td>
                                            <td> <?= $row['suhu_max'] ?></td>


                                            <td> <?= $row['analis'] ?></td>
                                            <td> <?= $row['keterangan'] ?></td>

                                            <td>
                                                <div class="btn-group btn-group-sm" style="float: none;">

                                                    <?php if ($row['editable'] == 1 && $row['approve_edit'] == 1 && $session->get('username') == $row['analis'] ||( $session->get('jabatan') == 'Manager QA' || $session->get('jabatan') == 'Spv QA' )){  ?>
                                                    <div class="btn-group btn-group-sm" style="float: none;">
                                                        
                                                        <button type="button" class="tabledit-edit-button btn btn-sm btn-info" style="float: none; margin: 5px;" data-animation="slideInUp" style="float:right;" data-toggle="modal" data-target="#EditSuhu<?=$row['id'] ?>">
                                                            <span class="ti-pencil"></span>
                                                        </button>
                                                       
                                                    <?php }  ?>
                                                     <a href="<?= base_url() ?>Suhu/Delete/<?= $row['id'] ?>" onclick="return confirm('Yakin Ingin menghapus nya ?')" class="tabledit-delete-button btn btn-sm btn-danger" style="float: none; margin: 5px;">
                                                            <span class="ti-trash"></span>
                                                        </a>
                                                     <?php if ( ($row['editable'] == 0 || $row['approve_edit'] == 0 ||  $session->get('username') != $row['analis']) && (  $session->get('jabatan') != 'Manager QA' && $session->get('jabatan') != 'Spv QA' ) ){  ?>
                                                    <div class="btn-group btn-group-sm" style="float: none;">
                                                        
                                                        <button type="button" class="tabledit-edit-button btn btn-sm btn-info" style="float: none; margin: 5px;" data-animation="slideInUp" style="float:right;" data-toggle="modal" data-target="#ViewSuhu<?=$row['id'] ?>">
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
                                        <div class="modal fade" id="EditSuhu<?=$row['id'] ?>" tabindex="-1" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <form method="POST" action="<?= base_url() ?>Suhu/Update">
                                                    <div class="modal-content">
                                                        <div class="modal-header">

                                                            <h5 class="modal-title mt-0">Update Data Suhu (°C) </h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input type="hidden" class="form-control" name="ppoj" value="<?= $Detail_Ruangan['no_ppoj'] ?>">
                                                            <input type="hidden" class="form-control" name="ruangan" value="<?= $Detail_Ruangan['nama_ruangan'] ?>">
                                                            <input type="hidden" class="form-control" name="id_ppoj" value="<?= $Detail_Ruangan['id'] ?>">
                                                            <input type="hidden" class="form-control" name="kelas" value="<?= $Detail_Ruangan['kelas'] ?>">
                                                            <input type="hidden" class="form-control" name="id" value="<?=$row['id'] ?>">

                                                            <div class="mb-3">

                                                                <label for="validationCustom04" class="form-label">Nama Analis</label>
                                                                <input type="text" class="form-control" name="analis" placeholder="Nama Analis" value="<?= $session->get('username') ?>" disabled>

                                                            </div>


                                                            <label>Suhu</label>
                                                            <div id="inputContainer">
                                                                <div class="input-group mb-3">

                                                                    <div class="input-group-prepend">

                                                                        <span class="input-group-text" for="smin_1">Suhu Min</span>
                                                                    </div>
                                                                    <input type="text" class="form-control smin" id="smin_1" name="smin" placeholder="Suhu Min" value="<?=$row['suhu_min'] ?>">

                                                                    <div class="input-group-prepend">

                                                                        <span class="input-group-text" for="smax_1">Suhu Max</span>
                                                                    </div>
                                                                    <input type="text" class="form-control smax" id="smax_1" name="smax" placeholder="Suhu Max" value="<?=$row['suhu_max'] ?>">

                                                                </div>


                                                            </div></br>
                                                          
                                                        </div>
                                                       
                                             
                                                        <div class="modal-footer">
                                                             <button type="button" class="btn btn-light " data-dismiss="modal">Close</button>
                                                            <?php if ( ($row['editable'] == 1 && $row['approve_edit'] == 1 && $session->get('username') == $row['analis']) || ( $session->get('jabatan') == 'Manager QA' || $session->get('jabatan') == 'Spv QA') ){  ?>
                                                          
                                                            <input type="submit" class="btn btn-primary" id="saveButton" value="Change">
                                                            <?php } ?>
                                                        </div>
                                                     
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    <!-- Modal View -->
                                        <div class="modal fade" id="ViewSuhu<?=$row['id'] ?>" tabindex="-1" role="dialog">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <form method="POST" action="<?= base_url() ?>Suhu/RequestEdit">
                                                    <div class="modal-content">
                                                        <div class="modal-header">

                                                            <h5 class="modal-title mt-0">Update Data Suhu (°C) </h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input type="hidden" class="form-control" name="ppoj" value="<?= $Detail_Ruangan['no_ppoj'] ?>">
                                                            <input type="hidden" class="form-control" name="ruangan" value="<?= $Detail_Ruangan['nama_ruangan'] ?>">
                                                            <input type="hidden" class="form-control" name="id_ppoj" value="<?= $Detail_Ruangan['id'] ?>">
                                                            <input type="hidden" class="form-control" name="kelas" value="<?= $Detail_Ruangan['kelas'] ?>">
                                                            <input type="hidden" class="form-control" name="id" value="<?=$row['id'] ?>">

                                                            <div class="mb-3">

                                                              
                                                                <input type="hidden" name="analis" placeholder="Nama Analis" value="<?= $session->get('username') ?>" >

                                                            </div>


                                                            <label>Suhu</label>
                                                            <div id="inputContainer">
                                                                <div class="input-group mb-3">

                                                                    <div class="input-group-prepend">

                                                                    <span class="input-group-text" for="smin_1">Suhu Min</span>
                                                                    </div>
                                                                    <input type="text" class="form-control smin" id="smin_1" name="smin" placeholder="Suhu Min" value="<?=$row['suhu_min'] ?>" disabled>
                                                                    <div class="input-group-prepend">

                                                                        <span class="input-group-text" for="smax_1">Suhu Max</span>
                                                                    </div>
                                                                    <input type="text" class="form-control smax" id="smax_1" name="smax" placeholder="Suhu Max" value="<?=$row['suhu_max'] ?>" disabled>

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
                                                        
                                                            
                                                             <?php if ( $session->get('username') == $row['analis'] && $row['editable'] == 0 ){  ?>
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