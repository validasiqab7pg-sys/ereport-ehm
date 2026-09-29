<?php
namespace App\Controllers;
use App\Models\AllModel;
use App\Models\AhuModel;
use App\Models\PpojModel;
use App\Models\SuhuModel;
use App\Models\DpModel;
use App\Models\FlowModel;
class Flow extends BaseController
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
        echo view('AtRest/flow', $data);
        //return view('AtRest/flow');
    }
    public function ViewDetail($id)
    {
         $PpojModel = New PpojModel;
         $AllModel = new AllModel();
         $PpojModel = new PpojModel();
         $AhuModel = New AhuModel;
         $FlowModel = New FlowModel;
         $Detail_AHU = $PpojModel->where('id',$id)->first();
         $countSelesaiFlow = $PpojModel->countSelesaiFlow($id);
         $data = [
             'id_ahu'  => $id,
            'List_AHU' => $AllModel->List_AHU(),
            'List_Ruangan' => $AllModel->List_Ruangan(),
            'List_PPOJ' => $PpojModel->List_Detail_Flow($id),
            'Detail_AHU' => $AhuModel->where('id',$id)->first(),
            'countSelesaiFlow' => $countSelesaiFlow[0]['selesaiFlow'],
            'FlowModel' => $FlowModel
         ];
         //dd($data);
    // echo $FlowModel->select('sum(hasil_flow) sum_flow')->where('id_ppoj',5)->first()['sum_flow'];
        echo view('AtRest/flow_detail', $data);
     
      
    }

    public function AddFlow($id)
    {
         $PpojModel = New PpojModel;
         $AllModel = new AllModel();
         $PpojModel = new PpojModel();
         $AhuModel = New AhuModel;
           $SuhuModel = new SuhuModel();
           $FlowModel = new FlowModel();
         $Detail_AHU = $PpojModel->where('id',$id)->first();
         $data = [
             // 'judul' => 'Daftar Antrian'
            'List_AHU' => $AllModel->List_AHU(),
            'List_Ruangan' => $AllModel->List_Ruangan(),
            'Data_Flow' => $FlowModel->where('id_ppoj',$id)->findAll(),
            'List_SUHU' => $SuhuModel->where('id_ppoj',$id)->findAll(),
            'Detail_Ruangan' => $PpojModel->where('id',$id)->first(),
            'List_PPOJ' => $PpojModel->findAll(),
 
         ];
      
    // dd($data);
        return view('AtRest/flow_add',$data);
   
      
    }
      public function AddPU()
    {
        $session = session();
        $PpojModel = New PpojModel;
        $SuhuModel = New SuhuModel;
        $AllModel = new AllModel();
        $FlowModel = new FlowModel();
        date_default_timezone_set('Asia/Jakarta');
        $getpost = $this->request->getPost();
        $id = $getpost['id_ppoj'];
        $PpojModel->update($id, [
            
            'jumlah_pertukaran_udara' => $getpost['pu']
    ]);
     
    session()->setFlashdata('Toast', 'Data Berhasil disimpan');
    return redirect()->back()->withInput();
    }
     public function UpdateStatus()
    {
          $session = session();
          $AhuModel = New AhuModel;
        $FlowModel = New FlowModel();
        $getpost = $this->request->getPost();
        $id_ahu = $getpost['id_ahu'];
        $FlowModel->where('id_ahu', $id_ahu)->set('status', 1)->update();
        $AhuModel->update($id_ahu, [
            
                'statusFlow' => 1
                
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
        $FlowModel = new FlowModel();
        date_default_timezone_set('Asia/Jakarta');
        // $AllModel = new AllModel();
        $getpost = $this->request->getPost();
       //$suhu[] =      $this->request->getVar('smin');//$getpost['smin[]'];
        $ket = [];
        $nf = $getpost['nf'];
        $kelas = $getpost['kelas'];
        $batch_data = [];
        foreach($nf as $no => $row ){
          
            $batch_data[]=
            [
                'no_ppoj' => $getpost['ppoj'],
                'id_ppoj' => $getpost['id_ppoj'],
                'id_ahu' => $getpost['id_ahu'],
                'nama_ruangan' => $getpost['ruangan'],
                'hasil_flow' => $getpost['nf'][$no],
                'keterangan' => $getpost['keterangan'],
                'volume_ruangan' => $getpost['volume_ruangan'],
                'analis' =>$session->get('username'),
                'tanggal_dilakukan' => date('Y-m-d H:i:')
                //'tanggal_dilakukan' => $getpost['tanggal_dilakukan']
            ];

        }
        //dd($batch_data);
        $FlowModel->insertBatch($batch_data);
       
      session()->setFlashdata('Toast', 'Data Berhasil disimpan');
      return redirect()->back()->withInput();
    }    

    public function Delete($id)
    {
        $FlowModel = New FlowModel;
        $FlowModel->where('id', $id)->delete();

        session()->setFlashdata('Toast', 'Data Berhasil dihapus');
        return redirect()->back()->withInput();
    }
}
