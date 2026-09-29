<?php
namespace App\Controllers;
use App\Models\AllModel;
use App\Models\AhuSwabModel;
use App\Models\PpojSwabModel;
use App\Models\PatogenSwabModel;
use App\Models\FileModel;


use Mpdf\Mpdf;



class PatogenSwab extends BaseController
{
    
    public function index()
    {
        $PpojSwabModel = new PpojSwabModel();
       
        $AhuSwabModel = New AhuSwabModel;
        $AllModel = new AllModel();
       
        $data = [
            
           'List_PPOJ_Swab' => $PpojSwabModel->findAll(),
           'List_AHU_Swab' => $PpojSwabModel->List_Patogen_Swab(),
          'List_Lokasi_Sampling' => $PpojSwabModel->findAll(),
         
           'List_Ruangan' => $AllModel->List_Ruangan()

        ];
        
        //echo $FlowModel->Pertukaran_Udara(2);
       // echo view('AtRest/flow', $data);
        echo view('AtRest/patogen_swab', $data);
        //return view('AtRest/flow');
    }

    


    public function ViewDetail($id)
    {
         $PpojSwabModel = New PpojSwabModel;
         $AllModel = new AllModel();
         $PpojSwabModel = new PpojSwabModel();
         $AhuSwabModel = New AhuSwabModel();
         $PatogenSwabModel = New PatogenSwabModel();
         $Detail_AHU = $PpojSwabModel->where('id',$id)->first();
         $data = [
            'id_swab'  => $id,

            'List_AHU' => $AllModel->List_AHU(),
            'List_Ruangan' => $AllModel->List_Ruangan(),
            'List_PPOJ_Swab' => $PpojSwabModel->List_Detail_Patogen_Swab($id),
            
            'Detail_AHU' => $AhuSwabModel->where('id',$id)->first(),
            'PatogenSwabModel' => $PatogenSwabModel
         ];
         
       //  echo $FlowModel->where('id_ppoj',52)->countAllResults();
        echo view('AtRest/patogen_detail_swab', $data);
     
      
    }
    public function AddPatogen($id)
    {
         $PpojSwabModel = New PpojSwabModel;
         $AllModel = new AllModel();
         $PpojSwabModel = new PpojSwabModel();
         $AhuSwabModel = New AhuSwabModel;
         $PatogenSwabModel = new PatogenSwabModel();
         $Detail_AHU = $PpojSwabModel->where('id',$id)->first();
         
         $titik_mikro = $AllModel->DataMikro($Detail_AHU['nama_mesin_personil_alat'])->titik_mikro ??0;
         $data = [
             // 'judul' => 'Daftar Antrian'
            'id' => $id,
            'List_AHU' => $AllModel->List_AHU(),
            'List_Ruangan' => $AllModel->List_Ruangan(),
            'List_Patogen' => $PatogenSwabModel->where('id_ppoj',$id)->findAll(),
            'Detail_Ruangan' => $PpojSwabModel->where('id',$id)->first(),
            'List_Lokasi_Sampling' => $PpojSwabModel->List_Lokasi_Sampling($id),
           
            'Syarat' => $AllModel->MasterData($Detail_AHU['nama_mesin_personil_alat'])
         ];
     // dd($data);
        return view('AtRest/patogen_add_swab',$data);
 
      
    }
    public function tampilkan_table_swab()
    {
        $db = \Config\Database::connect();
    
        // Query untuk mengambil data lokasi_sampling dan tanggal_dibersihkan
        $query = $db->query("
            SELECT mds.lokasi_sampling, das.tanggal_dibersihkan
            FROM master_data_swab mds
            JOIN data_awal_swab das ON mds.nama_mesin_personil_alat = das.nama_mesin_personil_alat
            WHERE das.nama_mesin_personil_alat IS NOT NULL
        ");
    
        $data['sampling_data'] = $query->getResultArray();
    
        return view('AtRest/patogen_add_swab', $data); 
    }
    
  


    public function DetailPpoj($id)
{
    require_once ROOTPATH . 'vendor/autoload.php';

    $PpojSwabModel = new PpojSwabModel();
    $AllModel = new AllModel();
    $AhuSwabModel = new AhuSwabModel();
    $PatogenSwabModel = new PatogenSwabModel();

    $Detail_AHU = $PpojSwabModel->where('id', $id)->first();

    $id_swab_row = $PpojSwabModel->select('id_swab')->where('id', $id)->first();
    $id_swab = $id_swab_row['id_swab'] ?? null;

    $dataPatogen = $PatogenSwabModel->where('id_ppoj', $id)->findAll();
    $dataHeader = $dataPatogen[0] ?? [];

    $data = [
        'Detail_AHU' => $Detail_AHU,
        'List_AHU' => $AllModel->List_AHU(),
        'List_Ruangan' => $AllModel->List_Ruangan(),
        'id' => $id,
        'List_PPOJ_Swab' => $AhuSwabModel->findAll(),
        'imageSrc' => $this->imageToBase64(ROOTPATH . 'public/logob7.png'),
        'imageSrcApproved'    => $this->imageToBase64(ROOTPATH . 'public/approved2.jpg'),
        'dataHeader' => $dataHeader,
        'Detail_Approve' => $id_swab ? $AhuSwabModel->where('id', $id_swab)->first() : [],
        'dataPatogen' => $dataPatogen
    ];
   

    $html = view('AtRest/ReportPatogenpdfSwab', $data);

    $mpdf = new \Mpdf\Mpdf([
        'mode' => 'utf-8',
        'format' => 'A4',
        'orientation' => 'L',
        'margin_top' => 50,
        'margin_bottom' => 80,
        'margin_footer' => 5
    ]);

    $mpdf->WriteHTML($html);
    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="Report_Patogen.pdf"');
    
   ob_clean(); // Tambahkan ini



   $namaMesin = isset($Detail_AHU['nama_mesin_personil_alat']) ? str_replace(' ', '_', $Detail_AHU['nama_mesin_personil_alat']) : 'Unknown_Room';
$tanggalSampling = isset($dataHeader['tanggal_sampling']) ? $dataHeader['tanggal_sampling'] : date('Y-m-d');

// Buat nama file dinamis
$filename = 'Report_Swab_' . $namaMesin . '_' . $tanggalSampling . '.pdf';

// Output PDF dengan nama file dinamis
ob_clean(); // Bersihkan buffer output sebelum mengirim PDF
$mpdf->Output($filename, 'D'); // 'D' artinya download
exit;
}


    private function imageToBase64($path)
  {
    $type = pathinfo($path, PATHINFO_EXTENSION);
    $data = file_get_contents($path);
    return 'data:image/' . $type . ';base64,' . base64_encode($data);
  }


    public function Detail($id)
  {
    $AllModel = new AllModel();
   
    $PpojSwabModel = new PpojSwabModel();
    $PatogenSwabModel = new PatogenSwabModel();
    $AhuSwabModel = new AhuSwabModel;
    $allData = $PatogenSwabModel->where('id_ppoj', $id)->findAll();
    $id_swab = $PpojSwabModel->select('id_swab')->where('id', $id)->first();
    $Detail_AHU = $PpojSwabModel->where('id', $id)->first();
   
    $Detail_Approve = $AhuSwabModel->where('id', $Detail_AHU['id_swab'])->first();
    
   
    $data = [
      'Detail_AHU' => $PpojSwabModel->where('id', $id)->first(),
      'List_AHU' => $AllModel->List_AHU(),
      'List_Ruangan' => $AllModel->List_Ruangan(),
      'id' => $id,
      'List_PPOJ_Swab' => $AhuSwabModel->findAll(),
      'imageSrc'    => $this->imageToBase64(ROOTPATH . 'public/logob7.png'),
      'imageSrcApproved'    => $this->imageToBase64(ROOTPATH . 'public/approved2.jpg'),
     'List_Patogen' => $PatogenSwabModel->where('id_swab', $id)->first(),
      'dataHeader' => $allData[0] ?? [],
      'Detail_Approve'=> $AhuSwabModel->where('id', $id_swab)->first(),
 
      'dataPatogen' => $PatogenSwabModel->where('id_ppoj',$id)->findAll()

    ];

    //dd($kondisi);
    //echo $countsuhu.''.$countrh.''.$countcapar.''.$countmas.''.$id;
    // dd($AllModel->selectData("master_data"));
    echo view('AtRest/ReportPatogenSwab', $data);
    //dd($data);
  }


  public function UpdateStatus()
    {
         $session = session();
         $AhuSwabModel = New AhuSwabModel;
        $PatogenSwabModel = New PatogenSwabModel;
        $getpost = $this->request->getPost();
        $id_swab = $getpost['id_swab'];
       $PatogenSwabModel->update($id_swab, ['status' => 1]);
         $AhuSwabModel->update($id_swab, [
            
                'statusPatogen' => 1
                
        ]);
       
        session()->setFlashdata('Toast', 'Data Berhasil diubah');
        return redirect()->back()->withInput();
    }
    
    public function Insert()
    {
        $session = session();
        $PpojSwabModel = New PpojSwabModel;
        
        $AllModel = new AllModel();
      
         $PatogenSwabModel = new PatogenSwabModel();
        $FileModel = new FileModel();
        date_default_timezone_set('Asia/Jakarta');
        // $AllModel = new AllModel();
        $getpost = $this->request->getPost();
      
       
		// $dataBerkas = $this->request->getFile('file');
		// $fileName = $dataBerkas->getName();
		$PatogenSwabModel->insert([
			// 'hasil_patogen' => $fileName,
           

            'no_ppoj' => $getpost['ppoj'],
            'id_ppoj' => $getpost['id_ppoj'],
            'id_swab'  => $getpost['id_swab'],
           'tanggal_sampling' => $getpost['tanggal_sampling'],
            
            'tgl_analisa' => $getpost['tgl_analisa'],
            'tgl_koloni' => $getpost['tgl_koloni'],
            'nama_mesin_personil_alat' => $getpost['nama_mesin_personil_alat'],
            'lokasi_sampling' => $getpost['lokasi_sampling'],
            'TAMC' => $getpost['tamc'],
            'TYMC' => $getpost['tymc'],
            'e_coli'=>$getpost['ecoli'],
            'salmonella_sp'=>$getpost['salmonela'],
            'staphylococcus_aureus'=>$getpost['staphylococcus'],
            'pseudomonas_aeruginosa'=>$getpost['pseudomonas'],
            'shigella_sp'=>$getpost['shigella'],
            'enterobacteriaceae'=>$getpost['enterobacteria'],
            'clostridia_sporogens'=>$getpost['clostridia'],           
            'analis' =>$session->get('username'),
            'keterangan' => $getpost['keterangan'],
            'tanggal_dibersihkan' => $getpost['tanggal_dibersihkan']
            
                    //'tanggal_dilakukan' => $getpost['tanggal_dilakukan']
		]);
		// $dataBerkas->move('File/', $fileName);
      session()->setFlashdata('Toast', 'Data Berhasil disimpan');
      return redirect()->back()->withInput();
    }    

    public function Delete($id)
    {
        $PatogenModel = New PatogenModel;
    //     $berkas = $PatogenModel->select('hasil_patogen')->where('id',$id)->first();
    //     $fileName =$berkas['hasil_patogen'];
    //    // echo $fileName;
    //      unlink("File/".$fileName."");
         
    
         $PatogenModel->where('id', $id)->delete();

        session()->setFlashdata('Toast', 'Data Berhasil dihapus');
        return redirect()->back()->withInput();
    }

    public function Update()
    {
        $session = session();
        $PpojSwabModel = New PpojSwabModel;
        $PatogenSwabModel = New PatogenSwabModel;
        $AllModel = new AllModel();
        date_default_timezone_set('Asia/Jakarta');
        // $AllModel = new AllModel();
        $getpost = $this->request->getPost();
        $id = $getpost['id'];
       
       
        $PatogenSwabModel->update($id, [
           
                'keterangan' => $getpost['keterangan'],
                'TAMC' => $getpost['tamc'],
                'TYMC' => $getpost['tymc'],
                'e_coli'=>$getpost['ecoli'],
                'salmonella_sp'=>$getpost['salmonela'],
                'staphylococcus_aureus'=>$getpost['staphylococcus'],
                'pseudomonas_aeruginosa'=>$getpost['pseudomonas'],
                'shigella_sp'=>$getpost['shigella'],
                'enterobacteriaceae'=>$getpost['enterobacteria'],
                'clostridia_sporogens'=>$getpost['clostridia'], 
                'editable' => 0,
                 'approve_edit' =>0,
                 'approve_edit_by' => $getpost['approve_edit_by'],
                 'tanggal_edit' => $getpost['tanggal_edit']
        ]);
      session()->setFlashdata('Toast', 'Data Berhasil diupdate');
      return redirect()->back()->withInput();
    }
}
