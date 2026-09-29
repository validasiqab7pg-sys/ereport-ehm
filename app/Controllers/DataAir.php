<?php

namespace App\Controllers;

use App\Models\DataSamplingAirModel;
use App\Models\HasilSamplingAirModel;
use App\Models\MasterDataAirModel;
use App\Models\DataTitikSamplingAirModel;
use App\Models\MasterDataAirSyaratModel;
use App\Libraries\ParameterAirDefinition;
use App\Models\OosAirModel;
use App\Models\PenyimpanganAirModel;
use App\Models\ScanHasilAirModel;
//use setasign\Fpdi\Mpdf\Fpdi;
use CodeIgniter\Controller;

class DataAir extends Controller
{
    public function index()
    {
        $session = session();
        $model   = new DataSamplingAirModel();
        $db      = \Config\Database::connect();

        $data['data']    = $model->findAll();
        $data['session'] = $session;
        $data['jenis_sampling_list'] = $db->table('master_data_air')
                                          ->select('jenis_sampling')
                                          ->distinct()
                                          ->where('jenis_sampling IS NOT NULL')
                                          ->orderBy('jenis_sampling', 'ASC')
                                          ->get()->getResultArray();

        return view('AtRest/data_sampling_air', $data);
    }

    // POST /DataAir/tambah
    // POST /DataAir/tambah
    public function tambah()
    {
        $model      = new DataSamplingAirModel();
        $keterangan = $this->request->getPost('keterangan');

        $idBaru = $model->insert([
            'tanggal_sampling' => $this->request->getPost('tanggal_sampling'),
            'site'             => $this->request->getPost('site'),
            'week'             => $this->request->getPost('week'),
            'jenis_sampling'   => $this->request->getPost('jenis_sampling'),
            'keterangan'       => $keterangan,
            'note'             => in_array($keterangan, ['Verifikasi', 'Sampling Ulang'])
                                  ? $this->request->getPost('note')
                                  : null,
            'status'           => $this->request->getPost('status'),
        ]);

        // DITAMBAHKAN: kirim notifikasi email ke QA Analis
        $this->kirimNotifikasiDataBaruAir($idBaru);

        return redirect()->to('/DataAir');
    }

