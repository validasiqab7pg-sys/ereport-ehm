<?php

namespace App\Controllers;

use App\Models\DataSamplingAirModel;
use App\Models\HasilSamplingAirModel;
use App\Models\DataTitikSamplingAirModel;
use App\Models\MasterDataAirSyaratModel;
use App\Libraries\ParameterAirDefinition;
use CodeIgniter\Controller;

class MikroAir extends BaseController
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

        return view('AtRest/mikro_air_view', $data);
    }

    // GET /MikroAir/detail/1
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

        $paramKeys       = array_keys(ParameterAirDefinition::mikrobiologi());
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

        return view('AtRest/mikro_air_detail_view', $data);
    }

    // POST /MikroAir/simpan/1
    public function simpan($id_sampling)
    {
        $modelHasil = new HasilSamplingAirModel();

        $id_master = $this->request->getPost('id_master');

        if (!$id_master) {
            session()->setFlashdata('Toast', 'Data outlet tidak valid');
            return redirect()->to('/MikroAir/detail/' . $id_sampling);
        }

        $dataHasil = [
            'id_sampling'                  => $id_sampling,
            'id_master_air'                => $id_master,
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

        session()->setFlashdata('Toast', 'Data berhasil disimpan');
        return redirect()->to('/MikroAir/detail/' . $id_sampling);
    }

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
        return redirect()->to('/MikroAir/detail/' . $id);
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
        return redirect()->to('/MikroAir/detail/' . $id);
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
        return redirect()->to('/MikroAir/detail/' . $id);
    }
}