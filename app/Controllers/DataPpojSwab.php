<?php

namespace App\Controllers;

use App\Models\AllModel;
use App\Models\AhuModel;
use App\Models\AhuSwabModel;
use App\Models\PpojSwabModel;
use App\Models\OosModel;
use App\Models\PenyimpanganModel;
use DateTime;
use Dompdf\Dompdf;

class DataPpojSwab extends BaseController
{
    public function index()
    {
        $AllModel = new AllModel();
        $PpojSwabModel = new PpojSwabModel();
       

        // Ambil data kategori dari model
        $List_Kategori = $AllModel->List_Kategori();

        $List_Departemen = $AllModel->List_Departemen();

        $data = [
            'List_Kategori' => $List_Kategori,

            'List_Departemen' => $List_Departemen, // Pastikan ini tersedia di AllModel
            'List_PPOJ_Swab' => $AllModel->List_PPOJ_Swab()
        ];

        echo view('AtRest/datappoj_swab', $data);
    }

    public function DetailPpoj_Swab($id)
    {
        $PpojSwabModel = new PpojSwabModel();
        $dataDetail = $PpojSwabModel->where('id', $id)->first();
        $id_swab = $PpojSwabModel->select('id_swab')->where('id', $id)->first();
        $AhuSwabModel = new AhuSwabModel;
        if (!$dataDetail) {
            return redirect()->to('/sampling')->with('error', 'Data tidak ditemukan');
        }

        $data = [
            'id_ahu'            => $id,
            'Detail_AHU' => $AhuSwabModel->where('id', $id_swab)->first(),
            'tanggal_sampling' => $dataDetail['tanggal_sampling'] ?? '',
            'kategori'         => $dataDetail['kategori'] ?? '',
            'site'             => $dataDetail['site'] ?? '',
            'keterangan'       => $dataDetail['keterangan'] ?? '',
            'status'           => $dataDetail['status'] ?? ''
        ];

        $html = view('AtRest/Getpdf2', $data);

        $dompdf = new Dompdf(['isRemoteEnabled' => true]);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('Pemantauan_Ruangan.pdf', ['Attachment' => true]);
    }

