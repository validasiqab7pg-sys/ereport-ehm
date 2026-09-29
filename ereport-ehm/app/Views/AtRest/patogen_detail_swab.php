<?php echo view('parsial/navbar'); ?>
<?php echo view('parsial/sidebar'); ?>
<!-- Begin page -->
<div class="page-content-wrapper ">

    <div class="container-fluid">

        <!--<div class="row">-->
        <!--    <div class="col-sm-12">-->
        <!--        <div class="page-title-box">-->
        <!--            <div class="btn-group float-right">-->
        <!--                <ol class="breadcrumb hide-phone p-0 m-0">-->

        <!--                    <li class="breadcrumb-item active">Data Patogen</li>-->
        <!--                </ol>-->
        <!--            </div>-->
        <!--            <h4 class="page-title">Detail Data Patogen</h4>-->
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
                  <li class="breadcrumb-item"><a href="<?= base_url() ?>PatogenSwab" >Data Swab Personnel/Machine Hygiene</a></li>
                  <li class="breadcrumb-item"><a href="#" style="font-weight: bold; color: black; font-size: 14px;">Detail Data Personnel/Machine Hygiene</a></li>
                  <!--<li class="breadcrumb-item"><a href="#" >Add Data Patogen</a></li>-->
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
                            <dt class="col-sm-4">Tanggal Sampling</dt>
                            <dd class="col-sm-8"><?= $Detail_AHU['tanggal_sampling'] ?></dd>

                            <dt class="col-sm-4">Kategori</dt>
                            <dd class="col-sm-8"><?= $Detail_AHU['kategori'] ?></dd>

                            <dt class="col-sm-4">Keterangan</dt>
                            <dd class="col-sm-8"><?= $Detail_AHU['keterangan'] ?></dd>

                            <dt class="col-sm-4">Site</dt>
                            <dd class="col-sm-8">
                                <?= $Detail_AHU['site'] ?>
                            </dd>
                        </dl>
                        <button type="button" class="btn btn-primary mt-3 btn-animation" data-animation="slideInUp" style="float:right;" data-toggle="modal" data-target="#exampleModalLong-1">Submit Data</button>
                                <!-- Modal -->

                                <div class="modal fade" id="exampleModalLong-1" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">

                                                <h5 class="modal-title" id="exampleModalLongTitle-1">Information</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form method="POST" action="<?= base_url() ?>PatogenSwab/UpdateStatus">
                                                <div class="modal-body">

                                                    <p>Yakin ingin merubah status Detail Patogen ?</p>

                                                    <input type="hidden" class="form-control" name="id_swab" value="<?= $id_swab ?>">

                                                    <div class="modal-footer">

                                                        <input type="submit" class="btn btn-primary" value="Save">


                                                    </div>

                                                </div><!-- /.modal-content -->
                                            </form>
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->
                                </div>
                                </div>
                    </div>

                </div>

            </div> <!-- end col -->

        </div> <!-- end row -->

        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="card">

                    
                   
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
                        
                    </script>
                    <div class="card-body table-responsive">
                        <!-- <button type="button" class="btn btn-primary mt-3 btn-animation" data-animation="slideInUp" style="float:right;" data-toggle="modal" data-target="#exampleModalLong-1">Add Data</button> -->
                        <!-- <button type="button" class="btn btn-primary waves-effect waves-light" id="sa-success">Click me</button> -->

                        <h4 class="card-title mb-4">Detail Data Personnel/Machine Hygiene</h4>
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
                                    
                                    <th>Action</th>

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
                                            
                                            <td>
                                                <div class="btn-group btn-group-sm" style="float: none;">
                                                    <a href="<?= base_url() ?>PatogenSwab/AddPatogen/<?= $row['id'] ?>" class="tabledit-delete-button btn btn-sm btn-primary" style="float: none; margin: 5px;">
                                                        <span class="ti-plus">Input Hasil Swab</span>
                                                    </a>
                                                </div>


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