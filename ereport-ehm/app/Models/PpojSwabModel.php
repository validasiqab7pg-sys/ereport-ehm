<?php

namespace App\Models;

use App\Models\BaseModel;

class PpojSwabModel extends BaseModel
{
    protected $table = 'data_awal_swab'; // Nama tabel
    protected $primaryKey = 'id'; // Nama primary key
    protected $returnType = 'array'; // Menentukan tipe data yang dikembalikan
    protected $allowedFields = [
        'id',
        'tanggal_sampling',
        'tanggal_dibersihkan',
        'kategori',
        'site',
        'keterangan',
        'status',
        'nama_mesin_personil_alat',
        'kelas',
        'departemen',
        'nama_ruangan',
        'ahu',
        'id_swab',
        'no_ppoj'



    ];
    public function List_PPOJ_Swab($id_swab)
    {
        $session = session();

        //   $query = $this->db->query('SELECT * FROM data_awal_ppoj where id_ahu = '+$id_ahu+'');


        $builder = $this->db->table("data_awal_swab");
        $builder->select('*');
        $builder->where('id_swab', $id_swab);
        $data = $builder->get()->getResultArray();
        return $data;
    }

    public function List_Lokasi_Sampling($id_ppoj)
    {
        $session = session();
        $query = $this->db->query("
            SELECT DISTINCT 
                mds.lokasi_sampling, 
                das.tanggal_dibersihkan,
                ps.editable,
                ps.approve_edit,
                ps.keterangan,
                ps.id,
                ps.TAMC,
                ps.TYMC,
                ps.tgl_analisa,
                ps.tgl_koloni,
                ps.e_coli,
                ps.salmonella_sp,
                ps.staphylococcus_aureus,
                ps.pseudomonas_aeruginosa,
                ps.shigella_sp,
                ps.enterobacteriaceae,
                ps.clostridia_sporogens,
                ps.analis
            FROM master_data_swab mds
            INNER JOIN data_awal_swab das 
                ON mds.nama_mesin_personil_alat = das.nama_mesin_personil_alat 
                AND mds.kategori = das.kategori
            LEFT JOIN patogen_swab ps 
                ON ps.id_ppoj = das.id 
                AND ps.lokasi_sampling = mds.lokasi_sampling
            WHERE das.id = ?
            ", [$id_ppoj]);
        
      $data = $query->getResultArray();
        return $data;
    }
    

    public function List_Patogen_Swab()
    {
      $session = session();
  
  
      $query = $this->db->query('SELECT A.*,count(B.nama_mesin_personil_alat) C_Nama_mesin_personil_alat FROM data_swab A, `data_awal_swab` B WHERE A.id =B.id_swab and A.approve_1 != ""  GROUP BY B.id_swab;');
  
      $data = $query->getResultArray();
      return $data;
    }



    public function List_PPOJ_Swab_Detail()
    {
        // Menulis query untuk mengambil data PPOJ Swab dengan field yang diperlukan
        $builder = $this->db->table($this->table);
        $builder->select('id, tanggal_sampling, nama_mesin_personil_alat, tanggal_dibersihkan, kategori, kelas, departemen, nama_ruangan, status');
        $builder->orderBy('tanggal_sampling', 'DESC'); // Menyusun data berdasarkan tanggal_sampling terbaru terlebih dahulu

        $query = $builder->get();
        return $query->getResultArray(); // Mengembalikan data dalam bentuk array
    }
    public function insertToDataSwab($data)
    {
        return $this->db->table('data_swab')->insert($data);
    }
    public function List_Detail_Patogen_Swab($id = null)
  {


    $query = $this->db->query('SELECT A.*,B.status as status_patogen FROM data_awal_swab A LEFT JOIN patogen B ON A.id = B.id_ppoj WHERE A.id_swab AND A.id_swab =' . $id . '');

    $data = $query->getResultArray();
    return $data;
  }

    public function Detail_AHU($id)
    {
        return $this->db->table('data_awal_swab')
            ->select('DISTINCT 
            data_awal_swab.id,
            data_awal_swab.id_ahu,
            data_awal_swab.ahu,
            data_awal_swab.tanggal_sampling,
            data_awal_swab.site,
            data_awal_swab.status,
            data_awal_swab.kelas,
            data_awal_swab.kategori,
            data_awal_swab.keterangan,
            data_awal_swab.nama_mesin_personil_alat,
            data_awal_swab.approve_1,
            data_awal_swab.approve_1_date,
            data_awal_swab.approve_2,
            data_awal_swab.approve_2_date,
            data_awal_swab.approve_3,
            data_awal_swab.approve_3_date,
            data_awal_swab.approve_4,
            data_awal_swab.approve_4_date,

            data_swab.id AS swab_id,
            data_swab.tanggal_sampling AS swab_tanggal_sampling,
            data_swab.ahu AS swab_ahu,
            data_swab.site AS swab_site,
            data_swab.kategori AS swab_kategori,
            data_swab.status AS swab_status,
            data_swab.keterangan AS swab_keterangan,
            data_swab.approve_1 AS swab_approve_1,
            data_swab.approve_1_date AS swab_approve_1_date,
            data_swab.approve_2 AS swab_approve_2,
            data_swab.approve_2_date AS swab_approve_2_date,
            data_swab.approve_3 AS swab_approve_3,
            data_swab.approve_3_date AS swab_approve_3_date,
            data_swab.approve_4 AS swab_approve_4,
            data_swab.approve_4_date AS swab_approve_4_date,

            master_data_swab.departemen,
            master_data_swab.nama_ruangan AS nama_ruangan
        ')
            ->join('data_swab', 'data_swab.ahu = data_awal_swab.ahu AND data_swab.tanggal_sampling = data_awal_swab.tanggal_sampling', 'left')
            ->join('master_data_swab', 'master_data_swab.nama_mesin_personil_alat = data_awal_swab.nama_mesin_personil_alat', 'left')
            ->where('data_awal_swab.id', $id)
            ->get()
            ->getRowArray();

        return $result;
    }
    public function Cek_button_qa($id = null)
    {
        $query = $this->db->query("
            SELECT COUNT(*) as totalSelesai
            FROM data_swab
            WHERE id = ?
            AND statusPatogen = 0
            AND EXISTS (
                SELECT 1 FROM data_awal_swab
                WHERE data_awal_swab.id_swab = data_swab.id
            )
        ", [$id]);

        return $query->getResultArray();
    }

  
    public function Cek_button_qc($id = null)
    {
  
  
      $query = $this->db->query('SELECT COUNT(*) as totalSelesai FROM `data_swab` WHERE id = ' . $id . ' AND  statusPatogen=1');
  
      $data = $query->getResultArray();
      return $data;
    }
    public function cekKeterangan($id = null)
    {
  
  
      $query = $this->db->query('SELECT COUNT(*) as cekKondisi
      FROM
          suhu A
          JOIN rh B ON A.id_ppoj = B.id_ppoj
          JOIN dp C ON A.id_ppoj = C.id_ppoj
          JOIN flow D ON A.id_ppoj = D.id_ppoj
          JOIN mikro_volumetrik E ON A.id_ppoj = E.id_ppoj
         
      WHERE 
          A.id_ppoj = ' . $id . ' 
          AND (
              (A.keterangan IS NOT NULL AND A.keterangan = B.keterangan) OR A.keterangan IS NULL
          )
          AND (
              (A.keterangan IS NOT NULL AND A.keterangan = C.keterangan) OR A.keterangan IS NULL
          )
          AND (
              (A.keterangan IS NOT NULL AND A.keterangan = D.keterangan) OR A.keterangan IS NULL
          )
          AND (
              (A.keterangan IS NOT NULL AND A.keterangan = E.keterangan) OR A.keterangan IS NULL
          )
         
  ');
  $data = $query->getResultArray();
    return $data;
  }
    // Mendapatkan data berdasarkan ID
    public function getDetails($id = null)
    {
        // Menggunakan query builder untuk menghindari SQL mentah
        return $this->where('id', $id)->first();
    }

    // Menambahkan record baru
    public function addRecord($data)
    {
        // Menambahkan data menggunakan query builder
        return $this->insert($data);
    }

    // Memperbarui record berdasarkan ID
    public function updateRecord($id, $data)
    {
        // Memperbarui data menggunakan query builder
        return $this->update($id, $data);
    }

    // Menghapus record berdasarkan ID
    public function deleteRecord($id)
    {
        // Menghapus record berdasarkan ID
        return $this->delete($id);
    }

    // Mendapatkan semua records
    public function getAllRecords()
    {
        // Mengambil semua data menggunakan query builder
        return $this->findAll();
    }

    // Menambahkan fungsi untuk mendapatkan data berdasarkan status
    public function getDataByStatus($status = null)
    {
        if ($status) {
            // Mengambil data berdasarkan status menggunakan query builder
            return $this->where('status', $status)->findAll();
        }
        // Mengambil semua data jika status tidak diberikan
        return $this->findAll();
    }

    // Fungsi untuk menghitung jumlah data dengan status tertentu
    public function countByStatus($status = null)
    {
        if ($status) {
            // Menghitung jumlah data berdasarkan status
            return $this->where('status', $status)->countAllResults();
        }
        // Menghitung semua hasil
        return $this->countAllResults();
    }

    // Fungsi untuk mendapatkan data berdasarkan rentang tanggal
    public function getDataByDateRange($startDate, $endDate)
    {
        return $this->where('tanggal_sampling >=', $startDate)
            ->where('tanggal_sampling <=', $endDate)
            ->findAll();
    }

    // Fungsi untuk memperbarui status
    public function updateStatus($id, $status)
    {
        // Memperbarui status menggunakan query builder
        return $this->update($id, ['status' => $status]);
    }

    // Fungsi untuk menyimpan data baru
    public function saveData($data)
    {
        // Menyimpan data baru menggunakan query builder
        return $this->save($data);
    }
    
    public function List_PPOJ_ID($id)
    {
        $builder = $this->db->table("data_awal_swab");
        $builder->select('
        data_awal_swab.*,
        master_data_swab.departemen,
        master_data_swab.nama_ruangan AS nama_ruangan,
        master_data_swab.site AS master_site,
        master_data_swab.kelas AS master_kelas
    ');
        $builder->join('master_data_swab', 'master_data_swab.nama_mesin_personil_alat = data_awal_swab.nama_mesin_personil_alat', 'left');
        $builder->where('data_awal_swab.id', $id);
        $data = $builder->get()->getResultArray();
        return $data;
    }

    public function Pilih_Kelas_Swab($ahu, $nama_mesin_personil_alat)
    {
        return $this->db->table('master_data_swab')
            ->select('kelas')
            ->where('nama_ahu', $ahu)
            ->where('nama_mesin_personil_alat', $nama_mesin_personil_alat)
            ->get()
            ->getRow(); // bisa getRowArray() jika mau array
    }
}