    public function Insert_PPOJ_Swab()
    {
        $session = session();
        $PpojSwabModel = new PpojSwabModel;
        $AllModel = new AllModel();
        $getpost = $this->request->getPost();

        date_default_timezone_set('Asia/Jakarta');
        $newDate = date("Y-m-d H:i:s");
        $newDate1 = date("Y-m-d");
        // Validasi data yang diterima
        $GetKelas = $AllModel->Pilih_Kelas_Swab($getpost['kategori'], $getpost['nama_mesin_personil_alat']);
        $GetDepartemen = $AllModel->Pilih_Departemen_Swab($getpost['kategori'], $getpost['nama_mesin_personil_alat']);
        $GetRuangan = $AllModel->Pilih_Ruangan_Swab($getpost['kategori'], $getpost['nama_mesin_personil_alat']);

       $tanggal_dibersihkan = $getpost['tanggal_dibersihkan'];
        if (!empty($tanggal_dibersihkan)) {
            $tanggal_dibersihkan = DateTime::createFromFormat('d/m/Y', $tanggal_dibersihkan)->format('Y-m-d');
        } else {
            $tanggal_dibersihkan = null;
        }
       

        // Menyimpan data ke dalam database
        $PpojSwabModel->insert([
            'no_ppoj' => "" . $getpost['site'] . "/" . $getpost['kategori'] . "/" . $getpost['nama_mesin_personil_alat'],
            
            'id_swab' => $getpost['id_swab'],
            'site' => $getpost['site'],
            'tanggal_sampling' => $getpost['tanggal_sampling'],
            'keterangan' => $getpost['keterangan'],
            'nama_mesin_personil_alat' => $getpost['nama_mesin_personil_alat'],
            'kelas' =>  $GetKelas->kelas,
            'departemen' =>  $GetDepartemen->departemen,
            'nama_ruangan' =>  $GetRuangan->nama_ruangan,

            'tanggal_dibersihkan' => $tanggal_dibersihkan,
            'kategori' => $getpost['kategori'],
            'status' => 'On Progress',
            'created_at' => date("Y-m-d H:i:s")  // Menambahkan waktu pembuatan data
        ]);

        session()->setFlashdata('Toast', 'Data Berhasil disimpan');
        return redirect()->back()->withInput();
    }
    public function Insert_Swab()
    {
        $session = session();
        $PpojSwabModel = new PpojSwabModel;
        $AllModel = new AllModel();
        $getpost = $this->request->getPost();

        // Ubah format tanggal dari dd/mm/yyyy ke yyyy-mm-dd (format MySQL)
        $tanggal_sampling = $getpost['tanggal_sampling'];
        if (!empty($tanggal_sampling)) {
            $tanggal_sampling = DateTime::createFromFormat('d/m/Y', $tanggal_sampling)->format('Y-m-d');
        } else {
            $tanggal_sampling = null;
        }

        // Menyimpan data ke dalam database
        $idBaru = $PpojSwabModel->insertToDataSwab([
            'site' => $getpost['site'],
            'tanggal_sampling' => $tanggal_sampling, // yang sudah diformat
            'keterangan' => $getpost['keterangan'],
            'kategori' => $getpost['kategori'],
            'status' => 'On Progress',
        ]);

        // DITAMBAHKAN: kirim notifikasi email ke QA Analis
        $this->kirimNotifikasiDataBaruSwab($idBaru, $tanggal_sampling);

        session()->setFlashdata('Toast', 'Data Berhasil disimpan');
        return redirect()->back()->withInput();
    }
    private function kirimNotifikasiDataBaruSwab($idBaru, $tanggalSampling): void
        {
            if (!$idBaru) return;

            $db     = \Config\Database::connect();
            $emails = $db->table('user')
                ->select('email')
                ->where('jabatan', 'QA Analis')
                ->get()->getResultArray();
            $emails = array_column($emails, 'email');

            $item = [
                'no_dokumen' => 'EHM-SWAB-' . $idBaru,
                'jenis_ehm'  => 'EHM Swab',
                'tanggal'    => $tanggalSampling,
                'url_detail' => base_url('DataPpojSwab/ViewDetail/' . $idBaru),
            ];

            (new \App\Libraries\NotifikasiEmailService())->kirimNotifikasiDataBaru($emails, $item);
        }
public function Ambil_NamaMesin()
{
    $AllModel = new AllModel();
    $kategori = $this->request->getPost("nama_namamesin");

    if (empty($kategori)) {
        return $this->response->setJSON(['status' => 'error', 'message' => 'Kategori kosong']);
    }

    try {
        $bulan = (int)date('n');
        $tahunSekarang = (int)date('Y');

        $periodeAktifMap = [
            'Caturwulan 1' => ($bulan >= 1 && $bulan <= 4),
            'Caturwulan 2' => ($bulan >= 5 && $bulan <= 8),
            'Caturwulan 3' => ($bulan >= 9 && $bulan <= 12),
            'Semester 1'   => ($bulan >= 1 && $bulan <= 6),
            'Semester 2'   => ($bulan >= 7 && $bulan <= 12),
        ];

        $periodeAktif = array_keys(array_filter($periodeAktifMap));

        $GetNamaMesin = $AllModel->Pilih_NamaMesin($kategori, $periodeAktif, $tahunSekarang);

        return $this->response->setJSON([
            'status'  => 'success',
            'data'    => $GetNamaMesin,
            'count'   => count($GetNamaMesin)
        ]);

    } catch (\Exception $e) {
        return $this->response->setJSON([
            'status'  => 'error',
            'message' => $e->getMessage(),
            'line'    => $e->getLine(),
            'file'    => $e->getFile()
        ]);
    }
}
  /**
   * TETAP SAMA: Helper function untuk menentukan periode aktif
   * berdasarkan kategori dan bulan berjalan
   */
  private function getPeriodeAktif($kategori)
{
  $bulan = date('n');
  $periode = '';
  
  if (in_array($kategori, ['Mesin (Bagian Dalam)', 'Alat Bagian Dalam'])) {
    if ($bulan >= 1 && $bulan <= 4) {
      $periode = 'Caturwulan 1';
    } elseif ($bulan >= 5 && $bulan <= 8) {
      $periode = 'Caturwulan 2';
    } else {
      $periode = 'Caturwulan 3';
    }
  } 
  elseif (in_array($kategori, ['Mesin (Bagian Luar)', 'Alat Bagian Luar', 'Personil'])) {
    if ($bulan >= 1 && $bulan <= 6) {
      $periode = 'Semester 1';
    } else {
      $periode = 'Semester 2';
    }
  }
  
  return $periode;
}
    public function Ambil_Kategori()
    {
        $AllModel = new AllModel();
        $NamaKategori = $this->request->getPost("kategori");
        $GetKategori = $AllModel->Pilih_Kategori($NamaKategori);
        //selectData("master_data", array("nama_ahu" => $NamaAhu));

        echo json_encode($GetKategori); // kirim data ke ajax yang ada di datappoj
    }
        public function Delete($id)
    {
        $AhuSwabModel = new AhuSwabModel();
        $AhuSwabModel->delete($id); // <== PENTING: ini yang aktifkan audit log

        session()->setFlashdata('Toast', 'Data Berhasil dihapus');
        return redirect()->to('/DataPpojSwab');
    }


