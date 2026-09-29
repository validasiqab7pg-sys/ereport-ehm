<?php

namespace App\Models;

use CodeIgniter\Model;
// use Modules\Authentication\Models\UserAuthModel;

class AllModel extends Model
{
  // protected $table = 'user';
  // protected $primaryKey = 'id';
  // protected $returnType = 'array';
  // //protected $useSoftDeletes = 'true';
  // protected $allowedFields = ['id','username','password','jabatan','department'	
  // ];
  // protected function initialize()
  // {
  //     $this->allowedFields[] = 'middlename';
  // }
  public function List_Kategori()
  {
      return $this->db->table('master_data_swab')
                      ->distinct() // Menambahkan distinct untuk kategori
                      ->select('kategori')
                      ->get()
                      ->getResultArray();
  }


  
  public function List_PPOJ_Swab()
  {
      // Query untuk mengambil data PPOJ Swab yang diperlukan
      $builder = $this->db->table('data_swab');
      $builder->select('id, tanggal_sampling, kategori, site, keterangan, status');
      $builder->orderBy('tanggal_sampling', 'DESC'); // Mengurutkan berdasarkan tanggal sampling terbaru

      $query = $builder->get();
      return $query->getResultArray(); // Mengembalikan data dalam bentuk array
  }


  public function deleteRecord($id)
  {
    // Inisialisasi model
    $AllModel = new AllModel();

    // Proses penghapusan data berdasarkan ID
    $AllModel->where('id', $id)->delete();

    // Set flashdata untuk memberi tahu pengguna bahwa data telah dihapus
    session()->setFlashdata('Toast', 'Data Berhasil dihapus');

    // Redirect ke halaman list setelah penghapusan
    return redirect()->to('/DataPpoj_Swab');
  }
  protected $table = 'master_data_swab'; // Ganti dengan nama tabel yang benar

  public function List_Departemen()
  {
    return $this->db->table('master_data_swab')->get()->getResultArray();
  }



  public function List_AHU()
  {
    $session = session();

    $builder = $this->db->table("nama_ahu");
    $builder->select('*');
    $data = $builder->get()->getResultArray();
    return $data;
  }

  public function Cek_Syarat_Suhu($kelas, $suhu_min, $suhu_max)
  {
    $builder = $this->db->table("master_syarat");
    $builder->select('*');
    $builder->where('kelas', $kelas);
    $builder->where('suhu_min <=', $suhu_min);
    $builder->where('suhu_max >=', $suhu_max);
    $data = $builder->get()->getRow();

    if ($data) {
      return "TMS";
    } else {
      return "MS";
    }
  }
  public function Cek_Syarat_Rh($kelas, $rh_min, $rh_max)
  {
    $builder = $this->db->table("master_syarat");
    $builder->select('*');
    $builder->where('kelas', $kelas);
    $builder->where('rh_min <=', $rh_min);
    $builder->where('rh_max >=', $rh_max);
    $data = $builder->get()->getRow();

    if ($data) {
      return "TMS";
    } else {
      return "MS";
    }
  }

  public function Cek_Syarat_DP($ruanganDP)
  {
    $builder = $this->db->table("master_data");
    $builder->select('kelas');
    $builder->where('nama_ruangan', $ruanganDP);
    $data = $builder->get()->getRow();

    return $data->kelas;
  }
  public function List_Ruangan()
  {
    $session = session();

    $builder = $this->db->table("master_data");
    $builder->DISTINCT('nama_ruangan');
    $builder->select('nama_ruangan');
    $data = $builder->get()->getResultArray();
    return $data;
  }
  


  public function List_RuanganDp()
  {
    $session = session();

    $builder = $this->db->table("master_data_dp");
    $builder->DISTINCT('terhadap_ruangan');
    $builder->select('terhadap_ruangan');
    $data = $builder->get()->getResultArray();
    return $data;
  }
  public function Pilih_Kelas($ahu, $nama_ruangan)
  {
    $session = session();

    $builder = $this->db->table("master_data");
    $builder->select('kelas');
    $builder->where('nama_ahu', $ahu);
    $builder->where('nama_ruangan', $nama_ruangan);
    $data = $builder->get()->getRow();
    return $data;
  }

  public function Pilih_Kelas_Swab($kategori, $nama_mesin_personil_alat)
  {
    $session = session();

    $builder = $this->db->table("master_data_swab");
    $builder->select('kelas');
    $builder->where('kategori', $kategori);
    $builder->where('nama_mesin_personil_alat', $nama_mesin_personil_alat);
    $data = $builder->get()->getRow();
    return $data;
  }

  public function Pilih_Departemen_Swab($kategori, $nama_mesin_personil_alat)
  {
    $session = session();

    $builder = $this->db->table("master_data_swab");
    $builder->select('departemen');
    $builder->where('kategori', $kategori);
    $builder->where('nama_mesin_personil_alat', $nama_mesin_personil_alat);
    $data = $builder->get()->getRow();
    return $data;
  }

  public function Pilih_Ruangan_Swab($kategori, $nama_mesin_personil_alat)
  {
    $session = session();

    $builder = $this->db->table("master_data_swab");
    $builder->select('nama_ruangan');
    $builder->where('kategori', $kategori);
    $builder->where('nama_mesin_personil_alat', $nama_mesin_personil_alat);
    $data = $builder->get()->getRow();
    return $data;
  }


