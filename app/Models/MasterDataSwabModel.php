<?php

namespace App\Models;

use App\Models\BaseModel;

class MasterDataSwabModel extends BaseModel
{
    
    protected $table = 'master_data_swab';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'site',
        'ahu',
        'kategori',
        'nama_mesin_personil_alat',
        'kelas',
        'nama_ruangan',
        'departemen',
        'lokasi_sampling',
        'periode'
    ];
    
}
