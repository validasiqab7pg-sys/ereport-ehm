<!DOCTYPE html>
<html>
<head>
    <title>Report Swab</title>
    <style>
        body { font-family: Arial; font-size: 9pt; }
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
            <td style="width: 75%; font-size: 14pt;"><strong>Personnel and Machine Hygiene Monitoring</strong></td>
        </tr>
    </table>

    <table class="noborder" style="margin-bottom: 2px;">>
        <tr>
            <td style="width: 10%; text-align: left;">Tanggal Sampling</td>
            <td style="width: 10%; text-align: left;">: <?= $dataHeader['tanggal_sampling'] ?? '-' ?></td>
            <td style="width: 10%; text-align: left;">Nama Ruangan</td>
            <td style="width: 10%; text-align: left;">: <?= $Detail_AHU['nama_ruangan'] ?? '-' ?></td>
        </tr>
        <tr>
            <td style="width: 20%; text-align: left;">Tanggal Analisa Sampel</td>
            <td style="width: 20%; text-align: left;">: <?= $dataHeader['tgl_analisa'] ?? '-' ?></td>
            <td style="width: 20%; text-align: left;">Departemen</td>
            <td style="width: 20%; text-align: left;">: <?= $Detail_AHU['departemen'] ?? '-' ?></td>
        </tr>
        <tr>
            <td style="width: 20%; text-align: left;">Site</td>
            <td style="width: 20%; text-align: left;">: <?= $Detail_AHU['site'] ?? '-' ?></td>
            <td style="width: 20%; text-align: left;">Kelas Kebersihan</td>
            <td style="width: 20%; text-align: left;">: <?= $Detail_AHU['kelas'] ?? '-' ?></td>
        </tr>
    </table>
</htmlpageheader>

<!-- DEFINISI FOOTER -->
<htmlpagefooter name="myFooter">
    <p style="text-align: left; font-size: 9pt;">
       
            <strong>Keterangan </strong>: Tulisan (-) artinya negatif, (+) artinya positif, dan N/A artinya tidak dilakukan pemeriksaan<br>
    </p>
    <table  style="margin-top: 2px;">
       
        <tr>
            <td style="text-align: center;">
                Disampling oleh<br><br><strong><?= $Detail_Approve['approve_1'] ?? '-' ?></strong><br><?= $Detail_Approve['approve_1_date'] ?? '-' ?><br>(QA Analis)
            </td>
            <td style="text-align: center;">
                Dianalisa oleh<br><br><strong><?= $Detail_Approve['approve_2'] ?? '-' ?></strong><br><?= $Detail_Approve['approve_2_date'] ?? '-' ?><br>(QC Analis)
            </td>
            <td style="text-align: center;">
                Diperiksa oleh<br><br><strong><?= $Detail_Approve['approve_3'] ?? '-' ?></strong><br><?= $Detail_Approve['approve_3_date'] ?? '-' ?><br>(QC Mgr/ QC Spi/ QC Spv)
            </td>
            <td style="text-align: center;">
                Disetujui oleh<br><br><strong><?= $Detail_Approve['approve_4'] ?? '-' ?></strong><br><?= $Detail_Approve['approve_4_date'] ?? '-' ?><br>(QA Mgr/ QA Spi/ QA Spv)
            </td>
        </tr>
    </table>
    <p style="font-size: 9pt; margin-top: 1px;">
        <em>
            *) Coret yang tidak perlu<br>
            - Formulir yang sudah diisi lengkap disimpan pada R. Administrasi QA selama 5 tahun setelah dilakukan sampling.<br>
            - Jika hasil pemantauan diluar dari syarat, lakukan tindakan sesuai dengan WI-QO-QA-8001 dan WI-QO-QA-8002.<br>
            - Nama ruangan diisi nama ruangan area swab.
        </em>
    </p>
    <div style="text-align: center; font-size: 9pt;">
       
        Dokumen ini telah ditandatangani secara elektronik menggunakan aplikasi FUPD Online dengan melampirkan lembar<br>
        persetujuan elektronik milik PT. Bintang Toedjoe (A Kalbe Company)<br>
        <img src="<?= $imageSrcApproved ?>" alt="Logo" height="40" >
    </div>
    <div style="text-align: right; font-size: 9pt;">
        CR-QO-QA-2012.02 (26 Jan 2022)<br>
        Halaman: {PAGENO}/{nbpg}
    </div>
</htmlpagefooter>

<!-- AKTIFKAN HEADER & FOOTER -->
<sethtmlpageheader name="myHeader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myFooter" value="on" />

<table style="margin-top: 0px;">
    <thead>
        <tr>
            <th>Nama Personil/ Alat/ Mesin/ Bahan Kemas</th>
            <th>Tanggal Dibersihkan Terakhir</th>
            <th>Lokasi Sampling</th>
            <th>TAMC</th>
            <th>TYMC</th>
            <th>E. coli</th>
            <th>Salmonella sp.</th>
            <th>Pseudomonas aeruginosa</th>
            <th>Staphylococcus aureus</th>
            <th>Shigella sp.</th>
            <th>Enterobacteriaceae</th>
            <th>Clostridia sporogens</th>
            <th>Kesimpulan (MS/TMS)</th>
        </tr>
        <tr>
            <td colspan="13" style="text-align: left;"><strong>Tanggal Perhitungan Koloni :</strong> <?= $dataHeader['tgl_koloni'] ?? '-' ?></td>
        </tr>
        <tr>
            <td colspan="3"><strong>Syarat</strong></td>
            <td>≤ 80 CFU/25 cm²</td>
            <td>≤ 80 CFU/25 cm²</td>
            <td>Negatif</td>
            <td>Negatif</td>
            <td>Negatif</td>
            <td>Negatif</td>
            <td>Negatif</td>
            <td>Negatif</td>
            <td>Negatif</td>
            <td></td>
        </tr>
    </thead>
 
    <tbody>
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

</body>
</html>