  public function Pilih_Kelas_Departemen($ahu, $departemen)
  {
    $session = session();

    $builder = $this->db->table("master_data_swab");
    $builder->select('kelas');
    $builder->where('nama_mesin_personil_alat', $ahu);
    $builder->where('departemen', $departemen);
    $data = $builder->get()->getRow();
    return $data;
  }

  public function Pilih_Ahu($ahu)
  {

    $builder = $this->db->table("master_data");
    $builder->select('nama_ruangan');
    $builder->where('nama_ahu', $ahu);
    $data = $builder->get()->getResult();
    return $data;
  }
  public function Pilih_NamaMesin($kategori, $periode, $tahunSekarang)
{
    $builder = $this->db->table('master_data_swab');
    $builder->distinct();
    $builder->select('nama_mesin_personil_alat');
    $builder->where('kategori', $kategori);
    $builder->where('periode', $periode);

    // Subquery untuk memfilter mesin yang SUDAH diinput
    $builder->whereNotIn('nama_mesin_personil_alat', function ($subquery) use ($kategori, $periode, $tahunSekarang) {
        $subquery->select('nama_mesin_personil_alat')
            ->from('data_awal_swab')
            ->where('kategori', $kategori)
            ->where('periode', $periode)
            // Filter tambahan: hanya cek data yang tahun samplingnya sama dengan tahun ini
            ->where("YEAR(tanggal_sampling)", $tahunSekarang); 
    });

    return $builder->get()->getResult();
}
  public function Pilih_Kategori($nama_mesin_personil_alat)
  {

    $builder = $this->db->table("data_awal_swab");
    $builder->select('kategori');
    $builder->where('nama_mesin_personil_alat', $nama_mesin_personil_alat);
    $data = $builder->get()->getResult();
    return $data;
  }
  public function Pilih_Ruangan($ppoj)
  {

    $builder = $this->db->table("data_awal_ppoj");
    $builder->select('nama_ruangan');
    $builder->where('no_ppoj', $ppoj);
    $data = $builder->get()->getResult();
    return $data;
  }
  public function selectData($table, $where = array())
  {
    $builder = $this->db->table($table);
    $builder->select("*");
    $builder->where($where);
    $query = $builder->get();
    // echo $this->db->getLastQuery();
    // die();
    return $query->getResult();
  }
  public function Pilih_Tanggal($tanggal)
  {

    $session = session();

    $builder = $this->db->table("data_awal_ppoj");
    $builder->select('tanggaldilakukan');
    $builder->where('tanggaldilakukan', $tanggal);
    $data = $builder->get()->getRow();
    return $data;
  }
  public function DataCapar($ruangan)
  {

    $builder = $this->db->table("master_data");
    $builder->select('titik_capar');
    $builder->where('nama_ruangan', $ruangan);
    $data = $builder->get()->getRow();
    return $data;
  }

  public function DataMikro($ruangan, $ahu = null)
{
    $builder = $this->db->table('master_data');
    $builder->select('titik_mikro');

    // Jika ada parameter AHU, prioritaskan pencarian berdasarkan ruangan + ahu
    if (!empty($ahu)) {
        $builder->where('nama_ruangan', $ruangan);
        $builder->where('nama_ahu', $ahu);
        $data = $builder->get()->getRow();

        // Jika tidak ditemukan, fallback ke pencarian hanya berdasarkan nama_ruangan
        if (!$data) {
            $builder = $this->db->table('master_data');
            $builder->select('titik_mikro');
            $builder->where('nama_ruangan', $ruangan);
            $data = $builder->get()->getRow();
        }
    } else {
        // Jika AHU tidak dikirim, gunakan pencarian berdasarkan nama_ruangan saja
        $builder->where('nama_ruangan', $ruangan);
        $data = $builder->get()->getRow();
    }

    return $data;
}

  public function MasterData($ruangan)
  {

    $builder = $this->db->table("master_data");
    $builder->select('*');
    $builder->where('nama_ruangan', $ruangan);
    $data = $builder->get()->getRow();
    return $data;
  }

  public function RequestEdit()
  {
    $session = session();

    $query = $this->db->query('SELECT "Rh" as type,id,no_ppoj,nama_ruangan,analis,editable,approve_edit,approve_edit_by FROM `rh` WHERE editable = 1 and approve_edit = 0
                                UNION 
                                SELECT "Suhu" as type,id,no_ppoj,nama_ruangan,analis,editable,approve_edit,approve_edit_by FROM `suhu` WHERE editable = 1 and approve_edit =0;');

    $data = $query->getResultArray();
    return $data;
  }
  public function RequestEditMikro()
  {
    $session = session();

    $query = $this->db->query('SELECT "Capar" as type,id,no_ppoj,nama_ruangan,analis,editable,approve_edit,approve_edit_by FROM `mikro_capar` WHERE editable = 1 and approve_edit = 0
                                UNION 
                                SELECT "Volumetrik" as type,id,no_ppoj,nama_ruangan,analis,editable,approve_edit,approve_edit_by FROM `mikro_volumetrik` WHERE editable = 1 and approve_edit =0;');

    $data = $query->getResultArray();
    return $data;
  }
}
