<?php

namespace App\Models;
use CodeIgniter\Model;
// use Modules\Authentication\Models\UserAuthModel;

class FlowModel extends Model
{
    protected $table = 'flow';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    //protected $useSoftDeletes = 'true';
    protected $allowedFields = [
    'id','no_ppoj','id_ahu','status','nama_ruangan','hasil_flow','volume_ruangan','analis','tanggal_dilakukan','keterangan','id_ppoj'

    ];
    public function Pertukaran_Udara($total_flow)
    {
      $session = session();
    
      $builder = $this->db->table("flow");
      $builder->select('ROUND((1.6*volume_ruangan)/'.$total_flow.') cnt');
      $data = $builder->get()->getRow();
      return $data->cnt;
    
    }



}