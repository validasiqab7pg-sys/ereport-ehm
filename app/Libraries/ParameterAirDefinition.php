<?php

namespace App\Libraries;

class ParameterAirDefinition
{
    public static function fisikaKimia(): array
    {
        return [
            'warna'           => ['label' => 'Warna',          'tipe' => 'teks'],
            'bau'             => ['label' => 'Bau',             'tipe' => 'teks'],
            'ph'              => ['label' => 'pH',              'tipe' => 'numerik'],
            'suhu'            => ['label' => 'Suhu',            'tipe' => 'numerik', 'satuan' => '°C'],
            'conductivity'    => ['label' => 'Conductivity',    'tipe' => 'numerik', 'satuan' => 'µS/cm'],
            'kesadahan'       => ['label' => 'Kesadahan',       'tipe' => 'numerik', 'satuan' => 'mg/L'],
            'zat_padat_total' => ['label' => 'Zat Padat Total', 'tipe' => 'numerik', 'satuan' => 'mg/L'],
            'toc'             => ['label' => 'TOC',             'tipe' => 'numerik', 'satuan' => 'ppb'],
        ];
    }

    public static function mikrobiologi(): array
    {
        return [
            'tamc'                   => ['label' => 'TAMC',                   'tipe' => 'numerik', 'satuan' => 'cfu/mL'],
            'tymc'                   => ['label' => 'TYMC',                   'tipe' => 'numerik', 'satuan' => 'cfu/mL'],
            'coliform'               => ['label' => 'Coliform',               'tipe' => 'teks'],
            'e_coli'                 => ['label' => 'E. coli',                'tipe' => 'teks'],
            'salmonella_sp'          => ['label' => 'Salmonella sp',          'tipe' => 'teks'],
            'staphylococcus_aureus'  => ['label' => 'Staphylococcus aureus',  'tipe' => 'teks'],
            'pseudomonas_aeruginosa' => ['label' => 'Pseudomonas aeruginosa', 'tipe' => 'teks'],
            'shigella_sp'            => ['label' => 'Shigella sp',            'tipe' => 'teks'],
            'enterobacteriaceae'     => ['label' => 'Enterobacteriaceae',     'tipe' => 'teks'],
            'clostridia_sporogens'   => ['label' => 'Clostridia sporogens',   'tipe' => 'teks'],
        ];
    }

    public static function semua(): array
    {
        return array_merge(self::fisikaKimia(), self::mikrobiologi());
    }

    public static function opsiTeksDefault(string $parameter): array
    {
        $map = [
            'warna' => ['Jernih, Tidak Berwarna', 'Berwarna'],
            'bau'   => ['Tidak Berbau', 'Berbau'],
        ];
        return $map[$parameter] ?? ['Negatif', 'Positif'];
    }

    // ================================================================
    // DITAMBAHKAN: helper terpusat untuk mengecek apakah SYARAT suatu
    // parameter di-set N/A (bukan hasil pemeriksaannya, tapi syaratnya
    // di Master Data Air). Dipakai bersama oleh evaluasiParameter() dan
    // seluruh view input hasil (FisikKimiaAir, MikroAir, DataAir).
    // ================================================================
    public static function isSyaratNA(?array $syarat): bool
    {
        if (!$syarat) {
            return false;
        }
        if (($syarat['tipe'] ?? null) === 'numerik' && ($syarat['operator'] ?? null) === 'N/A') {
            return true;
        }
        if (($syarat['tipe'] ?? null) === 'teks' && strtoupper(trim((string)($syarat['nilai_teks'] ?? ''))) === 'N/A') {
            return true;
        }
        return false;
    }

    public static function normalizeSyaratIndexed(array $indexed): array
    {
        if (!isset($indexed['clostridia_sporogens'])) {
            $clostridia = $indexed['clostridia'] ?? null;
            $sporogens  = $indexed['sporogens'] ?? null;
            $indexed['clostridia_sporogens'] = !self::isSyaratNA($clostridia) && $clostridia
                ? $clostridia
                : ($sporogens ?? $clostridia);
        }

        unset($indexed['clostridia'], $indexed['sporogens']);
        return $indexed;
    }

    public static function normalizeHasilRow(array $hasil): array
    {
        if (!array_key_exists('hasil_clostridia_sporogens', $hasil)) {
            $clostridia = $hasil['hasil_clostridia'] ?? null;
            $sporogens  = $hasil['hasil_sporogens'] ?? null;
            $hasil['hasil_clostridia_sporogens'] = ($clostridia !== null && trim((string)$clostridia) !== '' && strtoupper(trim((string)$clostridia)) !== 'NA')
                ? $clostridia
                : ($sporogens ?? $clostridia);
        }

        return $hasil;
    }

