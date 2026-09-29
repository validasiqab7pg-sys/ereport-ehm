<?php

namespace App\Models;
use CodeIgniter\Model;
// use Modules\Authentication\Models\UserAuthModel;

class PartikelModel extends Model
{
    protected $table = 'partikel';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    //protected $useSoftDeletes = 'true';
    protected $allowedFields = [
    'id','no_ppoj','nama_ruangan','hasil_partikel','analis','tanggal_dilakukan','keterangan','id_ppoj','id_ahu','nama_ahu'	

    ];
   



}