<?php

namespace App\Controllers;

use App\Models\AllModel;
use App\Models\AhuModel;
use App\Models\FlowModel;
use App\Models\DpModel;

use App\Models\PpojModel;
use App\Models\CaparModel;
use App\Models\MasModel;
use App\Models\SuhuModel;
use App\Models\RhModel;
use App\Models\PartikelModel;
use Mpdf\Mpdf;
//use setasign\Fpdi\Fpdi;
class DataPpoj extends BaseController
{
    public function index()
    {
        $AllModel = new AllModel();
        $PpojModel = new PpojModel();
        $AhuModel = new AhuModel;
        $data = [
            // 'judul' => 'Daftar Antrian'
            'List_AHU' => $AllModel->List_AHU(),
            'List_Ruangan' => $AllModel->List_Ruangan(),
            'List_PPOJ' => $AhuModel->findAll()

        ];
        // dd($AllModel->selectData("master_data"));
        echo view('AtRest/datappoj', $data);
        //dd($data);
    }

    public function DetailPpoj($id)
    {

         require_once ROOTPATH . 'vendor/autoload.php';

        $PpojModel = new PpojModel();
        $FlowModel = new FlowModel;
        $DpModel = new DpModel;
        $SuhuModel = new SuhuModel;
        $AhuModel = new AhuModel;
        $RhModel = new RhModel;
        $PartikelModel = new PartikelModel;
        $CaparModel = new CaparModel;
        $MasModel = new MasModel;
        $countsuhu = count($SuhuModel->where('id_ppoj', $id)->findAll());
        $countrh = count($RhModel->where('id_ppoj', $id)->findAll());
       $Detail_AHU = $PpojModel->where('id', $id)->first();
        $countcapar = count($CaparModel->where('id_ppoj', $id)->findAll());
        $countmas = count($MasModel->where('id_ppoj', $id)->findAll());
        $countflow = count($FlowModel->where('id_ppoj', $id)->findAll());
        $countdp = count($DpModel->where('id_ppoj', $id)->findAll());
        $id_ahu = $PpojModel->select('id_ahu')->where('id', $id)->first();
        $kondisi = $AhuModel->select('kondisi')->where('id', $id_ahu)->first();
        $cekpartikel = $PartikelModel->select('*')->where('id_ppoj', $id)->countAllResults();
        $data = [
            'id_ahu'  => $id,
            'Detail_AHU' => $AhuModel->where('id', $id_ahu)->first(),
            'imageSrc'    => $this->imageToBase64(ROOTPATH . 'public/logob7.png'),
            'imageSrcApproved'    => $this->imageToBase64(ROOTPATH . 'public/approved2.jpg'),
            'Detail_PPOJ' => $PpojModel->where('id', $id)->first(),
            'Detail_Flow' => $FlowModel->where('id_ppoj', $id)->findAll(),
            'DataSuhuRH'  => $PpojModel->DataPDF($countsuhu, $countrh,$countdp, $countflow, $countcapar, $countmas, $id),
            'JumlahData' => count($PpojModel->DataPDF($countsuhu, $countrh,$countdp, $countflow, $countcapar, $countmas, $id)),
            'Perbedaan_ruangan' => $PpojModel->Terhadap_Ruangan($id),
            'kondisi' => $kondisi['kondisi'],
            'cekpartikel' => $cekpartikel,
             'keterangan' =>  $PpojModel->cekKeterangan($id)

        ];

        //  echo $cekpartikel;
        //dd($data);
        $html = view('AtRest/Getpdf', $data);


       $mpdf = new \Mpdf\Mpdf([
        'mode' => 'utf-8',
        'format' => 'A4',
        'orientation' => 'L',
        'margin_top' => 42,
        'margin_bottom' => 75,
        'margin_footer' => 5,
       'autoPageBreak' => true

    ]);

    $mpdf->WriteHTML($html);
    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="PPOJ_Ruangan.pdf"');
    
   ob_clean(); // Tambahkan ini
   // Buat nama file dinamis
    $namaRuangan = isset($Detail_AHU['nama_ruangan']) ? str_replace(' ', '_', $Detail_AHU['nama_ruangan']) : 'Unknown_Ruangan';
    $tanggalDilakukan = isset($Detail_AHU['tanggaldilakukan']) ? str_replace(' ', '_', $Detail_AHU['tanggaldilakukan']) : 'Unknown_Ruangan';

    $filename = '' . $namaRuangan .'_'. $tanggalDilakukan . '.pdf';

    // Output PDF dengan nama file dinamis
    ob_clean(); // Bersihkan buffer output sebelum mengirim PDF
    $mpdf->Output($filename, 'D'); // 'D' artinya download
    exit;
    }

