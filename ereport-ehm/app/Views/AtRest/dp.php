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
            <!--            <h4 class="mb-0">Data Differential Pressure</h4>-->

            <!--            <div class="page-title-right">-->
            <!--                <ol class="breadcrumb m-0">-->
                                <!-- <li class="breadcrumb-item"><a href="javascript: void(0);">D</a></li> -->
            <!--                    <li class="breadcrumb-item active">Data Differential Pressure</li>-->
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
                  <li class="breadcrumb-item"><a href="<?= base_url() ?>Dp" style="font-weight: bold; color: black; font-size: 14px;">Data Differential Pressure</a></li>
                  <!--<li class="breadcrumb-item"><a href="#">Detail Data Cemaran Mikroba Cawan Papar</a></li>-->
                  <!--<li class="breadcrumb-item"><a href="#" style="font-weight: bold; color: black; font-size: 14px;">Add Data Cemaran Mikroba Cawan Papar</a></li>-->
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
                    
                            <h4 class="card-title mb-4">Data Differential Pressure</h4>
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
                                            <?php if ($row['statusDp'] == 0 || $row['statusDp'] == null) { ?>
                                                <div class="badge bg-secondary">On Progress</div>
                                            <?php }
                                            if ($row['statusDp'] == 1) { ?>
                                                <div class="badge bg-success">Selesai</div>
                                            <?php } ?>

                                        </td>
                                            <td>
                                                <div class="btn-group btn-group-sm" style="float: none;">
                                                  
                                                <a href="<?= base_url() ?>Dp/ViewDetail/<?= $row['id'] ?>" class="tabledit-delete-button btn btn-sm btn-primary" style="float: none; margin: 5px;">
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