    // DITAMBAHKAN
        private function kirimNotifikasiDataBaruAir($idBaru): void
            {
                if (!$idBaru) return;

                $row = (new DataSamplingAirModel())->find($idBaru);
                if (!$row) return;

                $db     = \Config\Database::connect();
                $emails = $db->table('user')
                    ->select('email')
                    ->where('jabatan', 'QA Analis')
                    ->get()->getResultArray();
                $emails = array_column($emails, 'email');

                $item = [
                    'no_dokumen' => 'EHM-AIR-' . $idBaru,
                    'jenis_ehm'  => 'EHM Air',
                    'tanggal'    => $row['tanggal_sampling'] ?? null,
                    'site'           => $row['site'] ?? '-',            // <-- Opsi Otomatis Muncul
                    'jenis_sampling' => $row['jenis_sampling'] ?? '-',  // <-- Opsi Otomatis Muncul
                    'keterangan'     => $row['keterangan'] ?? '-',      // <-- Opsi Otomatis Muncu
                    'url_detail' => base_url('DataAir/show/' . $idBaru),
                ];

                (new \App\Libraries\NotifikasiEmailService())->kirimNotifikasiDataBaru($emails, $item);
            }
    // GET /DataAir/hapus/1
    public function hapus($id)
{
    try {
        $model      = new DataSamplingAirModel();
        $modelHasil = new HasilSamplingAirModel();
        $modelTitik = new DataTitikSamplingAirModel();
        $db         = \Config\Database::connect();

        $db->table('scan_hasil_air')->where('id_sampling', $id)->delete();
        $modelHasil->where('id_sampling', $id)->delete();
        $modelTitik->where('id_sampling', $id)->delete();
        $db->table('sampling_air_excluded_outlet')->where('id_sampling', $id)->delete();

        $model->delete($id);

        return redirect()->to('/DataAir');

    } catch (\Throwable $e) {
        $logContent  = "===== ERROR hapus(id={$id}) =====\n";
        $logContent .= "Waktu     : " . date('Y-m-d H:i:s') . "\n";
        $logContent .= "Pesan     : " . $e->getMessage() . "\n";
        $logContent .= "File      : " . $e->getFile() . "\n";
        $logContent .= "Baris     : " . $e->getLine() . "\n";
        $logContent .= "Class     : " . get_class($e) . "\n";
        $logContent .= "Stack Trace:\n" . $e->getTraceAsString() . "\n";
        $logContent .= "=====================================\n\n";

        file_put_contents(
            WRITEPATH . 'debug_hapus_error.txt',
            $logContent,
            FILE_APPEND
        );

        header('Content-Type: text/plain');
        echo "Terjadi error saat menghapus data.\n\n";
        echo "Pesan: " . $e->getMessage() . "\n";
        echo "File : " . $e->getFile() . "\n";
        echo "Baris: " . $e->getLine() . "\n\n";
        echo "Detail lengkap tersimpan di: writable/debug_hapus_error.txt";
        exit;
    }
}
    // GET /DataAir/show/1
   public function show($id)
{
    $session     = session();
    $model       = new DataSamplingAirModel();
    $modelHasil  = new HasilSamplingAirModel();
    $modelMaster = new MasterDataAirModel();
    $modelTitik  = new DataTitikSamplingAirModel();
    $modelSyarat = new MasterDataAirSyaratModel();
    $db          = \Config\Database::connect();

    $row = $model->find($id);

    if ($modelTitik->sudahSnapshot((int)$id)) {
        $snapshotOutlet = $modelTitik->getByIdSampling((int)$id);
        $masterOutlet   = [];
        foreach ($snapshotOutlet as $s) {
            $masterOutlet[] = [
                'id'                   => $s['id_master_air'],
                'no_outlet_sampling'   => $s['no_outlet_sampling'],
                'nama_outlet_sampling' => $s['nama_outlet_sampling'],
                'lokasi'               => $s['lokasi'],
                'site'                 => $s['site'],
                'jenis_sampling'       => $s['jenis_sampling'],
            ];
        }
    } else {
        $excluded    = $db->table('sampling_air_excluded_outlet')
                          ->select('id_master_air')
                          ->where('id_sampling', $id)
                          ->get()->getResultArray();
        $excludedIds = array_column($excluded, 'id_master_air');

        $weekNum = str_replace('Week ', '', $row['week']);

        $masterQuery = $modelMaster
            ->where('site', $row['site'])
            ->where('jenis_sampling', $row['jenis_sampling'])
            ->where("FIND_IN_SET('{$weekNum}', jadwal_minggu_ke)", null, false);

        if (!empty($excludedIds)) {
            $masterQuery->whereNotIn('id', $excludedIds);
        }

        $masterOutlet = $masterQuery->findAll();
    }

    $hasilExisting = $modelHasil->where('id_sampling', $id)->findAll();
    $hasilIndex    = [];
    foreach ($hasilExisting as $h) {
        $hasilIndex[$h['id_master_air']] = $h;
    }

    $paramKeysSemua  = array_keys(ParameterAirDefinition::semua());
    $kesimpulanIndex = [];
    $syaratIndex     = []; // DITAMBAHKAN

    foreach ($masterOutlet as $outlet) {
        $idMaster      = $outlet['id'];
        $syaratIndexed = $modelSyarat->getIndexedByMasterId((int)$idMaster);
        $syaratIndex[$idMaster] = $syaratIndexed; // DITAMBAHKAN
        $hasilRow      = $hasilIndex[$idMaster] ?? [];

        $kesimpulanIndex[$idMaster] = ParameterAirDefinition::hitungKesimpulanBaris(
            $syaratIndexed,
            $hasilRow,
            $paramKeysSemua
        );
    }

    $data['row']             = $row;
    $data['masterOutlet']    = $masterOutlet;
    $data['hasilIndex']      = $hasilIndex;
    $data['kesimpulanIndex'] = $kesimpulanIndex;
    $data['syaratIndex']     = $syaratIndex; // DITAMBAHKAN
    $data['session']         = $session;

    return view('AtRest/data_sampling_air_detail', $data);
}
    // POST /DataAir/simpan/1
    public function simpan($id_sampling)
    {
        $modelHasil  = new HasilSamplingAirModel();
        $modelMaster = new MasterDataAirModel();
        $modelTitik  = new DataTitikSamplingAirModel();

        if ($modelTitik->sudahSnapshot((int)$id_sampling)) {
            $snapshotOutlet = $modelTitik->getByIdSampling((int)$id_sampling);
            $outlets = array_map(fn($s) => ['id' => $s['id_master_air']], $snapshotOutlet);
        } else {
            $row     = (new DataSamplingAirModel())->find($id_sampling);
            $outlets = $modelMaster->where('site', $row['site'])
                                   ->where('jenis_sampling', $row['jenis_sampling'])
                                   ->findAll();
        }

        foreach ($outlets as $outlet) {
            $id_master = $outlet['id'];

            $dataHasil = [
                'id_sampling'                  => $id_sampling,
                'id_master_air'                => $id_master,
                'hasil_warna'                  => $this->request->getPost('hasil_warna_'                  . $id_master),
                'hasil_bau'                    => $this->request->getPost('hasil_bau_'                    . $id_master),
                'hasil_ph'                     => $this->request->getPost('hasil_ph_'                     . $id_master),
                'hasil_suhu'                   => $this->request->getPost('hasil_suhu_'                   . $id_master),
                'hasil_conductivity'           => $this->request->getPost('hasil_conductivity_'           . $id_master),
                'hasil_kesadahan'              => $this->request->getPost('hasil_kesadahan_'              . $id_master),
                'hasil_zat_padat_total'        => $this->request->getPost('hasil_zat_padat_total_'        . $id_master),
                'hasil_toc'                    => $this->request->getPost('hasil_toc_'                    . $id_master),
                'hasil_tamc'                   => $this->request->getPost('hasil_tamc_'                   . $id_master),
                'hasil_tymc'                   => $this->request->getPost('hasil_tymc_'                   . $id_master),
                'hasil_coliform'               => $this->request->getPost('hasil_coliform_'               . $id_master),
                'hasil_e_coli'                 => $this->request->getPost('hasil_e_coli_'                 . $id_master),
                'hasil_salmonella_sp'          => $this->request->getPost('hasil_salmonella_sp_'          . $id_master),
                'hasil_staphylococcus_aureus'  => $this->request->getPost('hasil_staphylococcus_aureus_'  . $id_master),
                'hasil_pseudomonas_aeruginosa' => $this->request->getPost('hasil_pseudomonas_aeruginosa_' . $id_master),
                'hasil_shigella_sp'            => $this->request->getPost('hasil_shigella_sp_'            . $id_master),
                'hasil_enterobacteriaceae'     => $this->request->getPost('hasil_enterobacteriaceae_'     . $id_master),
                'hasil_clostridia'             => $this->request->getPost('hasil_clostridia_sporogens_' . $id_master),
                'hasil_sporogens'              => $this->request->getPost('hasil_clostridia_sporogens_' . $id_master),
            ];

            $existing = $modelHasil
                ->where('id_sampling', $id_sampling)
                ->where('id_master_air', $id_master)
                ->first();

            if ($existing) {
                $modelHasil->update($existing['id'], $dataHasil);
            } else {
                $modelHasil->insert($dataHasil);
            }
        }

        return redirect()->to('/DataAir/show/' . $id_sampling);
    }