    private function imageToBase64($path)
    {
        $path = $path;
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        return $base64;
    }
    public function Detail($id)
    {
        $AllModel = new AllModel();
        
        $PpojModel = new PpojModel();
        $FlowModel = new FlowModel;
        $DpModel = new DpModel;
        $SuhuModel = new SuhuModel;
        $AhuModel = new AhuModel;
        $RhModel = new RhModel;
        $PartikelModel = new PartikelModel;
        $CaparModel = new CaparModel;
        $MasModel = new MasModel;
        $countsuhu = count($SuhuModel->where('id_ppoj', $id)->findAll());
        $countrh = count($RhModel->where('id_ppoj', $id)->findAll());
        $countcapar = count($CaparModel->where('id_ppoj', $id)->findAll());
        $countmas = count($MasModel->where('id_ppoj', $id)->findAll());
        $countflow = count($FlowModel->where('id_ppoj', $id)->findAll());
        $countdp = count($DpModel->where('id_ppoj', $id)->findAll());

        $id_ahu = $PpojModel->select('id_ahu')->where('id', $id)->first();
        $kondisi = $AhuModel->select('kondisi')->where('id', $id_ahu)->first();
        $cekpartikel = $PartikelModel->select('*')->where('id_ppoj', $id)->countAllResults();
        $data = [
            'Detail_AHU' => $AhuModel->where('id', $id_ahu)->first(),
            'List_AHU' => $AllModel->List_AHU(),
            'List_Ruangan' => $AllModel->List_Ruangan(),
            'id' => $id,
            'List_PPOJ' => $AhuModel->findAll(),
            'imageSrc'    => $this->imageToBase64(ROOTPATH . 'public/logob7.png'),
           
            'Detail_PPOJ' => $PpojModel->where('id', $id)->first(),
            'Detail_Flow' => $FlowModel->where('id_ppoj', $id)->findAll(),
            'DataSuhuRH'  => $PpojModel->DataPDF($countsuhu, $countrh,$countdp, $countflow, $countcapar, $countmas, $id),
            'JumlahData' => count($PpojModel->DataPDF($countsuhu, $countrh,$countdp, $countflow, $countcapar, $countmas, $id)),
            'Perbedaan_ruangan' => $PpojModel->Terhadap_Ruangan($id),
            'kondisi' => $kondisi['kondisi'],
            'cekpartikel' => $cekpartikel,
            'keterangan' =>  $PpojModel->cekKeterangan($id)

        ];
    
       // dd($data);
         
        echo view('AtRest/table', $data);
        
    }

    public function Insert_AHU()
    {
        $session = session();
        $PpojModel = new PpojModel;
        $AhuModel = new AhuModel;
        $AllModel = new AllModel();
        $getpost = $this->request->getPost();

        //$originalDate = $getpost['tanggaldilakukan'];
        date_default_timezone_set('Asia/Jakarta');
        $newDate = date("Y-m-d H:i:s");
        // $newDate1 =date("Y-m-d");
        // $GetKelas = $AllModel->Pilih_Kelas($getpost['ahu'],$getpost['ruangan']);
        //$GetTanggal = $AllModel->Pilih_Tanggal($getpost['tanggaldilakukan']);

        //  echo $newDate;
        $AhuModel->insert([
            'ahu' => $getpost['ahu'],
            'site' => $getpost['site'],
            'tanggaldilakukan' =>  $newDate,
            'kondisi' => $getpost['kondisi'],
            'jenispemeriksaan' => $getpost['jenispemeriksaan'],
            'keterangan' => $getpost['keterangan'],
            'status' => 'On Progress'


        ]);

        session()->setFlashdata('Toast', 'Data Berhasil disimpan');
        return redirect()->to('/DataPpoj');
    }

    public function Insert_PPOJ()
    {
        $session = session();
        $PpojModel = new PpojModel;
        $AllModel = new AllModel();
        $getpost = $this->request->getPost();

        //$originalDate = $getpost['tanggaldilakukan'];
        date_default_timezone_set('Asia/Jakarta');
        $newDate = date("Y-m-d H:i:s");
        $newDate1 = date("Y-m-d");
        
        $GetKelas = $AllModel->Pilih_Kelas($getpost['ahu'], $getpost['ruangan']);
        //$GetTanggal = $AllModel->Pilih_Tanggal($getpost['tanggaldilakukan']);

        //  echo $newDate;
        $PpojModel->insert([
            'no_ppoj' => "AHU " . $getpost['ahu'] . "/" . $getpost['site'] . "/" . $getpost['ruangan'], //.$getpost['tanggaldilakukan'],
            'ahu' => $getpost['ahu'],
            'id_ahu' => $getpost['id_ahu'],
            'site' => $getpost['site'],
            'nama_ruangan' => $getpost['ruangan'],
            'kelas' =>  $GetKelas->kelas,
            'tanggaldilakukan' =>  $getpost['tanggaldilakukan'],
            'jenispemeriksaan' => $getpost['jenispemeriksaan'],
            'status' => 'On Progress'


        ]);

        session()->setFlashdata('Toast', 'Data Berhasil disimpan');
        return redirect()->back()->withInput();
    }
    public function Ambil_Ahu()
    {
        $AllModel = new AllModel();
        $NamaAhu = $this->request->getPost("nama_ahu");
        $GetAhu = $AllModel->Pilih_Ahu($NamaAhu);
        //selectData("master_data", array("nama_ahu" => $NamaAhu));

        echo json_encode($GetAhu); // kirim data ke ajax yang ada di datappoj
    }

