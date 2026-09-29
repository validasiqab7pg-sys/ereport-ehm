<?php echo view('parsial/navbar'); ?>
<?php echo view('parsial/sidebar'); ?>
<!-- Begin page -->
<div class="page-content-wrapper ">

    <div class="container-fluid">

<!--        <div class="row">-->
<!--            <div class="col-sm-12">-->
<!--                <div class="page-title-box">-->
<!--                    <div class="btn-group float-right">-->
<!--                        <ol class="breadcrumb hide-phone p-0 m-0">-->
<!--<li class="breadcrumb-item"><a href="javascript: void(0);">Kualifikasi</a></li>-->
<!--                            <li class="breadcrumb-item active">Data Kualifikasi dan EHM</li>-->
<!--                        </ol>-->
<!--                    </div>-->
<!--                    <h4 class="page-title">Data Kualifikasi dan EHM</h4>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="clearfix"></div>-->
<!--        </div>-->
    <div class="header-body">
          <div class="row align-items-center py-2"> 
            <div class="col-lg-3 col-5">
              <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-2">
                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                <li class="breadcrumb-item"><a href="#"><i class="fa fa-home "></i></a></li>
                  <li class="breadcrumb-item"><a href="#">Data Kualifikasi dan EHM</a></li>
                </ol>
              </nav>
            </div>
           
          </div>
          <div>


        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="card">

                    <form class="form-horizontal" method="POST" action="<?= base_url() ?>DataPpoj/Insert_AHU">
                        <!-- Modal -->



                        <!-- <div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header"> -->
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
                                    <div class="mb-3">
                                            <label for="validationCustom03" class="form-label">Jenis Pemeriksaan</label>
                                            <select class="form-control" id="validationCustom03" name="jenispemeriksaan" required>
                                                <option selected disabled value="">Choose...</option>
                                                <option value="Kualifikasi">Kualifikasi</option>
                                                <option value="EHM">EHM</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="validationCustom03" class="form-label">Nomor AHU</label>
                                            <select class="form-control" id="validationCustom03" name="ahu" required onchange="fetchStateData(this.value)">
                                                <option selected disabled value="">Choose...</option>
                                                <?php foreach ($List_AHU as $x) { ?>
                                                    <option value="<?= $x['ahu'] ?>"><?= $x['ahu'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="validationCustom03" class="form-label">Jenis Kondisi</label>
                                            <select class="form-control" id="validationCustom03" name="kondisi" required>
                                                <option selected disabled value="">Choose...</option>
                                                <option>At Rest</option>
                                                <option>In Operation</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="validationCustom03" class="form-label">Site</label>
                                            <select class="form-control" id="validationCustom03" name="site" required>
                                               <option selected disabled value="">Choose...</option>
                                                <option>Cikarang</option>
                                                <option>Pulogadung</option>
                                            </select>
                                        </div>
                                         <div class="mb-3">
                                            <label for="validationCustom03" class="form-label">Keterangan</label>
                                            <select class="form-control" id="validationCustom03" name="keterangan" required>
                                                <option selected disabled value="">Choose...</option>
                                                <option>N/A</option>
                                                <option>Verifikasi</option>
                                                <option>Sampling Ulang</option>
                                            </select>
                                        </div>
                                        <!-- <div class="mb-3">
                                            <label for="validationCustom04" class="form-label">Nama Ruangan</label>
                                            <select class="form-control" id="ruangan_id" name="ruangan" required>
                                                <option selected disabled value="">Choose...</option>
                                            </select>
                                        </div> -->
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
                           <?php if($session->get('jabatan') == 'QA Analis' OR $session->get('jabatan') == 'Manager QA' OR $session->get('jabatan') == 'Spv QA'){ ?>
                        <button type="button" class="btn btn-primary mt-3 btn-animation" data-animation="slideInUp" style="float:right;" data-toggle="modal" data-target="#exampleModalLong-1">Add Data</button>
                        <!-- <button type="button" class="btn btn-primary waves-effect waves-light" id="sa-success">Click me</button> -->
                        <?php } ?>
                        <h4 class="card-title mb-4">Monitoring Kualifikasi dan EHM</h4>
                        <div class="">
                            <table id="datatable2" class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Jenis Pemeriksaan</th>
                                        <th>AHU</th><!--Dropdown dari tabel Master Data-->
                                        
                                        <th>Kondisi</th>
                                       <th>Site</th>
                                        <th>Keterangan</th>
                                        <th>Status</th>
                                    <th>Action</th>
                                    
                                    </tr>
                                </thead>


                                <tbody>

                                    <?php foreach ($List_PPOJ as $no => $row) :  ?>
                                        <tr>
                                            <td><?= $no + 1 ?></td>
                                            <td> <?= $row['tanggaldilakukan'] ?></td>
                                            <td> <?= $row['jenispemeriksaan'] ?></td>
                                            <td> AHU <?= $row['ahu'] ?></td>
                                            
                                            <td> <?= $row['kondisi'] ?></td>
                                            <td> <?= $row['site'] ?></td>
                                            <td> <?= $row['keterangan'] ?></td>
                                           
                                             <!--<td style="width: 124px">-->
                                             <!--   </?php if ($row['status'] == 'On Progress' || $row['status'] == null) { ?>-->
                                             <!--       <div class="badge bg-secondary"><?= $row['status'] ?></div>-->
                                             <!--   </?php }-->
                                             <!--   if ($row['status'] == 'Selesai di QA') { ?>-->
                                             <!--       <div class="badge bg-success"><?= $row['status'] ?></div>-->
                                             <!--   </?php } ?>-->

                                             <!--</td>-->
                                             <td style="width: 124px; text-align: center;">
                                                    <?php if ($row['status'] == 'On Progress' || $row['status'] == null) { ?>
                                                        <div class="badge" style="background-color: #6c757d; color: #fff; padding: 10px 15px; border-radius: 20px; font-size: 14px; font-weight: bold; text-transform: uppercase;">
                                                            <i class="fas fa-spinner fa-spin" style="margin-right: 5px;"></i> <?= $row['status'] ?: 'Pending' ?>
                                                        </div>
                                                    <?php }
                                                    if ($row['status'] == 'Selesai di QA' || $row['status'] == 'Selesai di QC' || $row['status'] == 'Selesai di Spv QA' ||$row['status'] == 'Selesai di Spv QC') { ?>
                                                        <div class="badge" style="background-color: #28a745; color: #fff; padding: 10px 15px; border-radius: 20px; font-size: 14px; font-weight: bold; text-transform: uppercase;">
                                                            <i class="fas fa-check-circle" style="margin-right: 5px;"></i> <?= $row['status'] ?>
                                                        </div>
                                                    <?php } ?>
                                                </td>
                                            <td>
                                                <div class="btn-group btn-group-sm" style="float: none;">
                                                    <!-- <button type="button" class="tabledit-edit-button btn btn-sm btn-info" style="float: none; margin: 5px;">
                                                        <span class="ti-pencil"></span>
                                                    </button> -->
                                                    <?php if($session->get('jabatan') == 'QA Analis' OR $session->get('jabatan') == 'Manager QA' OR $session->get('jabatan') == 'Spv QA'){ ?>
                                                    <a href="<?= base_url() ?>DataPpoj/Delete/<?= $row['id'] ?>" onclick="return confirm('Yakin Ingin menghapus nya ?')"  class="tabledit-delete-button btn btn-sm btn-danger" style="float: none; margin: 5px;">
                                                        <span class="ti-trash"></span>
                                                    </a>
                                                    <?php } ?>
                                                <a href="<?= base_url() ?>DataPpoj/ViewDetail/<?= $row['id'] ?>" class="tabledit-delete-button btn btn-sm btn-primary" style="float: none; margin: 5px;">
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
                </div>
            </div>
        </div><!--end row-->




    </div><!-- container -->

</div> <!-- Page content Wrapper -->

</div> <!-- content -->
<?php echo view('parsial/footer'); ?>