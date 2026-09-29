<?php namespace App\Controllers;

use App\Models\OosAirModel;
use App\Models\PenyimpanganAirModel;

class OosPenyimpanganAir extends BaseController
{
    protected $oosAirModel;
    protected $penyimpanganAirModel;
    protected $session;

    public function __construct()
    {
        $this->oosAirModel          = new OosAirModel();
        $this->penyimpanganAirModel = new PenyimpanganAirModel();
        $this->session              = session();
    }

    public function TampilOOS()
    {
        $session = session();
        $model   = new OosAirModel();
        $data['data_request'] = $model->orderBy('id', 'DESC')->findAll(); // tidak pakai where
        $data['session']      = $session;
        return view('AtRest/oos_air_monitoring', $data);
    }

    public function TampilPenyimpangan()
    {
        $session = session();
        $model   = new PenyimpanganAirModel();
        $data['data_request'] = $model->orderBy('id', 'DESC')->findAll(); // tidak pakai where
        $data['session']      = $session;
        return view('AtRest/penyimpangan_air_monitoring', $data);
    }

    // method untuk update upload OOS
    public function upload_oos($id)
{
    $request = service('request');

    $keterangan = $request->getPost('keterangan');
    $linkOos    = $request->getPost('link_oos');

    // ===== DIUBAH: cek dulu apakah user pilih metode Link =====
    if (!empty($linkOos)) {
        $dataUpdate = [
            'keterangan' => $keterangan,
            'upload_oos' => $linkOos, // simpan URL apa adanya
            'status'     => 'Complete',
        ];

        $this->oosAirModel->update($id, $dataUpdate);

        return redirect()->back()->with('success', 'Data berhasil diupdate dengan link OOS.');
    }

    // ===== Kalau bukan link, lanjut proses upload file seperti biasa =====
    $file = $request->getFile('upload_oos');

    if (!$file || !$file->isValid()) {
        return redirect()->back()->with('error', 'File tidak valid atau belum diupload.');
    }

    $allowedTypes = ['application/pdf', 'image/jpeg', 'image/png'];
    if (!in_array($file->getMimeType(), $allowedTypes)) {
        return redirect()->back()->with('error', 'Format file tidak didukung. Hanya PDF, JPG, PNG yang diperbolehkan.');
    }

    if ($file->getSize() > 5 * 1024 * 1024) {
        return redirect()->back()->with('error', 'Ukuran file maksimal 5MB.');
    }

    $newName = $file->getRandomName();
    $file->move(ROOTPATH . 'public/uploads/oos_air', $newName);

    $dataUpdate = [
        'keterangan' => $keterangan,
        'upload_oos' => $newName,
        'status'     => 'Complete',
    ];

    $this->oosAirModel->update($id, $dataUpdate);

    return redirect()->back()->with('success', 'Data berhasil diupdate dan file berhasil diupload.');
}
    public function delete($id)
    {
        $model = new OosAirModel();
        $model->delete($id);
        return redirect()->to('OosPenyimpanganAir/TampilOOS');
    }

    public function upload_penyimpangan($id)
    {
        $request = service('request');

        // cek apakah file diupload
        $file       = $request->getFile('upload_penyimpangan');
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

        // simpan file ke folder public/uploads/penyimpangan_air dengan nama unik
        $newName = $file->getRandomName();
        $file->move(ROOTPATH . 'public/uploads/penyimpangan_air', $newName);

        // update data di database
        $dataUpdate = [
            'keterangan'          => $keterangan,
            'upload_penyimpangan' => $newName,
            'status'              => 'Complete', // update status jadi Complete
        ];

        $this->penyimpanganAirModel->update($id, $dataUpdate);

        return redirect()->back()->with('success', 'Data berhasil diupdate dan file berhasil diupload.');
    }

    public function deletePenyimpangan($id)
    {
        $model = new PenyimpanganAirModel();
        $model->delete($id);
        return redirect()->to('OosPenyimpanganAir/TampilPenyimpangan');
    }
}