    // ================================================================
    // DITAMBAHKAN: cek apakah syarat suatu parameter di-set "Pendataan"
    // (nilai tetap wajib dicatat oleh QC Analis, tapi TIDAK dievaluasi
    // MS/TMS karena memang tidak ada kriteria penerimaannya).
    // Berbeda dari N/A: N/A = tidak diperiksa sama sekali (field tidak
    // muncul di form input). Pendataan = field tetap muncul & wajib
    // diisi, hanya saja hasilnya tidak dibandingkan ke kriteria apapun.
    // ================================================================
    public static function isSyaratPendataan(?array $syarat): bool
    {
        if (!$syarat) {
            return false;
        }
        return ($syarat['tipe'] ?? null) === 'numerik'
            && ($syarat['operator'] ?? null) === 'Pendataan';
    }

    public static function evaluasiParameter(?array $syarat, ?string $hasilMentah): string
    {
        // DITAMBAHKAN: kalau syarat parameter ini memang di-set N/A,
        // langsung anggap NA — parameter ini memang tidak diperiksa
        // untuk outlet ini, jadi tidak ikut mempengaruhi kesimpulan.
        if (self::isSyaratNA($syarat)) {
            return 'NA';
        }

        // DITAMBAHKAN: syarat Pendataan tetap wajib diisi (memicu
        // BELUM_DIISI kalau kosong), tapi kalau sudah diisi TIDAK
        // dievaluasi MS/TMS — cukup dicatat sebagai data.
        if (self::isSyaratPendataan($syarat)) {
            if ($hasilMentah === null || trim((string)$hasilMentah) === '') {
                return 'BELUM_DIISI';
            }
            return 'PENDATAAN';
        }

        if ($hasilMentah === null || trim((string)$hasilMentah) === '') {
            return 'BELUM_DIISI';
        }
        if (strtoupper(trim($hasilMentah)) === 'NA') {
            return 'NA';
        }
        if (!$syarat) {
            return 'NA';
        }

        if ($syarat['tipe'] === 'teks') {
            $standar = strtolower(trim($syarat['nilai_teks'] ?? ''));
            $hasil   = strtolower(trim($hasilMentah));
            return $hasil === $standar ? 'MS' : 'TMS';
        }

        $nilaiHasil = is_numeric($hasilMentah) ? (float)$hasilMentah : null;
        if ($nilaiHasil === null) {
            return 'TMS';
        }

        return match ($syarat['operator']) {
            '<'      => $nilaiHasil <  (float)$syarat['nilai_max'] ? 'MS' : 'TMS',
            '<='     => $nilaiHasil <= (float)$syarat['nilai_max'] ? 'MS' : 'TMS',
            '>'      => $nilaiHasil >  (float)$syarat['nilai_min'] ? 'MS' : 'TMS',
            '>='     => $nilaiHasil >= (float)$syarat['nilai_min'] ? 'MS' : 'TMS',
            '='      => $nilaiHasil == (float)$syarat['nilai_min'] ? 'MS' : 'TMS',
            'antara' => ($nilaiHasil >= (float)$syarat['nilai_min']
                      && $nilaiHasil <= (float)$syarat['nilai_max']) ? 'MS' : 'TMS',
            default  => 'TMS',
        };
    }

