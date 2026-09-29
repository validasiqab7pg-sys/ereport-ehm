<?php
namespace App\Controllers;
use App\Models\AllModel;
use App\Models\AhuModel;
use App\Models\PpojModel;
use App\Models\SuhuModel;
use App\Models\FlowModel;
use App\Models\PatogenModel;
use App\Models\FileModel;
use App\Models\CaparModel;
use App\Models\MasModel;
use App\Models\RhModel;
use App\Models\DpModel;
use App\Models\PartikelModel;
use Mpdf\Mpdf;

class Patogen extends BaseController
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
           'List_AHU' => $PpojModel->List_Patogen(),
           'List_Suhu' => $SuhuModel->findAll(),
           'List_Ruangan' => $AllModel->List_Ruangan()

        ];
        
        //echo $FlowModel->Pertukaran_Udara(2);
       // echo view('AtRest/flow', $data);
        echo view('AtRest/patogen', $data);
        //return view('AtRest/flow');
    }
    public function ViewDetail($id)
    {
         $PpojModel = New PpojModel;
         $AllModel = new AllModel();
         $PpojModel = new PpojModel();
         $AhuModel = New AhuModel();
         $PatogenModel = New PatogenModel();
         $Detail_AHU = $PpojModel->where('id',$id)->first();
         $data = [
            'id_ahu'  => $id,
            'List_AHU' => $AllModel->List_AHU(),
            'List_Ruangan' => $AllModel->List_Ruangan(),
            'List_PPOJ' => $PpojModel->List_Detail_Patogen($id),
            'Detail_AHU' => $AhuModel->where('id',$id)->first(),
            'PatogenModel' => $PatogenModel
         ];
         
       //  echo $FlowModel->where('id_ppoj',52)->countAllResults();
        echo view('AtRest/patogen_detail', $data);
     
      
    }

    public function DetailPpoj($id)
    { 
        ini_set('memory_limit', '512M');
    set_time_limit(300);
      //$dompdf = new Dompdf(['isRemoteEnabled' => true]);
      $PpojModel = new PpojModel();
      $FlowModel = New FlowModel;
      $DpModel = new DpModel;
      $SuhuModel = New SuhuModel;
      $AhuModel = New AhuModel;
      $PatogenModel = new PatogenModel();
      $RhModel = New RhModel;
      $PartikelModel = New PartikelModel;
      $CaparModel = New CaparModel;
      $MasModel = New MasModel;
      $countsuhu = count($SuhuModel->where('id_ppoj',$id)->findAll());
      $countrh = count($RhModel->where('id_ppoj',$id)->findAll());
      $countflow = count($FlowModel->where('id_ppoj', $id)->findAll());
      $countdp = count($DpModel->where('id_ppoj', $id)->findAll());
      $countcapar = count($CaparModel->where('id_ppoj',$id)->findAll());
      $countmas = count($MasModel->where('id_ppoj',$id)->findAll());
      $id_ahu = $PpojModel->select('id_ahu')->where('id',$id)->first();
      $kondisi = $AhuModel->select('kondisi')->where('id',$id)->first();
      $cekpartikel = $PartikelModel->select('*')->where('id_ppoj',$id)->countAllResults();
      $data = [
          'id_ahu'  => $id,
          'id' => $id,
          'Detail_AHU' => $AhuModel->where('id',$id)->first(),
          'imageSrc'    => $this->imageToBase64(ROOTPATH . 'public/logob7.png'),
          'imageSrcApproved'    => $this->imageToBase64(ROOTPATH . 'public/approved2.jpg'),
          'Detail_Flow' => $FlowModel->where('id_ppoj',$id)->findAll(),
          'DataSuhuRH'  => $PpojModel->DataPDF($countsuhu, $countrh,$countdp, $countflow, $countcapar, $countmas, $id),
          'JumlahData' => count($PpojModel->DataPDF($countsuhu, $countrh,$countdp, $countflow, $countcapar, $countmas, $id)),
          'Perbedaan_ruangan' =>$PpojModel->Terhadap_Ruangan($id),
          'kondisi' =>$kondisi['kondisi'],
          'cekpartikel' =>$cekpartikel,
          'dataPatogen' => $PatogenModel->where('id_ahu',$id)->findAll()
          
      ];
     $html = view('AtRest/ReportPatogenpdf2', $data);

    $mpdf = new \Mpdf\Mpdf([
        'mode' => 'utf-8',
        'format' => 'A4',
        'orientation' => 'L',
        'margin_top' => 42,
        'margin_bottom' => 78,
        'margin_footer' => 5
    ]);

    $mpdf->WriteHTML($html);
    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="Report_Patogen.pdf"');
    
   ob_clean(); // Tambahkan ini

// Buat nama file dinamis
$filename = 'Report_Patogen.pdf';

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
    
    $PpojModel = new PpojModel();
    $FlowModel = new FlowModel;
    $SuhuModel = new SuhuModel;
    $DpModel = new DpModel;
    $PatogenModel = new PatogenModel();
    $AhuModel = new AhuModel;
    $RhModel = new RhModel;
    $PartikelModel = new PartikelModel;
    $CaparModel = new CaparModel;
    $MasModel = new MasModel;
    $countsuhu = count($SuhuModel->where('id_ppoj', $id)->findAll());
    $countrh = count($RhModel->where('id_ppoj', $id)->findAll());
    $countflow = count($FlowModel->where('id_ppoj', $id)->findAll());
    $countdp = count($DpModel->where('id_ppoj', $id)->findAll());
    $countcapar = count($CaparModel->where('id_ppoj', $id)->findAll());
    $countmas = count($MasModel->where('id_ppoj', $id)->findAll());
    $id_ahu = $PpojModel->select('id_ahu')->where('id', $id)->first();
    $kondisi = $AhuModel->select('kondisi')->where('id', $id)->first();
    $cekpartikel = $PartikelModel->select('*')->where('id_ppoj', $id)->countAllResults();
    $data = [
      'Detail_AHU' => $AhuModel->where('id', $id)->first(),
      'List_AHU' => $AllModel->List_AHU(),
      'List_Ruangan' => $AllModel->List_Ruangan(),
      'id' => $id,
      'List_PPOJ' => $AhuModel->findAll(),
      //'imageSrc'    => $this->imageToBase64(ROOTPATH . 'public/logob7.png'),
      'imageSrcApproved'    => $this->imageToBase64(ROOTPATH . 'public/approved2.jpg'),
     // 'Detail_PPOJ' => $PpojModel->where('id', $id)->first(),
      'Detail_Flow' => $FlowModel->where('id_ppoj', $id)->findAll(),
      'DataSuhuRH'  => $PpojModel->DataPDF($countsuhu, $countrh,$countdp, $countflow, $countcapar, $countmas, $id),
      'JumlahData' => count($PpojModel->DataPDF($countsuhu, $countrh,$countdp, $countflow, $countcapar, $countmas, $id)),
      'Perbedaan_ruangan' => $PpojModel->Terhadap_Ruangan($id),
      'kondisi' => $kondisi['kondisi'],
      'cekpartikel' => $cekpartikel,
      'dataPatogen' => $PatogenModel->where('id_ahu',$id)->findAll()

    ];

    //dd($kondisi);
    //echo $countsuhu.''.$countrh.''.$countcapar.''.$countmas.''.$id;
    // dd($AllModel->selectData("master_data"));
    echo view('AtRest/ReportPatogen', $data);
    //dd($data);
  }
  public function UpdateStatus()
    {
         $session = session();
         $AhuModel = New AhuModel;
        $PatogenModel = New PatogenModel;
        $getpost = $this->request->getPost();
        $id_ahu = $getpost['id_ahu'];
        $PatogenModel->where('id_ahu', $id_ahu)->set('status', 1)->update();
         $AhuModel->update($id_ahu, [
            
                'statusPatogen' => 1
                
        ]);
       
        session()->setFlashdata('Toast', 'Data Berhasil diubah');
        return redirect()->back()->withInput();
    }
    public function AddPatogen($id)
    {
         $PpojModel = New PpojModel;
         $AllModel = new AllModel();
         $PpojModel = new PpojModel();
         $AhuModel = New AhuModel;
           $SuhuModel = new SuhuModel();
           $FlowModel = new FlowModel();
           $PatogenModel = new PatogenModel();
         $Detail_AHU = $PpojModel->where('id',$id)->first();
          $titik_patogen = $AllModel->MasterData($Detail_AHU['nama_ruangan'])->patogen ??0;
         $data = [
             // 'judul' => 'Daftar Antrian'
            'List_AHU' => $AllModel->List_AHU(),
            'List_Ruangan' => $AllModel->List_Ruangan(),
            'Data_Flow' => $FlowModel->where('id_ppoj',$id)->findAll(),
            'List_Patogen' => $PatogenModel->where('id_ppoj',$id)->findAll(),
            'Detail_Ruangan' => $PpojModel->where('id',$id)->first(),
            'List_PPOJ' => $PpojModel->findAll(), 
            'titik_patogen' => $titik_patogen =='NA' ? 0 : $titik_patogen,
             'total_patogen' => $PatogenModel->where('id_ppoj',$id)->countAllResults() ?? 0,
            
         ];
      
    // dd($data);
        return view('AtRest/patogen_add',$data);
   
      
    }
    public function Insert()
    {
        $session = session();
        $PpojModel = New PpojModel;
        $SuhuModel = New SuhuModel;
        $AllModel = new AllModel();
        $FlowModel = new FlowModel();
         $PatogenModel = new PatogenModel();
        $FileModel = new FileModel();
        date_default_timezone_set('Asia/Jakarta');
        // $AllModel = new AllModel();
        $getpost = $this->request->getPost();
      
        $PatogenModel = new PatogenModel();
		// $dataBerkas = $this->request->getFile('file');
		// $fileName = $dataBerkas->getName();
		$PatogenModel->insert([
			// 'hasil_patogen' => $fileName,
            'no_ppoj' => $getpost['ppoj'],
            'id_ppoj' => $getpost['id_ppoj'],
            'id_ahu'  => $getpost['id_ahu'],
            'nama_ruangan' => $getpost['ruangan'],
            'e_coli'=>$getpost['ecoli'],
            'salmonella_sp'=>$getpost['salmonela'],
            'staphylococcus_aureus'=>$getpost['staphylococcus'],
            'pseudomonas_aeruginosa'=>$getpost['pseudomonas'],
            'shigella_sp'=>$getpost['shigella'],
            'enterobacteriaceae'=>$getpost['enterobacteria'],
            'clostridia_sporogens'=>$getpost['clostridia'],           
            'analis' =>$session->get('username'),
            'keterangan' => $getpost['keterangan'],
            'tanggal_dilakukan' => $getpost['tanggalanalisa']
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
}