    // GET /DataAir/hapusOutlet/1/5
    public function hapusOutlet($id_sampling, $id_master_air)
    {
        $modelHasil = new HasilSamplingAirModel();
        $db         = \Config\Database::connect();

        $modelHasil->where('id_sampling', $id_sampling)
                   ->where('id_master_air', $id_master_air)
                   ->delete();

        $db->table('sampling_air_excluded_outlet')->insert([
            'id_sampling'   => $id_sampling,
            'id_master_air' => $id_master_air,
        ]);

        return redirect()->to('/DataAir/show/' . $id_sampling);
    }

    // acc1 = QA Analis approve + SNAPSHOT titik sampling
    public function acc1($id)
    {
        $session     = session();
        $model       = new DataSamplingAirModel();
        $modelMaster = new MasterDataAirModel();
        $modelTitik  = new DataTitikSamplingAirModel();
        $db          = \Config\Database::connect();

        $row = $model->find($id);

        $model->update($id, [
            'approve_1'      => $session->get('username'),
            'approve_1_date' => date('Y-m-d H:i:s'),
            'status'         => 'Selesai di QA',
        ]);

        if (!$modelTitik->sudahSnapshot((int)$id)) {
            $excluded    = $db->table('sampling_air_excluded_outlet')
                              ->select('id_master_air')
                              ->where('id_sampling', $id)
                              ->get()->getResultArray();
            $excludedIds = array_column($excluded, 'id_master_air');

            $weekNum = str_replace('Week ', '', $row['week']);

            $masterQuery = $modelMaster
                ->where('site', $row['site'])
                ->where('jenis_sampling', $row['jenis_sampling'])
                ->where("FIND_IN_SET('{$weekNum}', jadwal_minggu_ke)", null, false);

            if (!empty($excludedIds)) {
                $masterQuery->whereNotIn('id', $excludedIds);
            }

            $outlets   = $masterQuery->findAll();
            $batchData = [];

            foreach ($outlets as $outlet) {
                $batchData[] = [
                    'id_sampling'          => $id,
                    'id_master_air'        => $outlet['id'],
                    'no_outlet_sampling'   => $outlet['no_outlet_sampling']   ?? null,
                    'nama_outlet_sampling' => $outlet['nama_outlet_sampling'] ?? null,
                    'lokasi'               => $outlet['lokasi']               ?? null,
                    'site'                 => $outlet['site']                 ?? null,
                    'jenis_sampling'       => $outlet['jenis_sampling']       ?? null,
                ];
            }

            if (!empty($batchData)) {
                $modelTitik->insertBatch($batchData);
            }
        }

        return redirect()->to('/DataAir/show/' . $id);
    }

    // acc2 = QC Analis Fisik & Kimia
    public function acc2($id)
    {
        $session = session();
        $model   = new DataSamplingAirModel();
        $row     = $model->find($id);

        $model->update($id, [
            'approve_qc_kimia'      => $session->get('username'),
            'approve_qc_kimia_date' => date('Y-m-d H:i:s'),
            'status'                => $row['approve_qc_mikro'] ? 'Selesai di QC' : 'Selesai di QA',
        ]);
        return redirect()->to('/DataAir/show/' . $id);
    }

