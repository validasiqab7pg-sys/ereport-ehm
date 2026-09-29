<?php

namespace App\Controllers;

use App\Models\DataSamplingAirModel;
use App\Models\HasilSamplingAirModel;
use App\Models\DataTitikSamplingAirModel;
use App\Models\MasterDataAirSyaratModel;
use App\Libraries\ParameterAirDefinition;
use App\Models\ScanHasilAirModel;
use CodeIgniter\Controller;

class FisikKimiaAir extends BaseController
{
    public function index()
    {
        $session    = session();
        $model      = new DataSamplingAirModel();
        $modelTitik = new DataTitikSamplingAirModel();

        $semuaData   = $model->where('approve_1 IS NOT NULL')->findAll();
        $jumlahTitik = $modelTitik->getJumlahPerSampling();

        foreach ($semuaData as &$row) {
            $row['jumlah_titik'] = $jumlahTitik[$row['id']] ?? 0;
        }

        $data['data']    = $semuaData;
        $data['session'] = $session;

        return view('AtRest/fisik_kimia_view', $data);
    }

    // GET /FisikKimiaAir/detail/1
    public function detail($id)
    {
        $session     = session();
        $model       = new DataSamplingAirModel();
        $modelHasil  = new HasilSamplingAirModel();
        $modelTitik  = new DataTitikSamplingAirModel();
        $modelSyarat = new MasterDataAirSyaratModel();

        $row          = $model->find($id);
        $masterOutlet = $modelTitik->getByIdSampling((int)$id);

        $hasilExisting = $modelHasil->where('id_sampling', $id)->findAll();
        $hasilIndex    = [];
        foreach ($hasilExisting as $h) {
            $hasilIndex[$h['id_master_air']] = $h;
        }

        // ===== Hitung kesimpulan MS/TMS per titik sampling =====
        $paramKeys       = array_keys(ParameterAirDefinition::fisikaKimia());
        $kesimpulanIndex = [];
        $syaratIndex     = []; // DITAMBAHKAN: dikirim ke view untuk deteksi N/A per field

        foreach ($masterOutlet as $outlet) {
            $idMaster      = $outlet['id_master_air'];
            $syaratIndexed = $modelSyarat->getIndexedByMasterId((int)$idMaster);
            $syaratIndex[$idMaster] = $syaratIndexed; // DITAMBAHKAN
            $hasilRow      = $hasilIndex[$idMaster] ?? [];

            $kesimpulanIndex[$idMaster] = ParameterAirDefinition::hitungKesimpulanBaris(
                $syaratIndexed,
                $hasilRow,
                $paramKeys
            );
        }

        $data['row']             = $row;
        $data['masterOutlet']    = $masterOutlet;
        $data['hasilIndex']      = $hasilIndex;
        $data['kesimpulanIndex'] = $kesimpulanIndex;
        $data['syaratIndex']     = $syaratIndex; // DITAMBAHKAN
        $data['session']         = $session;

        $modelScan = new ScanHasilAirModel();
        $data['scanList']      = $modelScan->getBySampling((int)$id);
        $data['canUploadScan'] = in_array($session->get('jabatan'), ['QC Analis', 'Spv QC']);

        return view('AtRest/fisik_kimia_detail_view', $data);
    }

