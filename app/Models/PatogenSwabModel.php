<?php

namespace App\Models;

//use App\Models\Model;
use App\Models\BaseModel;

// use Modules\Authentication\Models\UserAuthModel;

class PatogenSwabModel extends BaseModel
{
    protected $table = 'patogen_swab';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    //protected $useSoftDeletes = 'true';
    protected $allowedFields = [
    'id','no_ppoj','nama_mesin_personil_alat','tanggal_dibersihkan','lokasi_sampling','tanggal_sampling','id_swab','status','TAMC','TYMC','e_coli','salmonella_sp','staphylococcus_aureus','pseudomonas_aeruginosa','staphylococus_a','shigella_sp','enterobacteriaceae','clostridia_sporogens','tgl_analisa','tgl_koloni','analis','keterangan','id_ppoj','approve_edit_by','tanggal_edit'	
    ];
   
    public function getAllData()
    {
        return $this->findAll();  // Mengambil semua data dari tabel patogen_swab
    }
    public function getDataTMSBySwabId($id_swab)
    {
        return $this->where('id_swab', $id_swab)
                    ->where('keterangan', 'TMS')
                    ->findAll();
    }

}