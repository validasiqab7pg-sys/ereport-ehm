<?php

namespace App\Controllers;
use App\Models\PpojModel;
use App\Models\MasModel;
use App\Models\AllModel;
use App\Models\AhuModel;
class Mas extends BaseController
{
    public function index()
    {
        $PpojModel = new PpojModel();
        $MasModel = New MasModel;
        $AhuModel = New AhuModel;
        $AllModel = new AllModel();
        $data = [
            
           'List_PPOJ' => $PpojModel->findAll(),
           'List_AHU' => $PpojModel->List_MAS(),
           'List_Mas' => $MasModel->findAll()

        ];
        return view('AtRest/mas',$data);
     

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
        $MasModel = New MasModel;
        $AllModel = new AllModel();
        date_default_timezone_set('Asia/Jakarta');
        $getpost = $this->request->getPost();
      
        $tpc = $getpost['tpc'];
        $kk = $getpost['kk'];
        $batch_data = [];
        foreach($tpc as $no => $row ){
          
            $batch_data[]=
            [
                'no_ppoj' => $getpost['ppoj'],
                'nama_ruangan' => $getpost['ruangan'],
                'id_ppoj' => $getpost['id_ppoj'],
                 'id_ahu'  => $getpost['id_ahu'],
                'keterangan' => $getpost['keterangan'],
                'kelas' => $getpost['kelas'],
                'hasil_tpc' => $getpost['tpc'][$no],
                'hasil_kk' => $getpost['kk'][$no],
                'analis' =>$session->get('username'),
                'tanggal_dilakukan' => date('Y-m-d H:i:'),
                'editable' => 1,
                'approve_edit' =>1
                //'tanggal_dilakukan' => $getpost['tanggal_dilakukan']
            ];
     
        
        }
        $MasModel->insertBatch($batch_data);
       
      session()->setFlashdata('Toast', 'Data Berhasil disimpan');
      return redirect()->back()->withInput();
    }

    public function Update()
    {
        $session = session();
        $PpojModel = New PpojModel;
        $MasModel = New MasModel;
        $AllModel = new AllModel();
        date_default_timezone_set('Asia/Jakarta');
        // $AllModel = new AllModel();
        $getpost = $this->request->getPost();
        $id = $getpost['id'];
       
       
        $MasModel->update($id, [
            
                'keterangan' => $getpost['keterangan'],
                'hasil_tpc' => $getpost['tpc'],
                'hasil_kk' => $getpost['kk'],
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
         $data = [
             // 'judul' => 'Daftar Antrian'
             'id_ahu'   =>$id,
            'List_AHU' => $AllModel->List_AHU(),
            'List_Ruangan' => $AllModel->List_Ruangan(),
            'List_PPOJ' => $PpojModel->List_Detail_Mas($id),
            'Detail_AHU' => $AhuModel->where('id',$id)->first()
 
         ];
      

       // dd($data);
        return view('AtRest/mas_detail',$data);

      
    }

    public function AddMas($id)
    {
         $PpojModel = New PpojModel;
         $AllModel = new AllModel();
         $PpojModel = new PpojModel();
         $AhuModel = New AhuModel;
         $MasModel = new MasModel();
         $Detail_AHU = $PpojModel->where('id',$id)->first();
         //$titik_mikro = $AllModel->DataMikro($Detail_AHU['nama_ruangan'])->titik_mikro ??0;
 	 $dataMikro = $AllModel->DataMikro($Detail_AHU['nama_ruangan'], $Detail_AHU['ahu']);
    	 $titik_mikro = $dataMikro->titik_mikro ?? 0;
         $data = [
             // 'judul' => 'Daftar Antrian'
            'id' => $id,
            'List_AHU' => $AllModel->List_AHU(),
            'List_Ruangan' => $AllModel->List_Ruangan(),
            'List_MAS' => $MasModel->where('id_ppoj',$id)->findAll(),
            'Detail_Ruangan' => $PpojModel->where('id',$id)->first(),
            'titik_mikro' => $titik_mikro =='NA' ? 0 : $titik_mikro,
            'total_mikro' => $MasModel->where('id_ppoj',$id)->countAllResults() ?? 0,
            'Syarat' => $AllModel->MasterData($Detail_AHU['nama_ruangan'])
         ];
     // dd($data);
        return view('AtRest/mas_add',$data);
 
      
    }
       public function UpdateStatus()
    {
        $session = session();
        $MasModel = New MasModel;
        $AhuModel = New AhuModel;
        $getpost = $this->request->getPost();
        $id_ahu = $getpost['id_ahu'];
        $MasModel->where('id_ahu', $id_ahu)->set('status', 1)->update(); 
        $AhuModel->update($id_ahu, [
            
                'statusMas' => 1
                
        ]);
       
        session()->setFlashdata('Toast', 'Data Berhasil dihapus');
        return redirect()->back()->withInput();
    }
    public function RequestEdit()
    {
        $session = session();
        $MasModel = new MasModel();
        $getpost = $this->request->getPost();
        $id = $getpost['id'];
      
        $MasModel->update($id, [
            
                'editable' => 1
        ]);
       
      session()->setFlashdata('Toast', 'Request Edit Berhasil');
      return redirect()->back()->withInput();
    }
    public function Delete($id)
    {
        $MasModel = New MasModel;
        $MasModel->where('id', $id)->delete();

        session()->setFlashdata('Toast', 'Data Berhasil dihapus');
        return redirect()->back()->withInput();
    }
}
