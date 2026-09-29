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

        <!--                    <li class="breadcrumb-item active">Data Flow</li>-->
        <!--                </ol>-->
        <!--            </div>-->
        <!--            <h4 class="page-title">Detail Data Flow</h4>-->
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
                  <li class="breadcrumb-item"><a href="<?= base_url() ?>Flow">Data Flow dan Pertukaran Udara</a></li>
                  <li class="breadcrumb-item"><a href="#" style="font-weight: bold; color: black; font-size: 14px;">Detail Data Flow dan Pertukaran Udara</a></li>
                  <!--<li class="breadcrumb-item"><a href="#" >Add Data Flow dan Pertukaran Udara</a></li>-->
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
                                  
                        </dl>
                    <?php if($countSelesaiFlow == 0) { ?>
                      <button type="button" class="btn btn-primary mt-3 btn-animation" data-animation="slideInUp" style="float:right;" data-toggle="modal" data-target="#exampleModalLong-1">Submit Data</button>
                      <?php }  else { ?>
                            
                     <input type="submit" class="btn btn-secondary"   style="float:right;" value ="Submit Data" disabled> 
                    <?php } ?>                 
                                   
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
                                                    <form method="POST" action="<?= base_url() ?>Flow/UpdateStatus">
                                                        <div class="modal-body">
        
                                                            <p>Yakin ingin merubah status Detail Flow ?</p>
        
                                                            <input type="hidden" class="form-control" name="id_ahu" value="<?= $id_ahu ?>">
        
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

                    <form class="form-horizontal" method="POST" action="<?= base_url() ?>DataPpoj/Insert_PPOJ">
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
                                        <div class="mb-3">
                                            <label for="validationCustom03" class="form-label">Jenis Kondisi</label>
                                            <select class="form-control" id="validationCustom03" name="kondisi" required>
                                                <option selected disabled value="">Choose...</option>
                                                <option>At Rest</option>
                                                <option>In Operation</option>
                                            </select>
                                        </div>

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
                                        output += <option value="${data[row].nama_ruangan}">${data[row].nama_ruangan}</option>;
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
                        <!-- <button type="button" class="btn btn-primary mt-3 btn-animation" data-animation="slideInUp" style="float:right;" data-toggle="modal" data-target="#exampleModalLong-1">Add Data</button> -->
                        <!-- <button type="button" class="btn btn-primary waves-effect waves-light" id="sa-success">Click me</button> -->

                        <h4 class="card-title mb-4">Detail Data Flow dan Pertukaran Udara</h4>
                        <div class="">
                            <table id="datatable2" class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>No Report</th>
                                        <th>Nama Ruangan</th>
                                        <!--Dropdown dari tabel Master Data-->
                                        <th>Kelas</th>
                                        <th>Total Flow</th>
                                        <th>Jumlah Pertukaran Udara</th>
                                        <th>Status</th>


                                        <th>Action</th>

                                    </tr>
                                </thead>


                                <tbody>
                                    <?php foreach ($List_PPOJ as $no => $row) : ?>
                                            <tr>
                                                <td><?= $no + 1 ?></td>
                                                <td><?= $row['no_ppoj'] ?></td>
                                                <td><?= $row['nama_ruangan'] ?></td>
                                                <td><?= $row['kelas'] ?></td>
                                                <td><?= $FlowModel->select('sum(hasil_flow) sum_flow')->where('id_ppoj', $row['id'])->first()['sum_flow'] ?? 0; ?></td>
                                                <td><?= $row['jumlah_pertukaran_udara'] ?></td>
                                                <td>
                                                    <?php if ($row['status_flow'] == 0 || $row['status_flow'] == null) : ?>
                                                        <div class="badge bg-secondary">On Progress</div>
                                                    <?php elseif ($row['status_flow'] == 1) : ?>
                                                        <div class="badge bg-success">Selesai</div>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <button class="btn btn-sm btn-success"
                                                                data-toggle="modal"
                                                                data-target="#EditPU<?= $row['id'] ?>">
                                                            <span class="mdi mdi-library-plus sm"> PU</span>
                                                        </button>
                                                        <a href="<?= base_url() ?>Flow/AddFlow/<?= $row['id'] ?>" class="btn btn-sm btn-primary">
                                                            <span class="ti-plus"> Flow</span>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                </tbody>
                            </table>
                            <?php foreach ($List_PPOJ as $row) : ?>
                                <div class="modal fade" id="EditPU<?= $row['id'] ?>" tabindex="-1" role="dialog">
                                    <form class="form-horizontal" method="POST" action="<?= base_url() ?>Flow/AddPU">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Tambah Pertukaran Udara</h5>
                                                    <button type="button" class="close" data-dismiss="modal">
                                                        <span>&times;</span>
                                                    </button>
                                                </div>

                                                <div class="modal-body">
                                                    <input type="hidden" name="jenispemeriksaan" value="<?= $Detail_AHU['jenispemeriksaan'] ?>">
                                                    <input type="hidden" name="tanggaldilakukan" value="<?= $Detail_AHU['tanggaldilakukan'] ?>">
                                                    <input type="hidden" name="id_ahu" value="<?= $Detail_AHU['id'] ?>">
                                                    <input type="hidden" name="id_ppoj" value="<?= $row['id'] ?>">

                                                    <div class="mb-3">
                                                        <label class="form-label">Jumlah Pertukaran Udara</label>
                                                        <select id="puOption<?= $row['id'] ?>" class="form-control" onchange="toggleInputPU(<?= $row['id'] ?>)" required>
                                                            <option value="">-- Pilih --</option>
                                                            <option value="input">Masukkan Angka</option>
                                                            <option value="N/A">N/A</option>
                                                        </select>
                                                    </div>

                                                    <div class="mb-3" id="puInputContainer<?= $row['id'] ?>" style="display: none;">
                                                        <input type="number" step="any" class="form-control" name="pu" id="puInput<?= $row['id'] ?>">
                                                    </div>

                                                    <input type="hidden" name="pu" id="puFinal<?= $row['id'] ?>">
                                                    <input type="hidden" name="site" value="<?= $Detail_AHU['site'] ?>">
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                                                    <input type="submit" class="btn btn-primary" value="Save">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <?php endforeach; ?>
                                <script>
                                function toggleInputPU(id) {
                                    const option = document.getElementById("puOption" + id).value;
                                    const inputContainer = document.getElementById("puInputContainer" + id);
                                    const inputField = document.getElementById("puInput" + id);
                                    const hiddenFinal = document.getElementById("puFinal" + id);

                                    if (option === "input") {
                                        inputContainer.style.display = "block";
                                        inputField.value = "";
                                        hiddenFinal.value = "";
                                        inputField.oninput = function () {
                                            hiddenFinal.value = this.value;
                                        };
                                    } else {
                                        inputContainer.style.display = "none";
                                        hiddenFinal.value = option; // "N/A"
                                    }
                                }
                                </script>

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
                                                                output += <option value="${data[row].nama_ruangan}">${data[row].nama_ruangan}</option>;
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
                        </div>
                    </div>
                </div>
            </div>
        </div><!--end row-->




    </div><!-- container -->

</div> <!-- Page content Wrapper -->

</div> <!-- content -->
<?php echo view('parsial/footer'); ?>