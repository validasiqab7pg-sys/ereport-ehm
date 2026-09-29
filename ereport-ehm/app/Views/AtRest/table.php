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
            <!--            <h4 class="mb-0">E Report Pemantauan Ruangan (EHM)</h4>-->

            <!--            <div class="page-title-right">-->
            <!--                <ol class="breadcrumb m-0">-->
            <!-- <li class="breadcrumb-item"><a href="javascript: void(0);">D</a></li> -->
            <!--                    <li class="breadcrumb-item active">Sample</li>-->
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
                                <li class="breadcrumb-item"><a href="<?= base_url() ?>DataPpoj">Data Kualifikasi dan EHM</a></li>
                                <li class="breadcrumb-item"><a href="<?= base_url() ?>DataPpoj/ViewDetail/<?= $Detail_PPOJ['id_ahu'] ?>">Detail Data Kualifikasi dan EHM</a></li>
                                <li class="breadcrumb-item"><a href="#" style="font-weight: bold; color: black; font-size: 14px;">Report Data Kualifikasi dan EHM</a></li>
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



                                    <!-- end dropdown -->
                                    <h4 class="card-title mb-4">E Report</h4>
                                    <div class="d-flex flex-row-reverse bd-highlight">
                                        <a href="<?php echo base_url(); ?>DataPpoj/DetailPpoj/ <?= $id ?>"" class=" btn btn-primary">
                                            Download PDF
                                        </a>
                                    </div>
                                    <div class="card-body table-responsive">
                                        <table border="1" style="width: 100%; text-align: center;">
                                            <tr>
                                                <th style="width: 25%;"><img src="<?php echo base_url('assets/images/logo-b7.png'); ?>" alt="" height="75" class="auth-logo logo-dark mx-auto"></th>
                                                <th style="width: 75%; font-size: 20px;">Pemantauan Ruangan (EHM)</th>
                                            </tr>
                                        </table>
                                        <br>

                                        <div class="row mb-0">
                                            <div class="col-sm-6">
                                                <dl class="row">
                                                    <dt class="col-sm-4">Unit AHU </dt>
                                                    <dt class="col-sm-8">: <?= $Detail_PPOJ['ahu'] ?></dt>

                                                    <dt class="col-sm-4">Tanggal </dt>
                                                    <dt class="col-sm-8">: <?= $Detail_PPOJ['tanggaldilakukan'] ?></dt>
                                                </dl>
                                            </div>

                                            <div class="col-sm-6">
                                                <dl class="row">
                                                    <dt class="col-sm-4">Nama Ruangan </dt>
                                                    <dt class="col-sm-8">: <?= $Detail_PPOJ['nama_ruangan'] ?></dt>
                                                    <dt class="col-sm-4">Site </dt>
                                                    <dt class="col-sm-8">: <?= $Detail_PPOJ['site'] ?></dt>
                                                </dl>
                                            </div>
                                        </div>



                                        <table border="1" style='text-align:center;'>

                                            <tr>
                                                <th rowspan="8">Titik Sampling</th>
                                                <th rowspan="3" style="width: 70px;">Kelas</th>
                                                <th colspan="2" rowspan="2">Suhu</th>
                                                <th colspan="2" rowspan="2">RH</th>
                                                <th rowspan="3">Perbedaan Tekanan Ruangan (Pa)</th>
                                                <th rowspan="8">Flow CFM</th>
                                                <th rowspan="3">Jumlah Pertukaran Udara</th>
                                                <th rowspan="1" colspan="4">Jumlah Partikel Maks. (counts/m3)</th>
                                                <th colspan="2" rowspan="2">Mikroba Volumetrik</th>
                                                <th colspan="2" rowspan="2">Mikroba Cawan Papar</th>
                                                <th rowspan="8">Kesimpulan</th>

                                            </tr>

                                            <tr>
                                                <td colspan="2">At Rest</td>
                                                <td colspan="2">In Operation</td>


                                            </tr>

                                            <tr>
                                                <td>Min</td>
                                                <td>Max</td>
                                                <td>Min</td>
                                                <td>Max</td>
                                                <td>0.5µm</td>
                                                <td>5.0µm</td>
                                                <td>0.5µm</td>
                                                <td>5.0µm</td>
                                                <td>TPC</td>
                                                <td>KK</td>
                                                <td>TPC</td>
                                                <td>KK</td>
                                            </tr>

                                            <tr>
                                                <td>A</td>
                                                <td>16</td>
                                                <td>25</td>
                                                <td>45</td>
                                                <td>55</td>
                                                <td rowspan="5">Ruangan Berbeda Kelas : Min 10 <br><br>
                                                    Kelas Kebersihan sama : 5 - 20</td>
                                                <td>Min. 500</td>
                                                <td>3.520</td>
                                                <td>20</td>
                                                <td>3.520</td>
                                                <td>20</td>
                                                <td>
                                                    < 1</td>
                                                <td>
                                                    < 1</td>
                                                <td>
                                                    < 1</td>
                                                <td>
                                                    < 1</td>
                                            </tr>

                                            <tr>
                                                <td>C</td>
                                                <td>16</td>
                                                <td>25</td>
                                                <td>45</td>
                                                <td>55</td>
                                                <td>Min. 20</td>
                                                <td>352.000</td>
                                                <td>2.900</td>
                                                <td>352.000</td>
                                                <td>29.000</td>
                                                <td>100</td>
                                                <td>50</td>
                                                <td>50</td>
                                                <td>25</td>

                                            </tr>
                                            <tr>
                                                <td>D</td>
                                                <td>20</td>
                                                <td>27</td>
                                                <td>40</td>
                                                <td>60</td>
                                                <td>5-20 atau ≥ 20</td>
                                                <td>3.520.000</td>
                                                <td>29.000</td>
                                                <td>N/A</td>
                                                <td>N/A</td>
                                                <td>200</td>
                                                <td>100</td>
                                                <td>100</td>
                                                <td>50</td>
                                            </tr>
                                            <tr>
                                                <td>E</td>
                                                <td>20</td>
                                                <td>27</td>
                                                <td colspan="2">≤ 70</td>

                                                <td>5-20 atau ≥ 20</td>
                                                <td rowspan="2">3.520.000</td>
                                                <td rowspan="2">29.000</td>
                                                <td rowspan="2">N/A</td>
                                                <td rowspan="2">N/A</td>
                                                <td rowspan="2">300</td>
                                                <td rowspan="2">100</td>
                                                <td rowspan="2">N/A</td>
                                                <td rowspan="2">N/A</td>
                                            </tr>
                                            <tr>
                                                <td>E Khusus</td>
                                                <td>16</td>
                                                <td>25</td>
                                                <td colspan="2">≤ 30</td>

                                                <td>5-20 atau ≥ 20</td>

                                            </tr>

                                            <!-- Isi nya disiini      -->

                                            <?php foreach ($DataSuhuRH as $no => $row) :  ?>
                                                <tr>
                                                    <td>X<?= $no + 1 ?></td>
                                                    <td> <?= ($row['KELAS']) ? $row['KELAS'] : 'N/A' ?></td>
                                                    <td> <?= ($row['SUHU_MIN']) ? $row['SUHU_MIN'] : 'N/A' ?></td>
                                                    <td> <?= ($row['SUHU_MAX']) ? $row['SUHU_MAX'] : 'N/A' ?></td>
                                                    <td> <?= ($row['RH_MIN']) ? $row['RH_MIN'] : 'N/A' ?></td>
                                                    <td> <?= ($row['RH_MAX']) ? $row['RH_MAX'] : 'N/A' ?></td>
                                                    <td><?= $row['keterangan_dp'] ? $row['keterangan_dp'] : 'N/A' ?></td>
                                                    <td><?= $row['hasil_flow'] ? $row['hasil_flow'] : 'N/A' ?></td>
                                                                                                
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    <!-- END cek hasil flow -->
                                                    <!-- Untuk cek Pertukaran Udara -->
                                                    <?php if (0 >= $no) { ?>
                                                        <td rowspan="<?= $JumlahData  ?>"><?= $Detail_PPOJ['jumlah_pertukaran_udara'] ?></td>
                                                    <?php } ?>
                                                    <!-- END cek Pertukaran udara -->
                                                    <?php if ($kondisi == "In Operation") { ?>
                                                        <td>N/A</td>
                                                        <td>N/A </td>
                                                        <?php if ($cekpartikel >= 0) { ?>
                                                            <?php if (0 >= $no) {  ?>

                                                                <td colspan="2" rowspan="<?= $JumlahData ?>"> Terlampir </td>
                                                            <?php }
                                                        } else { ?>
                                                            <td>N/A</td>
                                                            <td>N/A</td>
                                                        <?php } ?>

                                                    <?php }
                                                    if ($kondisi == "At Rest") { ?>

                                                        <?php if ($cekpartikel >= 0) { ?>
                                                            <?php if (0 >= $no) {  ?>
                                                                <td colspan="2" rowspan="<?= $JumlahData ?>"> Terlampir </td>
                                                            <?php } ?>
                                                        <?php
                                                        } else { ?>
                                                            <td>N/A</td>
                                                            <td>N/A</td>
                                                        <?php } ?>

                                                        <td>N/A</td>
                                                        <td>N/A</td>
                                                    <?php } ?>
                                                    
                                                  
                                                    <td> <?= $row['MIKRO_TPC'] != null ? $row['MIKRO_TPC'] : 'N/A' ?></td>
                                                    <td> <?= $row['MIKRO_KK'] != null ? $row['MIKRO_KK'] : 'N/A' ?></td>
                                                    <td> <?= $row['CAPAR_TPC'] != null ? $row['CAPAR_TPC'] : 'N/A' ?></td>
                                                    <td> <?= $row['CAPAR_KK'] != null ? $row['CAPAR_KK'] : 'N/A' ?></td>
                                                    
                                                    
                                                    <?php if (0 >= $no) { ?>
                                                        <td rowspan="<?= $JumlahData ?>"> 
                                                         <?php if($keterangan[0]['cekKondisi'] >= 1) { ?>
                                                            MS
                                                        <?php  } else { ?>
                                                        
                                                        TMS
                                                        <?php }?>
                                                        </td>
                                                    <?php } ?>
                                                </tr>
                                            <?php endforeach; ?>
                                        </table>

                                    </div>
                                    <!-- end tableresponsive -->
                                    <div class="card-body table-responsive">
                                      <table border="1" style="width: 100%; text-align: center;">
                                        <tr>
                                            <td style="width: 25%;">
                                                Disampling oleh <br><br>
                                                <?php
                                                    if (!empty($Detail_AHU['approve_1']) && $Detail_AHU['approve_1_date'] != '0000-00-00' && !empty($Detail_AHU['approve_1_date'])) {
                                                        echo $Detail_AHU['approve_1'] . ' - ' . $Detail_AHU['approve_1_date'];
                                                    } else {
                                                        echo 'N/A';
                                                    }
                                                ?>
                                                <br>(QA Analyst)
                                            </td>
                                            <td style="width: 25%;">
                                                Dianalisa oleh <br><br>
                                                <?php
                                                    if (!empty($Detail_AHU['approve_2']) && $Detail_AHU['approve_2_date'] != '0000-00-00' && !empty($Detail_AHU['approve_2_date'])) {
                                                        echo $Detail_AHU['approve_2'] . ' - ' . $Detail_AHU['approve_2_date'];
                                                    } else {
                                                        echo 'N/A';
                                                    }
                                                ?>
                                                <br>(QA Analyst / QC Analyst)
                                            </td>
                                            <td style="width: 25%;">
                                                Diperiksa oleh <br><br>
                                                <?php
                                                    if (!empty($Detail_AHU['approve_3']) && $Detail_AHU['approve_3_date'] != '0000-00-00' && !empty($Detail_AHU['approve_3_date'])) {
                                                        echo $Detail_AHU['approve_3'] . ' - ' . $Detail_AHU['approve_3_date'];
                                                    } else {
                                                        echo 'N/A';
                                                    }
                                                ?>
                                                <br>(QC Spv/Spi/Mgr)
                                            </td>
                                            <td style="width: 25%;">
                                                Disetujui oleh <br><br>
                                                <?php
                                                    if (!empty($Detail_AHU['approve_4']) && $Detail_AHU['approve_4_date'] != '0000-00-00' && !empty($Detail_AHU['approve_4_date'])) {
                                                        echo $Detail_AHU['approve_4'] . ' - ' . $Detail_AHU['approve_4_date'];
                                                    } else {
                                                        echo 'N/A';
                                                    }
                                                ?>
                                                <br>(QA Spv/Spi/Mgr)
                                            </td>
                                        </tr>
                                    </table>
                                    </div>
                                    <div style="text-align: center; padding: 10px 0;">
                                        <p style="margin: 0;">Dokumen ini telah ditandatangani secara elektronik menggunakan aplikasi FUPD Online dengan
                                            melampirkan lembar</p>
                                        <p style="margin: 0;">persetujuan elektronik milik PT. Bintang Toedjoe (A Kalbe Company)</p>
                                        
                                        <p style="margin: 0;"><img src="<?php echo base_url('assets/images/approved2.jpg'); ?>" alt="" height="50" class="auth-logo logo-dark mx-auto"></p>
                                    </div>
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