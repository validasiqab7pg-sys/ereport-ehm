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
  public function Pilih_NamaMesin($kategori, $periodeAktif, $tahunSekarang)
{
    try {
        // Buat mapping periode → range bulan
        $periodeRangeMap = [
            'Caturwulan 1' => [1, 4],
            'Caturwulan 2' => [5, 8],
            'Caturwulan 3' => [9, 12],
            'Semester 1'   => [1, 6],
            'Semester 2'   => [7, 12],
        ];

        // ✅ Untuk setiap periode aktif, cari nama yang sudah diinput
        // berdasarkan range bulan tanggal_sampling (tanpa JOIN)
        $sudahDiinputMap = [];

        foreach ($periodeAktif as $periode) {
            if (!isset($periodeRangeMap[$periode])) continue;

            [$bulanAwal, $bulanAkhir] = $periodeRangeMap[$periode];

            $rows = $this->db->table('data_awal_swab')
                ->select('nama_mesin_personil_alat')
                ->where('kategori', $kategori)
                ->where("YEAR(tanggal_sampling)", $tahunSekarang)
                ->where("MONTH(tanggal_sampling) >=", $bulanAwal)
                ->where("MONTH(tanggal_sampling) <=", $bulanAkhir)
                ->get()
                ->getResult();

            foreach ($rows as $row) {
                // Key unik: nama + periode
                $key = $row->nama_mesin_personil_alat . '||' . $periode;
                if (!in_array($key, $sudahDiinputMap)) {
                    $sudahDiinputMap[] = $key;
                }
            }
        }

        // ✅ Ambil semua master data yang periodenya aktif
        $masterData = $this->db->table('master_data_swab')
            ->select('nama_mesin_personil_alat, periode')
            ->where('kategori', $kategori)
            ->whereIn('periode', $periodeAktif)
            ->get()
            ->getResult();

        // ✅ Filter: tampilkan hanya yang belum diinput
        $hasil = [];
        foreach ($masterData as $row) {
            $key = $row->nama_mesin_personil_alat . '||' . $row->periode;
            if (!in_array($key, $sudahDiinputMap)) {
                $hasil[] = $row;
            }
        }

        return $hasil;

    } catch (\Exception $e) {
        throw new \Exception('Model Error: ' . $e->getMessage() . ' (Line: ' . $e->getLine() . ')');
    }
}
  /**
   * ✅ HELPER: Tentukan range bulan berdasarkan periode
   * 
   * @param string $periode - Nama periode (Caturwulan 1-3, Semester 1-2)
   * @return array - [bulan_awal, bulan_akhir] atau array kosong
   */
  private function getBulanRangeByPeriode($periode)
  {
    switch ($periode) {
      case 'Caturwulan 1':
        return [1, 4];
      case 'Caturwulan 2':
        return [5, 8];
      case 'Caturwulan 3':
        return [9, 12];
      case 'Semester 1':
        return [1, 6];
      case 'Semester 2':
        return [7, 12];
      default:
        return [];
    }
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
