<?php namespace App\Controllers;

use App\Models\OosModel;
use App\Models\PenyimpanganModel;

class OosPenyimpangan extends BaseController
{
    public function TampilOOS($id_swab = null)
     {
         $session = session();
        $model = new OosModel();
        $data['data_request'] = $model->findAll(); // tidak pakai where
         $data['session'] = $session;
        return view('AtRest/oos_monitoring', $data);
    }

    public function TampilPenyimpangan($id_swab = null)
     {
         $session = session();
        $model = new PenyimpanganModel();
        $data['data_request'] = $model->findAll(); // tidak pakai where
         $data['session'] = $session;
        return view('AtRest/penyimpangan_monitoring', $data);
    }

    protected $oosModel;
    protected $penyimpanganModel;
    protected $session;

    public function __construct()
    {
        $this->oosModel = new oosModel();
        $this->penyimpanganModel = new penyimpanganModel();
        $this->session = session();
    }

    // method untuk update upload OOS
    public function upload_oos($id)
    {
        $request = service('request');

        // cek apakah file diupload
        $file = $request->getFile('upload_oos');
        $keterangan = $request->getPost('keterangan');

        if (!$file->isValid()) {
            return redirect()->back()->with('error', 'File tidak valid atau belum diupload.');
        }

        // validasi tipe file dan size (max 5MB)
        $allowedTypes = ['application/pdf', 'image/jpeg', 'image/png'];
        if (!in_array($file->getMimeType(), $allowedTypes)) {
            return redirect()->back()->with('error', 'Format file tidak didukung. Hanya PDF, JPG, PNG yang diperbolehkan.');
        }

        if ($file->getSize() > 5 * 1024 * 1024) {
            return redirect()->back()->with('error', 'Ukuran file maksimal 5MB.');
        }

        // simpan file ke folder public/uploads/oos dengan nama unik
        $newName = $file->getRandomName();
        $file->move(ROOTPATH . 'public/uploads/oos', $newName);

        // update data di database
        $dataUpdate = [
            'keterangan' => $keterangan,
            'upload_oos' => $newName,
            'status'     => 'Complete',  // update status jadi Complete
        ];

        $this->oosModel->update($id, $dataUpdate);

        return redirect()->back()->with('success', 'Data berhasil diupdate dan file berhasil diupload.');
    }
    public function delete($id)
    {
        $session = session();
        $model = new OosModel();
        $model->delete($id);
        return redirect()->to('OosPenyimpangan/TampilOOS');
    }
    public function upload_penyimpangan($id)
    {
        $request = service('request');

        // cek apakah file diupload
        $file = $request->getFile('upload_penyimpangan');
        $keterangan = $request->getPost('keterangan');

        if (!$file->isValid()) {
            return redirect()->back()->with('error', 'File tidak valid atau belum diupload.');
        }

        // validasi tipe file dan size (max 5MB)
        $allowedTypes = ['application/pdf', 'image/jpeg', 'image/png'];
        if (!in_array($file->getMimeType(), $allowedTypes)) {
            return redirect()->back()->with('error', 'Format file tidak didukung. Hanya PDF, JPG, PNG yang diperbolehkan.');
        }

        if ($file->getSize() > 5 * 1024 * 1024) {
            return redirect()->back()->with('error', 'Ukuran file maksimal 5MB.');
        }

        // simpan file ke folder public/uploads/oos dengan nama unik
        $newName = $file->getRandomName();
        $file->move(ROOTPATH . 'public/uploads/penyimpangan', $newName);

        // update data di database
        $dataUpdate = [
            'keterangan' => $keterangan,
            'upload_penyimpangan' => $newName,
            'status'     => 'Complete',  // update status jadi Complete
        ];

        $this->penyimpanganModel->update($id, $dataUpdate);

        return redirect()->back()->with('success', 'Data berhasil diupdate dan file berhasil diupload.');
    }
    public function deletePenyimpangan($id)
    {
        $session = session();
        $model = new PenyimpanganModel();
        $model->delete($id);
        return redirect()->to('OosPenyimpangan/TampilPenyimpangan');
    }
}