    public static function hitungKesimpulanBaris(array $syaratIndexed, array $hasilRow, array $paramKeys): string
    {
        $adaTMS        = false;
        $adaBelumDiisi = false;

        foreach ($paramKeys as $param) {
            $syarat     = $syaratIndexed[$param] ?? null;
            $fieldHasil = 'hasil_' . $param;
            $nilaiHasil = $hasilRow[$fieldHasil] ?? null;

            $status = self::evaluasiParameter($syarat, $nilaiHasil);

            if ($status === 'BELUM_DIISI') { $adaBelumDiisi = true; }
            if ($status === 'TMS')         { $adaTMS = true; }
        }

        if ($adaBelumDiisi) { return 'BELUM_LENGKAP'; }
        return $adaTMS ? 'TMS' : 'MS';
    }
    private static function formatAngka(?string $angka): string
    {
        if ($angka === null || trim($angka) === '') {
            return '';
        }
        if (!is_numeric($angka)) {
            return $angka;
        }

        // Buang trailing zero setelah titik desimal, dan buang titik
        // kalau semua digit belakang koma nol (jadi bilangan bulat)
        $formatted = rtrim(rtrim(number_format((float)$angka, 4, '.', ''), '0'), '.');

        return $formatted === '' ? '0' : $formatted;
    }
    public static function buildLabelSyarat(string $param, string $tipe, ?string $operator, ?string $min, ?string $max, ?string $nilaiTeks): ?string
    {
        if ($tipe === 'teks') {
            return $nilaiTeks;
        }

        $semua  = self::semua();
        $def    = isset($semua[$param]) && is_array($semua[$param]) ? $semua[$param] : [];
        $satuan = $def['satuan'] ?? '';

        // DITAMBAHKAN: format min/max supaya tidak tampil trailing zero (5.0000 -> 5)
        $minFormatted = self::formatAngka($min);
        $maxFormatted = self::formatAngka($max);

        return match ($operator) {
            'antara'    => trim($minFormatted . ' - ' . $maxFormatted),
            '<'         => trim('< ' . $maxFormatted . ' ' . $satuan),
            '<='        => trim('<= ' . $maxFormatted . ' ' . $satuan),
            '>'         => trim('> ' . $minFormatted . ' ' . $satuan),
            '>='        => trim('>= ' . $minFormatted . ' ' . $satuan),
            '='         => trim('= ' . $minFormatted . ' ' . $satuan),
            'N/A'       => 'N/A',
            'Pendataan' => 'Pendataan',
            default     => null,
        };
    }

    public static function formatHasilMikro(?string $hasilMentah): ?string
    {
        if ($hasilMentah === null || trim($hasilMentah) === '') {
            return null;
        }

        $v = strtolower(trim($hasilMentah));

        if ($v === 'na' || $v === 'n/a') {
            return 'N/A';
        }
        if (in_array($v, ['negatif', 'negative', '-'], true)) {
            return '(-)';
        }
        if (in_array($v, ['positif', 'positive', '+'], true)) {
            return '(+)';
        }

        return $hasilMentah;
    }
private static function semuaOutletNA(array $syaratPerOutlet, string $param): bool
    {
        if (empty($syaratPerOutlet)) {
            return false;
        }
        foreach ($syaratPerOutlet as $syaratIndexed) {
            $syarat = $syaratIndexed[$param] ?? null;
            if (!self::isSyaratNA($syarat)) {
                return false;
            }
        }
        return true;
    }

    // DITAMBAHKAN: filter daftar parameter, buang yang N/A di SEMUA outlet
    public static function filterParamKolomAktif(array $paramKeys, array $syaratPerOutlet): array
    {
        return array_values(array_filter($paramKeys, function ($p) use ($syaratPerOutlet) {
            return !self::semuaOutletNA($syaratPerOutlet, $p);
        }));
    }
    // =====================================================================
    // KONFIGURASI TEMPLATE LAPORAN PDF — PER SITE, PER SECTION (A/B/C)
    // =====================================================================
    public static function kategoriUtama(): array
    {
        return [
            'Air PAM/City Water/Soft Water' => [
                'referensi_fisika_kimia' => 'Permenkes No. 2 Tahun 2023, Guideline of Drinking Water (WHO, 2022)',
                'referensi_mikro'        => 'WI-QO-QA-8001/8002',
                'fisika'                 => ['warna', 'bau', 'ph', 'suhu'],
                'kimia'                  => ['kesadahan', 'zat_padat_total'],
                'mikro'                  => [
                    'tamc', 'coliform', 'e_coli', 'salmonella_sp', 'staphylococcus_aureus',
                    'pseudomonas_aeruginosa', 'shigella_sp', 'enterobacteriaceae', 'clostridia_sporogens',
                ],
                'catatan' => 'Kesadahan Air PAM/ City Water: 500 mg/L. Kesadahan Soft Water: 100 mg/L.',
                'layout'  => 'kimia_ikut_fisika',
            ],
            'Aquademin Suhu Kamar/Aquademin Suhu Panas' => [
                'referensi_fisika_kimia' => 'WI-QO-QA-8001',
                'referensi_mikro'        => 'WI-QO-QA-8001',
                'fisika'                 => ['warna', 'bau', 'ph', 'suhu', 'conductivity'],
                'kimia'                  => ['toc'],
                'mikro'                  => [
                    'tamc', 'tymc', 'coliform', 'e_coli', 'salmonella_sp', 'staphylococcus_aureus',
                    'pseudomonas_aeruginosa', 'shigella_sp', 'enterobacteriaceae', 'clostridia_sporogens',
                ],
                'catatan' => '(*) Untuk Aquademin Panas',
                'layout'  => 'kimia_ikut_mikro',
            ],
            'Purified Water' => [
                'referensi_fisika_kimia' => 'WI-QO-QA-8001/8002',
                'referensi_mikro'        => 'WI-QO-QA-8001/8002',
                'fisika'                 => ['warna', 'bau', 'ph', 'suhu', 'conductivity'],
                'kimia'                  => ['toc'],
                'mikro'                  => ['tamc','tymc'],
                'catatan'                => null,
                'layout'                 => 'satu_tabel',
            ],
        ];
    }

