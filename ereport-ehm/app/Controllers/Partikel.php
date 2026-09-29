<?php
namespace App\Controllers;
use App\Models\AllModel;
use App\Models\AhuModel;
use App\Models\PpojModel;
use App\Models\SuhuModel;
use App\Models\DpModel;
use App\Models\FlowModel;
use App\Models\PartikelModel;
use App\Models\FileModel;
use CodeIgniter\Files\File;

class Partikel extends BaseController
{
    
    public function index()
    {
        $PpojModel = new PpojModel();
        $SuhuModel = New SuhuModel;
        $AhuModel = New AhuModel;
        $AllModel = new AllModel();
        $FlowModel = new FlowModel();
        $data = [
            
           'List_PPOJ' => $PpojModel->findAll(),
           'List_AHU' => $PpojModel->List_SUHU(),
           'List_Suhu' => $SuhuModel->findAll(),
           'List_Ruangan' => $AllModel->List_Ruangan()

        ];
        
        //echo $FlowModel->Pertukaran_Udara(2);
       // echo view('AtRest/flow', $data);
        echo view('AtRest/partikel', $data);
        //return view('AtRest/flow');
    }
    public function ViewDetail($id)
    {
         $PpojModel = New PpojModel;
         $AllModel = new AllModel();
         $PpojModel = new PpojModel();
         $AhuModel = New AhuModel();
         $PartikelModel = New PartikelModel();
         $Detail_AHU = $PpojModel->where('id',$id)->first();
         $data = [
          
            'List_AHU' => $AllModel->List_AHU(),
            'List_Ruangan' => $AllModel->List_Ruangan(),
            'List_PPOJ' => $PpojModel->List_PPOJ_ID($id),
             'List_Partikel' => $PartikelModel->where('id_ahu',$id)->findAll(),
            'Detail_AHU' => $AhuModel->where('id',$id)->first(),
            'Detail_Ruangan' => $PpojModel->where('id',$id)->first(),
            'PartikelModel' => $PartikelModel
         ];
         
       //  echo $FlowModel->where('id_ppoj',52)->countAllResults();
        echo view('AtRest/partikel_detail', $data);
     
      
    }

    public function AddPartikel($id)
    {
         $PpojModel = New PpojModel;
         $AllModel = new AllModel();
         $PpojModel = new PpojModel();
         $AhuModel = New AhuModel;
           $SuhuModel = new SuhuModel();
           $FlowModel = new FlowModel();
           $PartikelModel = new PartikelModel();
         $Detail_AHU = $PpojModel->where('id',$id)->first();
         $data = [
             // 'judul' => 'Daftar Antrian'
            'List_AHU' => $AllModel->List_AHU(),
            'List_Ruangan' => $AllModel->List_Ruangan(),
            'Data_Flow' => $FlowModel->where('id_ppoj',$id)->findAll(),
            'List_Partikel' => $PartikelModel->where('id_ppoj',$id)->findAll(),
            'Detail_Ruangan' => $PpojModel->where('id',$id)->first(),
            'List_PPOJ' => $PpojModel->findAll(),
 
         ];
      
    // dd($data);
        return view('AtRest/partikel_add',$data);
   
      
    }
    public function Insert()
    {
        $request = service('request');
        $session = session();
        $PartikelModel = new PartikelModel();

        date_default_timezone_set('Asia/Jakarta');
        $getpost = $this->request->getPost();

        // Ambil file upload
        $file = $request->getFile('upload_partikel');
        if (!$file->isValid()) {
            return redirect()->back()->with('error', 'File tidak valid atau belum diupload.');
        }

        // Validasi tipe file
        $allowedTypes = ['application/pdf', 'image/jpeg', 'image/png'];
        if (!in_array($file->getMimeType(), $allowedTypes)) {
            return redirect()->back()->with('error', 'Format file tidak didukung. Hanya PDF, JPG, PNG yang diperbolehkan.');
        }

        // Validasi ukuran file
        if ($file->getSize() > 5 * 1024 * 1024) {
            return redirect()->back()->with('error', 'Ukuran file maksimal 5MB.');
        }

        // Ambil nama asli file
        $originalName = $file->getClientName(); // Contoh: "Laporan Pemeriksaan.pdf"
        $ext = $file->getExtension(); // Contoh: "pdf"

        // Bersihkan nama file dari karakter aneh
        $cleanOriginalName = preg_replace('/[^a-zA-Z0-9_\-]/', '_', pathinfo($originalName, PATHINFO_FILENAME));

        // Buat nama baru yang unik tapi masih readable
        $newName = $cleanOriginalName . '_' . time() . '.' . $ext;

        // Simpan file ke folder upload
        $file->move(ROOTPATH . 'public/uploads/partikel', $newName);

        // Simpan ke database
        $PartikelModel->insert([
            'hasil_partikel' => $newName, // Disimpan dengan nama unik (yang masih mengandung nama asli)
            'id_ahu' => $getpost['id_ahu'],
            'nama_ahu' => $getpost['nama_ahu'],
            'analis' => $session->get('username'),
            'keterangan' => $getpost['keterangan'],
            'tanggal_dilakukan' => date('Y-m-d H:i')
        ]);

        session()->setFlashdata('Toast', 'Data Berhasil disimpan');
        return redirect()->back()->withInput();
    }   

    public function Delete($id)
    {
        $PartikelModel = New PartikelModel;
        $berkas = $PartikelModel->select('hasil_partikel')->where('id',$id)->first();
        $fileName =$berkas['hasil_partikel'];
       // echo $fileName;
       
                 try {
           unlink("File/".$fileName."");
        } catch (\Exception $e) {
       
        }
        $PartikelModel->where('id', $id)->delete();

        session()->setFlashdata('Toast', 'Data Berhasil dihapus');
        return redirect()->back()->withInput();
    }
}
