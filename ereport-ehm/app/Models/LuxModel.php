<?php

namespace App\Models;
use CodeIgniter\Model;
// use Modules\Authentication\Models\UserAuthModel;

class LuxModel extends Model
{
    protected $table = 'lux';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    //protected $useSoftDeletes = 'true';
    protected $allowedFields = [
    'id','no_ppoj','id_ahu','status','nama_ruangan','hasil_lux','analis','tanggal_dilakukan','keterangan','id_ppoj'	

    ];
   



}