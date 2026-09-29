<?php

namespace App\Models;

use CodeIgniter\Model;

class PenyimpanganAirModel extends Model
{
    protected $table = 'penyimpangan_air';
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
        'upload_penyimpangan',
        'created_at',
    ];
}