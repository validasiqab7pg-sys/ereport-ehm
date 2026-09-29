<?php

namespace App\Models;

use CodeIgniter\Model;
// use Modules\Authentication\Models\UserAuthModel;

class PpojModel extends Model
{
  protected $table = 'data_awal_ppoj';
  protected $primaryKey = 'id';
  protected $returnType = 'array';
  //protected $useSoftDeletes = 'true';
  protected $allowedFields = [
    'id',
    'no_ppoj',
    'ahu',
    'tanggaldilakukan',
    'site',
    'keterangan',
    'nama_ruangan',
    'kelas',
    'kondisi',
    'status',
    'jenispemeriksaan',
    'id_ahu',
    'jumlah_pertukaran_udara'
  ];


  public function List_Detail_Suhu($id = null)
  {


    $query = $this->db->query('SELECT DISTINCT A.*,B.status as status_suhu FROM data_awal_ppoj A LEFT JOIN suhu B ON A.id = B.id_ppoj WHERE A.id_ahu AND A.id_ahu =' . $id . '');

    $data = $query->getResultArray();
    return $data;
  }

  public function countSelesaiSuhu($id = null)
  {


    $query = $this->db->query('SELECT count(*) selesaiSuhu FROM data_awal_ppoj A LEFT JOIN suhu B ON A.id = B.id_ppoj WHERE A.id_ahu AND B.status is null AND A.id_ahu =' . $id . '');

    $data = $query->getResultArray();
    return $data;
  }

  public function List_Detail_Lux($id = null)
  {


    $query = $this->db->query('SELECT DISTINCT A.*,B.status as status_lux FROM data_awal_ppoj A LEFT JOIN lux B ON A.id = B.id_ppoj WHERE A.id_ahu AND A.id_ahu =' . $id . '');

    $data = $query->getResultArray();
    return $data;
  }
  
  public function countSelesaiLux($id = null)
  {


    $query = $this->db->query('SELECT count(*) selesaiLux FROM data_awal_ppoj A LEFT JOIN lux B ON A.id = B.id_ppoj WHERE A.id_ahu AND B.status is null AND A.id_ahu =' . $id . '');

    $data = $query->getResultArray();
    return $data;
  }

  public function List_Detail_Flow($id = null)
  {


    $query = $this->db->query('SELECT DISTINCT A.*,B.status as status_flow FROM data_awal_ppoj A LEFT JOIN flow  B ON A.id = B.id_ppoj WHERE A.id_ahu AND A.id_ahu =' . $id . '');

    $data = $query->getResultArray();
    return $data;
  }

  public function countSelesaiFlow($id = null)
  {


    $query = $this->db->query('SELECT count(*) selesaiFlow FROM data_awal_ppoj A LEFT JOIN flow B ON A.id = B.id_ppoj WHERE A.id_ahu AND B.status is null AND A.id_ahu =' . $id . '');

    $data = $query->getResultArray();
    return $data;
  }

  public function List_Detail_Rh($id = null)
  {


    $query = $this->db->query('SELECT DISTINCT A.*,B.status as status_rh FROM data_awal_ppoj A LEFT JOIN rh B ON A.id = B.id_ppoj WHERE A.id_ahu AND A.id_ahu =' . $id . '');

    $data = $query->getResultArray();
    return $data;
  }
  public function countSelesaiRh($id = null)
  {


    $query = $this->db->query('SELECT count(*) selesaiRh FROM data_awal_ppoj A LEFT JOIN rh B ON A.id = B.id_ppoj WHERE A.id_ahu AND B.status is null AND A.id_ahu =' . $id . '');

    $data = $query->getResultArray();
    return $data;
  }

  public function List_Detail_Dp($id = null)
  {


    $query = $this->db->query('SELECT DISTINCT A.*,B.status as status_dp FROM data_awal_ppoj A LEFT JOIN dp B ON A.id = B.id_ppoj WHERE A.id_ahu AND A.id_ahu =' . $id . '');

    $data = $query->getResultArray();
    return $data;
  }
  public function countSelesaiDp($id = null)
  {


    $query = $this->db->query('SELECT count(*) selesaiDp FROM data_awal_ppoj A LEFT JOIN dp B ON A.id = B.id_ppoj WHERE A.id_ahu AND B.status is null AND A.id_ahu =' . $id . '');

    $data = $query->getResultArray();
    return $data;
  }
  public function List_Detail_Mas($id = null)
  {


    $query = $this->db->query('SELECT DISTINCT A.*,B.status as status_mas FROM data_awal_ppoj A LEFT JOIN mikro_volumetrik B ON A.id = B.id_ppoj WHERE A.id_ahu AND A.id_ahu =' . $id . '');

    $data = $query->getResultArray();
    return $data;
  }

