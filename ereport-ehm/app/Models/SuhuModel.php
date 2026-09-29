<?php

namespace App\Models;
use CodeIgniter\Model;
// use Modules\Authentication\Models\UserAuthModel;

class SuhuModel extends Model
{
    protected $table = 'suhu';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    //protected $useSoftDeletes = 'true';
    protected $allowedFields = [
    'id','no_ppoj','id_ahu','status','nama_ruangan','suhu_min','suhu_max','analis','tanggal_dilakukan','id_ppoj','keterangan','kelas','editable','approve_edit','approve_edit_by'

    ];
   



}