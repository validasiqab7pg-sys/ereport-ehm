<?php echo view('parsial/navbar'); ?>
<?php echo view('parsial/sidebar'); ?>
<div class="main-content">
    <?php $session = session(); ?>
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Kualifikasi</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Kualifikasi</a></li>
                                <li class="breadcrumb-item active">Data Differential Preassure</li>
                            </ol>
                            <!-- end ol -->
                        </div>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- Tombol untuk membuka modal -->
                            <button type="button" class="btn btn-primary mt-3 btn-animation" data-animation="slideInUp" style="float:right;" data-toggle="modal" data-target="#exampleModalLong-1">Add Data</button>
                            <!-- Modal Langkah 1 -->
                            <div class="col-sm-6 col-md-4 col-xl-3">

                                <!-- Modal Insert -->

                                    <div class="modal fade" id="exampleModalLong-1" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <form method="POST" action="<?= base_url() ?>Dp/Insert">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h5 class="modal-title mt-0">Input Data Differential Preassure</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="validationCustom03" class="form-label">Nomor PPOJ</label>
                                                        <select class="form-control" id="validationCustom03" required>
                                                            <option selected disabled value="">Choose...</option>
                                                            <?php foreach ($List_PPOJ as $x) { ?>
                                                                <option value="<?= $x['no_ppoj'] ?>"><?= $x['no_ppoj'] ?></option>
                                                            <?php } ?>

                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="validationCustom03" class="form-label">Nama Ruangan</label>
                                                        <select class="form-control" id="validationCustom03" required>

                                                            <option selected disabled value="">Choose...</option>
                                                            <option>...</option>
                                                        </select>
                                                    </div>
                                                    <!-- Form input awal -->
                                                    <label>Perbedaan Tekanan Ruangan (DP)</label>
                                                    <div id="inputContainer">
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                                <label class="input-group-text" for="validationCustom04_1">Ruangan (DP)</label>
                                                            </div>
                                                            <!-- Menggunakan elemen select -->
                                                            <select class="form-control" id="validationCustom04_1" name="dp[]" required onchange="fetchRuanganDP(this.value)">
                                                                <!-- Opsi-opsi ruangan -->
                                                                <option selected disabled value="">Choose...</option>
                                                                <?php foreach ($List_PPOJ as $x) { ?>
                                                                    <option value="<?= $x['no_ppoj'] ?>"><?= $x['no_ppoj'] ?></option>
                                                                <?php } ?>
                                                                <!-- Tambahkan opsi-opsi lain sesuai kebutuhan -->
                                                            </select>
                                                            <div class="input-group-prepend">
                                                                <label class="input-group-text" for="nilaiDp_1">Nilai DP</label>
                                                            </div>
                                                            <input type="text" class="form-control" id="nilaiDp_1" name="nilaidp[]" placeholder="Nilai DP" required>
                                                        </div>
                                                    </div>
                                                    <button type="button" class="btn btn-success btn-sm" onclick="tambahInput()"><i class="mdi mdi-plus icon-large"></i></button>
                                                     <button type="button" class="btn btn-danger btn-sm" onclick="kurangiInput()"><i class="mdi mdi-minus icon-large"></i></button>

                                                    </br>
                                                    </br>
                                                    <div class="mb-3">
                                                        <label for="validationCustom04" class="form-label">Nama Analis</label>
                                                        <input type="text" class="form-control" id="validationCustom04" placeholder="Nama Analis" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                            <button type="button" class="btn btn-light " data-dismiss="modal">Close</button>
                                                            <input type="submit" class="btn btn-primary" id="saveButton" value="Save">

                                                        </div>
                                            </div>
                                        </div>
                                </div>
                                
                                <?php
                                $session = session();
                                $toast = $session->getFlashdata('Toast');

                                ?>
                                <script>
                                    var textToast = "<?php echo $toast; ?>";

                                    <?php if ($toast) { ?>
                                        window.onload = (event) => {
                                            /*document.getElementById('saveButton').addEventListener('click', function() {
                                                // Simulasikan penyimpanan data atau aksi yang sesuai di sini
                                                // Sembunyikan modal
                                                $('.bs-example-modal-center').modal('hide');
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
                                                        // Arahkan kembali ke halaman "suhu.php"
                                                        redirect(Dp)
                                                    }
                                                }).showToast();
                                            });*/
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
                                        newInputContainer.querySelector('.form-control').id = 'validationCustom04_' + inputCounter;
                                        newInputContainer.querySelector('.form-control').name = 'dp[]'; // Ensure name remains as an array
                                        newInputContainer.querySelector('.form-control').value = ''; // Clear the input value
                                        newInputContainer.querySelector('.form-control').id = 'nilaiDp_' + inputCounter;
                                        newInputContainer.querySelector('.form-control').name = 'nilaidp[]'; // Ensure name remains as an array
                                        newInputContainer.querySelector('.form-control').value = ''; // Clear the input value
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
                            </div>
                            <!-- end dropdown -->
                            <h4 class="card-title mb-4">Data Differential Preassure</h4>
                            <div class="table-responsive">
                                <table class="table table-centered border table-nowrap mb-0" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No</th>
                                            <th>No PPOJ</th><!--Dari Tabel PPOJ-->
                                            <th>Nama Ruangan</th><!--Dari Tabel PPOJ-->
                                            <th>Perbedaan Terhadap Ruangan</th>
                                            <th>Nilai DP</th>
                                            <th>Nama Analis</th>
                                            <th>Keterangan</th><!--Hasil dari kesimpulan jika nilai dp tidak lulus syarat hasilnya bisa MS/TMS-->
                                            <th colspan="2">Action</th>
                                        </tr>
                                        <!-- end tr -->
                                    </thead>
                                    <!-- end thead -->
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>AHU 4.01/Cikarang/R.Filling</td>
                                            <td>R.Filling</td>
                                            <td>RAO Kelas E</td>
                                            <td>10</td>
                                            <td>Mia</td>
                                            <td>MS</td>
                                            <td style="width: 134px">
                                                <ul class="d-flex list-inline mb-0">
                                                    <li class="list-inline-item">
                                                        <a href="#" class="btn btn-light p-0 avatar-xs d-block rounded-circle">
                                                            <span class="avatar-title bg-transparent text-body">
                                                                <i class="mdi mdi-trash-can-outline"></i>
                                                            </span>
                                                        </a>
                                                    </li>
                                                    <!-- end li -->
                                                    <li class="list-inline-item">
                                                        <a href="#" class="btn btn-light p-0 avatar-xs d-block rounded-circle">
                                                            <span class="avatar-title bg-transparent text-body">
                                                                <i class="ri-edit-line"></i>
                                                            </span>
                                                        </a>
                                                    </li>
                                                    <!-- end li -->
                                                </ul>
                                            </td>
                                            <td>
                                        </tr>
                                        <!-- end /tr -->
                                    </tbody>
                                    <!-- end tbody -->
                                </table>
                                <!-- end table -->
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