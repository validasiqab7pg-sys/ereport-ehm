<?php

namespace App\Controllers;
use App\Models\PpojModel;
use App\Models\RhModel;
use App\Models\AllModel;
use App\Models\AhuModel;
class Rh extends BaseController
{
    public function index()
    {
        $PpojModel = new PpojModel();
        $RhModel = New RhModel;
        $AhuModel = New AhuModel;
        $AllModel = new AllModel();
        $data = [
            
           'List_PPOJ' => $PpojModel->findAll(),
           'List_AHU' => $PpojModel->List_RH(),
           'List_Rh' => $RhModel->findAll()

        ];
        return view('AtRest/rh',$data);
     

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
        $RhModel = New RhModel;
        $AllModel = new AllModel();
        date_default_timezone_set('Asia/Jakarta');
        // $AllModel = new AllModel();
        $getpost = $this->request->getPost();
        $ket = [];
        $rhmin = $getpost['rmin'];
        $rhmax = $getpost['rmax'];
        $batch_data = [];
        foreach($rhmin as $no => $row ){
            $ket[$no] = $AllModel->Cek_Syarat_Rh($getpost['kelas'],$getpost['rmin'][$no],$getpost['rmax'][$no]);
            $batch_data[]=
            [
                'no_ppoj' => $getpost['ppoj'],
                'nama_ruangan' => $getpost['ruangan'],
                'id_ppoj' => $getpost['id_ppoj'],
                'id_ahu' => $getpost['id_ahu'],
                'keterangan' =>  $getpost['keterangan'],
                'kelas' => $getpost['kelas'],
                'rh_min' => $getpost['rmin'][$no],
                'rh_max' => $getpost['rmax'][$no],
                'analis' =>$session->get('username'),
                'tanggal_dilakukan' => date('Y-m-d H:i:')
                //'tanggal_dilakukan' => $getpost['tanggal_dilakukan']
            ];
     
        
        }
        $RhModel->insertBatch($batch_data);
       
      session()->setFlashdata('Toast', 'Data Berhasil disimpan');
      return redirect()->back()->withInput();
    }
    public function UpdateStatus()
    {
       $session = session();
        $RhModel = New RhModel;
        $AhuModel = New AhuModel;
        $getpost = $this->request->getPost();
        $id_ahu = $getpost['id_ahu'];
        $RhModel->where('id_ahu', $id_ahu)->set('status', 1)->update();
         
        $AhuModel->update($id_ahu, [
            
                'statusRh' => 1
                
        ]);
       
        session()->setFlashdata('Toast', 'Data Berhasil dihapus');
        return redirect()->back()->withInput();
    }
    public function Update()
    {
        $session = session();
        $PpojModel = New PpojModel;
        $RhModel = New RhModel;
        $AllModel = new AllModel();
        date_default_timezone_set('Asia/Jakarta');
        // $AllModel = new AllModel();
        $getpost = $this->request->getPost();
       //$rh[] =      $this->request->getVar('rmin');//$getpost['rmin[]'];
        $ket = '';
        $id = $getpost['id'];
       
      
        $ket = $AllModel->Cek_Syarat_RH($getpost['kelas'],$getpost['rmin'],$getpost['rmax']);
      
        
        $RhModel->update($id, [
            
           
                'rh_min' => $getpost['rmin'],
                'rh_max' => $getpost['rmax'],
                'editable' => 0,
                'approve_edit' =>0
        ]);
        
      session()->setFlashdata('Toast', 'Data Berhasil diupdate');
      return redirect()->back()->withInput();
    }
    
          public function RequestEdit()
    {
        $session = session();
        $RhModel = New RhModel;
        $getpost = $this->request->getPost();
        $id = $getpost['id'];
      
        $RhModel->update($id, [
            
                'editable' => 1
        ]);
       
      session()->setFlashdata('Toast', 'Request Edit Berhasil');
      return redirect()->back()->withInput();
    }
    
    public function ViewDetail($id)
    {
         $PpojModel = New PpojModel;
         $AllModel = new AllModel();
         $PpojModel = new PpojModel();
         $AhuModel = New AhuModel;
         $Detail_AHU = $PpojModel->where('id',$id)->first();
          $countSelesaiRh = $PpojModel->countSelesaiRh($id);
         $data = [
             // 'judul' => 'Daftar Antrian'
             'id_ahu'   => $id,
            'List_AHU' => $AllModel->List_AHU(),
            'List_Ruangan' => $AllModel->List_Ruangan(),
            'List_PPOJ' => $PpojModel->List_Detail_Rh($id),
            'Detail_AHU' => $AhuModel->where('id',$id)->first(),
            'countSelesaiRh' => $countSelesaiRh[0]['selesaiRh']
 
         ];
      
       // dd($data);
        return view('AtRest/rh_detail',$data);
   
      
    }

    public function AddRh($id)
    {
         $PpojModel = New PpojModel;
         $AllModel = new AllModel();
         $PpojModel = new PpojModel();
         $AhuModel = New AhuModel;
         $RhModel = New RhModel;
         $Detail_AHU = $PpojModel->where('id',$id)->first();
         $titik_rh = $AllModel->MasterData($Detail_AHU['nama_ruangan'])->titik_rh ??0;
         $data = [
             // 'judul' => 'Daftar Antrian'
            'List_AHU' => $AllModel->List_AHU(),
            'List_Ruangan' => $AllModel->List_Ruangan(),
            'List_RH' => $RhModel->where('id_ppoj',$id)->findAll(),
            'Detail_Ruangan' => $PpojModel->where('id',$id)->first(),
            'titik_rh' => $titik_rh =='NA' ? 0 : $titik_rh,
            'total_rh' => $RhModel->where('id_ppoj',$id)->countAllResults() ?? 0,
            'Syarat' => $AllModel->MasterData($Detail_AHU['nama_ruangan'])
 
         ];
      
       
        return view('AtRest/rh_add',$data);
 
      
    }
    public function Delete($id)
    {
        $RhModel = New RhModel;
        $RhModel->where('id', $id)->delete();

        session()->setFlashdata('Toast', 'Data Berhasil dihapus');
        return redirect()->back()->withInput();
    }
}