    public function Approve_1()
    {
        $session = session();
        $AhuSwabModel = new AhuSwabModel;
        $getpost = $this->request->getPost();

        $id = $getpost['id_swab'];
        $AhuSwabModel->update($id, [
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
        $AhuSwabModel = new AhuSwabModel;
        $getpost = $this->request->getPost();

        $id = $getpost['id_swab'];
        $AhuSwabModel->update($id, [
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
        $AhuSwabModel = new AhuSwabModel;
        $getpost = $this->request->getPost();

        $id = $getpost['id_swab'];
        $AhuSwabModel->update($id, [
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
        $AhuSwabModel = new AhuSwabModel;
        $getpost = $this->request->getPost();

        $id = $getpost['id_swab'];
        $AhuSwabModel->update($id, [
            'status'    => 'Selesai di Spv QA',
            'approve_4' => $session->get('username'),
            'approve_4_date' => date("Y-m-d")

        ]);

        session()->setFlashdata('Approve', 'Data Berhasil di Approve');
        return redirect()->back()->withInput();
    }

    public function DeleteRuangan($id)
    {
        $PpojSwabModel = new PpojSwabModel();
        $PpojSwabModel->where('id', $id)->delete();

        session()->setFlashdata('Toast', 'Data Berhasil dihapus');
        return redirect()->back()->withInput();
    }

    public function deleteRecord($id)
    {
        $AllModel = new AllModel();
        $AllModel->where('id', $id)->delete();

        session()->setFlashdata('Toast', 'Data Berhasil dihapus');
        return redirect()->to('/DataPpoj_Swab');
    }

    public function UpdateStatus()
    {
        $session = session();
        $AhuSwabModel = new AhuSwabModel();
        $PpojSwabModel = new PpojSwabModel();
        $getpost = $this->request->getPost();
        $id_swab = $getpost['id_swab'];

        $PpojSwabModel->where('id_swab', $id_swab)->set('status', 'Selesai')->update();

        $AhuSwabModel->update($id_swab, [
            'approve_1' => $session->get('username'),
            'status'    => 'Selesai di QA'
        ]);

        session()->setFlashdata('Toast', 'Data Berhasil di Approve');
        return redirect()->back()->withInput();
    }
    public function DeleteMesin($id)
    {
        $PpojSwabModel = new PpojSwabModel;
        $PpojSwabModel->delete($id); 

        session()->setFlashdata('Toast', 'Data Berhasil dihapus');
        return redirect()->back()->withInput();
    }

    public function ViewDetail($id)
    {
        $PpojSwabModel = new PpojSwabModel();
        $AllModel = new AllModel();
        $AhuModel = new AhuModel();
        $AhuSwabModel = new AhuSwabModel();

        // Mengambil data detail AHU berdasarkan id
        $Detail_AHU = $PpojSwabModel->where('id', $id)->first();

      
            $cek_button_qa = $PpojSwabModel->Cek_button_qa($id);
            $cek_button_qc = $PpojSwabModel->Cek_button_qc($id);
            // Menyiapkan data untuk ditampilkan
            $data = [
                'id_ahu'         => $id,
                'id_swab'        => $id,
                'List_AHU'       => $AllModel->List_AHU(),
                'List_Ruangan'   => $AllModel->List_Ruangan(),
                'List_PPOJ_Swab_Detail'      => $PpojSwabModel->List_PPOJ_Swab_Detail($id),
                
                'List_PPOJ_Swab'      => $PpojSwabModel->List_PPOJ_Swab($id),
                'Detail_AHU'     => $AhuSwabModel->where('id', $id)->first(),
                'Cek_button_qa'  => $cek_button_qa[0]['totalSelesai'] ?? 0,
                'Cek_button_qc'  => $cek_button_qc[0]['totalSelesai'] ?? 0
            ];
            echo view('AtRest/datappoj_detail_swab', $data);

    
}
public function Detail($id)
    {
        $AllModel = new AllModel();
        $dompdf = new Dompdf(['isRemoteEnabled' => true]);
        $PpojSwabModel = new PpojSwabModel();
        $PatogenSwabModel = new PatogenSwabModel;
       
        $countPatogen = count($PatogenSwabModel->where('id_ppoj', $id)->findAll());
       
        $id_swab = $PpojSwabModel->select('id_swab')->where('id', $id)->first();

        $data = [
            'Detail_AHU' => $AhuModel->where('id', $id_ahu)->first(),
            'List_AHU' => $AllModel->List_AHU(),
            'List_Ruangan' => $AllModel->List_Ruangan(),
            'id' => $id,
            'List_PPOJ' => $AhuModel->findAll(),
            'imageSrc'    => $this->imageToBase64(ROOTPATH . 'public/logob7.png'),
            'Detail_PPOJ' => $PpojModel->where('id', $id)->first(),
            'Detail_Flow' => $FlowModel->where('id_ppoj', $id)->findAll(),
            'DataSuhuRH'  => $PpojModel->DataPDF($countsuhu, $countrh, $countcapar, $countmas, $id),
            'JumlahData' => count($PpojModel->DataPDF($countsuhu, $countrh, $countcapar, $countmas, $id)),
            'Perbedaan_ruangan' => $PpojModel->Terhadap_Ruangan($id),
            'kondisi' => $kondisi['kondisi'],
            'cekpartikel' => $cekpartikel,
            'keterangan' =>  $PpojModel->cekKeterangan($id)

        ];
    
       // dd($data);
         
        echo view('AtRest/tableSwab', $data);
        
    }
    public function requestOOS()
{
    $id_swab = $this->request->getPost('id_swab');

    if (!$id_swab) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'ID SWAB tidak ditemukan'
        ]);
    }

    $db = \Config\Database::connect();

    // Ambil data dari patogen_Swab sesuai id_swab
    $patogenTable = $db->table('patogen_Swab');
    $row = $patogenTable->where('id_swab', $id_swab)->get()->getRowArray();

    if (!$row) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Data patogen_Swab tidak ditemukan'
        ]);
    }

    // Siapkan data untuk insert ke tabel oos
    $oosData = [
        'id_swab' => $row['id_swab'],
        'nama_mesin_personil_alat' => $row['nama_mesin_personil_alat'],
        'lokasi_sampling' => $row['lokasi_sampling'],
        'tanggal_sampling' => $row['tanggal_sampling'],
        'tgl_analisa' => $row['tgl_analisa'],
        // Tambahkan kolom lain jika diperlukan sesuai struktur tabel oos
        'created_at' => date('Y-m-d H:i:s'), // misal untuk mencatat waktu insert
    ];

    // Insert data ke tabel oos
    $oosTable = $db->table('oos');
    $inserted = $oosTable->insert($oosData);

    if ($inserted) {
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Request OOS berhasil dikirim'
        ]);
    } else {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Gagal menyimpan data OOS'
        ]);
    }
}