    // acc3 = QC Analis Mikro
    public function acc3($id)
    {
        $session = session();
        $model   = new DataSamplingAirModel();
        $row     = $model->find($id);

        $model->update($id, [
            'approve_qc_mikro'      => $session->get('username'),
            'approve_qc_mikro_date' => date('Y-m-d H:i:s'),
            'status'                => $row['approve_qc_kimia'] ? 'Selesai di QC' : 'Selesai di QA',
        ]);
        return redirect()->to('/DataAir/show/' . $id);
    }

    // acc4 = Spv QC
    public function acc4($id)
    {
        $session = session();
        $model   = new DataSamplingAirModel();
        $model->update($id, [
            'approve_spv_qc'      => $session->get('username'),
            'approve_spv_qc_date' => date('Y-m-d H:i:s'),
            'status'              => 'Selesai di Spv QC',
        ]);
        return redirect()->to('/DataAir/show/' . $id);
    }

    // acc5 = Spv QA (final)
    public function acc5($id)
    {
        $session = session();
        $model   = new DataSamplingAirModel();
        $model->update($id, [
            'approve_spv_qa'      => $session->get('username'),
            'approve_spv_qa_date' => date('Y-m-d H:i:s'),
            'status'              => 'Selesai di Spv QA',
        ]);
        return redirect()->to('/DataAir/show/' . $id);
    }

