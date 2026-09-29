<?php

namespace App\Models;
use CodeIgniter\Model;
// use Modules\Authentication\Models\UserAuthModel;

class MasModel extends Model
{
    protected $table = 'mikro_volumetrik';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    //protected $useSoftDeletes = 'true';
    protected $allowedFields = [
    'id','no_ppoj','id_ahu','status','nama_ruangan','hasil_tpc','hasil_kk','analis','tanggal_dilakukan','id_ppoj','keterangan','kelas','tanggal_edit','editable','approve_edit','approve_edit_by'

    ];
   



}