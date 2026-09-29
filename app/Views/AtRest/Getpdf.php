<!DOCTYPE html>

<head>
    <title>Report Swab</title>
    <style>
        body { font-family: Arial; font-size: 11pt; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 0.5px solid #000; padding: 5px; text-align: center; }
        .noborder, .noborder td { border: none !important; }
        
    </style>
   
</head>

<body>

<!-- DEFINISI HEADER -->
<htmlpageheader name="myHeader">
    <table>
        <tr>
            <td style="width: 25%;">
                <img src="<?= $imageSrc ?>" alt="Logo" height="60">
            </td>
            <td style="width: 75%; font-size: 14pt;"><strong>Pemantauan Ruangan (EHM)</strong></td>
        </tr>
    </table>

    <table class="noborder" style="margin-bottom: 2px;">
        <tr>
            <td style="width: 10%; text-align: left;">Unit AHU</td>
            <td style="width: 10%; text-align: left;">: <?= $Detail_PPOJ['ahu'] ?? '-' ?></td>
            <td style="width: 10%; text-align: left;">Nama Ruangan</td>
            <td style="width: 10%; text-align: left;">: <?= $Detail_PPOJ['nama_ruangan'] ?? '-' ?></td>
        </tr>
        <tr>
            <td style="width: 20%; text-align: left;">Tanggal</td>
            <td style="width: 20%; text-align: left;">: <?= $Detail_PPOJ['tanggaldilakukan'] ?? '-' ?></td>
            <td style="width: 20%; text-align: left;">Site</td>
            <td style="width: 20%; text-align: left;">: <?= $Detail_PPOJ['site'] ?? '-' ?></td>
        </tr>
        
    </table>
</htmlpageheader>

<!-- DEFINISI FOOTER -->
<htmlpagefooter name="myFooter">
    <p style="text-align: left; font-size: 9pt;">
        <strong>Kesimpulan </strong>:
        <?php if ($keterangan[0]['cekKondisi'] >= 1) { ?>
            <span style="color: black;">Memenuhi Syarat</span>
        <?php } else { ?>
            <span style="color: red;">Tidak Memenuhi Syarat</span>
        <?php } ?>
        <br>
    </p>
    <table  style="margin-top: 2px;">
       
        <tr>
            <td style="text-align: center;">
                Disampling oleh<br><br>
                <?php if (!empty($Detail_AHU['approve_1']) && !empty($Detail_AHU['approve_1_date']) && $Detail_AHU['approve_1_date'] != '0000-00-00'): ?>
                    <strong><?= $Detail_AHU['approve_1']; ?></strong><br><?= $Detail_AHU['approve_1_date']; ?>
                <?php else: ?>
                    N/A
                <?php endif; ?>
                <br>(QA Analis)
            </td>
            <td style="text-align: center;">
                Dianalisa oleh<br><br>
                <?php if (!empty($Detail_AHU['approve_2']) && !empty($Detail_AHU['approve_2_date']) && $Detail_AHU['approve_2_date'] != '0000-00-00'): ?>
                    <strong><?= $Detail_AHU['approve_2']; ?></strong><br><?= $Detail_AHU['approve_2_date']; ?>
                <?php else: ?>
                    N/A
                <?php endif; ?>
                <br>(QC Analis)
            </td>
            <td style="text-align: center;">
                Diperiksa oleh<br><br>
                <?php if (!empty($Detail_AHU['approve_3']) && !empty($Detail_AHU['approve_3_date']) && $Detail_AHU['approve_3_date'] != '0000-00-00'): ?>
                    <strong><?= $Detail_AHU['approve_3']; ?></strong><br><?= $Detail_AHU['approve_3_date']; ?>
                <?php else: ?>
                    N/A
                <?php endif; ?>
                <br>(QC Mgr/ QC Spi/ QC Spv)
            </td>
            <td style="text-align: center;">
                Disetujui oleh<br><br>
                <?php if (!empty($Detail_AHU['approve_4']) && !empty($Detail_AHU['approve_4_date']) && $Detail_AHU['approve_4_date'] != '0000-00-00'): ?>
                    <strong><?= $Detail_AHU['approve_4']; ?></strong><br><?= $Detail_AHU['approve_4_date']; ?>
                <?php else: ?>
                    N/A
                <?php endif; ?>
                <br>(QA Mgr/ QA Spi/ QA Spv)
            </td>
        </tr>
    </table>
    <p style="font-size: 9pt; margin-top: 1px;">
        <em>
            *) Coret yang tidak perlu<br>
            - Formulir yang sudah diisi lengkap disimpan pada R. Administrasi QA selama 5 tahun setelah dilakukan sampling.<br>
            - Jika hasil pemantauan diluar dari syarat, lakukan tindakan sesuai dengan WI-QO-QA-8001 dan WI-QO-QA-8002.<br>
            
        </em>
    </p>
    <div style="text-align: center; font-size: 9pt;">
       
        Dokumen ini telah ditandatangani secara elektronik menggunakan aplikasi FUPD Online dengan melampirkan lembar<br>
        persetujuan elektronik milik PT. Bintang Toedjoe (A Kalbe Company)<br>
        <img src="<?= $imageSrcApproved ?>" alt="Logo" height="40" >
    </div>
    <div style="text-align: right; font-size: 9pt;">
        CR-QO-QA-8009.03 (24 Nov 2020)<br>
        Halaman: {PAGENO}/{nbpg}
    </div>