    public static function kategoriPerSite(): array
    {
        return [
            'Cikarang' => [
                ['kode' => 'A', 'kategori' => 'Air PAM/City Water/Soft Water'],
                ['kode' => 'B', 'kategori' => 'Purified Water'],
            ],
            'Pulogadung' => [
                ['kode' => 'A', 'kategori' => 'Air PAM/City Water/Soft Water'],
                ['kode' => 'B', 'kategori' => 'Aquademin Suhu Kamar/Aquademin Suhu Panas'],
                ['kode' => 'C', 'kategori' => 'Purified Water'],
            ],
        ];

    }

    public static function frekuensiSampling(): array
    {
        return ['Mingguan', 'Bulanan'];
    }

    public static function buildJenisSampling(string $kategori, string $frekuensi): string
    {
        return trim($kategori) . ' - ' . trim($frekuensi);
    }

    public static function extractKategoriDariJenisSampling(?string $jenisSampling): string
    {
        $val = trim((string)$jenisSampling);

        foreach (self::frekuensiSampling() as $frek) {
            $suffix = ' - ' . $frek;
            if (strlen($val) > strlen($suffix)
                && strtolower(substr($val, -strlen($suffix))) === strtolower($suffix)) {
                return trim(substr($val, 0, -strlen($suffix)));
            }
        }

        return $val;
    }

    public static function getSectionConfig(string $site, string $kategoriNama): ?array
    {
        $kategoriUtama   = self::kategoriUtama();
        $kategoriPerSite = self::kategoriPerSite();

        $siteNormalized     = strtolower(trim($site));
        $daftarKategoriSite = null;
        foreach ($kategoriPerSite as $siteKey => $daftar) {
            if (strtolower(trim($siteKey)) === $siteNormalized) {
                $daftarKategoriSite = $daftar;
                break;
            }
        }

        if (!$daftarKategoriSite) {
            return null;
        }

        foreach ($daftarKategoriSite as $item) {
            if (strtolower(trim($item['kategori'])) !== strtolower(trim($kategoriNama))) {
                continue;
            }

            $def = $kategoriUtama[$item['kategori']] ?? null;
            if (!$def) {
                return null;
            }

            return [
                'kode'                   => $item['kode'],
                'title'                  => strtoupper($item['kategori']),
                'referensi_fisika_kimia' => $def['referensi_fisika_kimia'],
                'referensi_mikro'        => $def['referensi_mikro'],
                'fisika'                 => $def['fisika'],
                'kimia'                  => $def['kimia'],
                'mikro'                  => $def['mikro'],
                'catatan'                => $def['catatan'],
                'layout'                 => $def['layout'] ?? 'kimia_ikut_fisika',
            ];
        }

        return null;
    }