  public function List_Detail_Capar($id = null)
  {


    $query = $this->db->query('SELECT DISTINCT A.*,B.status as status_capar FROM data_awal_ppoj A LEFT JOIN mikro_capar B ON A.id = B.id_ppoj WHERE A.id_ahu   =' . $id . '');

    $data = $query->getResultArray();
    return $data;
  }

  public function List_Detail_Patogen($id = null)
  {


    $query = $this->db->query('SELECT A.*,B.status as status_patogen FROM data_awal_ppoj A LEFT JOIN patogen B ON A.id = B.id_ppoj WHERE A.id_ahu AND A.id_ahu =' . $id . '');

    $data = $query->getResultArray();
    return $data;
  }
  public function Cek_button_qa($id = null)
  {
      $query = $this->db->query("
          SELECT COUNT(*) as totalSelesai 
          FROM data_ahu 
          WHERE id = $id 
          AND (
              keterangan = 'Verifikasi' 
              OR (statusRH = 1 AND statusDP = 1 AND statusSuhu = 1 AND statusFlow = 1)
          )
      ");

      $data = $query->getResultArray();
      return $data;
  }


  public function Cek_button_qc($id = null)
  {


    $query = $this->db->query('SELECT COUNT(*) as totalSelesai FROM `data_ahu` WHERE id = ' . $id . ' AND  statusMas =1 AND statusCapar =1 AND  statusPatogen=1');

    $data = $query->getResultArray();
    return $data;
  }
  public function cekKeterangan($id = null)
  {


    $query = $this->db->query('
    SELECT 
        CASE 
            WHEN EXISTS (
                SELECT 1 FROM suhu WHERE id_ppoj = ? AND keterangan = "TMS"
                UNION ALL
                SELECT 1 FROM rh WHERE id_ppoj = ? AND keterangan = "TMS"
                UNION ALL
                SELECT 1 FROM dp WHERE id_ppoj = ? AND keterangan = "TMS"
                UNION ALL
                SELECT 1 FROM flow WHERE id_ppoj = ? AND keterangan = "TMS"
                UNION ALL
                SELECT 1 FROM mikro_volumetrik WHERE id_ppoj = ? AND keterangan = "TMS"
            )
            THEN 0
            ELSE 1
        END AS cekKondisi
', [$id, $id, $id, $id, $id]);


    $data = $query->getResultArray();
    return $data;
  }
  public function List_PPOJ_AHU()
  {
    $session = session();

    //   $builder = $this->db->table("data_awal_ppoj");
    //   $builder->distinct('ahu,tanggaldilakukan');
    //$builder->select('id,ahu,tanggaldilakukan,jenispemeriksaan,kondisi,site,status');

    $query = $this->db->query('SELECT * FROM data_awal_ppoj GROUP by ahu,tanggaldilakukan;');

    $data = $query->getResultArray();
    return $data;
  }

  public function List_SUHU()
  {
    $session = session();

    $query = $this->db->query('SELECT A.*,count(B.id_ahu) C_Ruangan FROM data_ahu A, `data_awal_ppoj` B WHERE A.id =B.id_ahu GROUP BY B.id_ahu;');

    $data = $query->getResultArray();
    return $data;
  }
  public  function QuerySuhu()
  {
    return '(select 
      ID_PPOJ, 
      ROW_NUMBER() over (partition by ID_PPOJ order by SUHU_MIN) as rn, 
      SUHU_MIN, 
      SUHU_MAX 
    from 
      suhu )';
  }
  public function QueryRh()
  {
    return ' ( select 
      ID_PPOJ, 
      ROW_NUMBER() over (partition by ID_PPOJ order by RH_MIN) as rn, 
      RH_MIN, 
      RH_MAX 
    from rh )';
  }
  public function QueryCapar()
  {
    return '( select 
      ID_PPOJ, 
      ROW_NUMBER() over (partition by ID_PPOJ order by id) as rn, 
      HASIL_TPC, 
      HASIL_KK 
    from mikro_capar )';
  }
  public function QueryMas()
  {
    return '( select 
      ID_PPOJ, 
      ROW_NUMBER() over (partition by ID_PPOJ order by id) as rn, 
      HASIL_TPC, 
      HASIL_KK 
    from mikro_volumetrik )';
  }
