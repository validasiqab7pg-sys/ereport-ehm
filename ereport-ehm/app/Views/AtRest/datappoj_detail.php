<?php echo view('parsial/navbar'); ?>
<?php echo view('parsial/sidebar'); ?>
<!-- Begin page -->
<div class="page-content-wrapper ">
    <?php $session = session(); ?>
    <div class="container-fluid">

        <!--<div class="row">-->
        <!--    <div class="col-sm-12">-->
        <!--        <div class="page-title-box">-->
        <!--            <div class="btn-group float-right">-->
        <!--                <ol class="breadcrumb hide-phone p-0 m-0">-->

        <!--                    <li class="breadcrumb-item active">Detail Data Kualifikasi dan EHM</li>-->
        <!--                </ol>-->
        <!--            </div>-->
        <!--            <h4 class="page-title">Detail Data Kualifikasi dan EHM</h4>-->
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
                            <li class="breadcrumb-item"><a href="<?= base_url() ?>DataPpoj">Data Kualifikasi dan EHM</a></li>
                            <li class="breadcrumb-item"><a href="#" style="font-weight: bold; color: black; font-size: 14px;">Detail Data Kualifikasi dan EHM</a></li>
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

                                <h4 class="mt-0 header-title">Description list alignment</h4>


                                <dl class="row mb-0">
                                    <dt class="col-sm-4">Tanggal</dt>
                                    <dd class="col-sm-8"><?= $Detail_AHU['tanggaldilakukan'] ?></dd>

                                    <dt class="col-sm-4">AHU</dt>
                                    <dd class="col-sm-8"><?= $Detail_AHU['ahu'] ?></dd>

                                    <dt class="col-sm-4">Jenis Pemeriksaan</dt>
                                    <dd class="col-sm-8"><?= $Detail_AHU['jenispemeriksaan'] ?></dd>


                                    <dt class="col-sm-4">Site</dt>
                                    <dd class="col-sm-8">
                                        <?= $Detail_AHU['site'] ?>

                                    </dd>
                                    <dt class="col-sm-4">Keterangan</dt>
                                    <dd class="col-sm-8"><?= $Detail_AHU['keterangan'] ?></dd>
                                </dl>
                                <!-- APPROVE QA ANALIS -->
                                <?php if ($session->get('jabatan') == 'QA Analis' && $Detail_AHU['approve_1'] == '' && $Cek_button_qa == 1) { ?>
                                    <button type="button" class="btn btn-primary mt-3 btn-animation" data-animation="slideInUp" style="float:right;" data-toggle="modal"
                                        data-target="#approveQA">Approve By QA Analis</button>
                                <?php } ?>

                                <?php if (
                                    ($session->get('jabatan') == 'QA Analis' && $Detail_AHU['approve_1'] == '' && $Cek_button_qa == 0) ||
                                    ($session->get('jabatan') == 'QA Analis' && $Detail_AHU['approve_1'] != '')
                                ) { ?>
                                    <input type="submit" class="btn btn-secondary" style="float:right;" value="Approve By QA Analis" disabled>
                                <?php } ?>

                                <!-- MODAL UNTUK APPROVE QA -->
                                <div class="modal fade" id="approveQA" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Information</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form method="POST" action="<?= base_url() ?>DataPpoj/Approve_1">
                                                <div class="modal-body">
                                                    <p>Yakin ingin merubah status Kualifikasi & EHM ?</p>
                                                    <input type="hidden" class="form-control" name="id_ahu" value="<?= $id_ahu ?>">
                                                    <div class="modal-footer">
                                                        <input type="submit" class="btn btn-primary" value="Save">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- APPROVE QC ANALIS -->
                                <?php if (
                                    $session->get('jabatan') == 'QC Analis' &&
                                    $Detail_AHU['approve_2'] == '' &&
                                    $Detail_AHU['approve_1'] != '' &&
                                    $Cek_button_qc == 1 &&
                                    $Detail_AHU['keterangan'] != 'Verifikasi' // skip jika verifikasi
                                ) { ?>
                                    <form class="form-horizontal" method="POST" action="<?= base_url() ?>DataPpoj/Approve_2">
                                        <input type='hidden' value='<?= $Detail_AHU['id'] ?>' name='id_ahu'>
                                        <input type="submit" class="btn btn-primary mt-3" style="float:right;" value='Approve By QC Analis'>
                                    </form>
                                <?php } ?>

                                <?php if (
                                    ($session->get('jabatan') == 'QC Analis' &&
                                        $Detail_AHU['approve_1'] != '' &&
                                        $Detail_AHU['approve_2'] == '' &&
                                        $Cek_button_qc == 0 &&
                                        $Detail_AHU['keterangan'] != 'Verifikasi') ||
                                    ($session->get('jabatan') == 'QC Analis' && $Detail_AHU['approve_2'] != '')
                                ) { ?>
                                    <input type="submit" class="btn btn-secondary mt-3" style="float:right;" value="Approve By QC Analis" disabled>
                                <?php } ?>

                                <!-- APPROVE QC SPV/MANAGER -->
                                <?php if (
                                    ($session->get('jabatan') == 'Spv QC' || $session->get('jabatan') == 'Manager QC') &&
                                    $Detail_AHU['approve_3'] == '' &&
                                    $Detail_AHU['approve_1'] != '' &&
                                    $Detail_AHU['approve_2'] != '' &&
                                    $Detail_AHU['keterangan'] != 'Verifikasi' // skip jika verifikasi
                                ) { ?>
                                    <form class="form-horizontal" method="POST" action="<?= base_url() ?>DataPpoj/Approve_3">
                                        <input type='hidden' value='<?= $Detail_AHU['id'] ?>' name='id_ahu'>
                                        <input type="submit" class="btn btn-primary mt-3" style="float:right;" value='Approve By QC Spv/Spi/Mgr'>
                                    </form>
                                <?php } ?>

                                <?php if (
                                    ($session->get('jabatan') == 'Spv QC' || $session->get('jabatan') == 'Manager QC') &&
                                    ($Detail_AHU['approve_3'] != '' || $Detail_AHU['keterangan'] == 'Verifikasi')
                                ) { ?>
                                    <input type="submit" class="btn btn-secondary mt-3" style="float:right;" value="Approve By QC Spv/Spi/Mgr" disabled>
                                <?php } ?>

                                <!-- APPROVE QA SPV/MANAGER -->
                                <?php
                                $jabatan_qa_spv_mgr = $session->get('jabatan') == 'Spv QA' || $session->get('jabatan') == 'Manager QA';
                                $approve_4_kosong = $Detail_AHU['approve_4'] == '';

                                $syarat_normal = $Detail_AHU['approve_1'] != '' && $Detail_AHU['approve_2'] != '' && $Detail_AHU['approve_3'] != '';
                                $syarat_verifikasi = $Detail_AHU['keterangan'] == 'Verifikasi' && $Detail_AHU['approve_1'] != '';
                                ?>

                                <?php if ($jabatan_qa_spv_mgr && $approve_4_kosong && ($syarat_normal || $syarat_verifikasi)) { ?>
                                    <form class="form-horizontal" method="POST" action="<?= base_url() ?>DataPpoj/Approve_4">
                                        <input type='hidden' value='<?= $Detail_AHU['id'] ?>' name='id_ahu'>
                                        <input type="submit" class="btn btn-primary mt-3" style="float:right;" value='Approve By QA Spv/Spi/Mgr'>
                                    </form>
                                <?php } ?>

                                <?php if (
                                    $jabatan_qa_spv_mgr &&
                                    (
                                        ($Detail_AHU['keterangan'] == 'Verifikasi' && ($Detail_AHU['approve_1'] == '' || $Detail_AHU['approve_4'] != '')) ||
                                        ($Detail_AHU['keterangan'] != 'Verifikasi' && ($Detail_AHU['approve_1'] == '' || $Detail_AHU['approve_2'] == '' || $Detail_AHU['approve_3'] == '' || $Detail_AHU['approve_4'] != ''))
                                    )
                                ) { ?>
                                    <input type="submit" class="btn btn-secondary mt-3" style="float:right;" value="Approve By QA Spv/Spi/Mgr" disabled>
                                <?php } ?>
                            </div>
                        </div>

                    </div>

                </div> <!-- end col -->

            </div> <!-- end row -->
            <?php
            $session = session();
            $approve = $session->getFlashdata('Approve');
            ?>
            <script>
                var textToast = "<?php echo $approve; ?>";
                <?php if ($approve) { ?>
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
            </script>
            <div class="row">
                <div class="col-lg-12 col-sm-12">
                    <div class="card">

                        <form class="form-horizontal" method="POST" action="<?= base_url() ?>DataPpoj/Insert_PPOJ">
                            <!-- Modal -->

                            <div class="modal fade" id="exampleModalLong-1" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">

                                            <h5 class="modal-title" id="exampleModalLongTitle-1">Pilih AHU</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">


                                            <input type="hidden" value="<?= $Detail_AHU['jenispemeriksaan'] ?>" name="jenispemeriksaan">
                                            <input type="hidden" value="<?= $Detail_AHU['tanggaldilakukan'] ?>" name="tanggaldilakukan">
                                            <input type="hidden" value="<?= $Detail_AHU['id'] ?>" name="id_ahu">
                                            <div class="mb-3">
                                                <label for="validationCustom03" class="form-label">Nomor AHU</label>
                                                <select class="form-control" id="validationCustom03" name="ahu" required onchange="fetchStateData(this.value)">
                                                    <option selected disabled value="">Choose...</option>

                                                    <option value="<?= $Detail_AHU['ahu'] ?>"><?= $Detail_AHU['ahu'] ?></option>

                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="validationCustom04" class="form-label">Nama Ruangan</label>
                                                <select class="form-control" id="ruangan_id" name="ruangan" required>
                                                    <option selected disabled value="">Choose...</option>
                                                </select>
                                            </div>
                                            <!-- <div class="mb-3">
                                            <label for="validationCustom03" class="form-label">Jenis Kondisi</label>
                                            <select class="form-control" id="validationCustom03" name="kondisi" required>
                                                <option selected disabled value="">Choose...</option>
                                                <option>At Rest</option>
                                                <option>In Operation</option>
                                            </select>
                                        </div> -->

                                            <input type="hidden" class="form-control" id="validationCustom04" name="site" value="<?= $Detail_AHU['site']  ?>">


                                            <!--<div class="mb-3">
                                                    <label for="validationCustom04" class="form-label">Tanggal</label>
                                                    <input type="date" name="tanggal" class="form-control" id="validationCustom04" placeholder="Tanggal" required>
                                                </div>-->
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light " data-dismiss="modal">Close</button>
                                                <input type="submit" class="btn btn-primary" id="saveButton" value="Save">


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
                        <div class="card-body table-responsive">
                            <?php if ($session->get('jabatan') == 'QA Analis' or $session->get('jabatan') == 'Manager QA' or $session->get('jabatan') == 'Spv QA') { ?>
                                <button type="button" class="btn btn-primary mt-3 btn-animation" data-animation="slideInUp" style="float:right;" data-toggle="modal" data-target="#exampleModalLong-1">Add Data</button>
                                <!-- <button type="button" class="btn btn-primary waves-effect waves-light" id="sa-success">Click me</button> -->
                            <?php } ?>
                            <h4 class="card-title mb-4">Monitoring Data</h4>
                            <div class="">
                                <table id="datatable2" class="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>

                                            <th>Nama Ruangan</th><!--Dropdown dari tabel Master Data-->
                                            <th>Tanggal</th>
                                            <th>Kelas</th><!--Dropdown dari tabel Master Data-->
                                            <th>No Report</th><!--No PPOJ dibentuk dari gabungan AHU, Site, Nama Ruangan, dan Tanggal-->

                                            <?php if ($session->get('jabatan') == 'QA Analis' or $session->get('jabatan') == 'Manager QA' or $session->get('jabatan') == 'Spv QA') { ?>
                                                <th>Action</th>
                                            <?php } ?>
                                        </tr>
                                    </thead>


                                    <tbody>

                                        <?php foreach ($List_PPOJ as $no => $row) :  ?>
                                            <tr>
                                                <td><?= $no + 1 ?></td>

                                                <td> <?= $row['nama_ruangan'] ?></td>
                                                <td> <?= $row['tanggaldilakukan'] ?></td>
                                                <td> <?= $row['kelas'] ?></td>
                                                <td><a href="<?= base_url() ?>DataPpoj/Detail/<?= $row['id'] ?>" style="color: #1A61DE;"><?= $row['no_ppoj'] ?></a></td>
                                                <!--<td style="width: 124px">-->

                                                <!--    </?php if ($row['status'] == 'On Progress' || $row['status'] == null) { ?>-->
                                                <!--         <div class="badge bg-secondary">On Progress</div>-->
                                                <!--     </?php }-->
                                                <!--     if ($row['status'] == 'Selesai') { ?>-->
                                                <!--         <div class="badge bg-success">Selesai</div>-->
                                                <!--     </?php } ?>-->


                                                <?php if ($session->get('jabatan') == 'QA Analis' or $session->get('jabatan') == 'Manager QA' or $session->get('jabatan') == 'Spv QA') { ?>
                                                    <td>
                                                        <div class="btn-group btn-group-sm" style="float: none;">

                                                            <a href="<?= base_url() ?>DataPpoj/DeleteRuangan/<?= $row['id'] ?>" onclick="return confirm('Yakin Ingin menghapus nya ?')" class="tabledit-delete-button btn btn-sm btn-danger" style="float: none; margin: 5px;">
                                                                <span class="ti-trash"></span>
                                                            </a>


                                                        </div>



                                                    </td>
                                                <?php } ?>
                                                <!-- <td style="width: 134px">
                                                    <div class="btn btn-soft-primary btn-sm">View detail<i class="mdi mdi-arrow-right ms-1"></i></div>
                                                </td> -->
                                            </tr>
                                            <!-- Modal Update -->
                                            <div class="modal fade" id="Status<?= $row['id'] ?>" tabindex="-1" role="dialog">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <form method="POST" action="<?= base_url() ?>">
                                                        <div class="modal-content">
                                                            <div class="modal-header">

                                                                <h5 class="modal-title mt-0">Status PPOJ </h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">

                                                                <input type="hidden" class="form-control" name="id" value="<?= $row['id'] ?>">

                                                                <div class="mb-3">


                                                                </div>


                                                                <label>Suhu</label>
                                                                <div id="inputContainer">
                                                                    <div class="input-group mb-3">

                                                                        <div class="input-group-prepend">

                                                                            <span class="input-group-text" for="smin_1">Suhu Min</span>
                                                                        </div>

                                                                        <div class="input-group-prepend">

                                                                            <span class="input-group-text" for="smax_1">Suhu Max</span>
                                                                        </div>

                                                                    </div>

                                                                </div></br>

                                                            </div>


                                                            <div class="modal-footer">

                                                            </div>

                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
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