    public function Approve_1()
    {
        $session = session();
        $AhuModel = new AhuModel;
        $getpost = $this->request->getPost();

        $id = $getpost['id_ahu'];
        $AhuModel->update($id, [
            'status'    => 'Selesai di QA',
            'approve_1' => $session->get('username'),
            'approve_1_date' => date("Y-m-d")

        ]);

        session()->setFlashdata('Approve', 'Data Berhasil di Approve');
        return redirect()->back()->withInput();
    }

    public function Approve_2()
    {
        $session = session();
        $AhuModel = new AhuModel;
        $getpost = $this->request->getPost();

        $id = $getpost['id_ahu'];
        $AhuModel->update($id, [
            'status'    => 'Selesai di QC',
            'approve_2' => $session->get('username'),
            'approve_2_date' => date("Y-m-d")

        ]);

        session()->setFlashdata('Approve', 'Data Berhasil di Approve');
        return redirect()->back()->withInput();
    }

    public function Approve_3()
    {
        $session = session();
        $AhuModel = new AhuModel;
        $getpost = $this->request->getPost();

        $id = $getpost['id_ahu'];
        $AhuModel->update($id, [
            'status'    => 'Selesai di Spv QC',
            'approve_3' => $session->get('username'),
            'approve_3_date' => date("Y-m-d")

        ]);

        session()->setFlashdata('Approve', 'Data Berhasil di Approve');
        return redirect()->back()->withInput();
    }

    public function Approve_4()
    {
        $session = session();
        $AhuModel = new AhuModel;
        $getpost = $this->request->getPost();

        $id = $getpost['id_ahu'];
        $AhuModel->update($id, [
            'status'    => 'Selesai di Spv QA',
            'approve_4' => $session->get('username'),
             'approve_4_date' => date("Y-m-d")

        ]);

        session()->setFlashdata('Approve', 'Data Berhasil di Approve');
        return redirect()->back()->withInput();
    }

    public function DeleteRuangan($id)
    {
        $PpojModel = new PpojModel;
        $PpojModel->where('id', $id)->delete();

        session()->setFlashdata('Toast', 'Data Berhasil dihapus');
        return redirect()->back()->withInput();
    }

    

    public function Delete($id)
    {
        $AhuModel = new AhuModel();
        $AhuModel->where('id', $id)->delete();

        session()->setFlashdata('Toast', 'Data Berhasil dihapus');
        return redirect()->to('/DataPpoj');
    }
    public function UpdateStatus()
    {
        $session = session();
        $AhuModel = new AhuModel;
        $PpojModel = new PpojModel();
        $getpost = $this->request->getPost();
        $id_ahu = $getpost['id_ahu'];
        $PpojModel->where('id_ahu', $id_ahu)->set('status', 'Selesai')->update();


        $AhuModel->update($id_ahu, [

            'approve_1' => $session->get('username'),
            'status'    => 'Selesai di QA'

        ]);

        session()->setFlashdata('Toast', 'Data Berhasil di Approve');
        return redirect()->back()->withInput();
    }

    public function ViewDetail($id)
    {
        $PpojModel = new PpojModel;
        $AllModel = new AllModel();
        $PpojModel = new PpojModel();
        $AhuModel = new AhuModel;
        $Detail_AHU = $PpojModel->where('id', $id)->first();
        $cek_button_qa =  $PpojModel->Cek_button_qa($id);
        $cek_button_qc =  $PpojModel->Cek_button_qc($id);
        $data = [
            // 'judul' => 'Daftar Antrian'
            'id_ahu'  => $id,
            'List_AHU' => $AllModel->List_AHU(),
            'List_Ruangan' => $AllModel->List_Ruangan(),
            'List_PPOJ' => $PpojModel->List_PPOJ_ID($id),
            'Detail_AHU' => $AhuModel->where('id', $id)->first(),
            'Cek_button_qa' => $cek_button_qa[0]['totalSelesai'],
            'Cek_button_qc' => $cek_button_qc[0]['totalSelesai']

        ];
        // dd($data);
        echo view('AtRest/datappoj_detail', $data);
    }
}
