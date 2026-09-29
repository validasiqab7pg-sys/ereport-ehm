<?php echo view('parsial/navbar'); ?>
<?php echo view('parsial/sidebar'); ?>
<div class="main-content">
    <?php $session = session(); ?>
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <!--<div class="row">-->
            <!--    <div class="col-12">-->
            <!--        <div class="page-title-box d-flex align-items-center justify-content-between">-->
            <!--            <h4 class="mb-0">Rh</h4>-->

            <!--            <div class="page-title-right">-->
            <!--                <ol class="breadcrumb m-0">-->
                                <!-- <li class="breadcrumb-item"><a href="javascript: void(0);">D</a></li> -->
            <!--                    <li class="breadcrumb-item active">Data Rh</li>-->
            <!--                </ol>-->
                            <!-- end ol -->
            <!--            </div>-->
            <!--        </div>-->
            <!--    </div>-->
                <!-- end col -->
            <!--</div>-->
            
            <!--Header Judul-->
         <div class="header-body">
          <div class="row align-items-center py-2"> 
            <div class="col-lg-12 col-5">
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-2">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                  <li class="breadcrumb-item"><a href="<?= base_url() ?>DataPpoj"><i class="fa fa-home "></i></a></li>
                  <li class="breadcrumb-item"><a href="<?= base_url() ?>Rh" style="font-weight: bold; color: black; font-size: 14px;">Data Rh</a></li>
                  <!--<li class="breadcrumb-item"><a href="#">Detail Data Rh</a></li>-->
                  <!--<li class="breadcrumb-item"><a href="#" >Add Data Rh</a></li>-->
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
                            <!-- Tombol untuk membuka modal -->
                            <!-- <button type="button" class="btn btn-primary mt-3 btn-animation" data-animation="slideInUp" style="float:right;" data-toggle="modal" data-target="#exampleModalLong-1">Add Data</button>
                        -->

                            <!-- Modal Langkah 1 -->

                            <div class="modal fade" id="exampleModalLong-1" tabindex="-1" role="dialog">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                            <form  method="POST" action="<?= base_url() ?>Rh/Insert">
                                <div class="modal-content">
                                    <div class="modal-header">

                                    <h5 class="modal-title mt-0">Input Data Rh (%)</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                            <div class="modal-body">

                                                <div class="mb-3">
                                                    <label for="validationCustom03" class="form-label">Nomor PPOJ</label><!--dropdown hasil dari data PPOJ tapi dibedakan berdasarkan status-->
                                                    <!--<select class="form-control select2" id="validationCustom03" name="ppoj"  onchange="fetchPPOJData(this.value)">
                                                        <option selected disabled value="">Choose...</option>-->
                                                        <select class="form-control" id="validationCustom03" name="ppoj"  onchange="fetchPPOJData(this.value)">
                                                        <option selected disabled value="">Choose...</option>
                                                        <?php foreach ($List_PPOJ as $x) { ?>
                                                            <option value="<?= $x['no_ppoj'] ?>"><?= $x['no_ppoj'] ?></option>
                                                        <?php } ?>

                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="validationCustom03" class="form-label">Nama Ruangan</label>
                                                    <select class="form-control" id="ruangan_id2" name="ruangan">
                                                        <option selected disabled value="">Choose...</option>

                                                    </select>
                                                </div>

                                                <label>Rh</label>
                                                <div id="inputContainer">
                                                    <div class="input-group mb-3">

                                                        <div class="input-group-prepend">

                                                            <span class="input-group-text" for="rmin_1">Rh Min</span>
                                                        </div>
                                                        <input type="text" class="form-control rmin" id="rmin_1" name="rmin[]" placeholder="Rh Min" >

                                                        <div class="input-group-prepend">

                                                            <span class="input-group-text" for="rmax_1">Rh Max</span>
                                                        </div>
                                                        <input type="text" class="form-control rmax" id="rmax_1" name="rmax[]" placeholder="Rh Max" >

                                                    </div>


                                                </div></br>
                                                <button type="button" class="btn btn-success btn-sm" onclick="tambahInput()"><i class="mdi mdi-plus icon-large"></i></button>
                                                <button type="button" class="btn btn-danger btn-sm" onclick="kurangiInput()"><i class="mdi mdi-minus icon-large"></i></button>
           

                                                </br>
                                                </br>


                                                <div class="mb-3">

                                                    <label for="validationCustom04" class="form-label">Nama Analis</label>
                                                    <input type="text" class="form-control" name="analis" placeholder="Nama Analis" value="<?= $session->get('username') ?>" disabled>

                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Close</button>
                                                <input type="submit" class="btn btn-primary waves-effect waves-light" id="saveButton" value="Save">
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
                                    // Simulasikan penyimpanan data atau aksi yang sesuai di sini

                                    // Sembunyikan modal
                                   /* $('.bs-example-modal-center').modal('hide');

                                    // Tampilkan notifikasi keberhasilan
                                    Toastify({
                                        text: "Data berhasil disimpan",
                                        duration: 3000, // Durasi notifikasi dalam milidetik (opsional)
                                        gravity: "center", // Posisi notifikasi (top, center, bottom)
                                        position: 'center', // Posisi notifikasi di dalam gravity (left, center, right)
                                        backgroundColor: "green", // Warna latar belakang notifikasi
                                        stopOnFocus: true, // Hentikan durasi notifikasi ketika fokus ke elemen input
                                        callback: function() {
                                            // Callback yang dapat dijalankan setelah notifikasi hilang
                                            console.log('Notifikasi hilang');

                                            // Arahkan kembali ke halaman "rh.php"
                                            redirect(Rh)
                                        }
                                    }).showToast();
                                };*/
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
                                    
                                     newInputContainer.querySelector('.form-control').id = 'rmin_' + inputCounter;
                                    // newInputContainer.querySelector('.form-control').name = 'rmin[]'; // Ensure name remains as an array
                                     newInputContainer.querySelector('.rmin').value = ''; // Clear the input value
                                    // newInputContainer.querySelector('.form-control').value = '';
                                    newInputContainer.querySelector('.form-control').id = 'rmax_' + inputCounter;
                                    // newInputContainer.querySelector('.form-control').name = 'rmax[]'; // Ensure name remains as an array
                                     newInputContainer.querySelector('.rmax').value = ''; // Clear the input value

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







                            <!-- end dropdown -->
                            <h4 class="card-title mb-4">Data Rh</h4>
                            <div class="card-body table-responsive">
                      
                        <div class="">
                            <table id="datatable2" class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Jenis Pemeriksaan</th>
                                        <th>AHU</th><!--Dropdown dari tabel Master Data-->
                                        <th>Jumlah Ruangan</th><!--Dropdown dari tabel Master Data-->
                                        
                                        <th>Site</th>
                                       
                                        <th>Status</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>


                                <tbody>

                                    <?php foreach ($List_AHU as $no => $row) :  ?>
                                        <tr>
                                            <td><?= $no + 1 ?></td>
                                            <td> <?= $row['tanggaldilakukan'] ?></td>
                                            <td> <?= $row['jenispemeriksaan'] ?></td>
                                            <td> AHU <?= $row['ahu'] ?></td>
                                            
                                           
                                            <td> <?= $row['C_Ruangan'] ?></td>
                                            
                                           
                                            <td> <?= $row['site'] ?></td>
                                           
                                           <td style="width: 124px">
                                                <?php if ($row['statusRh'] == 0 || $row['statusRh'] == null) { ?>
                                                    <div class="badge bg-secondary">On Progress</div>
                                                <?php }
                                                if ($row['statusRh'] == 1) { ?>
                                                    <div class="badge bg-success">Selesai</div>
                                                <?php } ?>

                                        </td>
                                            <td>
                                                <div class="btn-group btn-group-sm" style="float: none;">
                                                  
                                                <a href="<?= base_url() ?>Rh/ViewDetail/<?= $row['id'] ?>" class="tabledit-delete-button btn btn-sm btn-primary" style="float: none; margin: 5px;">
                                                        <span class="ti-eye"></span>
                                                    </button>
                                                   
                                                </a>
                                                


                                            </td>
                                            <!-- <td style="width: 134px">
                                                    <div class="btn btn-soft-primary btn-sm">View detail<i class="mdi mdi-arrow-right ms-1"></i></div>
                                                </td> -->
                                        </tr>
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