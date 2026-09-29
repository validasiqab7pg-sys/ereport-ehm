<?php echo view('parsial/navbar'); ?>
<?php echo view('parsial/sidebar'); ?>
<!-- Begin page -->
<?php $session = session(); ?>
<div class="page-content-wrapper ">

    <div class="container-fluid">

        <!--<div class="row">-->
        <!--    <div class="col-sm-12">-->
        <!--        <div class="page-title-box">-->
        <!--            <div class="btn-group float-right">-->
        <!--                <ol class="breadcrumb hide-phone p-0 m-0">-->

        <!--                    <li class="breadcrumb-item active">Detail Data Lux</li>-->
        <!--                </ol>-->
        <!--            </div>-->
        <!--            <h4 class="page-title">Detail Data Lux</h4>-->
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
                  <li class="breadcrumb-item"><a href="<?= base_url() ?>Lux">Data Lux</a></li>
                  <li class="breadcrumb-item"><a href="<?= base_url() ?>Lux/ViewDetail/<?= $Detail_Ruangan['id_ahu'] ?>">Detail Data Lux</a></li>
                  <li class="breadcrumb-item"><a href="#" style="font-weight: bold; color: black; font-size: 14px;">Add Data Lux</a></li>
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
                        <form method="POST" action="<?= base_url() ?>Lux/Insert" enctype="multipart/form-data">
                                <div class="modal-content">
                                    <div class="modal-header">

                                        <h5 class="modal-title mt-0">Input Data Lux</h5>
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

                                            <label for="validationCustom04" class="form-label">Nama Analis</label>
                                            <input type="text" class="form-control" name="analis" placeholder="Nama Analis" value="<?= $session->get('username') ?>" disabled>

                                        </div>

                                        <div class="mb-3">

                                           
                                            <h4 class="mt-0 header-title">File Upload </h4>
                                            <p class="text-muted mb-4 font-14"></p>
                                            <input type="file" id="input-file-now" class="dropify" name="file" required/>   
                                        </div>

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

                    <!-- Modal Update -->
                  

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





                    <div class="card-body table-responsive">
                        <!-- Tombol untuk membuka modal -->
                        <button type="button" class="btn btn-primary mt-3 btn-animation" data-animation="slideInUp" style="float:right;" data-toggle="modal" data-target="#exampleModalLong-1">Add Data</button>


                        <h4 class="card-title mb-4">Add Data Lux</h4>
                        <div class="">
                            <table id="datatable2" class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama File</th>
                                      
                                        <!--No PPOJ dibentuk dari gabungan AHU, Site, Nama Ruangan, dan Tanggal-->
                                        <th>Analis</th>
                                      <th>Keterangan</th> 
                                        <!-- <th>Keterangan</th> -->
                                        <th>Action</th>

                                    </tr>
                                </thead>


                                <tbody>

                                    <?php foreach ($List_Lux as $no => $row) :  ?>
                                        <tr>
                                            <td><?= $no + 1 ?></td>

                                            <td> <?= $row['hasil_lux'] ?></td>
                                        
                                            <td> <?= $row['analis'] ?></td>
                                            <td> <?= $row['keterangan'] ?></td>
                                             

                                            <td>
                                                <div class="btn-group btn-group-sm" style="float: none;">


                                                    <div class="btn-group btn-group-sm" style="float: none;">
                                                        
                                                        <a href="<?= base_url() ?>Lux/Delete/<?= $row['id'] ?>" onclick="return confirm('Yakin Ingin menghapus nya ?')" class="tabledit-delete-button btn btn-sm btn-danger" style="float: none; margin: 5px;">
                                                            <span class="ti-trash"></span>
                                                        </a>

                                                    </div>


                                            </td>
                                            <!-- <td style="width: 134px">
                                                    <div class="btn btn-soft-primary btn-sm">View detail<i class="mdi mdi-arrow-right ms-1"></i></div>
                                                </td> -->
                                        </tr>
                                        <!-- Modal Update -->
                                        

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