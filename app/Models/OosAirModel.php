<?php

namespace App\Models;

use CodeIgniter\Model;

class OosAirModel extends Model
{
    protected $table = 'oos_air';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id_sampling',
        'id_master_air',
        'nama_outlet_sampling',
        'no_outlet_sampling',
        'site',
        'tanggal_sampling',
        'parameter_tms',
        'keterangan',
        'status',
        'upload_oos',
        'created_at',
    ];
}