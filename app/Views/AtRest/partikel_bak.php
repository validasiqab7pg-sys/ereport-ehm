<?php echo view('parsial/navbar'); ?>
<?php echo view('parsial/sidebar'); ?>
<div class="main-content">

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
                                <li class="breadcrumb-item active">Data Partikel</li>
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
                            <button type="button" class="btn btn-primary waves-effect waves-light" style="float:right;" data-bs-toggle="modal" data-target=".bs-example-modal-center">Add Data</button>

                            <!-- Modal Langkah 1 -->
                            <div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title mt-0">Input Data Partikel</h5>
                                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="validationCustom03" class="form-label">Nomor PPOJ</label>
                                                <select class="form-select" id="validationCustom03" required>
                                                    <option selected disabled value="">Choose...</option>
                                                    <option>...</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="validationCustom03" class="form-label">Nama Ruangan</label>
                                                <select class="form-select" id="validationCustom03" required>
                                                    <option selected disabled value="">Choose...</option>
                                                    <option>...</option>
                                                </select>
                                            </div>
                                          <div class="mb-3">

                                                <label for="file">Pilih file:</label>
                                                </br>
                                                <input type="file" id="file" name="file" accept=".txt, .pdf, .docx" class> <!-- Menggunakan atribut accept untuk membatasi jenis file yang dapat diunggah-->
                                                <button type="button" class="btn btn-primary waves-effect" data-dismiss="modal">Unggah</button>
                                            </div>


                                 

                                            <div class="mb-3">

                                                <label for="validationCustom04" class="form-label">Nama Analis</label>
                                                <input type="text" class="form-control" id="validationCustom04" placeholder="Nama Analis" required>

                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary waves-effect waves-light" id="saveButton">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <script>
                                document.getElementById('saveButton').addEventListener('click', function() {
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
                                            redirect(Partikel)
                                        }
                                    }).showToast();
                                });
                            </script>







                            <!-- end dropdown -->
                            <h4 class="card-title mb-4">Data Jenis Partikel</h4>
                            <div class="table-responsive">
                                <table class="table table-centered border table-nowrap mb-0" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No</th>
                                            <th>No PPOJ</th><!--Dari Tabel PPOJ-->
                                            <th>Nama Ruangan</th><!--Dari Tabel PPOJ-->
                                            <th>File</th>
                                            <th>Jenis Pelaksanaan</th><!--Dari Tabel PPOJ-->
                                            <th>Nama Analis</th>
                                           
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
                                            <td>46</td>
                                            <td>55</td>
                                            <td>Mia</td>
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