    // ================================================================
    public function cetakPdf($id)
    {
        try {
            $model       = new DataSamplingAirModel();
            $modelHasil  = new HasilSamplingAirModel();
            $modelMaster = new MasterDataAirModel();
            $modelTitik  = new DataTitikSamplingAirModel();
            $modelSyarat = new MasterDataAirSyaratModel();
            $db          = \Config\Database::connect();
 
            $row = $model->find($id);
 
            if (!$row) {
                throw new \RuntimeException('Data sampling dengan id=' . $id . ' tidak ditemukan di tabel data_sampling_air.');
            }
 
            // ===== Ambil daftar outlet — pola sama persis dengan show() =====
            if ($modelTitik->sudahSnapshot((int)$id)) {
                $snapshotOutlet = $modelTitik->getByIdSampling((int)$id);
                $masterOutlet   = [];
                foreach ($snapshotOutlet as $s) {
                    $masterOutlet[] = [
                        'id'                   => $s['id_master_air'],
                        'no_outlet_sampling'   => $s['no_outlet_sampling'],
                        'nama_outlet_sampling' => $s['nama_outlet_sampling'],
                        'lokasi'               => $s['lokasi'],
                        'site'                 => $s['site'],
                        'jenis_sampling'       => $s['jenis_sampling'],
                    ];
                }
            } else {
                $excluded    = $db->table('sampling_air_excluded_outlet')
                                  ->select('id_master_air')
                                  ->where('id_sampling', $id)
                                  ->get()->getResultArray();
                $excludedIds = array_column($excluded, 'id_master_air');
 
                $weekNum = str_replace('Week ', '', $row['week']);
 
                $masterQuery = $modelMaster
                    ->where('site', $row['site'])
                    ->where('jenis_sampling', $row['jenis_sampling'])
                    ->where("FIND_IN_SET('{$weekNum}', jadwal_minggu_ke)", null, false);
 
                if (!empty($excludedIds)) {
                    $masterQuery->whereNotIn('id', $excludedIds);
                }
 
                $masterOutlet = $masterQuery->findAll();
            }
 
            // ===== Hasil pemeriksaan =====
            $hasilExisting = $modelHasil->where('id_sampling', $id)->findAll();
            $hasilIndex    = [];
            foreach ($hasilExisting as $h) {
                $hasilIndex[$h['id_master_air']] = $h;
            }
 
            // ===== Tentukan 1 section yang relevan langsung dari jenis_sampling
            //        milik laporan ini (BUKAN dicek per outlet) — karena 1
            //        data_sampling_air hanya pernah berisi outlet dari 1
            //        kategori saja (dijamin oleh query di atas: where site +
            //        where jenis_sampling exact match). =====
            $kategoriLaporan = ParameterAirDefinition::extractKategoriDariJenisSampling($row['jenis_sampling'] ?? '');
            $secConf         = ParameterAirDefinition::getSectionConfig($row['site'] ?? '', $kategoriLaporan);
                file_put_contents(WRITEPATH . 'debug_section.txt',
                    "site        : [" . ($row['site'] ?? '') . "]\n" .
                    "jenis_samp  : [" . ($row['jenis_sampling'] ?? '') . "]\n" .
                    "kategoriLap : [" . $kategoriLaporan . "]\n" .
                    "secConf null? : " . ($secConf === null ? 'YA (bermasalah)' : 'TIDAK') . "\n"
                );
            $semuaParam = ParameterAirDefinition::semua();
            $sections   = [];
 
            if ($secConf && !empty($masterOutlet)) {
                // DITAMBAHKAN: kumpulkan syarat semua outlet DULU (sebelum
                // menentukan daftar kolom), supaya bisa dicek parameter mana
                // yang N/A di SEMUA outlet section ini — parameter tersebut
                // akan difilter/dibuang dari daftar kolom yang ditampilkan
                // di PDF (bukan cuma nilainya kosong, tapi kolomnya hilang).
                $syaratPerOutlet = [];
                foreach ($masterOutlet as $outlet) {
                    $idMaster = $outlet['id'];
                    $syaratPerOutlet[$idMaster] = $modelSyarat->getIndexedByMasterId((int)$idMaster);
                }

                // DITAMBAHKAN: filter fisika/kimia/mikro — buang parameter yang
                // N/A di SEMUA outlet section ini (mis. TYMC untuk PW Cikarang)
                $fisikaAktif = ParameterAirDefinition::filterParamKolomAktif($secConf['fisika'], $syaratPerOutlet);
                $kimiaAktif  = ParameterAirDefinition::filterParamKolomAktif($secConf['kimia'], $syaratPerOutlet);
                $mikroAktif  = ParameterAirDefinition::filterParamKolomAktif($secConf['mikro'], $syaratPerOutlet);

                $paramKeysSection = array_merge($fisikaAktif, $kimiaAktif, $mikroAktif);

                $rows = [];
 
                foreach ($masterOutlet as $outlet) {
                    $idMaster      = $outlet['id'];
                    $syaratIndexed = $syaratPerOutlet[$idMaster]; // DIUBAH: reuse hasil loop di atas, tidak query ulang
 
                    $hasil = $hasilIndex[$idMaster] ?? [];
 
                    $kesimpulanRaw = ParameterAirDefinition::hitungKesimpulanBaris(
                        $syaratIndexed,
                        $hasil,
                        $paramKeysSection
                    );
                    $kesimpulanLabel = match ($kesimpulanRaw) {
                        'MS'  => 'MS',
                        'TMS' => 'TMS',
                        default => '-',
                    };
 
                    $nilai = [];
                    foreach ($paramKeysSection as $p) {
                        $fieldHasil = 'hasil_' . $p;
                        $raw        = $hasil[$fieldHasil] ?? null;
 
                        // format khusus pos/neg/N-A hanya untuk parameter mikro bertipe teks
                        $nilai[$p] = in_array($p, $mikroAktif, true)
                            ? ParameterAirDefinition::formatHasilMikro($raw)
                            : $raw;
                    }
 
                    $rows[] = [
                        'no_outlet_sampling'   => $outlet['no_outlet_sampling'],
                        'nama_outlet_sampling' => $outlet['nama_outlet_sampling'],
                        'nilai'                => $nilai,
                        'kesimpulan'           => $kesimpulanLabel,
                    ];
                }
 
                // Bangun label kriteria per kolom parameter
                $kriteria = [];
                foreach ($paramKeysSection as $p) {
                    $kriteria[$p] = ParameterAirDefinition::resolveKriteriaLabel(array_values($syaratPerOutlet), $p);
                }
 
                $sections[] = [
                    'kode'                   => $secConf['kode'],
                    'title'                  => $secConf['title'],
                    'referensi_fisika_kimia' => $secConf['referensi_fisika_kimia'],
                    'referensi_mikro'        => $secConf['referensi_mikro'],
                    'catatan'                => $secConf['catatan'],
                    'fisika'                 => $fisikaAktif, // DIUBAH: pakai hasil filter, bukan $secConf mentah
                    'kimia'                  => $kimiaAktif,  // DIUBAH
                    'mikro'                  => $mikroAktif,  // DIUBAH
                    'layout'                 => $secConf['layout'],
                    'kriteria'               => $kriteria,
                    'rows'                   => $rows,
                ];
            }
 
            // ===== Fallback: kalau kategori/site tidak dikenali (belum
            //        terdaftar di kategoriUtama()/kategoriPerSite()),
            //        pakai format tabel datar lama (semua parameter, 1 tabel) =====
            $dataOutletFlat = [];
            if (!$secConf) {
                $paramKeysSemua = array_keys($semuaParam);
                foreach ($masterOutlet as $outlet) {
                    $idMaster = $outlet['id'];
                    $hasil    = $hasilIndex[$idMaster] ?? [];
 
                    $syaratIndexed = $modelSyarat->getIndexedByMasterId((int)$idMaster);
                    $kesimpulanRaw = ParameterAirDefinition::hitungKesimpulanBaris($syaratIndexed, $hasil, $paramKeysSemua);
                    $kesimpulanLabel = match ($kesimpulanRaw) {
                        'MS'  => 'MS',
                        'TMS' => 'TMS',
                        default => '-',
                    };
 
                    $item = [
                        'no_outlet_sampling'   => $outlet['no_outlet_sampling'],
                        'nama_outlet_sampling' => $outlet['nama_outlet_sampling'],
                        'lokasi'               => $outlet['lokasi'],
                        'kesimpulan'           => $kesimpulanLabel,
                    ];
                    foreach ($paramKeysSemua as $p) {
                        $item['hasil_' . $p] = in_array($p, array_keys(ParameterAirDefinition::mikrobiologi()), true)
                            ? ParameterAirDefinition::formatHasilMikro($hasil['hasil_' . $p] ?? null)
                            : ($hasil['hasil_' . $p] ?? null);
                    }
                    $dataOutletFlat[] = $item;
                }
            }

            // ===== DITAMBAHKAN: ambil scan hasil analisa Fisika & Kimia =====
            // Gambar (JPG/PNG) akan di-embed via HTML <img> di view.
            // File PDF akan digabung sebagai halaman baru via FPDI setelah
            // WriteHTML() dipanggil, supaya jadi 1 file PDF utuh untuk arsip.
            $modelScan   = new ScanHasilAirModel();
            $scanListRaw = $modelScan->getBySampling((int)$id);

            $scanImages = [];
            $scanPdfs   = [];

            foreach ($scanListRaw as $scan) {
                $ext      = strtolower(pathinfo($scan['nama_file'], PATHINFO_EXTENSION));
                $filePath = FCPATH . 'uploads/scan_hasil_air/' . $scan['nama_file'];

                if (!is_file($filePath)) {
                    continue; // file fisik tidak ditemukan di server, skip
                }

                if (in_array($ext, ['jpg', 'jpeg', 'png'])) {
                    $scanImages[] = [
                        'nama_asli'   => $scan['nama_asli'],
                        'uploaded_by' => $scan['uploaded_by'],
                        'uploaded_at' => $scan['uploaded_at'],
                        'file_path'   => $filePath,
                    ];
                } elseif ($ext === 'pdf') {
                    $scanPdfs[] = [
                        'nama_asli'   => $scan['nama_asli'],
                        'uploaded_by' => $scan['uploaded_by'],
                        'uploaded_at' => $scan['uploaded_at'],
                        'file_path'   => $filePath,
                    ];
                }
            }
 
            // ===== Logo =====
            $logoPath     = ROOTPATH . 'public/logob7.png';
            $approvedPath = ROOTPATH . 'public/Approved3.png';
 
            $imageSrc         = $this->imageToBase64($logoPath);
            $imageSrcApproved = $this->imageToBase64($approvedPath);
 
            // ===== Cek file view ada atau tidak SEBELUM di-render =====
            $viewPath = APPPATH . 'Views/AtRest/ReportSamplingAirPdf.php';
            if (!is_file($viewPath)) {
                throw new \RuntimeException('File view tidak ditemukan di: ' . $viewPath);
            }
 
            $html = view('AtRest/ReportSamplingAirPdf', [
                'row'              => $row,
                'sections'         => $sections,
                'dataOutletFlat'   => $dataOutletFlat,
                'imageSrc'         => $imageSrc,
                'imageSrcApproved' => $imageSrcApproved,
                //'scanImages'       => $scanImages, // DITAMBAHKAN
            ]);
 
            // DIUBAH: pakai Fpdi (turunan Mpdf) supaya bisa import halaman PDF lain
            $mpdf = new \Mpdf\Mpdf([
                'mode'          => 'utf-8',
                'format'        => 'A4',
                'orientation'   => 'L',
                'margin_top'    => 28,
                'margin_bottom' => 30,
                'margin_footer' => 2,
            ]);
                ini_set('pcre.backtrack_limit', '10000000');   // naikkan dari default 1 juta jadi 10 juta
                ini_set('pcre.recursion_limit', '10000000');   // jaga-jaga, biar konsisten
            $mpdf->WriteHTML($html);

            if (!empty($scanImages)) {
    // DIUBAH: pindah halaman DULU, baru reset header/footer —
    // supaya halaman laporan sebelumnya (footer MAUPUN header) tidak ikut kosong.
                $mpdf->WriteHTML('<pagebreak />');

                $mpdf->WriteHTML('<htmlpagefooter name="empty_footer_img"></htmlpagefooter>');
                $mpdf->WriteHTML('<sethtmlpagefooter name="empty_footer_img" value="on" show-this-page="1" />');
                $mpdf->WriteHTML('<htmlpageheader name="empty_header_img"></htmlpageheader>');
                $mpdf->WriteHTML('<sethtmlpageheader name="empty_header_img" value="on" show-this-page="1" />');

                $mpdf->WriteHTML('<div class="section-title">Lampiran: Scan Hasil Analisa Fisika &amp; Kimia</div>');

                foreach ($scanImages as $i => $scan) {
                    if ($i > 0) {
                        $mpdf->WriteHTML('<pagebreak />');
                    }

                    $mpdf->WriteHTML(
                        '<table class="noborder" style="margin-bottom: 8px;"><tr><td style="text-align:left; font-size:8pt;">'
                        . '<strong>' . esc($scan['nama_asli']) . '</strong><br>'
                        . 'Diupload oleh: ' . esc($scan['uploaded_by']) . ' &middot; '
                        . date('d/m/Y H:i', strtotime($scan['uploaded_at']))
                        . '</td></tr></table>'
                    );

                    $mpdf->WriteHTML(
                        '<div style="text-align:center;"><img src="' . $scan['file_path'] . '" style="max-width:100%; max-height:650px;"></div>'
                    );
                }
            }

            if (!empty($scanPdfs)) {
                // DIUBAH: pindah halaman dulu + reset header/footer, pola sama seperti scanImages
                $mpdf->WriteHTML('<pagebreak />');
                $mpdf->WriteHTML('<htmlpagefooter name="empty_footer_pdf"></htmlpagefooter>');
                $mpdf->WriteHTML('<sethtmlpagefooter name="empty_footer_pdf" value="on" show-this-page="1" />');
                $mpdf->WriteHTML('<htmlpageheader name="empty_header_pdf"></htmlpageheader>');
                $mpdf->WriteHTML('<sethtmlpageheader name="empty_header_pdf" value="on" show-this-page="1" />');

                foreach ($scanPdfs as $i => $pdfScan) {
                    try {
                        if ($i > 0) {
                            $mpdf->AddPage();
                        }
                        $mpdf->WriteHTML(
                            '<h4 style="font-size: 11pt;">Lampiran Scan: ' . esc($pdfScan['nama_asli']) . '</h4>' .
                            '<p style="font-size: 8pt; color: #666;">Diupload oleh: ' . esc($pdfScan['uploaded_by']) .
                            ' &middot; ' . date('d/m/Y H:i', strtotime($pdfScan['uploaded_at'])) . '</p>'
                        );

                        $pageCount = $mpdf->setSourceFile($pdfScan['file_path']);

                        if (!$pageCount) {
                            file_put_contents(
                                WRITEPATH . 'debug_pdf_error.txt',
                                "===== GAGAL: setSourceFile return falsy =====\n" .
                                "File   : " . $pdfScan['file_path'] . "\n" .
                                "Return : " . var_export($pageCount, true) . "\n" .
                                "Waktu  : " . date('Y-m-d H:i:s') . "\n\n",
                                FILE_APPEND
                            );
                            continue;
                        }

                        for ($p = 1; $p <= $pageCount; $p++) {
                            $tplId     = $mpdf->importPage($p);
                            $tplSize   = $mpdf->getTemplateSize($tplId);
                            $orientasi = ($tplSize['width'] > $tplSize['height']) ? 'L' : 'P';

                            $mpdf->AddPage($orientasi);
                            $mpdf->useTemplate($tplId);
                        }
                    } catch (\Throwable $e) {
                        file_put_contents(
                            WRITEPATH . 'debug_pdf_error.txt',
                            "===== GAGAL IMPORT SCAN PDF =====\n" .
                            "File   : " . $pdfScan['nama_asli'] . "\n" .
                            "Pesan  : " . $e->getMessage() . "\n" .
                            "Waktu  : " . date('Y-m-d H:i:s') . "\n\n",
                            FILE_APPEND
                        );
                        continue;
                    }
                }
            }


            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename="Report_Sampling_Air.pdf"');
 
            ob_clean();
 
            $siteName = isset($row['site']) ? str_replace(' ', '_', $row['site']) : 'Site';
            $tanggal  = $row['tanggal_sampling'] ?? date('Y-m-d');
            $filename = 'Report_Sampling_Air_' . $siteName . '_' . $tanggal . '.pdf';
 
            ob_clean();
            $mpdf->Output($filename, 'I');
            exit;
 
        } catch (\Throwable $e) {
            // ===== Tangkap SEMUA jenis error/exception, tulis ke file teks =====
            $logContent  = "===== ERROR cetakPdf(id={$id}) =====\n";
            $logContent .= "Waktu     : " . date('Y-m-d H:i:s') . "\n";
            $logContent .= "Pesan     : " . $e->getMessage() . "\n";
            $logContent .= "File      : " . $e->getFile() . "\n";
            $logContent .= "Baris     : " . $e->getLine() . "\n";
            $logContent .= "Class     : " . get_class($e) . "\n";
            $logContent .= "Stack Trace:\n" . $e->getTraceAsString() . "\n";
            $logContent .= "=====================================\n\n";
 
            file_put_contents(
                WRITEPATH . 'debug_pdf_error.txt',
                $logContent,
                FILE_APPEND
            );
 
            // Tampilkan pesan singkat di browser (plain text, tidak akan diblokir AV)
            header('Content-Type: text/plain');
            echo "Terjadi error saat membuat PDF.\n\n";
            echo "Pesan: " . $e->getMessage() . "\n";
            echo "File : " . $e->getFile() . "\n";
            echo "Baris: " . $e->getLine() . "\n\n";
            echo "Detail lengkap tersimpan di: writable/debug_pdf_error.txt";
            exit;
        }
    }
 