</htmlpagefooter>

<!-- AKTIFKAN HEADER & FOOTER -->
<sethtmlpageheader name="myHeader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myFooter" value="on" />
<?php 
$rowsPerPage = 6;
$totalRows = $JumlahData;
$pages = ceil($totalRows / $rowsPerPage);

for ($p = 0; $p < $pages; $p++): 
    $start = $p * $rowsPerPage;
    $chunk = array_slice($DataSuhuRH, $start, $rowsPerPage);
?>
<table style="margin-top: 0px;">
    <thead>
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
                <td>0.5um</td>
                <td>5.0um</td>
                <td>0.5um</td>
                <td>5.0um</td>
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
                    &lt; 1</td>
                <td>
                    &lt; 1</td>
                <td>
                    &lt; 1</td>
                <td>
                    &lt; 1</td>
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
                <td colspan="2"> &le; 70</td>

                <td>5-20 atau &ge; 20</td>
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
                <td colspan="2">&le; 30</td>

                <td>5-20 atau &ge; 20</td>

            </tr>
    </thead>
 
   <tbody>
<?php foreach ($chunk as $no => $row) : ?>
    <tr>
        <td>X<?= $start + $no + 1 ?></td>
        <td><?= $row['KELAS'] ? $row['KELAS'] : 'N/A' ?></td>
        <td><?= $row['SUHU_MIN'] ? $row['SUHU_MIN'] : 'N/A' ?></td>
        <td><?= $row['SUHU_MAX'] ? $row['SUHU_MAX'] : 'N/A' ?></td>
        <td><?= $row['RH_MIN'] ? $row['RH_MIN'] : 'N/A' ?></td>
        <td><?= $row['RH_MAX'] ? $row['RH_MAX'] : 'N/A' ?></td>
        <td><?= $row['keterangan_dp'] ? $row['keterangan_dp'] : 'N/A' ?></td>
         <td><?= $row['hasil_flow'] ? $row['hasil_flow'] : 'N/A' ?></td>

        





        

        <?php if ($no == 0) { ?>
            <td rowspan="<?= count($chunk) ?>"><?= $Detail_PPOJ['jumlah_pertukaran_udara'] ?></td>
        <?php } ?>

        <?php if ($kondisi == "In Operation") { ?>
            <td>N/A</td>
            <td>N/A</td>
            <?php if ($cekpartikel >= 0) { ?>
                <?php if ($no == 0) { ?>
                    <td colspan="2" rowspan="<?= count($chunk) ?>"> Terlampir </td>
                <?php } ?>
            <?php } else { ?>
                <td>N/A</td>
                <td>N/A</td>
            <?php } ?>
        <?php } ?>

        <?php if ($kondisi == "At Rest") { ?>
            <?php if ($cekpartikel >= 0) { ?>
                <?php if ($no == 0) { ?>
                    <td colspan="2" rowspan="<?= count($chunk) ?>"> Terlampir </td>
                <?php } ?>
            <?php } else { ?>
                <td>N/A</td>
                <td>N/A</td>
            <?php } ?>
            <td>N/A</td>
            <td>N/A</td>
        <?php } ?>

        <td><?= $row['MIKRO_TPC'] !== null ? $row['MIKRO_TPC'] : 'N/A' ?></td>
        <td><?= $row['MIKRO_KK'] !== null ? $row['MIKRO_KK'] : 'N/A' ?></td>
        <td><?= $row['CAPAR_TPC'] !== null ? $row['CAPAR_TPC'] : 'N/A' ?></td>
        <td><?= $row['CAPAR_KK'] !== null ? $row['CAPAR_KK'] : 'N/A' ?></td>

        <?php if ($no == 0) { 
            $status = ($keterangan[0]['cekKondisi'] >= 1) ? 'MS' : 'TMS';
            $color = ($status == 'TMS') ? 'red' : 'black';  // merah kalau TMS, hitam kalau MS
        ?>
            <td rowspan="<?= count($chunk) ?>" style="color: <?= $color ?>;">
                <?= $status ?>
            </td>
        <?php } ?>
    </tr>
<?php endforeach; ?>
</tbody>
</table>
<?php endfor; ?>
</body>
</html>
