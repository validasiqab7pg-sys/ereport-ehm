<!DOCTYPE html>
<html>
<head>
    <title>Report Patogen</title>
    <style>
        body { font-family: Arial; font-size: 9pt; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 0.5px solid #000; padding: 5px; text-align: center; }
        th { font-weight: normal; } 
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
            <td style="width: 75%; font-size: 14pt;"><strong>Laporan Pemeriksaan Patogen Ruangan (EHM)</strong></td>
        </tr>
    </table>

    <table class="noborder" style="margin-bottom: 2px;">>
        <tr>
            <td style="width: 10%; text-align: left;">Tanggal </td>
            <td style="width: 10%; text-align: left;">: <?= $Detail_AHU['tanggaldilakukan'] ?? '-' ?></td>
            
        </tr>
        <tr>
            <td style="width: 20%; text-align: left;">Site</td>
            <td style="width: 20%; text-align: left;">: <?= $Detail_AHU['site'] ?? '-' ?></td>
           
        </tr>

    </table>
</htmlpageheader>

<!-- DEFINISI FOOTER -->
<htmlpagefooter name="myFooter">
    <p style="text-align: left; font-size: 9pt;">
       
            <strong>Catatan </strong>:<br>
    </p>
    <table  style="margin-top: 2px;">
       
        <tr>
            <td style="text-align: center;">
                Disampling oleh<br><br><strong><?= $Detail_AHU['approve_1'] ?? '-' ?></strong><br><?= $Detail_AHU['approve_1_date'] ?? '-' ?><br>(QA Analis)
            </td>
            <td style="text-align: center;">
                Dianalisa oleh<br><br><strong><?= $Detail_AHU['approve_2'] ?? '-' ?></strong><br><?= $Detail_AHU['approve_2_date'] ?? '-' ?><br>(QC Analis)
            </td>
            <td style="text-align: center;">
                Diperiksa oleh<br><br><strong><?= $Detail_AHU['approve_3'] ?? '-' ?></strong><br><?= $Detail_AHU['approve_3_date'] ?? '-' ?><br>(QC Mgr/ QC Spi/ QC Spv)
            </td>
            <td style="text-align: center;">
                Disetujui oleh<br><br><strong><?= $Detail_AHU['approve_4'] ?? '-' ?></strong><br><?= $Detail_AHU['approve_4_date'] ?? '-' ?><br>(QA Mgr/ QA Spi/ QA Spv)
            </td>
        </tr>
    </table>
    <p style="font-size: 9pt; margin-top: 1px;">
        <em>
            
            Keterangan: Tulisan (-) artinya negatif, (+) artinya positif, dan N/A artinya tidak dilakukan pemeriksaan; *coret yang tidak perlu<br>
            - Formulir yang sudah diisi lengkap disimpan pada R. Administrasi QA selama 5 tahun setelah dilakukan sampling.<br>
            - Definisi: MS = Memenuhi Syarat; TMS = Tidak Memenuhi Syarat .<br>
            
        </em>
    </p>
    <div style="text-align: center; font-size: 9pt;">
       
        Dokumen ini telah ditandatangani secara elektronik menggunakan aplikasi FUPD Online dengan melampirkan lembar<br>
        persetujuan elektronik milik PT. Bintang Toedjoe (A Kalbe Company)<br>
        <img src="<?= $imageSrcApproved ?>" alt="Logo" height="40" >
    </div>
    <div style="text-align: right; font-size: 9pt;">
        CR-QO-QA-8027.01 (07 Jan 2022)<br>
        Halaman: {PAGENO}/{nbpg}
    </div>
</htmlpagefooter>

<!-- AKTIFKAN HEADER & FOOTER -->
<sethtmlpageheader name="myHeader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myFooter" value="on" />

<table style="margin-top: 0px;">
    <thead>
        <tr>
            <th colspan="2" rowspan="3">Area Sampling</th>
            <th colspan="7">Patogen</th>
            <th rowspan="5">Kesimpulan (MS/TMS)</th>
        </tr>
        <tr>
            <th>E.Coli</th>
            <th>Salmonella sp.</th>
            <th>Staphylococcus aureus</th>
            <th>Pseudomonas aeruginosa</th>
            <th>Shigella sp.</th>
            <th>Enterobacteriaceae</th>
            <th>Clostridia sporogens</th>
        </tr>
        <tr>
            <th colspan="7">Kriteria Penerimaan (WI-QO-QA-8001 & WI-QO-QA-8002)</th>
        </tr>
        <tr>
            <th>Nama Ruangan</th>
            <th>Titik Sampling</th>
            <th colspan="7">Negatif</th>
            
        </tr>
        <tr>
            <th colspan="2">Tanggal Sampling</th>
            <th colspan="7" style="text-align: left;">: <?= $Detail_AHU['tanggaldilakukan'] ?></th>
            
        </tr>
    </thead>
    <tbody>
        <?php foreach ($dataPatogen as $ptg) : ?>
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
            <td><?= $ptg['keterangan'] ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>
