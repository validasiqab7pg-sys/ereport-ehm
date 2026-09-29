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
                                <li class="breadcrumb-item"><a href="<?= base_url() ?>DataPpojSwab"><i class="fa fa-home "></i></a></li>
                                <li class="breadcrumb-item"><a href="<?= base_url() ?>DataPpojSwab/ViewDetail/<?= $Detail_AHU['id_swab'] ?>">Data Swab Personnel & Machine Hygiene</a></li>
                                <li class="breadcrumb-item"><a href="#" style="font-weight: bold; color: black; font-size: 14px;">Report Data Swab</a></li>
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
                                        <a href="<?php echo base_url(); ?>PatogenSwab/DetailPpoj/ <?= $id ?>" class=" btn btn-primary">
                                            Download PDF
                                        </a>
                                    </div>
                                    <div class="card-body table-responsive">
                                        <table border="1" style="width: 100%; text-align: center; border-collapse: collapse;">
                                            <tr>
                                                <td style="width: 25%;">
                                                    <img src="<?= base_url('assets/images/logo-b7.png'); ?>" alt="Logo" height="75">
                                                </td>
                                                <td style="width: 75%; font-size: 20px;">
                                                    <strong>Personnel and Machine Hygiene Monitoring</strong>
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- Informasi Umum -->
                                        <table style="width: 100%; margin-top: 10px;">
                                            <tr>
                                                <td style="width: 20%;">Tanggal Sampling</td>
                                                <td style="width: 30%;">: <?= $dataHeader['tanggal_sampling'] ?? '-' ?></td>
                                                <td style="width: 20%;">Nama Ruangan</td>
                                                <td style="width: 30%;">: <?= $Detail_AHU['nama_ruangan'] ?? '-' ?></td>
                                            </tr>
                                            <tr>
                                                <td>Tanggal Analisa Sampel</td>
                                                <td>: <?= $dataHeader['tgl_analisa'] ?? '-' ?></td>
                                                <td>Departemen</td>
                                                <td>: <?= $Detail_AHU['departemen'] ?? '-' ?></td>
                                            </tr>
                                            <tr>
                                                <td>Site</td>
                                                <td>: <?= $Detail_AHU['site'] ?? '-' ?></td>
                                                <td>Kelas Kebersihan</td>
                                                <td>: <?= $Detail_AHU['kelas'] ?? '-' ?></td>
                                            </tr>
                                        </table>

                                        <!-- Tabel Utama -->
                                        <table border="1" style="width: 100%; margin-top: 15px; text-align: center; font-size: 13px; border-collapse: collapse;">
                                            <thead>
                                                <tr>
                                                    <th rowspan="2">Nama Personil/ Alat/ Mesin/ Bahan Kemas</th>
                                                    <th rowspan="2">Tanggal Dibersihkan Terakhir</th>
                                                    <th rowspan="2">Lokasi Sampling</th>
                                                    <th rowspan="2">TAMC</th>
                                                    <th rowspan="2">TYMC</th>
                                                    <th rowspan="2">E. coli</th>
                                                    <th rowspan="2">Salmonella sp.</th>
                                                    <th rowspan="2">Pseudomonas aeruginosa</th>
                                                    <th rowspan="2">Staphylococcus aureus</th>
                                                    <th rowspan="2">Shigella sp.</th>
                                                    <th rowspan="2">Enterobacteriaceae</th>
                                                    <th rowspan="2">Clostridia sporogens</th>
                                                    <th rowspan="2">Kesimpulan (MS/TMS)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th colspan="12" style="text-align: left; padding-left: 20px;" ><strong>Tanggal Perhitungan Koloni :</strong> <?= $dataHeader['tgl_koloni'] ?? '-' ?></th>
                                                    <td rowspan="2"></td>       
                                                </tr>
                                                <tr>
                                                    <td colspan="3">Syarat</td>
                                                    <td>≤ 80 CFU/25 cm²</td>
                                                    <td>≤ 80 CFU/25 cm²</td>
                                                    <td>Negatif</td>
                                                    <td>Negatif</td>
                                                    <td>Negatif</td>
                                                    <td>Negatif</td>
                                                    <td>Negatif</td>
                                                    <td>Negatif</td>
                                                    <td>Negatif</td>
                                                
                                                </tr>

                                                <!-- Data -->
                                                <?php foreach ($dataPatogen as $ptg): ?>
                                                <tr>
                                                    <td><?= $ptg['nama_mesin_personil_alat'] ?></td>
                                                    <td><?= $ptg['tanggal_dibersihkan'] ?></td>
                                                    <td><?= $ptg['lokasi_sampling'] ?></td>
                                                    <td><?= $ptg['TAMC'] ?></td>
                                                    <td><?= $ptg['TYMC'] ?></td>
                                                    <td><?= $ptg['e_coli'] ?></td>
                                                    <td><?= $ptg['salmonella_sp'] ?></td>
                                                    <td><?= $ptg['pseudomonas_aeruginosa'] ?></td>
                                                    <td><?= $ptg['staphylococcus_aureus'] ?></td>
                                                    <td><?= $ptg['shigella_sp'] ?></td>
                                                    <td><?= $ptg['enterobacteriaceae'] ?></td>
                                                    <td><?= $ptg['clostridia_sporogens'] ?></td>
                                                    <td style="color: <?= ($ptg['keterangan'] === 'TMS') ? 'red' : 'black' ?>">
                                                    <?= $ptg['keterangan'] ?>
                                                    </td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>

                                        <!-- Keterangan -->
                                        <p style="margin-top: 10px;">
                                            <strong>Keterangan:</strong> Tulisan (-) artinya negatif, (+) artinya positif, dan N/A artinya tidak dilakukan pemeriksaan
                                        </p>

                                        <!-- Kolom TTD -->
                                        <table border="1" style="width: 100%; text-align: center; margin-top: 20px; border-collapse: collapse;">
                                            <tr>
                                                <td>Disampling oleh<br><br><strong><?= $Detail_Approve['approve_1'] ?? '-' ?></strong><br><?= $Detail_Approve['approve_1_date'] ?? '-' ?><br>(QA Analis)</td>
                                                <td>Dianalisa oleh<br><br><strong><?= $Detail_Approve['approve_2'] ?? '-' ?></strong><br><?= $Detail_Approve['approve_2_date'] ?? '-' ?><br>(QC Analis)</td>
                                                <td>Diperiksa oleh<br><br><strong><?= $Detail_Approve['approve_3'] ?? '-' ?></strong><br><?= $Detail_Approve['approve_3_date'] ?? '-' ?><br>(QC Mgr/ QC Spi/ QC Spv)</td>
                                                <td>Disetujui oleh<br><br><strong><?= $Detail_Approve['approve_4'] ?? '-' ?></strong><br><?= $Detail_Approve['approve_4_date'] ?? '-' ?><br>(QA Mgr/ QA Spi/ QA Spv)</td>
                                            </tr>
                                        </table>

                                        <!-- Footer -->
                                        <p style="margin-top: 10px;">
                                            <em>
                                            *) Coret yang tidak perlu<br>
                                            - Formulir yang sudah diisi lengkap disimpan pada R. Administrasi QA selama 5 tahun setelah dilakukan sampling.<br>
                                            - Jika hasil pemantauan diluar dari syarat, lakukan tindakan sesuai dengan WI-QO-QA-8001 dan WI-QO-QA-8002.<br>
                                            - Nama ruangan diisi nama ruangan area swab.
                                            </em>
                                        </p>
                                        <table>
                                            <tr>
                                            <td>
                                            <div style="text-align: center; margin-top: 10px; ">
                                                <p>Dokumen ini telah ditandatangani secara elektronik menggunakan aplikasi FUPD Online dengan melampirkan lembar persetujuan elektronik milik PT. Bintang Toedjoe (A Kalbe Company)</p>
                                                <img src="<?= base_url('assets/images/approved2.jpg'); ?>" alt="Approved" height="50">
                                            </div>
                                            </td>
                                            <td>
                                            <div style="text-align: right; margin-top: 2;">
                                            <p>CR-QO-QA-2012.02 (26 Jan 2022)</p>
                                            <p>Halaman : 1/1</p>
                                            </div>
                                            </td>
                                            </tr>
                                        </table>
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
    </div>
    </div>
    <!-- END layout-wrapper -->
    <?php echo view('parsial/footer'); ?>