public function QueryDp()
{
  return '( 
    SELECT 
      ID_PPOJ, 
      ROW_NUMBER() OVER (PARTITION BY ID_PPOJ ORDER BY terhadap_ruangan) AS rn,
      CONCAT( ROW_NUMBER() OVER (PARTITION BY ID_PPOJ ORDER BY terhadap_ruangan), " . ", terhadap_ruangan, " : ", hasil_dp) AS keterangan_dp
    FROM dp 
  )';
}
public function QueryFlow()
{
  return '( 
    SELECT 
      ID_PPOJ, 
      ROW_NUMBER() OVER (PARTITION BY ID_PPOJ ORDER BY hasil_flow) AS rn,
      hasil_flow
    FROM flow 
  )';
}


public function getMaxDataSource($id)
{
    $counts = [];

    $tables = [
        'flow' => 'SELECT COUNT(*) AS jml FROM flow WHERE ID_PPOJ = ?',
        'mikro_volumetrik' => 'SELECT COUNT(*) AS jml FROM mikro_volumetrik WHERE ID_PPOJ = ?',
        'dp' => 'SELECT COUNT(*) AS jml FROM dp WHERE ID_PPOJ = ?',
        'mikro_capar' => 'SELECT COUNT(*) AS jml FROM mikro_capar WHERE ID_PPOJ = ?'
    ];

    foreach ($tables as $key => $sql) {
        $query = $this->db->query($sql, [$id])->getRow();
        $counts[$key] = $query->jml;
    }

    arsort($counts);
    return array_key_first($counts);
}

public function DataPDF($suhu, $rh, $dp, $flow, $mas, $capar, $id)
{
    // Urutkan berdasarkan nilai terbanyak
    $values = [
        'suhu' => $suhu,
        'rh' => $rh,
        'dp' => $dp,
        'flow' => $flow,
        'mas' => $mas,
        'capar' => $capar
    ];

    arsort($values);

    $queryMap = [
        'suhu'  => ['query' => $this->QuerySuhu(),   'alias' => 'su'],
        'rh'    => ['query' => $this->QueryRh(),     'alias' => 'rh'],
        'dp'    => ['query' => $this->QueryDp(),     'alias' => 'dp'],
        'flow'  => ['query' => $this->QueryFlow(),   'alias' => 'fl'],
        'mas'   => ['query' => $this->QueryMas(),    'alias' => 'ms'],
        'capar' => ['query' => $this->QueryCapar(),  'alias' => 'cp']
    ];

    // Ambil driver utama (tabel dengan jumlah terbanyak)
    $mainDriver = array_key_first($values);
    $driverAlias = $queryMap[$mainDriver]['alias'];
    
    return $this->DataSuhuRH(
        $queryMap['suhu']['query'],  
        $queryMap['rh']['query'], 
        $queryMap['dp']['query'],    
        $queryMap['flow']['query'], 
        $queryMap['mas']['query'],   
        $queryMap['capar']['query'], 
        $id,
        $queryMap['suhu']['alias'], 
        $queryMap['rh']['alias'], 
        $queryMap['dp']['alias'],   
        $queryMap['flow']['alias'], 
        $queryMap['mas']['alias'],  
        $queryMap['capar']['alias'],
        $driverAlias
    );
}