    // ================================================================
    // Helper: convert gambar ke base64 (sama seperti pola PatogenSwab)
    // ================================================================
    private function imageToBase64($path)
    {
        if (!is_file($path)) {
            return '';
        }
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        return 'data:image/' . $type . ';base64,' . base64_encode($data);
    }

    // ================================================================
    // Helper internal: ambil info outlet (nama/no outlet) + hitung
    // parameter mana saja yang TMS untuk 1 outlet tertentu.
    // Dipakai bersama oleh requestOOS() dan requestPenyimpangan().
    // ================================================================
    private function siapkanDataEskalasiOutlet($idSampling, $idMasterAir)
    {
        $model       = new DataSamplingAirModel();
        $modelHasil  = new HasilSamplingAirModel();
        $modelTitik  = new DataTitikSamplingAirModel();
        $modelMaster = new MasterDataAirModel();
        $modelSyarat = new MasterDataAirSyaratModel();

        $row = $model->find($idSampling);
        if (!$row) {
            return null;
        }

        // Ambil info outlet — pakai snapshot kalau sudah ada (sama pola dengan show()/cetakPdf())
        if ($modelTitik->sudahSnapshot((int)$idSampling)) {
            $outlet = $modelTitik->where('id_sampling', $idSampling)
                                  ->where('id_master_air', $idMasterAir)
                                  ->first();
        } else {
            $outlet = $modelMaster->find($idMasterAir);
        }

        if (!$outlet) {
            return null;
        }

        $namaOutlet = $outlet['nama_outlet_sampling'] ?? null;
        $noOutlet   = $outlet['no_outlet_sampling'] ?? null;

        // Hitung parameter mana saja yang TMS untuk outlet ini
        $hasil         = $modelHasil->where('id_sampling', $idSampling)
                                     ->where('id_master_air', $idMasterAir)
                                     ->first() ?? [];
        $syaratIndexed = $modelSyarat->getIndexedByMasterId((int)$idMasterAir);
        $paramDef      = ParameterAirDefinition::semua();

        $parameterTms = [];
        foreach (array_keys($paramDef) as $p) {
            $syarat     = $syaratIndexed[$p] ?? null;
            $nilaiHasil = $hasil['hasil_' . $p] ?? null;
            $status     = ParameterAirDefinition::evaluasiParameter($syarat, $nilaiHasil);
            if ($status === 'TMS') {
                $parameterTms[] = $paramDef[$p]['label'] ?? $p;
            }
        }

        return [
            'row'                  => $row,
            'nama_outlet_sampling' => $namaOutlet,
            'no_outlet_sampling'   => $noOutlet,
            'parameter_tms'        => implode(', ', $parameterTms),
        ];
    }

