<?php

namespace App\Models;
use CodeIgniter\Model;
// use Modules\Authentication\Models\UserAuthModel;

class DpModel extends Model
{
    protected $table = 'dp';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    //protected $useSoftDeletes = 'true';
    protected $allowedFields = [
    'id','no_ppoj','id_ahu','status','nama_ruangan','terhadap_ruangan','hasil_dp','analis','tanggal_dilakukan','keterangan','id_ppoj'	

    ];
   



}