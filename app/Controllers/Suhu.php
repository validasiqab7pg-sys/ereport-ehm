<?php

namespace App\Controllers;
use App\Models\PpojModel;
use App\Models\SuhuModel;
use App\Models\AllModel;
use App\Models\MasterDataModel;
use App\Models\AhuModel;
class Suhu extends BaseController
{
    public function index()
    {
        $PpojModel = new PpojModel();
        $SuhuModel = New SuhuModel;
        $AhuModel = New AhuModel;
        $AllModel = new AllModel();
        $data = [
            
           'List_PPOJ' => $PpojModel->findAll(),
           'List_AHU' => $PpojModel->List_SUHU(),
           'List_Suhu' => $SuhuModel->findAll()

        ];
        return view('AtRest/suhu',$data);
     

    }

    public function Ambil_Ruangan()
    {
        $AllModel = new AllModel();
        $no_ppoj = $this->request->getPost("no_ppoj");
        $GetRuangan = $AllModel->Pilih_Ruangan($no_ppoj);
        //selectData("master_data", array("nama_ahu" => $NamaAhu));
      
        echo json_encode($GetRuangan); // kirim data ke ajax yang ada di datappoj
    }
    public function Insert()
    {
        $session = session();
        $PpojModel = New PpojModel;
        $SuhuModel = New SuhuModel;
        $AllModel = new AllModel();
        date_default_timezone_set('Asia/Jakarta');
        // $AllModel = new AllModel();
        $getpost = $this->request->getPost();
       //$suhu[] =      $this->request->getVar('smin');//$getpost['smin[]'];
        $ket = [];
        $suhumin = $getpost['smin'];
        $suhumax = $getpost['smax'];
        $batch_data = [];
        foreach($suhumin as $no => $row ){
            $ket[$no] = $AllModel->Cek_Syarat_Suhu($getpost['kelas'],$getpost['smin'][$no],$getpost['smax'][$no]);
            $batch_data[]=
            [
                'no_ppoj' => $getpost['ppoj'],
                'nama_ruangan' => $getpost['ruangan'],
                'id_ppoj' => $getpost['id_ppoj'],
                 'id_ahu' => $getpost['id_ahu'],
                'keterangan' => $getpost['keterangan'],
                'kelas' => $getpost['kelas'],
                'suhu_min' => $getpost['smin'][$no],
                'suhu_max' => $getpost['smax'][$no],
                'analis' =>$session->get('username'),
                'tanggal_dilakukan' => date('Y-m-d H:i:'),
                'editable' => 0,
                'aprrove_edit' => 0
                //'tanggal_dilakukan' => $getpost['tanggal_dilakukan']
            ];
     
        
        }
        $SuhuModel->insertBatch($batch_data);
       
      session()->setFlashdata('Toast', 'Data Berhasil disimpan');

      return redirect()->back()->withInput();
    }

    public function Update()
    {
        $session = session();
        $PpojModel = New PpojModel;
        $SuhuModel = New SuhuModel;
        $AllModel = new AllModel();
        date_default_timezone_set('Asia/Jakarta');
        // $AllModel = new AllModel();
        $getpost = $this->request->getPost();
       
        $ket = '';
        $id = $getpost['id'];
       
      
        $ket = $AllModel->Cek_Syarat_Suhu($getpost['kelas'],$getpost['smin'],$getpost['smax']);
     
        
        $SuhuModel->update($id, [
            
               // 'keterangan' => $getpost['keterangan'],
                'suhu_min' => $getpost['smin'],
                'suhu_max' => $getpost['smax'],
                'editable' => 0,
                'approve_edit' =>0
        ]);
       
      session()->setFlashdata('Toast', 'Data Berhasil diupdate');
      return redirect()->back()->withInput();
    }
    public function ViewDetail($id)
    {
         $PpojModel = New PpojModel;
         $AllModel = new AllModel();
         $PpojModel = new PpojModel();
         $AhuModel = New AhuModel;
         $Detail_AHU = $PpojModel->where('id',$id)->first();
         $countSelesaiSuhu = $PpojModel->countSelesaiSuhu($id);
         $data = [
             // 'judul' => 'Daftar Antrian'
            'id_ahu'    => $id,
            'List_AHU' => $AllModel->List_AHU(),
            'List_Ruangan' => $AllModel->List_Ruangan(),
            'List_PPOJ' => $PpojModel->List_Detail_Suhu($id),
            'Detail_AHU' => $AhuModel->where('id',$id)->first(),
            'countSelesaiSuhu' => $countSelesaiSuhu[0]['selesaiSuhu']
 
         ];
      
   // dd($data);
        return view('AtRest/suhu_detail',$data);
   
      
    }
    