    // POST /DataAir/requestOOS — dipanggil via AJAX dari tombol "OOS"
    // per baris outlet yang berkesimpulan TMS di halaman detail.
    public function requestOOS()
    {
        $idSampling  = $this->request->getPost('id_sampling');
        $idMasterAir = $this->request->getPost('id_master_air');

        if (!$idSampling || !$idMasterAir) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'ID Sampling atau ID Outlet tidak ditemukan',
            ]);
        }

        $siap = $this->siapkanDataEskalasiOutlet($idSampling, $idMasterAir);
        if (!$siap) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Data sampling atau outlet tidak ditemukan',
            ]);
        }

        $oosAirModel = new OosAirModel();

        $inserted = $oosAirModel->insert([
            'id_sampling'          => $idSampling,
            'id_master_air'        => $idMasterAir,
            'nama_outlet_sampling' => $siap['nama_outlet_sampling'],
            'no_outlet_sampling'   => $siap['no_outlet_sampling'],
            'site'                 => $siap['row']['site'] ?? null,
            'tanggal_sampling'     => $siap['row']['tanggal_sampling'] ?? null,
            'parameter_tms'        => $siap['parameter_tms'],
            'created_at'           => date('Y-m-d H:i:s'),
        ]);

        if ($inserted) {
            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'Request OOS berhasil dikirim',
            ]);
        }

        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'Gagal menyimpan data OOS',
        ]);
    }

    // POST /DataAir/requestPenyimpangan — sama seperti requestOOS(), tapi
    // ditujukan ke tabel penyimpangan_air.
    public function requestPenyimpangan()
    {
        $idSampling  = $this->request->getPost('id_sampling');
        $idMasterAir = $this->request->getPost('id_master_air');

        if (!$idSampling || !$idMasterAir) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'ID Sampling atau ID Outlet tidak ditemukan',
            ]);
        }

        $siap = $this->siapkanDataEskalasiOutlet($idSampling, $idMasterAir);
        if (!$siap) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Data sampling atau outlet tidak ditemukan',
            ]);
        }

        $penyimpanganAirModel = new PenyimpanganAirModel();

        $inserted = $penyimpanganAirModel->insert([
            'id_sampling'          => $idSampling,
            'id_master_air'        => $idMasterAir,
            'nama_outlet_sampling' => $siap['nama_outlet_sampling'],
            'no_outlet_sampling'   => $siap['no_outlet_sampling'],
            'site'                 => $siap['row']['site'] ?? null,
            'tanggal_sampling'     => $siap['row']['tanggal_sampling'] ?? null,
            'parameter_tms'        => $siap['parameter_tms'],
            'created_at'           => date('Y-m-d H:i:s'),
        ]);

        if ($inserted) {
            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'Request Penyimpangan berhasil dikirim',
            ]);
        }

        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'Gagal menyimpan data Penyimpangan',
        ]);
    }

}