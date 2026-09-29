<?php echo view('parsial/navbar'); ?>
<?php echo view('parsial/sidebar'); ?>
<!-- Begin page -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<div class="page-content-wrapper ">
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
                            <li class="breadcrumb-item"><a href="<?= base_url() ?>DataPpojSwab"><i class="fa fa-home "></i></a></li>
                            <li class="breadcrumb-item"><a href="<?= base_url() ?>DataPpojSwab">Data Swab Personnel & Machine Hygiene</a></li>
                            <li class="breadcrumb-item"><a href="#" style="font-weight: bold; color: black; font-size: 14px;">Detail Swab Personnel & Machine Hygiene </a></li>
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

                                    <dt class="col-sm-4">Tanggal Sampling</dt>
                                    <dd class="col-sm-8"><?= $Detail_AHU['tanggal_sampling']  ?></dd>
                                    <dt class="col-sm-4">Kategori</dt>
                                    <dd class="col-sm-8"><?= $Detail_AHU['kategori']  ?></dd>
                                    <dt class="col-sm-4">Site</dt>
                                    <dd class="col-sm-8">
                                        <?= $Detail_AHU['site']  ?>
                                    </dd>
                                    <dt class="col-sm-4">Keterangan</dt>
                                    <dd class="col-sm-8"><?= $Detail_AHU['keterangan']  ?></dd>
                                </dl>
                                <!--UNTUK APPROVE QA-->
                                <?php if ($session->get('jabatan') == 'QA Analis' and $Detail_AHU['approve_1'] == '' and  $Cek_button_qa  == 1) {  ?>

                                    <button type="button" class="btn btn-primary mt-3 btn-animation" data-animation="slideInUp" style="float:right;" data-toggle="modal"
                                        data-target="#approveQA">Approve By QA Analis</button>
                                <?php }  ?>
                                <?php if (($session->get('jabatan') == 'QA Analis' and $Detail_AHU['approve_1'] == '' and  $Cek_button_qa  == 0) ||
                                    ($Detail_AHU['approve_1'] != '' and $session->get('jabatan') == 'QA Analis')
                                ) { ?>
                                    <input type="submit" class="btn btn-secondary" style="float:right;" value="Approve By QA Analis" disabled>
                                <?php }  ?>

                                <div class="modal fade" id="approveQA" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">

                                                <h5 class="modal-title" id="exampleModalLongTitle-1">Information</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form method="POST" action="<?= base_url() ?>DataPpojSwab/Approve_1">
                                                <div class="modal-body">

                                                    <p>Yakin ingin merubah status Swab Personnel & Machine Hygiene ?</p>

                                                    <input type="hidden" class="form-control" name="id_swab" value="<?= $id_swab ?>">

                                                    <div class="modal-footer">

                                                        <input type="submit" class="btn btn-primary" value="Save">


                                                    </div>

                                                </div><!-- /.modal-content -->
                                            </form>
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->
                                </div>

                                <!--UNTUK APPROVE QC-->
                                <?php if (
                                    $session->get('jabatan') == 'QC Analis' and $Detail_AHU['approve_2'] == '' and $Detail_AHU['approve_1'] != ''
                                    and  $Cek_button_qc == 1
                                ) { ?>
                                    <form class="form-horizontal" method="POST" action="<?= base_url() ?>DataPpojSwab/Approve_2">
                                        <input type='hidden' value='<?= $Detail_AHU['id'] ?>' name='id_swab'>
                                        <input type="submit" class="btn btn-primary mt-3 " style="float:right;" value='Approve By QC Analis'>
                                    </form>
                                <?php } ?>

                                <?php if (
                                    ($session->get('jabatan') == 'QC Analis' and $Detail_AHU['approve_2'] == '' and $Detail_AHU['approve_1'] != ''
                                        and  $Cek_button_qc == 0) || ($Detail_AHU['approve_2'] != '' and $session->get('jabatan') == 'QC Analis')
                                ) { ?>

                                    <input type="submit" class="btn btn-secondary mt-3" style="float:right;" value="Approve By QC Analis" disabled>
                                <?php }  ?>

                                <!-- END UNTUK APPROVE QC-->
                                <!--  UNTUK APPROVE SPV QC-->
                                <?php if (($session->get('jabatan') == 'Spv QC' or $session->get('jabatan') == 'Manager QC')
                                    and $Detail_AHU['approve_3'] == '' and $Detail_AHU['approve_1'] != '' and $Detail_AHU['approve_2'] != ''
                                ) { ?>
                                    <form class="form-horizontal" method="POST" action="<?= base_url() ?>DataPpojSwab/Approve_3">
                                        <input type='hidden' value='<?= $Detail_AHU['id'] ?>' name='id_swab'>
                                        <input type="submit" class="btn btn-primary mt-3 " style="float:right;" VALUE='Approve By QC Spv/Spi/Mgr'>
                                    </form>
                                <?php } ?>
                                <?php if (
                                    (($session->get('jabatan') == 'Spv QC' or $session->get('jabatan') == 'Manager QC')
                                        and $Detail_AHU['approve_3'] != '' and $Detail_AHU['approve_1'] != '' and $Detail_AHU['approve_2'] != '')
                                    || ($Detail_AHU['approve_3'] != '' and ($session->get('jabatan') == 'Spv QC' or $session->get('jabatan') == 'Manager QC'))
                                ) { ?>

                                    <input type="submit" class="btn btn-secondary mt-3" style="float:right;" value="Approve By QC Spv/Spi/Mgr" disabled>
                                <?php }  ?>

                                <!--  UNTUK APPROVE SPV QA-->
                               <?php if (($session->get('jabatan') == 'Spv QA' || $session->get('jabatan') == 'Manager QA') 
                                    && $Detail_AHU['approve_4'] == '' 
                                    && $Detail_AHU['approve_3'] != '' 
                                    && $Detail_AHU['approve_2'] != '' 
                                    && $Detail_AHU['approve_1'] != ''): ?>
                                    <button type="button" class="btn btn-primary mt-3" style="float:right;" data-toggle="modal" data-target="#modalApproveSpvQA">
                                        Approve By QA Spv/Spi/Mgr
                                    </button>
                                <?php endif; ?>

                                <div class="modal fade" id="modalApproveSpvQA" tabindex="-1" role="dialog" aria-labelledby="modalApproveSpvQA" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <form id="form-approve-qa">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Konfirmasi Lanjutan</h5>
                                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                                </div>
                                                <div class="modal-body" style="padding-bottom: 1.5rem;">
                                                    <p>Apakah perlu lanjut OOS dan Lanjut Penyimpangan?</p>

                                                    <input type="hidden" name="id_swab" id="id_swab" value="<?= $Detail_AHU['id']; ?>">
                                                    <div id="feedback" class="text-success font-weight-bold mb-2"></div>

                                                    <div class="d-flex justify-content-between">
                                                        <button type="button" class="btn btn-warning" id="request-oos" data-id="<?= $Detail_AHU['id'] ?>">Request OOS</button>
                                                        <button type="button" class="btn btn-danger" id="request-penyimpangan" data-id="<?= $Detail_AHU['id'] ?>">Request Penyimpangan</button>
                                                    </div>

                                                    <hr>
                                                    <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary mt-2 float-right" id="final-approve">Close And Approve</button>
                                                   </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                <script>
                                    

                               $(document).ready(function () {
                                // Variabel tracking masih bisa dipakai kalau mau tampilkan feedback
                                let sentOOS = false;
                                let sentPenyimpangan = false;

                                function sendRequest(url, type) {
                                    let idSwab = $('#id_swab').val();
                                    $.ajax({
                                        url: url,
                                        method: 'POST',
                                        data: { id_swab: idSwab },
                                        success: function (response) {
                                            if (response.status === 'success') {
                                                $('#feedback').text(type + " berhasil dikirim.");
                                                if (type === 'OOS') sentOOS = true;
                                                if (type === 'Penyimpangan') sentPenyimpangan = true;
                                            } else {
                                                alert("Gagal: " + response.message);
                                            }
                                        },
                                        error: function () {
                                            alert("Terjadi kesalahan saat mengirim " + type);
                                        }
                                    });
                                }

                                $('#request-oos').on('click', function () {
                                    sendRequest("<?= base_url('DataPpojSwab/RequestOOS') ?>", 'OOS');
                                });

                                $('#request-penyimpangan').on('click', function () {
                                    sendRequest("<?= base_url('DataPpojSwab/RequestPenyimpangan') ?>", 'Penyimpangan');
                                });

                                $('#form-approve-qa').on('submit', function (e) {
                                    e.preventDefault();

                                    // Hilangkan syarat minimal klik Request
                                    $.post("<?= base_url('DataPpojSwab/Approve_4') ?>", {
                                        id_swab: $('#id_swab').val()
                                    }, function (response) {
                                        alert('Data telah di-approve!');
                                        location.reload();
                                    });
                                });
                            });

                                </script>

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


                        <form class="form-horizontal" method="POST" action="<?= base_url() ?>DataPpojSwab/Insert_PPOJ_Swab">
                            <!-- Modal -->

                            <div class="modal fade" id="exampleModalLong-1" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">

                                            <h5 class="modal-title" id="exampleModalLongTitle-1">Pilih Swab Personnel & Machien Hygiene</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                           
                                            <input type="hidden" value="<?= $Detail_AHU['tanggal_sampling'] ?>" name="tanggal_sampling">
                                            <input type="hidden" value="<?= $Detail_AHU['keterangan'] ?>" name="keterangan">
                                            <input type="hidden" value="<?= $Detail_AHU['site'] ?>" name="site">
                                            <input type="hidden" value="<?= $Detail_AHU['id'] ?>" name="id_swab">
                                            <div class="mb-3">
                                                <label for="validationCustom03" class="form-label">Kategori</label>
                                                <select class="form-control" id="validationCustom03" name="kategori" required onchange="fetchNamaMesinData(this.value)">
                                                    <option selected disabled value="">Choose...</option>

                                                    <option value="<?= $Detail_AHU['kategori'] ?>"><?= $Detail_AHU['kategori'] ?></option>

                                                </select>
                                            </div>
                                          
                                            <div class="mb-3">
                                                <label for="validationCustom04" class="form-label">Pilih Nama Mesin/Personil/Alat</label>
                                                <select class="form-control" id="nama_mesin_personil_alat" name="nama_mesin_personil_alat" required>
                                                    <option selected disabled value="">Choose...</option>
                                                </select>
                                                
                                               
                                               
                                                <div class="mb-3">
                                                    <label for="tanggal_dibersihkan" class="form-label">
                                                    Tanggal Dibersihkan <small class="text-muted">(dd/mm/yyyy)</small>
                                                    </label>
                                                    <input type="date" class="form-control" id="tanggal_dibersihkan" name="tanggal_dibersihkan" required>
                                                </div>


                                                




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
                        
                        <?php
                        $session = session();
                        $toast = $session->getFlashdata('Toast');
                        ?>
                        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
                            <script>
                                flatpickr("#tanggal_dibersihkan", {
                                    dateFormat: "d/m/Y", // Format tampilan dd/mm/yyyy
                                    altInput: true,
                                    altFormat: "d/m/Y",
                                    allowInput: true
                                });
                            </script>
                        <script>
                            function fetchNamaMesinData(kategori) {
  if (!kategori || kategori === '') {
    console.warn('Kategori kosong, skip fetch');
    document.getElementById('nama_mesin_personil_alat').innerHTML = '<option selected disabled value="">Choose...</option>';
    return;
  }

  console.log('Fetch mesin untuk kategori:', kategori);

  $.ajax({
    url: '<?= base_url("DataPpojSwab/Ambil_NamaMesin") ?>',
    type: 'POST',
    data: {
      nama_namamesin: kategori
    },
    dataType: 'json',
    timeout: 5000,
    
    success: function(response) {
    if (response.status === 'success') {
        let selectHtml = '<option selected disabled value="">Choose...</option>';
        
        if (response.data && response.data.length > 0) {
            response.data.forEach(function(item) {
                // Mengambil properti dari objek item
                let nama = item.nama_mesin_personil_alat;
                let periode = item.periode;
                
                // Menampilkan label yang informatif: "Nama Alat (Caturwulan 2)"
                selectHtml += '<option value="' + nama + '">' + nama + ' (' + periode + ')</option>';
            });
        } else {
            selectHtml = '<option selected disabled value="">Tidak ada jadwal sampling untuk bulan ini</option>';
        }
        document.getElementById('nama_mesin_personil_alat').innerHTML = selectHtml;
    }
},
    
    error: function(xhr, status, error) {
      console.error('AJAX Error:', error);
      document.getElementById('nama_mesin_personil_alat').innerHTML = 
        '<option selected disabled value="">Error: ' + error + '</option>';
    }
  });
}
                        </script>


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
                            <h4 class="card-title mb-4">Detail Data Personnel & Machine Hygiene</h4>
                            <div class="">
                                <table id="datatable2" class="table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Mesin/Personil/Alat</th><!--Dropdown dari tabel Master Data-->
                                            <th>Tanggal Dibersihkan</th>
                                            <th>Kelas</th><!--Dropdown dari tabel Master Data-->
                                            <th>Departemen</th>
                                            <th>Nama Ruangan</th>
                                            <th>No Report</th><!--No PPOJ dibentuk dari gabungan AHU, Site, Nama Ruangan, dan Tanggal-->
                                            <th>Status</th>
                                            <?php if ($session->get('jabatan') == 'QA Analis' or $session->get('jabatan') == 'Manager QA' or $session->get('jabatan') == 'Spv QA') { ?>
                                                <th>Action</th>
                                            <?php } ?>
                                        </tr>
                                    </thead>


                                    <tbody>

                                        <?php foreach ($List_PPOJ_Swab as $no => $row) :  ?>
                                            <tr>
                                                <td><?= $no + 1 ?></td>
                                                <td><?= $row['nama_mesin_personil_alat'] ?: 'NA' ?></td>
                                                <td><?= $row['tanggal_dibersihkan'] ?: 'NA' ?></td>
                                                <td><?= $row['kelas'] ?: 'NA' ?></td>
                                                <td><?= $row['departemen'] ?: 'NA' ?></td>
                                                <td><?= $row['nama_ruangan'] ?: 'NA' ?></td>
                                                <td><a href="<?= base_url() ?>PatogenSwab/Detail/<?= $row['id'] ?>" style="color: #1A61DE;"> Report <?= $row['kategori'] ?> </a></td>

                                                <td style="width: 124px">
                                                    <?php if ($row['status'] == 'On Progress' || $row['status'] == null) { ?>
                                                        <div class="badge bg-secondary" style="background-color: gray;">On Progress</div>
                                                    <?php } ?>

                                                    <?php if ($row['status'] == 'Selesai') { ?>
                                                        <div class="badge bg-success" style="background-color: green;">Selesai</div>
                                                    <?php } ?>
                                                </td>



                                                <?php if ($session->get('jabatan') == 'QA Analis' or $session->get('jabatan') == 'Manager QA' or $session->get('jabatan') == 'Spv QA') { ?>
                                                    <td>
                                                        <div class="btn-group btn-group-sm" style="float: none;">

                                                            <a href="<?= base_url() ?>DataPpojSwab/DeleteMesin/<?= $row['id'] ?>" onclick="return confirm('Yakin Ingin menghapus nya ?')" class="tabledit-delete-button btn btn-sm btn-danger" style="float: none; margin: 5px;">
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