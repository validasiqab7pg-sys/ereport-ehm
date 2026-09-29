<?php

namespace App\Models;
use CodeIgniter\Model;
// use Modules\Authentication\Models\UserAuthModel;

class PatogenModel extends Model
{
    protected $table = 'patogen';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    //protected $useSoftDeletes = 'true';
    protected $allowedFields = [
    'id','no_ppoj','nama_ruangan','id_ahu','status','e_coli','salmonella_sp','staphylococcus_aureus','pseudomonas_aeruginosa','shigella_sp','enterobacteriaceae','clostridia_sporogens','tgl_analisa','analis','tanggal_dilakukan','keterangan','id_ppoj'	

    ];
   



}