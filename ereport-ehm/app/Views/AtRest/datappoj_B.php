<?php echo view('parsial/navbar'); ?>
<?php echo view('parsial/sidebar'); ?>
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0">Data Kualifikasi dan EHM</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Kualifikasi</a></li>
                                <li class="breadcrumb-item active">Data Kualifikasi dan EHM</li>
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
                            <!-- Small modal 
                                            <button type="button" class="btn btn-primary waves-effect waves-light" style="float:right;"
                                                data-bs-toggle="modal" data-bs-target="#staticBackdrop">Add Data</button>-->
                            <button type="button" class="btn btn-primary waves-effect waves-light" style="float:right;" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center">Add Data</button>
                            <!-- Modal 
                            <div class="mb-3">
                                <label class="form-label">Data PPOJ</label>
                                <!!-- end select ->
                            </div>-->
                            <form class="form-horizontal" method="POST" action="<?= base_url() ?>DataPpoj/Insert">
                                <div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title mt-0">Pilih AHU</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="validationCustom03" class="form-label">Nomor AHU</label>
                                                    <select class="form-select" id="validationCustom03" name="ahu" 
                                                    required onchange="fetchStateData(this.value)">
                                                        <option selected disabled value="">Choose...</option>
                                                        <?php foreach ($List_AHU as $x) { ?>
                                                            <option value="<?= $x['ahu'] ?>"><?= $x['ahu'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="validationCustom03" class="form-label">Jenis Kondisi</label>
                                                    <select class="form-select" id="validationCustom03" name="kondisi" required>
                                                        <option selected disabled value="">Choose...</option>
                                                        <option>At Rest</option>
                                                        <option>In Operation</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="validationCustom04" class="form-label">Site</label>
                                                    <input type="text" class="form-control" id="validationCustom04" name="site" placeholder="Site" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="validationCustom04" class="form-label">Nama Ruangan</label>
                                                    <select class="form-select" id="ruangan_id" name="ruangan" required>
                                                        <option selected disabled value="">Choose...</option>
                                                    </select>
                                                </div>
                                                <!--<div class="mb-3">
                                                    <label for="validationCustom04" class="form-label">Tanggal</label>
                                                    <input type="date" name="tanggal" class="form-control" id="validationCustom04" placeholder="Tanggal" required>
                                                </div>-->
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Close</button>
                                                    <input type="submit" class="btn btn-primary waves-effect waves-light" id="saveButton" value="Save">
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->
                                </div>
                            </form>
                            <script>
                                function fetchStateData(ahu) {
                                    console.log(ahu); // cek nama ahu yang di ambil
                                    $.ajax({
                                        url: "<?php echo base_url() ?>ambil_ahu", // setting ambil_ahu ada di routes
                                        method: "POST",
                                        data: {
                                            nama_ahu: ahu
                                        },
                                        success: function(result) {
                                            let data = JSON.parse(result);
                                            let output = "<option selected disabled value=''>Choose...</option>";
                                            for (let row in data) {
                                                output += `<option value="${data[row].nama_ruangan}">${data[row].nama_ruangan}</option>`;
                                            }
                                            document.querySelector("#ruangan_id").innerHTML = output;
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
                                var textToast = "<?php echo $toast; ?>";
                                <?php if ($toast) { ?>
                                    window.onload = (event) => {
                                        // Toastify({
                                        //     text: textToast, //"Data Berhasil disimpan",
                                        //     duration: 3000, // Durasi notifikasi dalam milidetik (opsional)
                                        //     gravity: "center", // Posisi notifikasi (top, center, bottom)
                                        //     position: 'center', // Posisi notifikasi di dalam gravity (left, center, right)
                                        //     backgroundColor: "green", // Warna latar belakang notifikasi
                                        //     stopOnFocus: true, // Hentikan durasi notifikasi ketika fokus ke elemen input
                                        //     callback: function() {
                                        //         // Callback yang dapat dijalankan setelah notifikasi hilang
                                        //         console.log('Notifikasi hilang');
                                        //         // Arahkan kembali ke halaman "suhu.php"
                                        //         redirect(DataPpoj)
                                        //     }
                                        // }).showToast();
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
                                // document.getElementById('saveButton').addEventListener('click', function() {
                                //     // Simulasikan penyimpanan data atau aksi yang sesuai di sini
                                //     // Sembunyikan modal
                                //     $('.bs-example-modal-center').modal('hide');
                                //     // Tampilkan notifikasi keberhasilan
                                //     Toastify({
                                //         text: "Data berhasil disimpan",
                                //         duration: 3000, // Durasi notifikasi dalam milidetik (opsional)
                                //         gravity: "center", // Posisi notifikasi (top, center, bottom)
                                //         position: 'center', // Posisi notifikasi di dalam gravity (left, center, right)
                                //         backgroundColor: "green", // Warna latar belakang notifikasi
                                //         stopOnFocus: true, // Hentikan durasi notifikasi ketika fokus ke elemen input
                                //         callback: function() {
                                //             // Callback yang dapat dijalankan setelah notifikasi hilang
                                //             console.log('Notifikasi hilang');
                                //             // Arahkan kembali ke halaman "suhu.php"
                                //             redirect(DataPpoj)
                                //         }
                                //     }).showToast();
                                // });
                            </script>
                            <!-- end dropdown -->
                            <h4 class="card-title mb-4">Monitoring Kualifikasi dan EHM</h4>
                            <div class="card-body table-responsive">
                                <!-- <table class="table table-centered border table-nowrap mb-0" 
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;"> -->
                                <table id="datatable2" class="table">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No</th>
                                            <th>AHU</th><!--Dropdown dari tabel Master Data-->
                                            <th>Jenis Kondisi</th>
                                            <th>Site</th>
                                            <th>Nama Ruangan</th><!--Dropdown dari tabel Master Data-->
                                            <th>Tanggal</th>
                                            <th>Kelas</th><!--Dropdown dari tabel Master Data-->
                                            <th>No Report</th><!--No PPOJ dibentuk dari gabungan AHU, Site, Nama Ruangan, dan Tanggal-->
                                            <th>Status</th>
                                            <th colspan="2">Action</th>

                                        </tr>
                                        <!-- end tr -->
                                    </thead>
                                    <!-- end thead -->
                                    <tbody>
                                        <?php foreach ($List_PPOJ as $no => $row) :  ?>
                                            <tr>
                                                <td><?= $no + 1 ?></td>
                                                <td> AHU <?= $row['ahu'] ?></td>
                                                <td> <?= $row['kondisi'] ?></td>
                                                <td> <?= $row['site'] ?></td>
                                                <td> <?= $row['nama_ruangan'] ?></td>
                                                <td> <?= $row['tanggaldilakukan'] ?></td>
                                                <td> <?= $row['kelas'] ?></td>
                                                <td> <?= $row['no_ppoj'] ?></td>
                                                <td style="width: 134px">
                                                    <?php if ($row['status'] == 'On Progress') { ?>
                                                        <div class="btn btn-soft-danger btn-sm"><?= $row['status'] ?></div>
                                                    <?php } ?>
                                                </td>
                                                <td>
                                                    <ul class="d-flex list-inline mb-0">
                                                        <li class="list-inline-item">
                                                            <a href="<?= base_url() ?>DataPpoj/Delete/<?= $row['id'] ?>" onclick="return confirm('Yakin Ingin menghapus nya ?')" class="btn btn-light p-0 avatar-xs d-block rounded-circle">
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
                                                <td style="width: 134px">
                                                    <div class="btn btn-soft-primary btn-sm">View detail<i class="mdi mdi-arrow-right ms-1"></i></div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
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