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
                                <li class="breadcrumb-item"><a href="<?= base_url() ?>Patogen"><i class="fa fa-home "></i></a></li>
                                <li class="breadcrumb-item"><a href="<?= base_url() ?>Patogen">Data Patogen</a></li>
                                <li class="breadcrumb-item"><a href="#" style="font-weight: bold; color: black; font-size: 14px;">Report Data Patogen</a></li>
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
                                        <a href="<?php echo base_url(); ?>Patogen/DetailPpoj/ <?= $id ?>" class=" btn btn-primary">
                                            Download PDF
                                        </a>
                                    </div>
                                    <div class="card-body table-responsive">
                                        <table border="1" style="width: 100%; text-align: center;">
                                            <tr>
                                                <th style="width: 25%;"><img src="<?php echo base_url('assets/images/logo-b7.png'); ?>" alt="" height="75" class="auth-logo logo-dark mx-auto"></th>
                                                <th style="width: 75%; font-size: 20px;">Laporan Pemeriksaan Patogen Ruangan (EHM)
                                                </th>
                                            </tr>
                                        </table>
                                        <br>

                                        <div class="row mb-0">
                                            <div class="col-sm-6">
                                                <dl class="row">


                                                        <dt class="col-sm-4">Tanggal </dt>
                                                        <dt class="col-sm-8">: <?= $Detail_AHU['tanggaldilakukan'] ?></dt>


                                                        <dt class="col-sm-4">Site </dt>
                                                        <dt class="col-sm-8">: <?= $Detail_AHU['site'] ?></dt>
                                                    </dl>
                                            </div>
                                        </div>



                                        <table border="1" style='width: 100%; text-align:center;'>

                                            <tr>
                                                <th style="width: 25%;" colspan="2" rowspan="3">Area Sampling</th>
                                                <th style="width: 65%;" colspan="7" rowspan="1">Patogen</th>
                                                <th style="width: 10%;" rowspan="5">Kesimpulan (MS/TMS)</th>

                                            </tr>

                                            <tr>
                                                <td style="width: 9%;" colspan="1">E.Coli</td>
                                                <td style="width: 11%;" colspan="1">Salmonella sp.</td>
                                                <td style="width: 12%;" colspan="1">Staphylococcus aureus</td>
                                                <td style="width: 10%;" colspan="1">Pseudomonas aeruginosa</td>
                                                <td style="width: 10%;" colspan="1">Shigella sp. </td>
                                                <td style="width: 13%;" colspan="1">Enterobacteriaceae</td>
                                                <td style="width: 25%;" colspan="1">Clostridia sporogens</td>


                                            </tr>

                                            <tr>
                                                <th colspan="7" rowspan="1">Kriteria Penerimaan (WI-QO-QA-8001 & WI-QO-QA-8002)</th>

                                            </tr>

                                            <tr>
                                                <th rowspan="1">Nama Ruangan</th>
                                                <th rowspan="1">Titik Sampling</th>
                                                <th colspan="7" rowspan="1">Negatif</th>

                                            </tr>

                                            <tr>
                                                <th colspan="2" rowspan="1">Tanggal Sampling</th>
                                                <th colspan="7" rowspan="1" style="text-align: left;">: <?= $Detail_AHU['tanggaldilakukan'] ?></th>
                                            </tr>
                                            
                                            <?php foreach($dataPatogen as $ptg)  : ?>
                                            <tr>
                                            
                                                <td><?= $ptg['nama_ruangan'] ?></td>
                                                <td>X1</td>
                                                <td><?= $ptg['e_coli'] ?></td>
                                                <td><?= $ptg['salmonella_sp'] ?></td>
                                                <td><?= $ptg['staphylococcus_aureus'] ?></td>
                                                <td><?= $ptg['pseudomonas_aeruginosa'] ?></td>
                                                <td><?= $ptg['shigella_sp'] ?></td>
                                                <td><?= $ptg['enterobacteriaceae'] ?></td>
                                                <td><?= $ptg['clostridia_sporogens'] ?></td>
                                                <td style="color: <?= ($ptg['keterangan'] === 'TMS') ? 'red' : 'black' ?>">
                                                    <?= $ptg['keterangan'] ?>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>

                                            <!-- Isi nya disiini      -->


                                        </table>

                                    </div>
                                    <!-- end tableresponsive -->
                                    <div class="card-body table-responsive">
                                        <table border="1" style="width: 100%; text-align: center;">
                                            <tr>
                                                <td style="width: 25%;">Disampling oleh <br><br><?= $Detail_AHU['approve_1']; ?> - <?= $Detail_AHU['approve_1_date']; ?>  <br>(QA Analyst)</td>
                                                <td style="width: 25%;">Dianalisa oleh <br><br><?= $Detail_AHU['approve_2']; ?> - <?= $Detail_AHU['approve_2_date']; ?>  <br> (QA Analyst / QC Analyst)</td>
                                                <td style="width: 25%;">Diperiksa oleh <br><br><?= $Detail_AHU['approve_3']; ?> - <?= $Detail_AHU['approve_3_date']; ?> <br> (QC Spv/Spi/Mgr)</td>
                                                <td style="width: 25%;">Disetujui oleh <br><br><?= $Detail_AHU['approve_4']; ?> - <?= $Detail_AHU['approve_4_date']; ?> <br> (QA Spv/Spi/Mgr)</td>
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