public function requestPenyimpangan()
{
    $id_swab = $this->request->getPost('id_swab');

    if (!$id_swab) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'ID SWAB tidak ditemukan'
        ]);
    }

    $db = \Config\Database::connect();

    // Ambil data dari patogen_Swab sesuai id_swab
    $patogenTable = $db->table('patogen_Swab');
    $row = $patogenTable->where('id_swab', $id_swab)->get()->getRowArray();

    if (!$row) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Data patogen_Swab tidak ditemukan'
        ]);
    }

    // Siapkan data untuk insert ke tabel oos
    $oosData = [
        'id_swab' => $row['id_swab'],
        'nama_mesin_personil_alat' => $row['nama_mesin_personil_alat'],
        'lokasi_sampling' => $row['lokasi_sampling'],
        'tanggal_sampling' => $row['tanggal_sampling'],
        'tgl_analisa' => $row['tgl_analisa'],
        // Tambahkan kolom lain jika diperlukan sesuai struktur tabel oos
        'created_at' => date('Y-m-d H:i:s'), // misal untuk mencatat waktu insert
    ];

    // Insert data ke tabel oos
    $oosTable = $db->table('penyimpangan');
    $inserted = $oosTable->insert($oosData);

    if ($inserted) {
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Request Penyimpangan berhasil dikirim'
        ]);
    } else {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Gagal menyimpan data OOS'
        ]);
    }
}
    

}