public function DataSuhuRH($q1, $q2, $q3, $q4, $q5, $q6, $id, $a1, $a2, $a3, $a4, $a5, $a6)
{
    // Buat mapping query dan alias
    $queries = [
        $a1 => $q1,
        $a2 => $q2,
        $a3 => $q3,
        $a4 => $q4,
        $a5 => $q5,
        $a6 => $q6,
    ];

    // Subquery masing-masing tabel dengan filter ID_PPOJ
    $subqueries = [];
    foreach ($queries as $alias => $query) {
        $subqueries[] = "
            SELECT rn FROM ({$query}) {$alias} 
            WHERE {$alias}.ID_PPOJ = '{$id}'
        ";
    }

    // Buat union semua rn
    $unionRn = implode("\nUNION\n", $subqueries);

    // Bangun query utama
    $sql = "
        WITH rn_numbers AS (
            {$unionRn}
        )
        SELECT 
            DAP.KELAS,
            DAP.ID AS ID_PPOJ,
            rn_numbers.rn,

            {$a1}.SUHU_MIN, 
            {$a1}.SUHU_MAX,
            {$a2}.RH_MIN, 
            {$a2}.RH_MAX,
            {$a3}.keterangan_dp,
            {$a4}.hasil_flow,
            {$a5}.HASIL_TPC AS MIKRO_TPC,
            {$a5}.HASIL_KK AS MIKRO_KK,
            {$a6}.HASIL_TPC AS CAPAR_TPC,
            {$a6}.HASIL_KK AS CAPAR_KK

        FROM rn_numbers
        CROSS JOIN data_awal_ppoj DAP

        LEFT JOIN ({$queries[$a1]}) {$a1} ON {$a1}.ID_PPOJ = DAP.ID AND {$a1}.rn = rn_numbers.rn
        LEFT JOIN ({$queries[$a2]}) {$a2} ON {$a2}.ID_PPOJ = DAP.ID AND {$a2}.rn = rn_numbers.rn
        LEFT JOIN ({$queries[$a3]}) {$a3} ON {$a3}.ID_PPOJ = DAP.ID AND {$a3}.rn = rn_numbers.rn
        LEFT JOIN ({$queries[$a4]}) {$a4} ON {$a4}.ID_PPOJ = DAP.ID AND {$a4}.rn = rn_numbers.rn
        LEFT JOIN ({$queries[$a5]}) {$a5} ON {$a5}.ID_PPOJ = DAP.ID AND {$a5}.rn = rn_numbers.rn
        LEFT JOIN ({$queries[$a6]}) {$a6} ON {$a6}.ID_PPOJ = DAP.ID AND {$a6}.rn = rn_numbers.rn

        WHERE DAP.ID = ?
        ORDER BY rn_numbers.rn
    ";

    $result = $this->db->query($sql, [$id]);
    return $result->getResultArray();
}
  public function List_RH()
  {
    $session = session();

    //   $builder = $this->db->table("data_awal_ppoj");
    //   $builder->distinct('ahu,tanggaldilakukan');
    //$builder->select('id,ahu,tanggaldilakukan,jenispemeriksaan,kondisi,site,status');

    $query = $this->db->query('SELECT A.*,count(B.id_ahu) C_Ruangan FROM data_ahu A, `data_awal_ppoj` B WHERE A.id =B.id_ahu GROUP BY B.id_ahu;');

    $data = $query->getResultArray();
    return $data;
  }
  public function List_MAS()
  {
      $session = session();

      $query = $this->db->query('
          SELECT A.*, COUNT(B.id_ahu) AS C_Ruangan 
          FROM data_ahu A, data_awal_ppoj B 
          WHERE A.id = B.id_ahu 
          AND A.approve_1 != "" 
          AND (A.keterangan IS NULL OR A.keterangan != "Verifikasi")
          GROUP BY B.id_ahu
      ');

      $data = $query->getResultArray();
      return $data;
  }
  public function List_CAPAR()
  {
      $session = session();

      $query = $this->db->query('
          SELECT A.*, COUNT(B.id_ahu) AS C_Ruangan 
          FROM data_ahu A, data_awal_ppoj B 
          WHERE A.id = B.id_ahu 
          AND A.approve_1 != "" 
          AND (A.keterangan IS NULL OR A.keterangan != "Verifikasi")
          GROUP BY B.id_ahu
      ');

      $data = $query->getResultArray();
      return $data;
  }
  public function List_Patogen()
  {
      $session = session();

      $query = $this->db->query('
          SELECT A.*, COUNT(B.id_ahu) AS C_Ruangan 
          FROM data_ahu A, data_awal_ppoj B 
          WHERE A.id = B.id_ahu 
          AND A.approve_1 != "" 
          AND (A.keterangan IS NULL OR A.keterangan != "Verifikasi")
          GROUP BY B.id_ahu
      ');

      $data = $query->getResultArray();
      return $data;
  }
  
  public function Terhadap_Ruangan($id)
  {

    $query = $this->db->query('SELECT 
     terhadap_ruangan,hasil_dp FROM dp WHERE id_ppoj =' . $id . '');

    $data = $query->getResultArray();
    return $data;
  }
  public function List_PPOJ_ID($id_ahu)
  {
    $session = session();

    //   $query = $this->db->query('SELECT * FROM data_awal_ppoj where id_ahu = '+$id_ahu+'');

    $builder = $this->db->table("data_awal_ppoj");
    $builder->select('*');
    $builder->where('id_ahu', $id_ahu);
    $data = $builder->get()->getResultArray();
    return $data;
  }
}