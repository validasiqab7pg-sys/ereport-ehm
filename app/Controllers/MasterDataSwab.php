<?php namespace App\Controllers;

use App\Models\MasterDataSwabModel;
use CodeIgniter\Controller;

class MasterDataSwab extends Controller
{
    public function index()
    {
        $session = session();
        $model = new MasterDataSwabModel();
        $data['data'] = $model->findAll();
        $data['session'] = $session;
        return view('AtRest/master_data_swab', $data);
    }

    public function create()
    {
        $session = session();
        $model = new MasterDataSwabModel();
        $data = [
            'site' => $this->request->getPost('site'),
            'ahu' => $this->request->getPost('ahu'),
            'kategori' => $this->request->getPost('kategori'),
            'nama_mesin_personil_alat' => $this->request->getPost('nama_mesin_personil_alat'),
            'kelas' => $this->request->getPost('kelas'),
            'nama_ruangan' => $this->request->getPost('nama_ruangan'),
            'departemen' => $this->request->getPost('departemen'),
            'lokasi_sampling' => $this->request->getPost('lokasi_sampling'),
            'periode' => $this->request->getPost('periode'),
        ];
        $model->insert($data);
        return redirect()->to('/masterdataswab');
    }

    public function edit($id)
    {
        $session = session();
        $model = new MasterDataSwabModel();
        $data = [
            'site' => $this->request->getPost('site'),
            'ahu' => $this->request->getPost('ahu'),
            'kategori' => $this->request->getPost('kategori'),
            'nama_mesin_personil_alat' => $this->request->getPost('nama_mesin_personil_alat'),
            'kelas' => $this->request->getPost('kelas'),
            'nama_ruangan' => $this->request->getPost('nama_ruangan'),
            'departemen' => $this->request->getPost('departemen'),
            'lokasi_sampling' => $this->request->getPost('lokasi_sampling'),
            'periode' => $this->request->getPost('periode'),
        ];
        $model->update($id, $data);
        return redirect()->to('/masterdataswab');
    }

    public function delete($id)
    {
        $session = session();
        $model = new MasterDataSwabModel();
        $model->delete($id);
        return redirect()->to('/masterdataswab');
    }
}