      public function UpdateStatus()
    {
        $session = session();
         $AhuModel = New AhuModel;
        $SuhuModel = New SuhuModel;
       
        $getpost = $this->request->getPost();
        $id_ahu = $getpost['id_ahu'];
        $SuhuModel->where('id_ahu', $id_ahu)->set('status', 1)->update();
         
        $AhuModel->update($id_ahu, [
            
                'statusSuhu' => 1
                
        ]);
       
        session()->setFlashdata('Toast', 'Data Berhasil diubah');
        return redirect()->back()->withInput();
    }

    public function AddSuhu($id)
    {
         $PpojModel = New PpojModel;
         $AllModel = new AllModel();
         $PpojModel = new PpojModel();
         $AhuModel = New AhuModel;
         $SuhuModel = new SuhuModel();
         $Detail_AHU = $PpojModel->where('id',$id)->first();
         $titik_suhu = $AllModel->MasterData($Detail_AHU['nama_ruangan'])->titik_suhu ??0;
         $data = [
             // 'judul' => 'Daftar Antrian'
            'List_AHU' => $AllModel->List_AHU(),
            'List_Ruangan' => $AllModel->List_Ruangan(),
            'List_SUHU' => $SuhuModel->where('id_ppoj',$id)->findAll(),
            'Detail_Ruangan' => $PpojModel->where('id',$id)->first(),
            'titik_suhu' => $titik_suhu =='NA' ? 0 : $titik_suhu,
            'total_suhu' => $SuhuModel->where('id_ppoj',$id)->countAllResults() ?? 0,
            'Syarat' => $AllModel->MasterData($Detail_AHU['nama_ruangan'])
         ];
      
   //dd($data);
       return view('AtRest/suhu_add',$data);
 
      
    }
      public function RequestEdit()
    {
        $session = session();
        $SuhuModel = New SuhuModel;
        date_default_timezone_set('Asia/Jakarta');
        $getpost = $this->request->getPost();
        $id = $getpost['id'];
      
        $SuhuModel->update($id, [
            
                'editable' => 1
        ]);
       
      session()->setFlashdata('Toast', 'Request Edit Berhasil');
      return redirect()->back()->withInput();
    }
    public function Delete($id)
    {
        $SuhuModel = New SuhuModel;
        $SuhuModel->where('id', $id)->delete();

        session()->setFlashdata('Toast', 'Data Berhasil dihapus');
        return redirect()->back()->withInput();
    }
public function __construct()
{
    $this->MasterDataModel = new \App\Models\MasterDataModel();
}
    // Controller: Suhu.php
public function getSyaratSuhu()
{
    $ahu = $this->request->getGet('ahu');
    $nama_ruangan = $this->request->getGet('nama_ruangan');

    $MasterDataModel = new \App\Models\MasterDataModel();
    $syarat = $MasterDataModel->getSyaratSuhu($ahu, $nama_ruangan);

    if ($syarat) {
        return $this->response->setJSON($syarat);
    } else {
        return $this->response->setJSON(['error' => 'Syarat suhu tidak ditemukan']);
    }
}


}
