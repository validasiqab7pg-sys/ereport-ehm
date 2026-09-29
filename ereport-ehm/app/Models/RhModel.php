<?php

namespace App\Models;
use CodeIgniter\Model;
// use Modules\Authentication\Models\UserAuthModel;

class RhModel extends Model
{
    protected $table = 'rh';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    //protected $useSoftDeletes = 'true';
    protected $allowedFields = [
    'id','no_ppoj','status','id_ahu','nama_ruangan','rh_min','rh_max','analis','tanggal_dilakukan','id_ppoj','keterangan','kelas','editable','approve_edit','approve_edit_by'

    ];
   



}