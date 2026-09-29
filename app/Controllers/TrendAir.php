<?php

namespace App\Controllers;

use App\Models\TrendAirModel;
use App\Libraries\ParameterAirDefinition;

class TrendAir extends BaseController
{
    // GET /TrendAir — halaman filter + grid grafik
    public function index()
    {
        $session = session();

        $kategoriPerSite = ParameterAirDefinition::kategoriPerSite();
        $siteList        = array_keys($kategoriPerSite);

        $data['session']         = $session;
        $data['siteList']        = $siteList;
        $data['kategoriPerSite'] = $kategoriPerSite; // dipakai JS untuk isi dropdown kategori sesuai site terpilih

        return view('AtRest/trend_air', $data);
    }

    // GET /TrendAir/data — dipanggil via AJAX (fetch), return JSON siap pakai untuk Chart.js.
    // Query string: site, kategori, tanggal_mulai (opsional), tanggal_akhir (opsional)
    public function data()
    {
        $site         = $this->request->getGet('site');
        $kategori     = $this->request->getGet('kategori');
        $tanggalMulai = $this->request->getGet('tanggal_mulai');
        $tanggalAkhir = $this->request->getGet('tanggal_akhir');

        if (!$site || !$kategori) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Site dan Kategori wajib dipilih',
            ]);
        }

        $secConf = ParameterAirDefinition::getSectionConfig($site, $kategori);
        if (!$secConf) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Kombinasi Site dan Kategori ini belum terdaftar di ParameterAirDefinition',
            ]);
        }

        // Urutan parameter mengikuti urutan tampil di form: fisika -> kimia -> mikro
        $paramKeysSection = array_merge($secConf['fisika'], $secConf['kimia'], $secConf['mikro']);
        $paramDef         = ParameterAirDefinition::semua();

        $model = new TrendAirModel();
        $rows  = $model->ambilTrend($site, $kategori, $tanggalMulai, $tanggalAkhir);

        if (empty($rows)) {
            return $this->response->setJSON([
                'status'  => 'success',
                'charts'  => [],
                'message' => 'Belum ada data sampling untuk kombinasi filter ini.',
            ]);
        }

        // Label sumbu X: "Week X (tgl)" — supaya tetap unik & terurut kronologis
        // walau ada 2 laporan dengan Week yang sama (misal Sampling Ulang/Verifikasi)
        $buatLabel = function (array $r) {
            $tgl = $r['tanggal_sampling'] ? date('d M Y', strtotime($r['tanggal_sampling'])) : '-';
            return trim(($r['week'] ?: '-') . ' (' . $tgl . ')');
        };

        $labels = [];
        foreach ($rows as $r) {
            $lbl = $buatLabel($r);
            if (!in_array($lbl, $labels, true)) {
                $labels[] = $lbl;
            }
        }

        $paramCharts = [];

        foreach ($paramKeysSection as $p) {
            $def   = $paramDef[$p] ?? ['label' => $p, 'tipe' => 'numerik'];
            $field = 'hasil_' . $p;

            // Kumpulkan deret nilai per titik sampling (outlet)
            $perOutlet = []; // id_master_air => ['nama'=>, 'no'=>, 'data'=>[label => nilai]]

            foreach ($rows as $r) {
                $outletKey = $r['id_master_air'];
                $lbl       = $buatLabel($r);

                if (!isset($perOutlet[$outletKey])) {
                    $perOutlet[$outletKey] = [
                        'nama' => $r['nama_outlet_sampling'],
                        'no'   => $r['no_outlet_sampling'],
                        'data' => [],
                    ];
                }

                $raw = $r[$field] ?? null;
                $perOutlet[$outletKey]['data'][$lbl] = $this->konversiNilai($raw, $def['tipe'] ?? 'numerik');
            }

            $datasets = [];
            foreach ($perOutlet as $o) {
                $seri = [];
                foreach ($labels as $lbl) {
                    $seri[] = $o['data'][$lbl] ?? null;
                }
                $datasets[] = [
                    'label' => trim($o['nama'] . ' (' . $o['no'] . ')'),
                    'data'  => $seri,
                ];
            }

            $paramCharts[] = [
                'key'      => $p,
                'label'    => $def['label'] ?? $p,
                'satuan'   => $def['satuan'] ?? '',
                'tipe'     => $def['tipe']   ?? 'numerik',
                'labels'   => $labels,
                'datasets' => $datasets,
            ];
        }

        return $this->response->setJSON([
            'status' => 'success',
            'charts' => $paramCharts,
        ]);
    }

    /**
     * Konversi nilai hasil (varchar, apa adanya dari database) jadi angka
     * untuk digrafikkan.
     * - Parameter numerik: langsung di-cast ke float (kalau bukan angka valid, null / gap di grafik).
     * - Parameter teks (Negatif/Positif, Tidak Berbau/Berbau, dst): dipetakan
     *   ke 0/1 supaya tetap bisa divisualisasikan sebagai tren naik-turun.
     *   Catatan: untuk parameter jenis ini, angka 0/1 hanya representasi
     *   visual "aman vs tidak aman", bukan satuan ukur yang sebenarnya.
     */
    private function konversiNilai(?string $raw, string $tipe)
    {
        if ($raw === null || trim($raw) === '') {
            return null;
        }
        if ($tipe === 'numerik') {
            return is_numeric($raw) ? (float) $raw : null;
        }

        $v = strtolower(trim($raw));
        if (in_array($v, ['negatif', 'tidak berbau', 'tidak berwarna'], true)) {
            return 0;
        }
        if (in_array($v, ['positif', 'berbau', 'berwarna'], true)) {
            return 1;
        }

        return null; // N/A atau nilai tak dikenal -> dibiarkan kosong (gap di grafik)
    }

    // GET /TrendAir/exportExcel — download 1 tabel flat (semua baris outlet x
    // laporan, semua kolom parameter untuk kategori itu) sesuai filter yang
    // sedang aktif di halaman. Query string sama persis dengan data().
    public function exportExcel()
    {
        $site         = $this->request->getGet('site');
        $kategori     = $this->request->getGet('kategori');
        $tanggalMulai = $this->request->getGet('tanggal_mulai');
        $tanggalAkhir = $this->request->getGet('tanggal_akhir');

        if (!$site || !$kategori) {
            return redirect()->back()->with('error', 'Site dan Kategori wajib dipilih sebelum export.');
        }

        $secConf = ParameterAirDefinition::getSectionConfig($site, $kategori);
        if (!$secConf) {
            return redirect()->back()->with('error', 'Kombinasi Site dan Kategori ini belum terdaftar di ParameterAirDefinition.');
        }

        $paramKeysSection = array_merge($secConf['fisika'], $secConf['kimia'], $secConf['mikro']);
        $paramDef         = ParameterAirDefinition::semua();

        $model = new TrendAirModel();
        $rows  = $model->ambilTrend($site, $kategori, $tanggalMulai, $tanggalAkhir);

        // ===== Bangun spreadsheet: 1 tabel flat, 1 baris = 1 outlet x 1 laporan =====
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Trend Data Air');

        $headers = ['Tanggal Sampling', 'Week', 'Site', 'Kategori', 'No Outlet', 'Nama Outlet'];
        foreach ($paramKeysSection as $p) {
            $def       = $paramDef[$p] ?? ['label' => $p, 'satuan' => ''];
            $headers[] = $def['label'] . (!empty($def['satuan']) ? ' (' . $def['satuan'] . ')' : '');
        }

        $sheet->fromArray($headers, null, 'A1');
        $kolomTerakhir = $sheet->getHighestColumn();
        $sheet->getStyle('A1:' . $kolomTerakhir . '1')->getFont()->setBold(true);
        $sheet->getStyle('A1:' . $kolomTerakhir . '1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('D9E1F2');

        $baris = 2;
        foreach ($rows as $r) {
            $data = [
                $r['tanggal_sampling'],
                $r['week'],
                $r['site'],
                $r['jenis_sampling'],
                $r['no_outlet_sampling'],
                $r['nama_outlet_sampling'],
            ];
            foreach ($paramKeysSection as $p) {
                $data[] = $r['hasil_' . $p] ?? '-';
            }
            $sheet->fromArray($data, null, 'A' . $baris);
            $baris++;
        }

        foreach (range('A', $kolomTerakhir) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $namaFile = 'Trend_Data_Air_' . str_replace(' ', '_', $site) . '_'
                  . str_replace(' ', '_', $kategori) . '_' . date('Ymd_His') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $namaFile . '"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}