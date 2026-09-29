<?php

namespace App\Models;

//use CodeIgniter\Model;
use App\Models\BaseModel;

// use Modules\Authentication\Models\UserAuthModel;

class AhuSwabModel extends BaseModel
{
    protected $table = 'data_swab';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    //protected $useSoftDeletes = 'true';
    protected $allowedFields = [
        'id',
        'tanggal_sampling',
        'kategori',
        'site',
        'keterangan',
        'status',
        'approve_1',
        'approve_1_date',
        'approve_2',
        'approve_2_date',
        'approve_3',
        'approve_3_date',
        'approve_4',
        'approve_4_date',
        'statusPatogen'


    ];
    public function Detail_AHU_RUANGAN($id)
    {

        $query = $this->db->query('SELECT A.*,count(B.id_ahu) C_Ruangan FROM data_awal_swab A, `data_awal_swab` B WHERE A.id =B.id_ahu GROUP BY B.id_ahu;');

        $builder = $this->db->table("data_awal_swab");
        $builder->select('kelas');
        $builder->where('nama_mesin_personil_alat', $id);
        $data = $builder->get()->getRow();

        return $data->kelas;
    }
}
