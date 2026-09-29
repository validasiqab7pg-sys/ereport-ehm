<?php

namespace App\Models;

use CodeIgniter\Model;
// use Modules\Authentication\Models\UserAuthModel;

class AhuModel extends Model
{
  protected $table = 'data_ahu';
  protected $primaryKey = 'id';
  protected $returnType = 'array';
  //protected $useSoftDeletes = 'true';
  protected $allowedFields = [
    'id',
    'ahu',
    'tanggaldilakukan',
    'site',
    'keterangan',
    'status',
    'jenispemeriksaan',
    'kondisi',
    'approve_1',
    'approve_1_date',
    'approve_2',
    'approve_2_date',
    'approve_3',
    'approve_3_date',
    'approve_4',
    'approve_4_date',
    'statusSuhu',
    'statusRh',
    'statusDp',
    'statusFlow',
    'statusLux',
    'statusPartikel',
    'statusMas',
    'statusCapar',
    'statusPatogen'

  ];

  public function Detail_AHU_RUANGAN($id)
  {

    $query = $this->db->query('SELECT A.*,count(B.id_ahu) C_Ruangan FROM data_ahu A, `data_awal_ppoj` B WHERE A.id =B.id_ahu GROUP BY B.id_ahu;');

    $builder = $this->db->table("data_ahu");
    $builder->select('kelas');
    $builder->where('nama_ruangan', $id);
    $data = $builder->get()->getRow();

    return $data->kelas;
  }
}
