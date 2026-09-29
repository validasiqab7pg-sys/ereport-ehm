<?php

namespace App\Controllers;

use App\Models\DataSamplingAirModel;
use App\Models\AhuModel;
use App\Models\AhuSwabModel;

class MyTask extends BaseController
{
    // GET /MyTask
    public function index()
    {
        $session = session();
        $jabatan = $session->get('jabatan');

        // Gabungkan pending task dari 3 modul berbeda jadi 1 array seragam
        $tasks = array_merge(
            $this->getPendingDataAir($jabatan),
            $this->getPendingEhmRuangan($jabatan),
            $this->getPendingEhmSwab($jabatan)
        );

        // Urutkan: tanggal sampling/pemeriksaan TERLAMA dulu (paling mendesak di atas)
        usort($tasks, function ($a, $b) {
            $tglA = $a['tanggal'] ? strtotime($a['tanggal']) : PHP_INT_MAX;
            $tglB = $b['tanggal'] ? strtotime($b['tanggal']) : PHP_INT_MAX;
            return $tglA <=> $tglB;
        });

        $data = [
            'session' => $session,
            'jabatan' => $jabatan,
            'tasks'   => $tasks,
        ];

        return view('AtRest/my_task', $data);
    }

    // ================================================================
    // MODUL 1: EHM Air (data_sampling_air)
    // Alur approval: QA Analis -> QC Analis (kimia & mikro paralel) ->
    // Spv QC -> Spv QA / Manager QA
    // ================================================================
    private function getPendingDataAir(?string $jabatan): array
    {
        $model = new DataSamplingAirModel();

        switch ($jabatan) {
            case 'QA Analis':
                $rows = $model->where('approve_1 IS NULL', null, false)->findAll();
                break;

            case 'QC Analis':
                $rows = $model->where('approve_1 IS NOT NULL', null, false)
                    ->groupStart()
                        ->where('approve_qc_kimia IS NULL', null, false)
                        ->orWhere('approve_qc_mikro IS NULL', null, false)
                    ->groupEnd()
                    ->findAll();
                break;

            case 'Spv QC':
                $rows = $model->where('approve_qc_kimia IS NOT NULL', null, false)
                    ->where('approve_qc_mikro IS NOT NULL', null, false)
                    ->where('approve_spv_qc IS NULL', null, false)
                    ->findAll();
                break;

            case 'Spv QA':
            case 'Manager QA':
                $rows = $model->where('approve_spv_qc IS NOT NULL', null, false)
                    ->where('approve_spv_qa IS NULL', null, false)
                    ->findAll();
                break;

            default:
                return [];
        }

        $result = [];
        foreach ($rows as $row) {
            $result[] = [
                'no_dokumen' => 'EHM-AIR-' . $row['id'],
                'jenis_ehm'  => 'EHM Air',
                'tanggal'    => $row['tanggal_sampling'] ?? null,
                'url_detail' => base_url('DataAir/show/' . $row['id']),
                'pending'    => 'Menunggu Approval Anda (' . $jabatan . ')',
            ];
        }

        return $result;
    }

