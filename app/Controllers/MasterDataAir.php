<?php

namespace App\Controllers;

use App\Models\MasterDataAirModel;
use App\Models\MasterDataAirSyaratModel;
use App\Libraries\ParameterAirDefinition;
use CodeIgniter\Controller;

class MasterDataAir extends Controller
{
    public function index()
    {
        $session     = session();
        $model       = new MasterDataAirModel();
        $modelSyarat = new MasterDataAirSyaratModel();

        $semuaData = $model->findAll();

        // Ambil syarat terstruktur per baris untuk ditampilkan di modal Edit
        $syaratIndex = [];
        foreach ($semuaData as $row) {
            $syaratIndex[$row['id']] = $modelSyarat->getIndexedByMasterId($row['id']);
        }

        $data['data']        = $semuaData;
        $data['syaratIndex'] = $syaratIndex;
        $data['session']     = $session;

        return view('AtRest/master_data_air', $data);
    }

    public function create()
    {
        $model       = new MasterDataAirModel();
        $modelSyarat = new MasterDataAirSyaratModel();

        $idBaru = $model->insert($this->_getPostData());

        $modelSyarat->replaceForMaster((int)$idBaru, $this->_collectSyaratFromPost());

        return redirect()->to('/MasterDataAir');
    }

    public function edit($id)
    {
        $model       = new MasterDataAirModel();
        $modelSyarat = new MasterDataAirSyaratModel();

        $model->update($id, $this->_getPostData());

        $modelSyarat->replaceForMaster((int)$id, $this->_collectSyaratFromPost());

        return redirect()->to('/MasterDataAir');
    }

    public function delete($id)
    {
        // Tidak perlu hapus manual di master_data_air_syarat —
        // sudah ditangani otomatis oleh FK ON DELETE CASCADE.
        $model = new MasterDataAirModel();
        $model->delete($id);

        return redirect()->to('/MasterDataAir');
    }

    // ----------------------------------------------------------------
    // Helper: kumpulkan POST identitas + syarat_xxx (label otomatis)
    // ----------------------------------------------------------------
    private function _getPostData(): array
    {
        $jenisSampling = $this->request->getPost('jenis_sampling');
        if ($jenisSampling === '__lainnya__') {
            $jenisSampling = $this->request->getPost('jenis_sampling_manual');
        }

        $data = [
            'lokasi'               => $this->request->getPost('lokasi'),
            'site'                 => $this->request->getPost('site'),
            'jenis_sampling'       => $jenisSampling,
            'no_outlet_sampling'   => $this->request->getPost('no_outlet_sampling'),
            'nama_outlet_sampling' => $this->request->getPost('nama_outlet_sampling'),
            'jadwal_minggu_ke'     => $this->request->getPost('jadwal_minggu_ke'),
        ];

        // syarat_xxx dibentuk OTOMATIS dari operator+nilai (Opsi B),
        // bukan lagi diketik manual oleh user
        foreach (ParameterAirDefinition::semua() as $param => $def) {
            $tipe      = $def['tipe'];
            $operator  = $this->request->getPost($param . '_operator');
            $min       = $this->request->getPost($param . '_nilai_min');
            $max       = $this->request->getPost($param . '_nilai_max');
            $nilaiTeks = $this->request->getPost($param . '_nilai_teks');

            $labelSyarat = ParameterAirDefinition::buildLabelSyarat(
                $param, $tipe, $operator, $min, $max, $nilaiTeks
            );
            if ($param === 'clostridia_sporogens') {
                // Kolom fisik lama dipertahankan agar data existing tetap kompatibel.
                $data['syarat_clostridia'] = $labelSyarat;
                $data['syarat_sporogens']  = $labelSyarat;
            } else {
                $data['syarat_' . $param] = $labelSyarat;
            }
        }

        return $data;
    }

    // ----------------------------------------------------------------
    // Helper: kumpulkan POST untuk disimpan ke master_data_air_syarat
    // ----------------------------------------------------------------
    private function _collectSyaratFromPost(): array
    {
        $result = [];

        foreach (ParameterAirDefinition::semua() as $param => $def) {
            if ($def['tipe'] === 'teks') {
                $result[$param] = [
                    'tipe'       => 'teks',
                    'nilai_teks' => $this->request->getPost($param . '_nilai_teks'),
                ];
            } else {
                $result[$param] = [
                    'tipe'      => 'numerik',
                    'operator'  => $this->request->getPost($param . '_operator'),
                    'nilai_min' => $this->request->getPost($param . '_nilai_min') ?: null,
                    'nilai_max' => $this->request->getPost($param . '_nilai_max') ?: null,
                    'satuan'    => $def['satuan'] ?? null,
                ];
            }
        }

        return $result;
    }
}