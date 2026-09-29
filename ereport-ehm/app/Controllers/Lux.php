<?php
namespace App\Controllers;
use App\Models\AllModel;
use App\Models\AhuModel;
use App\Models\PpojModel;
use App\Models\SuhuModel;
use App\Models\DpModel;
use App\Models\FlowModel;
use App\Models\LuxModel;
use App\Models\FileModel;
use CodeIgniter\Files\File;

class Lux extends BaseController
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
        echo view('AtRest/lux', $data);
        //return view('AtRest/flow');
    }
    public function ViewDetail($id)
    {
         $PpojModel = New PpojModel;
         $AllModel = new AllModel();
         $PpojModel = new PpojModel();
         $AhuModel = New AhuModel();
         $LuxModel = New LuxModel();
         $Detail_AHU = $PpojModel->where('id',$id)->first();
         $countSelesaiLux = $PpojModel->countSelesaiLux($id);
         $data = [
            'id_ahu'    => $id,
            'List_AHU' => $AllModel->List_AHU(),
            'List_Ruangan' => $AllModel->List_Ruangan(),
            'List_PPOJ' => $PpojModel->List_Detail_Lux($id),
            'Detail_AHU' => $AhuModel->where('id',$id)->first(),
            'countSelesaiLux' => $countSelesaiLux[0]['selesaiLux'],
            'LuxModel' => $LuxModel
         ];
         
       //  echo $FlowModel->where('id_ppoj',52)->countAllResults();
      // dd($data);
        echo view('AtRest/lux_detail', $data);
     
      
    }
     public function UpdateStatus()
    {
         $session = session();
        $LuxModel = New LuxModel;
         $AhuModel = New AhuModel;
        $getpost = $this->request->getPost();
        $id_ahu = $getpost['id_ahu'];
        $LuxModel->where('id_ahu', $id_ahu)->set('status', 1)->update();
        
        
          $AhuModel->update($id_ahu, [
            
                'statusLux' => 1
                
        ]);
       
        session()->setFlashdata('Toast', 'Data Berhasil dihapus');
        return redirect()->back()->withInput();
    }
    public function AddLux($id)
    {
         $PpojModel = New PpojModel;
         $AllModel = new AllModel();
         $PpojModel = new PpojModel();
         $AhuModel = New AhuModel;
           $SuhuModel = new SuhuModel();
           $FlowModel = new FlowModel();
           $LuxModel = new LuxModel();
         $Detail_AHU = $PpojModel->where('id',$id)->first();
         $data = [
             // 'judul' => 'Daftar Antrian'
            'List_AHU' => $AllModel->List_AHU(),
            'List_Ruangan' => $AllModel->List_Ruangan(),
            'Data_Flow' => $FlowModel->where('id_ppoj',$id)->findAll(),
            'List_Lux' => $LuxModel->where('id_ppoj',$id)->findAll(),
            'Detail_Ruangan' => $PpojModel->where('id',$id)->first(),
            'List_PPOJ' => $PpojModel->findAll(),
 
         ];
      
    // dd($data);
        return view('AtRest/lux_add',$data);
   
      
    }
    public function Insert()
    {
        $session = session();
        $PpojModel = New PpojModel;
        $SuhuModel = New SuhuModel;
        $AllModel = new AllModel();
        $FlowModel = new FlowModel();
         $LuxModel= new LuxModel();
        $FileModel = new FileModel();
        date_default_timezone_set('Asia/Jakarta');
        // $AllModel = new AllModel();
        $getpost = $this->request->getPost();
       //$suhu[] =      $this->request->getVar('smin');//$getpost['smin[]'];
        
        // foreach($nf as $no => $row ){
          
        //     $batch_data[]=
        //     [
        //         'no_ppoj' => $getpost['ppoj'],
        //         'id_ppoj' => $getpost['id_ppoj'],
        //         'nama_ruangan' => $getpost['ruangan'],
        //         'hasil_flow' => $getpost['nf'][$no],
        //         'volume_ruangan' => $getpost['volume_ruangan'],
        //         'analis' =>$session->get('username'),
        //         'tanggal_dilakukan' => date('Y-m-d H:i:')
        //         //'tanggal_dilakukan' => $getpost['tanggal_dilakukan']
        //     ];

        // }
        // //dd($batch_data);
        // $FlowModel->insertBatch($batch_data);
        $LuxModel = new LuxModel();
		$dataBerkas = $this->request->getFile('file');
		$fileName = $dataBerkas->getName();
		$LuxModel ->insert([
			'hasil_lux' => $fileName,
            'no_ppoj' => $getpost['ppoj'],
            'id_ppoj' => $getpost['id_ppoj'],
            'nama_ruangan' => $getpost['ruangan'],
           'id_ahu'         =>  $getpost['id_ahu'],
            'analis' =>$session->get('username'),
          'keterangan' => $getpost['keterangan'],
            'tanggal_dilakukan' => date('Y-m-d H:i:')
                    //'tanggal_dilakukan' => $getpost['tanggal_dilakukan']
		]);
		$dataBerkas->move('File/', $fileName);
      session()->setFlashdata('Toast', 'Data Berhasil disimpan');
      return redirect()->back()->withInput();
    }    

    public function Delete($id)
    {
        $LuxModel = New LuxModel;
        $berkas = $LuxModel->select('hasil_lux')->where('id',$id)->first();
        $fileName =$berkas['hasil_lux'];
       // echo $fileName;
         unlink("File/".$fileName."");
         
    
         $LuxModel->where('id', $id)->delete();

        session()->setFlashdata('Toast', 'Data Berhasil dihapus');
        return redirect()->back()->withInput();
    }
}