    // ================================================================
    // MODUL 2: Kualifikasi & EHM Ruangan (tabel ahu, via AhuModel)
    // Alur approval linear: QA Analis -> QC Analis -> Spv QC -> Spv QA
    // jenispemeriksaan bisa 'Kualifikasi' atau 'EHM', label beda sesuai itu.
    // ================================================================
    private function getPendingEhmRuangan(?string $jabatan): array
    {
        $model = new AhuModel();

        // DIUBAH: kolom approve_x di tabel ini kadang tersimpan sebagai
        // string kosong/spasi (" "), bukan NULL murni. Jadi "belum diisi"
        // dicek dengan (IS NULL OR TRIM(...) = ''), dan "sudah diisi"
        // dicek dengan kebalikannya, supaya kedua kondisi data tertangkap.
        switch ($jabatan) {
            case 'QA Analis':
                $rows = $model->groupStart()
                        ->where('approve_1 IS NULL', null, false)
                        ->orWhere("TRIM(approve_1) =", '')
                    ->groupEnd()
                    ->findAll();
                break;

            case 'QC Analis':
                $rows = $model->groupStart()
                        ->where('approve_1 IS NOT NULL', null, false)
                        ->where("TRIM(approve_1) !=", '')
                    ->groupEnd()
                    ->groupStart()
                        ->where('approve_2 IS NULL', null, false)
                        ->orWhere("TRIM(approve_2) =", '')
                    ->groupEnd()
                    ->findAll();
                break;

            case 'Spv QC':
                $rows = $model->groupStart()
                        ->where('approve_2 IS NOT NULL', null, false)
                        ->where("TRIM(approve_2) !=", '')
                    ->groupEnd()
                    ->groupStart()
                        ->where('approve_3 IS NULL', null, false)
                        ->orWhere("TRIM(approve_3) =", '')
                    ->groupEnd()
                    ->findAll();
                break;

            case 'Spv QA':
            case 'Manager QA':
                $rows = $model->groupStart()
                        ->where('approve_3 IS NOT NULL', null, false)
                        ->where("TRIM(approve_3) !=", '')
                    ->groupEnd()
                    ->groupStart()
                        ->where('approve_4 IS NULL', null, false)
                        ->orWhere("TRIM(approve_4) =", '')
                    ->groupEnd()
                    ->findAll();
                break;

            default:
                return [];
        }

        $result = [];
        foreach ($rows as $row) {
            $isKualifikasi = strtolower(trim($row['jenispemeriksaan'] ?? '')) === 'kualifikasi';

            $result[] = [
                'no_dokumen' => ($isKualifikasi ? 'KUALIFIKASI-RUANGAN-' : 'EHM-RUANGAN-') . $row['id'],
                'jenis_ehm'  => $isKualifikasi ? 'Kualifikasi Ruangan' : 'EHM Ruangan',
                'tanggal'    => $row['tanggaldilakukan'] ?? null,
                'url_detail' => base_url('DataPpoj/ViewDetail/' . $row['id']),
                'pending'    => 'Menunggu Approval Anda (' . $jabatan . ')',
            ];
        }

        return $result;
    }

    // ================================================================
    // MODUL 3: EHM Swab (tabel ahu_swab, via AhuSwabModel)
    // Alur approval linear: QA Analis -> QC Analis -> Spv QC -> Spv QA
    // ================================================================
    private function getPendingEhmSwab(?string $jabatan): array
    {
        $model = new AhuSwabModel();

        // DIUBAH: sama seperti AhuModel, kolom approve_x di tabel ini
        // juga tersimpan sebagai string kosong (""), bukan NULL murni.
        switch ($jabatan) {
            case 'QA Analis':
                $rows = $model->groupStart()
                        ->where('approve_1 IS NULL', null, false)
                        ->orWhere("TRIM(approve_1) =", '')
                    ->groupEnd()
                    ->findAll();
                break;

            case 'QC Analis':
                $rows = $model->groupStart()
                        ->where('approve_1 IS NOT NULL', null, false)
                        ->where("TRIM(approve_1) !=", '')
                    ->groupEnd()
                    ->groupStart()
                        ->where('approve_2 IS NULL', null, false)
                        ->orWhere("TRIM(approve_2) =", '')
                    ->groupEnd()
                    ->findAll();
                break;

            case 'Spv QC':
                $rows = $model->groupStart()
                        ->where('approve_2 IS NOT NULL', null, false)
                        ->where("TRIM(approve_2) !=", '')
                    ->groupEnd()
                    ->groupStart()
                        ->where('approve_3 IS NULL', null, false)
                        ->orWhere("TRIM(approve_3) =", '')
                    ->groupEnd()
                    ->findAll();
                break;

            case 'Spv QA':
            case 'Manager QA':
                $rows = $model->groupStart()
                        ->where('approve_3 IS NOT NULL', null, false)
                        ->where("TRIM(approve_3) !=", '')
                    ->groupEnd()
                    ->groupStart()
                        ->where('approve_4 IS NULL', null, false)
                        ->orWhere("TRIM(approve_4) =", '')
                    ->groupEnd()
                    ->findAll();
                break;

            default:
                return [];
        }

        $result = [];
        foreach ($rows as $row) {
            $result[] = [
                'no_dokumen' => 'EHM-SWAB-' . $row['id'],
                'jenis_ehm'  => 'EHM Swab',
                'tanggal'    => $row['tanggal_sampling'] ?? null,
                'url_detail' => base_url('DataPpojSwab/ViewDetail/' . $row['id']),
                'pending'    => 'Menunggu Approval Anda (' . $jabatan . ')',
            ];
        }

        return $result;
    }
}