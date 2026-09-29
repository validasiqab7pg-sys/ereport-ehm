<?php

namespace App\Controllers;

use App\Models\MasterDataRuanganModel;
use CodeIgniter\Controller;

class MasterDataRuangan extends Controller
{
    public function index()
    {
        $session = session();
        $model = new MasterDataRuanganModel();
        $data['data'] = $model->findAll();
        $data['session'] = $session;
        return view('AtRest/master_data_ruangan', $data); // Ganti nama view
    }

    public function create()
    {
        $session = session();
        $model = new MasterDataRuanganModel();
        $data = [
            'nama_ahu' => $this->request->getPost('nama_ahu'),
            'keterangan' => $this->request->getPost('keterangan'),
            'nama_ruangan' => $this->request->getPost('nama_ruangan'),
            'kelas' => $this->request->getPost('kelas'),
            'suhu_min' => $this->request->getPost('suhu_min'),
            'suhu_max' => $this->request->getPost('suhu_max'),
            'rh_min' => $this->request->getPost('rh_min'),
            'rh_max' => $this->request->getPost('rh_max'),
            'lux' => $this->request->getPost('lux'),
            'Perbedaan_Tekanan' => $this->request->getPost('Perbedaan_Tekanan'),
            'Pertukaran_Udara' => $this->request->getPost('Pertukaran_Udara'),
            'Partikel_05AR' => $this->request->getPost('Partikel_05AR'),
            'Partikel_50AR' => $this->request->getPost('Partikel_50AR'),
            'Partikel_05IO' => $this->request->getPost('Partikel_05IO'),
            'Partikel_50IO' => $this->request->getPost('Partikel_50IO'),
            'Volumetrik_TPC' => $this->request->getPost('Volumetrik_TPC'),
            'Volumetrik_KK' => $this->request->getPost('Volumetrik_KK'),
            'Capar_TPC' => $this->request->getPost('Capar_TPC'),
            'Capar_KK' => $this->request->getPost('Capar_KK'),
            'titik_suhu' => $this->request->getPost('titik_suhu'),
            'titik_rh' => $this->request->getPost('titik_rh'),
            'titik_mikro' => $this->request->getPost('titik_mikro'),
            'titik_partikel' => $this->request->getPost('titik_partikel'),
            'titik_capar' => $this->request->getPost('titik_capar'),
            'titik_flow' => $this->request->getPost('titik_flow'),
            'titik_lux' => $this->request->getPost('titik_lux'),
            'patogen' => $this->request->getPost('patogen'),
            
            'volume_ruangan' => $this->request->getPost('volume_ruangan'),
        ];
        $model->insert($data);
        return redirect()->to('/masterdataruangan');
    }

    public function edit($id)
    {
        $session = session();
        $model = new MasterDataRuanganModel();
        $data = [
            'nama_ahu' => $this->request->getPost('nama_ahu'),
            'keterangan' => $this->request->getPost('keterangan'),
            'nama_ruangan' => $this->request->getPost('nama_ruangan'),
            'kelas' => $this->request->getPost('kelas'),
            'suhu_min' => $this->request->getPost('suhu_min'),
            'suhu_max' => $this->request->getPost('suhu_max'),
            'rh_min' => $this->request->getPost('rh_min'),
            'rh_max' => $this->request->getPost('rh_max'),
            'lux' => $this->request->getPost('lux'),
            'Perbedaan_Tekanan' => $this->request->getPost('Perbedaan_Tekanan'),
            'Pertukaran_Udara' => $this->request->getPost('Pertukaran_Udara'),
           'Partikel_05AR' => $this->request->getPost('Partikel_05AR'),
            'Partikel_50AR' => $this->request->getPost('Partikel_50AR'),
            'Partikel_05IO' => $this->request->getPost('Partikel_05IO'),
            'Partikel_50IO' => $this->request->getPost('Partikel_50IO'),
            'Volumetrik_TPC' => $this->request->getPost('Volumetrik_TPC'),
            'Volumetrik_KK' => $this->request->getPost('Volumetrik_KK'),
            'Capar_TPC' => $this->request->getPost('Capar_TPC'),
            'Capar_KK' => $this->request->getPost('Capar_KK'),
            'titik_suhu' => $this->request->getPost('titik_suhu'),
            'titik_rh' => $this->request->getPost('titik_rh'),
            'titik_mikro' => $this->request->getPost('titik_mikro'),
            'titik_partikel' => $this->request->getPost('titik_partikel'),
            'titik_capar' => $this->request->getPost('titik_capar'),
            'titik_flow' => $this->request->getPost('titik_flow'),
            'titik_lux' => $this->request->getPost('titik_lux'),
            'patogen' => $this->request->getPost('patogen'),
            
            'volume_ruangan' => $this->request->getPost('volume_ruangan'),
        ];
        $model->update($id, $data);
        return redirect()->to('/masterdataruangan');
    }

    public function delete($id)
    {
        $session = session();
        $model = new MasterDataRuanganModel();
        $model->delete($id);
        return redirect()->to('/masterdataruangan');
    }
}