    public function uploadScan($id_sampling)
    {
        $session = session();
        $jabatan = $session->get('jabatan');

        if (!in_array($jabatan, ['QC Analis', 'Spv QC'])) {
            session()->setFlashdata('Toast', 'Anda tidak memiliki akses untuk upload scan');
            return redirect()->to('/FisikKimiaAir/detail/' . $id_sampling);
        }

        $files = $this->request->getFiles();
        if (empty($files['scan_file'])) {
            session()->setFlashdata('Toast', 'Tidak ada file dipilih');
            return redirect()->to('/FisikKimiaAir/detail/' . $id_sampling);
        }

        $uploadPath = FCPATH . 'uploads/scan_hasil_air/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $modelScan     = new ScanHasilAirModel();
        $allowedMime   = ['image/jpeg', 'image/png', 'image/jpg', 'application/pdf'];
        $maxSize       = 5 * 1024 * 1024;
        $berhasil      = 0;

        foreach ($files['scan_file'] as $file) {
            if (!$file->isValid() || $file->hasMoved()) continue;
            if (!in_array($file->getMimeType(), $allowedMime)) continue;
            if ($file->getSize() > $maxSize) continue;

            $newName = $file->getRandomName();
            $file->move($uploadPath, $newName);

            $modelScan->insert([
                'id_sampling' => $id_sampling,
                'nama_asli'   => $file->getClientName(),
                'nama_file'   => $newName,
                'uploaded_by' => $session->get('username'),
                'uploaded_at' => date('Y-m-d H:i:s'),
            ]);
            $berhasil++;
        }

        session()->setFlashdata('Toast', $berhasil > 0
            ? $berhasil . ' file berhasil diupload'
            : 'Tidak ada file valid (format: jpg/png/pdf, maks 5MB)');
        return redirect()->to('/FisikKimiaAir/detail/' . $id_sampling);
    }

    public function hapusScan($id_scan)
    {
        $session   = session();
        $modelScan = new ScanHasilAirModel();
        $scan      = $modelScan->find($id_scan);

        if (!$scan) return redirect()->back();

        if (!in_array($session->get('jabatan'), ['QC Analis', 'Spv QC'])) {
            session()->setFlashdata('Toast', 'Anda tidak memiliki akses untuk menghapus scan');
            return redirect()->to('/FisikKimiaAir/detail/' . $scan['id_sampling']);
        }

        $filePath = FCPATH . 'uploads/scan_hasil_air/' . $scan['nama_file'];
        if (is_file($filePath)) unlink($filePath);
        $modelScan->delete($id_scan);

        session()->setFlashdata('Toast', 'File berhasil dihapus');
        return redirect()->to('/FisikKimiaAir/detail/' . $scan['id_sampling']);
    }

    // POST /FisikKimiaAir/simpan/1
    public function simpan($id_sampling)
    {
        $modelHasil = new HasilSamplingAirModel();

        $id_master = $this->request->getPost('id_master');

        if (!$id_master) {
            session()->setFlashdata('Toast', 'Data outlet tidak valid');
            return redirect()->to('/FisikKimiaAir/detail/' . $id_sampling);
        }

        $dataHasil = [
            'id_sampling'           => $id_sampling,
            'id_master_air'         => $id_master,
            'hasil_warna'           => $this->request->getPost('hasil_warna_'           . $id_master),
            'hasil_bau'             => $this->request->getPost('hasil_bau_'             . $id_master),
            'hasil_ph'              => $this->request->getPost('hasil_ph_'              . $id_master),
            'hasil_suhu'            => $this->request->getPost('hasil_suhu_'            . $id_master),
            'hasil_conductivity'    => $this->request->getPost('hasil_conductivity_'    . $id_master),
            'hasil_kesadahan'       => $this->request->getPost('hasil_kesadahan_'       . $id_master),
            'hasil_zat_padat_total' => $this->request->getPost('hasil_zat_padat_total_' . $id_master),
            'hasil_toc'             => $this->request->getPost('hasil_toc_'             . $id_master),
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

        session()->setFlashdata('Toast', 'Data berhasil disimpan');
        return redirect()->to('/FisikKimiaAir/detail/' . $id_sampling);
    }

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
        return redirect()->to('/FisikKimiaAir/detail/' . $id);
    }

    public function acc4($id)
    {
        $session = session();
        $model   = new DataSamplingAirModel();
        $model->update($id, [
            'approve_spv_qc'      => $session->get('username'),
            'approve_spv_qc_date' => date('Y-m-d H:i:s'),
            'status'              => 'Selesai di Spv QC',
        ]);
        return redirect()->to('/FisikKimiaAir/detail/' . $id);
    }

    public function acc5($id)
    {
        $session = session();
        $model   = new DataSamplingAirModel();
        $model->update($id, [
            'approve_spv_qa'      => $session->get('username'),
            'approve_spv_qa_date' => date('Y-m-d H:i:s'),
            'status'              => 'Selesai di Spv QA',
        ]);
        return redirect()->to('/FisikKimiaAir/detail/' . $id);
    }
}