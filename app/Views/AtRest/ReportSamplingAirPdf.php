<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="<?= base_url('favicon.ico') ?>">
    <title><?= esc($row['jenis_sampling'] ?? 'Report') ?> - <?= esc($row['site'] ?? '') ?> - <?= esc($row['week'] ?? '') ?></title>
    <style>
        body { font-family: Arial; font-size: 9pt; }
        table { border-collapse: collapse; width: 100%; margin-bottom: 4px; }
        th, td { border: 0.5px solid #000; padding: 4px; height: 25px; text-align: center; vertical-align: middle; }
        .noborder, .noborder td { border: none !important; }
        .section-title { font-size: 10pt; font-weight: bold; margin: 10px 0 4px 0; }
        .kelompok-fisika { background-color: #ffffff; }
        .kelompok-kimia  { background-color: #ffffff; }
        .kelompok-mikro  { background-color: #ffffff; }
        .catatan-section { font-size: 8pt; font-style: italic; margin: 0 0 12px 0; }
        /* Baris "Kriteria Penerimaan (kode acuan)" di dalam header tabel, sesuai form resmi */
        .kriteria-row th { font-weight: bold;}
        .info-table td {
            padding: 1px 4px;
            height: auto;
            line-height: 1.2;
        }
    </style>
</head>
<body>

<!-- HEADER: hanya logo + judul, berulang di setiap halaman -->
<htmlpageheader name="myHeader">
    <table>
        <tr>
            <td style="width: 20%;">
                <img src="<?= $imageSrc ?>" alt="Logo" height="60">
            </td>
            <td style="width: 80%; font-size: 18pt; text-align: center;">
                <strong>Laporan Pemeriksaan Air (EHM) <?= esc($row['site'] ?? '-') ?></strong>
            </td>
        </tr>
    </table>
</htmlpageheader>

<sethtmlpageheader name="myHeader" value="on" show-this-page="1" />

<?php
use App\Libraries\ParameterAirDefinition;
$paramDef = ParameterAirDefinition::semua();

// Hitung Bulan & Tahun sekali saja, dipakai berulang di tiap section
$bulanIndo = [
    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
];
$bulanTahunLabel = '-';
if (!empty($row['tanggal_sampling'])) {
    $ts = strtotime($row['tanggal_sampling']);
    if ($ts !== false) {
        $bulanTahunLabel = $bulanIndo[(int)date('n', $ts)] . ' ' . date('Y', $ts);
    }
}

// ================================================================
// DITAMBAHKAN: fungsi cetak footer dinamis (dipanggil per section
// dan juga untuk fallback). Isinya SAMA seperti footer statis
// sebelumnya — hanya kode dokumen, keterangan, dan referensi WI
// yang sekarang ditarik dari ParameterAirDefinition::getFooterConfig()
// berdasarkan site + kategori/jenis sampling, supaya bisa berbeda
// per site dan per jenis sampling. Silakan kustomisasi isi
// footerConfigPerSiteKategori() di ParameterAirDefinition.php nanti.
// ================================================================
$cetakFooter = function (string $footerName, array $footerConfig) use ($row, $imageSrcApproved) {
    ?>
    <htmlpagefooter name="<?= esc($footerName) ?>">

        <table style="margin-top: 2px;">
            <tr>
                <td colspan="5" style="text-align: left; border: 0.5px solid #000; padding: 4px;">
                    Catatan : <?= esc($row['note'] ?? '-') ?>
                </td>
            </tr>
            <tr>
                <td style="text-align: center;">
                    Disampling oleh<br><br>
                    <strong><?= esc($row['approve_1'] ?? '-') ?></strong><br>
                    <?= esc($row['approve_1_date'] ?? '-') ?><br>
                    (QA Analis)
                </td>
                <td style="text-align: center;">
                    Dianalisa Fisika &amp; Kimia<br><br>
                    <strong><?= esc($row['approve_qc_kimia'] ?? '-') ?></strong><br>
                    <?= esc($row['approve_qc_kimia_date'] ?? '-') ?><br>
                    (QC Analis)
                </td>
                <td style="text-align: center;">
                    Dianalisa Mikrobiologi<br><br>
                    <strong><?= esc($row['approve_qc_mikro'] ?? '-') ?></strong><br>
                    <?= esc($row['approve_qc_mikro_date'] ?? '-') ?><br>
                    (QC Analis)
                </td>
                <td style="text-align: center;">
                    Diperiksa oleh<br><br>
                    <strong><?= esc($row['approve_spv_qc'] ?? '-') ?></strong><br>
                    <?= esc($row['approve_spv_qc_date'] ?? '-') ?><br>
                    (QC Mgr/Spi/Spv)
                </td>
                <td style="text-align: center;">
                    Disetujui oleh<br><br>
                    <strong><?= esc($row['approve_spv_qa'] ?? '-') ?></strong><br>
                    <?= esc($row['approve_spv_qa_date'] ?? '-') ?><br>
                    (QA Mgr/Spi/Spv)
                </td>
            </tr>
        </table>

        <p style="text-align: left; font-size: 8pt;">
             - Keterangan : <?= esc($footerConfig['keterangan']) ?>
        </p>
        <p style="font-size: 8pt; margin-top: 1px;">
            <em>
                - <?= esc($footerConfig['catatan_penyimpanan']) ?><br>
                - Jika hasil pemantauan diluar dari syarat, lakukan tindakan sesuai dengan <?= esc($footerConfig['referensi_wi']) ?>.<br>
                - <?= esc($footerConfig['definisi_tamc']) ?>
            </em>
        </p>
        <div style="text-align: right; font-size: 8pt;">
           <?= esc($footerConfig['kode_dokumen']) ?>
        </div>
        <div style="text-align: right; font-size: 8pt;">
            Halaman: {PAGENO}/{nbpg}
        </div>
        <div style="text-align: center; font-size: 8pt;">
            Dokumen ini telah ditandatangani secara elektronik menggunakan aplikasi FUPD Online dengan melampirkan lembar<br>
            persetujuan elektronik milik PT. Bintang Toedjoe (A Kalbe Company)<br>
            <img src="<?= $imageSrcApproved ?>" alt="Approved" height="40">
        </div>

    </htmlpagefooter>
    <sethtmlpagefooter name="<?= esc($footerName) ?>" value="on" show-this-page="1" />
    <?php
};
?>

<?php if (!empty($sections)): ?>

    <?php foreach ($sections as $section):
        $fisika = $section['fisika'];
        $kimia  = $section['kimia'];
        $mikro  = $section['mikro'];
        $layout = $section['layout'] ?? 'kimia_ikut_fisika';
        $isFirstSection = $section['kode'] === 'A';

        // DITAMBAHKAN: footer dinamis untuk section ini (site + kategori/jenis sampling)
        $footerConfig = ParameterAirDefinition::getFooterConfig(
            $row['site'] ?? '',
            $section['title'] ?? ''
        );
        $cetakFooter('footer_' . $section['kode'], $footerConfig);

        // Tentukan pembagian kolom per halaman berdasarkan layout kategori
        if ($layout === 'satu_tabel') {
            $page1 = array_merge($fisika, $kimia, $mikro);
            $page2 = [];
        } elseif ($layout === 'kimia_ikut_mikro') {
            $page1 = $fisika;
            $page2 = array_merge($kimia, $mikro);
        } else { // kimia_ikut_fisika (default)
            $page1 = array_merge($fisika, $kimia);
            $page2 = $mikro;
        }

        $adaHalamanKedua = !empty($page2);
    ?>

    <div class="section-title"><?= esc($section['kode']) ?>. <?= esc($section['title']) ?></div>

    <table class="noborder info-table" style="margin-bottom: 6px;">
        <?php if ($isFirstSection): ?>
            <tr>
                <td style="width: 20%; text-align: left;">Pemeriksaan Minggu Ke</td>
                <td style="width: 30%; text-align: left;">: <?= esc($row['week'] ?? '-') ?></td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td style="text-align: left;">Bulan dan Tahun</td>
                <td style="text-align: left;">: <?= esc($bulanTahunLabel) ?></td>
                <td colspan="2"></td>
            </tr>
        <?php else: ?>
            <tr>
                <td style="width: 20%; text-align: left;">Pemeriksaan Minggu Ke</td>
                <td style="width: 30%; text-align: left;">: <?= esc($row['week'] ?? '-') ?></td>
                <td style="width: 20%; text-align: left;">Tanggal Sampling</td>
                <td style="width: 30%; text-align: left;">: <?= esc($row['tanggal_sampling'] ?? '-') ?></td>
            </tr>
            <tr>
                <td style="text-align: left;">Bulan dan Tahun</td>
                <td style="text-align: left;">: <?= esc($bulanTahunLabel) ?></td>
                <td style="text-align: left;">Site</td>
                <td style="text-align: left;">: <?= esc($row['site'] ?? '-') ?></td>
            </tr>
        <?php endif; ?>
    </table>

    <?php
        // ---------- Fungsi render 1 kelompok kolom (fisika+kimia, atau mikro) ----------
        // Header dibuat 4 baris, PERSIS seperti form resmi (CR-QO-QA-8030 / CR-QO-QA-8007):
        //   Baris 1: Titik Sampling (rowspan) | Fisika | Kimia | Mikrobiologi | Kesimpulan (rowspan)
        //   Baris 2: nama parameter + satuan
        //   Baris 3: "Kriteria Penerimaan (kode acuan)" menyatu satu baris, melebar semua kolom parameter
        //   Baris 4: Nama Outlet | No Outlet | nilai/kriteria per parameter
        // Titik Sampling & Kesimpulan menggunakan rowspan dinamis: 4 baris kalau ada baris
        // kriteria acuan, atau 3 baris kalau referensiLabel kosong.
        //
        // ATURAN JUMLAH BARIS: setiap tabel selalu berisi TEPAT 8 baris outlet.
        // - Kalau data outlet < 8, sisanya diisi baris kosong sampai genap 8.
        // - Kalau data outlet > 8, sisanya di-pecah ke tabel baru di halaman
        //   berikutnya (header ikut berulang), tiap tabel baru juga tetap 8 baris.
        $maxBarisPerHalaman = 8;

        $renderTabelSection = function (array $paramKeys, bool $tampilkanKesimpulan, ?string $referensiLabel) use ($section, $paramDef, $maxBarisPerHalaman) {
            $fisikaDiHalaman = array_values(array_intersect($paramKeys, $section['fisika']));
            $kimiaDiHalaman  = array_values(array_intersect($paramKeys, $section['kimia']));
            $mikroDiHalaman  = array_values(array_intersect($paramKeys, $section['mikro']));

            $totalHeaderRows      = $referensiLabel ? 4 : 3;
            $titikSamplingRowspan = $totalHeaderRows - 1; // baris terakhir dipecah jadi Nama Outlet / No Outlet
            $kesimpulanRowspan    = $totalHeaderRows;

            $colspanKosong = 2 + count($paramKeys) + ($tampilkanKesimpulan ? 1 : 0);

            // Helper cetak thead supaya tidak duplikasi kode antara kondisi
            // "tidak ada outlet" dan kondisi normal (berulang tiap chunk halaman).
            $cetakThead = function () use ($titikSamplingRowspan, $kesimpulanRowspan, $fisikaDiHalaman, $kimiaDiHalaman, $mikroDiHalaman, $tampilkanKesimpulan, $paramKeys, $paramDef, $referensiLabel, $section) {
    ?>
            <thead>
                <tr>
                    <th rowspan="<?= $titikSamplingRowspan ?>" colspan="2">Titik Sampling</th>
                    <?php if (!empty($fisikaDiHalaman)): ?>
                        <th colspan="<?= count($fisikaDiHalaman) ?>" class="kelompok-fisika">Fisika</th>
                    <?php endif; ?>
                    <?php if (!empty($kimiaDiHalaman)): ?>
                        <th colspan="<?= count($kimiaDiHalaman) ?>" class="kelompok-kimia">Kimia</th>
                    <?php endif; ?>
                    <?php if (!empty($mikroDiHalaman)): ?>
                        <th colspan="<?= count($mikroDiHalaman) ?>" class="kelompok-mikro">Mikrobiologi</th>
                    <?php endif; ?>
                    <?php if ($tampilkanKesimpulan): ?>
                        <th rowspan="<?= $kesimpulanRowspan ?>">Kesimpulan<br>(MS/TMS)</th>
                    <?php endif; ?>
                </tr>
                <tr>
                    <?php foreach ($paramKeys as $p):
                        $label  = $paramDef[$p]['label']  ?? $p;
                        $satuan = $paramDef[$p]['satuan'] ?? '';
                    ?>
                        <th><?= esc($label) ?><?= $satuan ? ' (' . esc($satuan) . ')' : '' ?></th>
                    <?php endforeach; ?>
                </tr>
                <?php if ($referensiLabel): ?>
                <tr class="kriteria-row">
                    <th colspan="<?= count($paramKeys) ?>">
                        Kriteria Penerimaan (<?= esc($referensiLabel) ?>)
                    </th>
                </tr>
                <?php endif; ?>
                <tr>
                    <th>Nama Outlet</th>
                    <th>No Outlet</th>
                    <?php foreach ($paramKeys as $p): ?>
                        <th style="font-weight: normal;"><?= esc($section['kriteria'][$p] ?? '-') ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
    <?php
            };

            // Kalau memang tidak ada outlet sama sekali untuk kategori ini
            // (bukan soal jumlah baris, tapi memang tidak ada data outlet
            // yang cocok dengan konfigurasi), tampilkan 1 baris pesan.
            if (empty($section['rows'])) {
    ?>
        <table>
            <?php $cetakThead(); ?>
            <tbody>
                <tr>
                    <td colspan="<?= $colspanKosong ?>">Belum ada outlet untuk kategori ini.</td>
                </tr>
            </tbody>
        </table>
    <?php
                return;
            }

            // Pecah baris data jadi beberapa halaman, tiap halaman MAKSIMAL 8 baris
            $rowsChunks = array_chunk($section['rows'], $maxBarisPerHalaman);

            foreach ($rowsChunks as $chunkIndex => $rowsChunk):
                if ($chunkIndex > 0): ?>
                    <pagebreak />
                <?php endif; ?>
        <table>
            <?php $cetakThead(); ?>
            <tbody>
                <?php foreach ($rowsChunk as $r): ?>
                <tr>
                    <td style="text-align: left;"><?= esc($r['nama_outlet_sampling']) ?></td>
                    <td><?= esc($r['no_outlet_sampling']) ?></td>
                    <?php foreach ($paramKeys as $p):
                        $val = $r['nilai'][$p] ?? null;
                    ?>
                        <td><?= ($val !== null && $val !== '') ? esc($val) : '-' ?></td>
                    <?php endforeach; ?>
                    <?php if ($tampilkanKesimpulan): ?>
                        <td style="font-weight: bold; color: <?= $r['kesimpulan'] === 'TMS' ? 'red' : 'black' ?>;">
                            <?= esc($r['kesimpulan']) ?>
                        </td>
                    <?php endif; ?>
                </tr>
                <?php endforeach; ?>

                <?php
                    // Padding baris kosong supaya tabel selalu genap 8 baris,
                    // walaupun data outlet di halaman ini kurang dari 8.
                    $jumlahTerisi = count($rowsChunk);
                    for ($i = $jumlahTerisi; $i < $maxBarisPerHalaman; $i++):
                ?>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <?php foreach ($paramKeys as $p): ?>
                        <td>&nbsp;</td>
                    <?php endforeach; ?>
                    <?php if ($tampilkanKesimpulan): ?>
                        <td>&nbsp;</td>
                    <?php endif; ?>
                </tr>
                <?php endfor; ?>
            </tbody>
        </table>
    <?php
            endforeach;
        };
        // ---------------------------------------------------------------------

        // Tentukan label referensi untuk tiap halaman
        $refPage1 = !empty(array_intersect($page1, array_merge($section['fisika'], $section['kimia'])))
                    ? $section['referensi_fisika_kimia'] : null;
        $refPage2 = !empty(array_intersect($page2, $section['mikro']))
                    ? $section['referensi_mikro'] : null;

        // Render halaman 1 (Kesimpulan cuma tampil di sini kalau tidak ada halaman 2)
        $renderTabelSection($page1, !$adaHalamanKedua, $refPage1);

        // Render halaman 2 kalau ada (pindah halaman baru di PDF)
        if ($adaHalamanKedua):
    ?>
        <pagebreak />

    <?php
        $renderTabelSection($page2, true, $refPage2);
        endif;
    ?>

    <?php if (!empty($section['catatan'])): ?>
        <p class="catatan-section">Note: <?= esc($section['catatan']) ?></p>
    <?php endif; ?>

    <?php endforeach; ?>

<?php elseif (!empty($dataOutletFlat)): ?>

    <?php
        // DITAMBAHKAN: footer default untuk fallback (site/kategori belum terdaftar)
        $footerConfigFallback = ParameterAirDefinition::getFooterConfig($row['site'] ?? '', '');
        $cetakFooter('footer_fallback', $footerConfigFallback);
    ?>

    <!-- ===== FALLBACK: site belum terdaftar di ParameterAirDefinition::kategoriPerSite() ===== -->
    <p style="font-size: 8pt; color: #a00;">
        * Site "<?= esc($row['site'] ?? '-') ?>" belum punya konfigurasi format section — menampilkan tabel gabungan semua parameter.
    </p>
    <table style="font-size: 7.5pt;">
        <thead>
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">No Outlet</th>
                <th rowspan="2">Nama Outlet</th>
                <th rowspan="2">Lokasi</th>
                <th colspan="8" class="kelompok-fisika">Fisika &amp; Kimia</th>
                <th colspan="10" class="kelompok-mikro">Mikrobiologi</th>
                <th rowspan="2">Kesimpulan</th>
            </tr>
            <tr>
                <th>Warna</th><th>Bau</th><th>pH</th><th>Suhu</th><th>Conductivity</th>
                <th>Kesadahan</th><th>Zat Padat Total</th><th>TOC</th>
                <th>TAMC</th><th>TYMC</th><th>Coliform</th><th>E. coli</th>
                <th>Salmonella sp</th><th>Staphylococcus aureus</th><th>Pseudomonas aeruginosa</th>
                <th>Shigella sp</th><th>Enterobacteriaceae</th><th>Clostridia sporogens</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dataOutletFlat as $no => $item): ?>
            <tr>
                <td><?= $no + 1 ?></td>
                <td><?= esc($item['no_outlet_sampling']) ?></td>
                <td style="text-align: left;"><?= esc($item['nama_outlet_sampling']) ?></td>
                <td style="text-align: left;"><?= esc($item['lokasi']) ?></td>
                <td><?= esc($item['hasil_warna']                  ?? '-') ?></td>
                <td><?= esc($item['hasil_bau']                    ?? '-') ?></td>
                <td><?= esc($item['hasil_ph']                     ?? '-') ?></td>
                <td><?= esc($item['hasil_suhu']                   ?? '-') ?></td>
                <td><?= esc($item['hasil_conductivity']           ?? '-') ?></td>
                <td><?= esc($item['hasil_kesadahan']               ?? '-') ?></td>
                <td><?= esc($item['hasil_zat_padat_total']        ?? '-') ?></td>
                <td><?= esc($item['hasil_toc']                    ?? '-') ?></td>
                <td><?= esc($item['hasil_tamc']                   ?? '-') ?></td>
                <td><?= esc($item['hasil_tymc']                   ?? '-') ?></td>
                <td><?= esc($item['hasil_coliform']                ?? '-') ?></td>
                <td><?= esc($item['hasil_e_coli']                 ?? '-') ?></td>
                <td><?= esc($item['hasil_salmonella_sp']          ?? '-') ?></td>
                <td><?= esc($item['hasil_staphylococcus_aureus']  ?? '-') ?></td>
                <td><?= esc($item['hasil_pseudomonas_aeruginosa'] ?? '-') ?></td>
                <td><?= esc($item['hasil_shigella_sp']            ?? '-') ?></td>
                <td><?= esc($item['hasil_enterobacteriaceae']     ?? '-') ?></td>
                <td><?= esc($item['hasil_clostridia_sporogens']   ?? '-') ?></td>
                <td style="color: <?= ($item['kesimpulan'] === 'TMS') ? 'red' : 'black' ?>; font-weight: bold;">
                    <?= esc($item['kesimpulan'] ?? '-') ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<?php else: ?>
    <p>Tidak ada data outlet untuk laporan ini.</p>
<?php endif; ?>
<?php if (!empty($scanImages)): ?>
    <pagebreak />
    <div class="section-title">Lampiran: Scan Hasil Analisa Fisika &amp; Kimia</div>

    <?php foreach ($scanImages as $i => $scan): ?>
        <?php if ($i > 0): ?>
            <pagebreak />
        <?php endif; ?>

        <table class="noborder" style="margin-bottom: 8px;">
            <tr>
                <td style="text-align: left; font-size: 8pt;">
                    <strong><?= esc($scan['nama_asli']) ?></strong><br>
                    Diupload oleh: <?= esc($scan['uploaded_by']) ?> &middot;
                    <?= date('d/m/Y H:i', strtotime($scan['uploaded_at'])) ?>
                </td>
            </tr>
        </table>

        <div style="text-align: center;">
            <img src="<?= $scan['base64'] ?>" style="max-width: 100%; max-height: 650px;">
        </div>
    <?php endforeach; ?>
<?php endif; ?>
</body>
</html>