    public static function resolveKriteriaLabel(array $syaratPerOutlet, string $param): string
    {
        $labels = [];

        foreach ($syaratPerOutlet as $syaratIndexed) {
            $s = $syaratIndexed[$param] ?? null;
            if (!$s) {
                continue;
            }

            $label = self::buildLabelSyarat(
                $param,
                $s['tipe'] ?? 'numerik',
                $s['operator'] ?? null,
                isset($s['nilai_min']) ? (string)$s['nilai_min'] : null,
                isset($s['nilai_max']) ? (string)$s['nilai_max'] : null,
                $s['nilai_teks'] ?? null
            );

            if ($label !== null && $label !== '') {
                $labels[] = $label;
            }
        }

        if (empty($labels)) {
            return '-';
        }

        $counts = array_count_values($labels);
        arsort($counts);

        return array_key_first($counts);
    }
    public static function footerConfigPerSiteKategori(): array
{
    return [
        'Cikarang' => [
            'Air PAM/City Water/Soft Water' => [
                'kode_dokumen'        => 'CR-QO-QA-8030.00 (08 Agustus 2025)',
                'referensi_wi'        => 'WI-QO-QA-8002 (EHM Site CKR)',
                'keterangan'          => '-	Keterangan: Tulisan (-) artinya negatif, (+) artinya positif, dan N/A artinya tidak dilakukan pemeriksaan',
                'catatan_penyimpanan' => 'Formulir yang sudah diisi lengkap disimpan pada R. Administrasi QA selama 5 tahun setelah dilakukan sampling.',
                'definisi_tamc'       => 'Defenisi TAMC = Total Aerobic Micriobiol Count / TP',
            ],
            'Purified Water' => [
                'kode_dokumen'        => 'CR-QO-QA-8030.00 (08 Agustus 2025)',
                'referensi_wi'        => 'WI-QO-QA-8002 (EHM Site CKR)',
                'keterangan'          => '-	Keterangan: Tulisan (-) artinya negatif, (+) artinya positif, dan N/A artinya tidak dilakukan pemeriksaan',
                'catatan_penyimpanan' => 'Formulir yang sudah diisi lengkap disimpan pada R. Administrasi QA selama 5 tahun setelah dilakukan sampling.',
                'definisi_tamc'       => 'Defenisi TAMC = Total Aerobic Micriobiol Count / TPC',
            ],
        ],
        'Pulogadung' => [
            'Air PAM/City Water/Soft Water' => [
                'kode_dokumen'        => 'CR-QO-QA-8007.08 (03 Dec 2025)',
               // 'referensi_wi'        => 'WI-QO-QA-8001 (EHM Site PLG) & WI-QO-QA-8002 (EHM Site CKR)',
                'keterangan'          => 'Keterangan = Tulisan (-) artinya Negatif, (+) artinya Positif, N/A artinya Tidak dilakukan pemeriksaan',
                //'catatan_penyimpanan' => 'Formulir yang sudah diisi lengkap disimpan pada R. Administrasi QA selama 5 tahun setelah dilakukan sampling.',
                'definisi_tamc'       => 'Defenisi TAMC = Total Aerobic Micriobiol Count / TPC',
            ],
            'Aquademin Suhu Kamar/Aquademin Suhu Panas' => [
                'kode_dokumen'        => 'CR-QO-QA-8007.08 (03 Dec 2025)',
                'referensi_wi'        => 'WI-QO-QA-8001 (EHM Site PLG) & WI-QO-QA-8002 (EHM Site CKR)',
                'keterangan'          => 'Keterangan = Tulisan (-) artinya Negatif, (+) artinya Positif, N/A artinya Tidak dilakukan pemeriksaan',
                'catatan_penyimpanan' => 'Formulir yang sudah diisi lengkap disimpan pada R. Administrasi QA selama 5 tahun setelah dilakukan sampling.',
                'definisi_tamc'       => '(*) Untuk Aquademin Suhu Panas',
            ],
            'Purified Water' => [
                'kode_dokumen'        => 'CR-QO-QA-8007.08 (03 Dec 2025)',
                'referensi_wi'        => 'WI-QO-QA-8001 (EHM Site PLG) & WI-QO-QA-8002 (EHM Site CKR)',
                'keterangan'          => 'Formulir yang sudah diisi lengkap disimpan pada R. Administrasi QA selama 5 tahun setelah dilakukan sampling.',
                'catatan_penyimpanan' => 'Defenisi TAMC = Total Aerobic Micriobiol Count / TPC, TYMC = Total Yeast Mould Count/KK.',
                'definisi_tamc'       => '(*) Hanya dilakukan di Site Pulogadung',
            ],
        ],
    ];
}



public static function getFooterConfig(string $site, string $kategoriNama): array
{
    $default = [
        'kode_dokumen'        => 'CR-QO-QA-8030.00 (08 Agustus 2025)',
        'referensi_wi'        => 'WI-QO-QA-8002',
        'keterangan'          => '(-) = Negatif, (+) = Positif, N/A = Tidak dilakukan pemeriksaan, MS = Memenuhi Syarat, TMS = Tidak Memenuhi Syarat',
        'catatan_penyimpanan' => 'Formulir yang sudah diisi lengkap disimpan pada R. Administrasi QA selama 5 tahun setelah dilakukan sampling.',
        'definisi_tamc'       => 'Defenisi TAMC = Total Aerobic Micriobiol Count / TP',
    ];

    $daftar         = self::footerConfigPerSiteKategori();
    $siteNormalized = strtolower(trim($site));

    foreach ($daftar as $siteKey => $kategoriMap) {
        if (strtolower(trim($siteKey)) !== $siteNormalized) {
            continue;
        }
        foreach ($kategoriMap as $kategoriKey => $config) {
            if (strtolower(trim($kategoriKey)) === strtolower(trim($kategoriNama))) {
                return $config;
            }
        }
    }

    return $default;
}
}