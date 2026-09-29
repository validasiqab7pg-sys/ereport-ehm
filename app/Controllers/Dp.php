<?php

namespace App\Controllers;
use App\Models\AllModel;
use App\Models\AhuModel;
use App\Models\PpojModel;
use App\Models\SuhuModel;
use App\Models\DpModel;
class Dp extends BaseController
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
           'List_Suhu' => $SuhuModel->findAll(),
           'List_Ruangan' => $AllModel->List_Ruangan(),
           'List_RuanganDp' => $AllModel->List_RuanganDp()

        ];
        
        echo view('AtRest/dp', $data);

   
    }

    public function ViewDetail($id)
    {
         $PpojModel = New PpojModel;
         $AllModel = new AllModel();
         $PpojModel = new PpojModel();
         $AhuModel = New AhuModel;
         $Detail_AHU = $PpojModel->where('id',$id)->first();  
         $countSelesaiDp = $PpojModel->countSelesaiDp($id);
         $data = [
            'id_ahu'    => $id,
            'List_AHU' => $AllModel->List_AHU(),
            'List_Ruangan' => $AllModel->List_Ruangan(),
            'List_RuanganDp' => $AllModel->List_RuanganDp(),
            'List_PPOJ' => $PpojModel->List_Detail_Dp($id),
            'Detail_AHU' => $AhuModel->where('id',$id)->first(),
            'countSelesaiDp' => $countSelesaiDp[0]['selesaiDp']
 
         ];
     // dd($data);
        echo view('AtRest/dp_detail', $data);
     
      
    }

    public function AddDp($id)
    {
         $PpojModel = New PpojModel;
         $AllModel = new AllModel();
         $PpojModel = new PpojModel();
         $AhuModel = New AhuModel;
           $SuhuModel = new SuhuModel();
           $DpModel = new DpModel();
         $Detail_AHU = $PpojModel->where('id',$id)->first();
         $data = [
             // 'judul' => 'Daftar Antrian'
            'List_AHU' => $AllModel->List_AHU(),
            'List_Ruangan' => $AllModel->List_Ruangan(),
            'List_RuanganDP' => $AllModel->List_RuanganDp(),
            'Data_Ruangan' => $DpModel->where('id_ppoj',$id)->findAll(),
            'List_SUHU' => $SuhuModel->where('id_ppoj',$id)->findAll(),
            'Detail_Ruangan' => $PpojModel->where('id',$id)->first(),
            'List_PPOJ' => $PpojModel->findAll(),
 
         ];
      
     
        return view('AtRest/dp_add',$data);
   
      
    }
    
     public function UpdateStatus()
    {
       $session = session();
        $DpModel = New DpModel;
        $AhuModel = New AhuModel;
        $getpost = $this->request->getPost();
        $id_ahu = $getpost['id_ahu'];
        $DpModel->where('id_ahu', $id_ahu)->set('status', 1)->update();
         
        $AhuModel->update($id_ahu, [
            
                'statusDp' => 1
                
        ]);
       
        session()->setFlashdata('Toast', 'Data Berhasil dihapus');
        return redirect()->back()->withInput();
    }

    public function Insert()
    {
        $session = session();
        $PpojModel = New PpojModel;
        $SuhuModel = New SuhuModel;
        $AllModel = new AllModel();
        $DpModel = new DpModel();
        date_default_timezone_set('Asia/Jakarta');
        // $AllModel = new AllModel();
        $getpost = $this->request->getPost();
       //$suhu[] =      $this->request->getVar('smin');//$getpost['smin[]'];
        $ket = [];
        $dp = $getpost['dp'];
        $kelas = $getpost['kelas'];
    
        $DpModel->insert([
            'no_ppoj' => $getpost['ppoj'],
            'id_ppoj' => $getpost['id_ppoj'],
            'id_ahu'  => $getpost['id_ahu'],
            'nama_ruangan' => $getpost['ruangan'],
            'terhadap_ruangan' => $getpost['dp'],
            'keterangan' => $getpost['keterangan'],
            'kelas' => $getpost['kelas'],
            'hasil_dp' =>$getpost['nilaidp'],
           
            'analis' =>$session->get('username'),
            'tanggal_dilakukan' => date('Y-m-d H:i:')
        ]);
       
      session()->setFlashdata('Toast', 'Data Berhasil disimpan');
      return redirect()->back()->withInput();
    }
    
    public function Delete($id)
    {
        $DpModel = New DpModel();
        $DpModel->where('id', $id)->delete();

        session()->setFlashdata('Toast', 'Data Berhasil dihapus');
        return redirect()->back()->withInput();
    }
}
